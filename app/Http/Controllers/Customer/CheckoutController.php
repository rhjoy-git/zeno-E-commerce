<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    // public function checkout(Request $request)
    // {
    //     $selected = json_decode($request->selected_items, true);
    //     dd($selected);
    //     // Fetch only selected items from DB
    //     $cartItems = ProductCart::with('product', 'variant')
    //         ->whereIn('id', $selected)
    //         ->where('user_id', Auth::id())
    //         ->get();

    //     if ($cartItems->isEmpty()) {
    //         return redirect()->route('cart.index')->with('error', 'No items selected for checkout.');
    //     }

    //     return view('customer.checkout', compact('cartItems'));
    // }

    public function checkout(Request $request)
    {
        try {
            // Decode selected items safely
            $selectedItems = json_decode($request->input('selected_items', '[]'), true);

            // Validation - must be array of integers
            if (!is_array($selectedItems) || empty($selectedItems)) {
                return redirect()->back()->withErrors(['cart' => 'No items selected for checkout.']);
            }

            // Sanitize ids (force int, remove invalid)
            $selectedItems = array_map('intval', $selectedItems);

            // Retrieve only current user's cart items
            $cartItems = ProductCart::with(['product', 'variant'])
                ->whereIn('id', $selectedItems)
                ->where('user_id', Auth::id())
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')
                    ->withErrors(['cart' => 'Your selected items are invalid or not available.']);
            }

            // --- Calculation Logic ---
            $subtotal = 0;
            $discountTotal = 0;
            $vatRate = 0.05;

            foreach ($cartItems as $cartItem) {
                $basePrice = $cartItem->variant ? $cartItem->variant->price : $cartItem->product->price;
                $discountedPrice = $cartItem->variant ? $cartItem->variant->discount_price : $cartItem->product->discount_price;
                $effectivePrice = $discountedPrice ?? $basePrice;

                $itemDiscount = ($basePrice - $effectivePrice) * $cartItem->qty;

                $subtotal += $effectivePrice * $cartItem->qty;
                $discountTotal += $itemDiscount;
            }

            $taxAmount = $subtotal * $vatRate;
            $grandTotal = $subtotal + $taxAmount;

            // 🟢 Store checkout data in session for later confirmation
            session([
                'checkout' => [
                    'items' => $cartItems->pluck('id')->toArray(),
                    'subtotal' => $subtotal,
                    'discount' => $discountTotal,
                    'vat' => $taxAmount,
                    'grand_total' => $grandTotal,
                ],
            ]);
            return view('customer.checkout', compact('cartItems', 'subtotal', 'discountTotal', 'taxAmount', 'grandTotal'));
        } catch (\Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage(), [
                'userId' => Auth::id(),
                'selectedItems' => $request->input('selected_items'),
            ]);
            return redirect()->route('cart.index')->withErrors(['checkout' => 'Something went wrong, please try again.']);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string|max:30',
            'address'   => 'required|string|max:1000',
            'apartment' => 'nullable|string|max:255',
            'city'      => 'required|string|max:255',
            'postcode'  => 'nullable|string|max:50',
            'payment'   => 'required|string|in:cod,bkash,mobile-banking,card',
        ]);


        // Retrieve the 'checkout' session data
        $checkout = session('checkout');

        // Retrieve all session data
        $allSessionData = session()->all();

        // Combine the data for clarity
        $response = [
            'checkout' => $checkout,
            'all_session_data' => $allSessionData
        ];

        dd($response, $request->all());
        
        if (empty($checkout) || empty($checkout['items']) || !is_array($checkout['items'])) {
            return redirect()->route('cart.index')->withErrors(['checkout' => 'No items selected for checkout.']);
        }

        // 3) Determine owner constraint (auth user or guest session)
        $userId = Auth::id();
        $sessionId = session()->getId();

        // Sanitize ids
        $selectedIds = array_map('intval', $checkout['items']);

        try {
            // 4) Re-fetch ONLY the selected cart items that belong to this user/session
            $cartQuery = ProductCart::with(['product', 'variant'])
                ->whereIn('id', $selectedIds)
                ->where(function ($q) use ($userId, $sessionId) {
                    if ($userId) {
                        $q->where('user_id', $userId);
                    } else {
                        $q->where('session_id', $sessionId);
                    }
                });

            $cartItems = $cartQuery->get();

            // 5) Ensure all selected items were found
            if ($cartItems->count() !== count($selectedIds)) {
                // some items missing (maybe removed or tampered)
                Log::warning('Checkout: selected items mismatch', [
                    'expected' => $selectedIds,
                    'found' => $cartItems->pluck('id')->toArray(),
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                ]);
                return redirect()->route('cart.index')->withErrors(['checkout' => 'Some selected items are no longer available. Please check your cart.']);
            }

            // 6) Server-side re-calculation and stock validation
            $subtotal = 0;
            $discountTotal = 0;
            $vatRate = 0.05;

            foreach ($cartItems as $item) {
                $basePrice = $item->variant ? $item->variant->price : $item->product->price;
                $discountPrice = $item->variant ? $item->variant->discount_price : $item->product->discount_price;
                $effectivePrice = $discountPrice ?? $basePrice;

                // stock check
                $availableQty = $item->variant ? ($item->variant->stock ?? 0) : ($item->product->stock ?? 0);
                if ($item->qty > $availableQty) {
                    return redirect()->route('cart.index')->withErrors([
                        'stock' => "Insufficient stock for product: {$item->product->title}. Available: {$availableQty}, Requested: {$item->qty}"
                    ]);
                }

                $subtotal += $effectivePrice * $item->qty;
                $discountTotal += ($basePrice - $effectivePrice) * $item->qty;
            }

            $taxAmount = $subtotal * $vatRate;
            $grandTotal = $subtotal + $taxAmount;

            // Optionally: compare server grandTotal with session('checkout.grand_total')
            // If you want to detect price changes you can:
            if (isset($checkout['grand_total']) && abs($checkout['grand_total'] - $grandTotal) > 0.01) {
                // Price changed since the user started checkout
                session()->put('checkout.grand_total', $grandTotal);
                // Either inform user or continue with updated price. Here we notify:
                return redirect()->back()->withErrors(['price_change' => 'Product prices have changed. Please review the updated totals.']);
            }

            // 7) Create order + items in transaction
            DB::beginTransaction();

            $order = Order::create([
                'user_id'      => $userId ?: null,
                'guest_session_id' => $userId ? null : $sessionId,
                'full_name'    => $validated['full_name'],
                'phone'        => $validated['phone'],
                'address'      => $validated['address'],
                'apartment'    => $validated['apartment'] ?? null,
                'city'         => $validated['city'],
                'postcode'     => $validated['postcode'] ?? null,
                'payment_method' => $validated['payment'],
                'subtotal'     => $subtotal,
                'discount'     => $discountTotal,
                'tax'          => $taxAmount,
                'total'        => $grandTotal,
                'status'       => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $priceUsed = $item->variant ? ($item->variant->discount_price ?? $item->variant->price) : ($item->product->discount_price ?? $item->product->price);

                $order->items()->create([
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'qty'        => $item->qty,
                    'price'      => $priceUsed,
                    'line_total' => $priceUsed * $item->qty,
                ]);

                // optionally decrement stock (recommended)
                if ($item->variant) {
                    $item->variant->decrement('stock', $item->qty);
                } else {
                    $item->product->decrement('stock', $item->qty);
                }
            }

            // 8) Remove only the selected cart rows (keep other cart rows intact)
            $deleteQuery = ProductCart::whereIn('id', $selectedIds);
            if ($userId) $deleteQuery->where('user_id', $userId);
            else $deleteQuery->where('session_id', $sessionId);
            $deleteQuery->delete();

            DB::commit();

            // 9) Clear checkout session data
            session()->forget('checkout');

            // 10) Redirect based on payment method
            if ($validated['payment'] === 'cod') {
                $order->update(['status' => 'confirmed']);
                return redirect()->route('home', $order->id)->with('success', 'Order placed successfully.');
            }

            // For online payments: redirect to PaymentController
            return redirect()->route('home', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order store failed: ' . $e->getMessage(), [
                'userId' => $userId,
                'sessionId' => $sessionId,
                'selected' => $selectedIds,
            ]);
            return redirect()->back()->withErrors(['order' => 'Failed to place order. Please try again later.']);
        }
    }

    public function success(Order $order)
    {
        return view('home', compact('order'));
    }
    /**
     * Cart update helper
     */
    private function updateCartItem($itemId, $variantId = null, $qty = 1, $color = null, $size = null)
    {
        if (Auth::check()) {
            $cartItem = ProductCart::where('user_id', Auth::id())->find($itemId);
            if ($cartItem) {
                $cartItem->variant_id = $variantId;
                $cartItem->qty = $qty;
                $cartItem->color = $color;
                $cartItem->size = $size;

                // variant এর price set করি
                if ($variantId) {
                    $variant = ProductVariant::find($variantId);
                    if ($variant) {
                        $cartItem->price = $variant->price;
                    }
                } else {
                    $cartItem->price = $cartItem->product->sale_price ?: $cartItem->product->price;
                }

                $cartItem->save();
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$itemId])) {
                $cart[$itemId]['variant_id'] = $variantId;
                $cart[$itemId]['qty'] = $qty;
                $cart[$itemId]['color'] = $color;
                $cart[$itemId]['size'] = $size;

                if ($variantId) {
                    $variant = ProductVariant::find($variantId);
                    if ($variant) {
                        $cart[$itemId]['price'] = $variant->price;
                    }
                } else {
                    $product = Product::find($cart[$itemId]['product_id']);
                    $cart[$itemId]['price'] = $product->sale_price ?: $product->price;
                }

                Session::put('cart', $cart);
            }
        }
    }

    private function calculateCheckoutTotals($cartItems)
    {
        $orderValue = 0;
        $totalDiscount = 0;
        $vatRate = 0.05;

        foreach ($cartItems as $item) {
            $itemTotal = $item->price * $item->qty;
            $orderValue += $itemTotal;

            if ($item->product->discount && $item->product->discount_price) {
                $originalTotal = $item->product->price * $item->qty;
                $discountedTotal = $item->product->discount_price * $item->qty;
                $totalDiscount += ($originalTotal - $discountedTotal);
            }
        }

        $vatAmount = $orderValue * $vatRate;
        $totalPrice = $orderValue + $vatAmount;

        return [
            'order_value' => $orderValue,
            'total_discount' => $totalDiscount,
            'vat_amount' => $vatAmount,
            'total_price' => $totalPrice
        ];
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,bkash,mobile-banking,card'
        ]);

        // Order process (এখন dummy)
        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully',
            'order_id' => 'ORD123456'
        ]);
    }
}
