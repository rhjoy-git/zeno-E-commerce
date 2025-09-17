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
use Illuminate\Support\Str;


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

    public function index(Request $request)
    {
        try {
            // Decode selected items safely
            $selectedItems = json_decode($request->input('selected_items', '[]'), true);

            // Validation - must be array of integers
            if (!is_array($selectedItems) || empty($selectedItems)) {
                return redirect()->back()->with('warning', 'No items selected for checkout.');
            }

            if (Auth::check()) {
                // Sanitize ids (force int, remove invalid)
                $selectedItems = array_map('intval', $selectedItems);

                // Retrieve only current user's cart items
                $cartItems = ProductCart::with(['product', 'variant'])
                    ->whereIn('id', $selectedItems)
                    ->where('user_id', Auth::id())
                    ->get();
            } else {
                $cart = Session::get('cart', []);
                $cartItems = collect();
                // dd($cart);
                foreach ($cart as $item) {
                    if (in_array($item['uniqueId'], $selectedItems)) {
                        $product = Product::find($item['product_id']);
                        $variant = $item['variant_id'] ? ProductVariant::find($item['variant_id']) : null;

                        $cartItems->push((object) [
                            'id' => $item['uniqueId'],
                            'product_id' => $item['product_id'],
                            'product' => $product,
                            'variant' => $variant,
                            'variant_id' => $item['variant_id'],
                            'qty' => $item['qty'],
                        ]);
                    }
                }
            }


            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')
                    ->with(['error', 'Your selected items are invalid or not available.']);
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
            return redirect()->route('cart.index')->withErrors(['error' => 'Something went wrong, please try again.']);
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
        if (empty($checkout) || empty($checkout['items']) || !is_array($checkout['items'])) {
            session()->forget('checkout');

            return redirect()->route('cart.index')->with('warning', 'No items selected for checkout.');
        }

        // 3) Determine owner constraint (auth user or guest session)
        $userId = Auth::id() ?? null;
        $sessionId = session()->getId() ?? null;

        // Check if the user is authenticated
        if (Auth::check()) {
            $selectedIds = array_map('intval', $checkout['items']);
        } else {
            $selectedIds = $checkout['items'];
        }

        try {
            if (Auth::check()) {
                $cartItems = ProductCart::with(['product', 'variant'])
                    ->whereIn('id', $selectedIds)
                    ->where('user_id', Auth::id())
                    ->get();
            } else {
                $cart = Session::get('cart', []);
                $cartItems = collect();
                foreach ($cart as $item) {
                    if (in_array($item['uniqueId'], $selectedIds)) {
                        $product = Product::find($item['product_id']);
                        $variant = $item['variant_id'] ? ProductVariant::find($item['variant_id']) : null;

                        $cartItems->push((object) [
                            'id' => $item['uniqueId'],
                            'product_id' => $item['product_id'],
                            'product' => $product,
                            'variant' => $variant,
                            'variant_id' => $item['variant_id'],
                            'qty' => $item['qty'],
                        ]);
                    }
                }
            }

            // 5) Ensure all selected items were found
            if ($cartItems->count() !== count($selectedIds)) {
                // some items missing (maybe removed or tampered)
                Log::warning('Checkout: selected items mismatch', [
                    'expected' => $selectedIds,
                    'found' => $cartItems->pluck('id')->toArray(),
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                ]);
                session()->forget('checkout');

                return redirect()->route('cart.index')->with('error', 'Some selected items are no longer available. Please check your cart.');
            }

            // 6) Server-side re-calculation and stock validation
            $subtotal = 0;
            $discountTotal = 0;
            $vatRate = 0.05;
            // dd($cartItems);
            foreach ($cartItems as $item) {

                $basePrice = $item->variant ? $item->variant->price : $item->product->price;
                if (!$item->product->has_variants && $item->product->discount) {
                    $discountPrice = $item->product->discount ? $item->product->discount_price : $item->product->price;
                } else {
                    $discountPrice = $basePrice;
                }
                $effectivePrice = $discountPrice ?? $basePrice;

                // stock check
                $availableQty = $item->variant ? ($item->variant->stock_quantity ?? 0) : ($item->product->stock_quantity ?? 0);
                if ($item->qty > $availableQty) {
                    session()->forget('checkout');

                    return redirect()->route('cart.index')->with(
                        'error',
                        "Insufficient stock for product: {$item->product->title}. Available: {$availableQty}, Requested: {$item->qty}"
                    );
                }

                $subtotal += $effectivePrice * $item->qty;
                $discountTotal += ($basePrice - $effectivePrice) * $item->qty;
                // var_dump(
                //     "Item: ",
                //     $item->id,
                //     "Base Price:",
                //     $basePrice,
                //     $discountPrice,
                //     $effectivePrice,
                //     "Qty",
                //     $item->qty,
                //     "Sub-Total",
                //     $subtotal,
                //     "Dis-total",
                //     $discountTotal
                // );
            }

            $taxAmount = $subtotal * $vatRate;
            $grandTotal = $subtotal + $taxAmount;

            // Detect price changes you can:
            // dd($checkout['grand_total'], $grandTotal, $taxAmount);
            if (isset($checkout['grand_total']) && abs($checkout['grand_total'] - $grandTotal) > 0.01) {
                // Price changed since the user started checkout
                session()->put('checkout.grand_total', $grandTotal);
                session()->forget('checkout');
                return redirect()->back()->with(['warning' => 'Product prices have changed. Please review the updated totals.']);
            }

            // 7) Create order + items in transaction
            DB::beginTransaction();

            // Generate a unique order number
            $orderNumber = 'ORD-' . Str::upper(Str::random(8));

            // Create the order
            $order = Order::create([
                'user_id' => $userId,
                'guest_session_id' => $sessionId,
                'order_number' => $orderNumber,
                'customer_email' => Auth::check() ? Auth::user()->email : null,
                'customer_phone' => $validated['phone'],
                'full_name' => $validated['full_name'],
                'address' => $validated['address'],
                'apartment' => $validated['apartment'] ?? null,
                'city' => $validated['city'],
                'postcode' => $validated['postcode'] ?? null,
                'payment_method' => $validated['payment'],
                'subtotal' => $subtotal,
                'discount_amount' => $discountTotal,
                'tax_amount' => $taxAmount,
                'total' => $grandTotal,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $basePrice = $item->variant ? $item->variant->price : $item->product->price;

                if (!$item->product->has_variants && $item->product->discount) {
                    $effectivePrice = $item->product->discount ? $item->product->discount_price : $item->product->price;
                } else {
                    $effectivePrice = $basePrice;
                }
                $discountAmount = ($basePrice - $effectivePrice);
                $taxAmountItem = ($effectivePrice * $vatRate);
                $rowTotal = $effectivePrice * $item->qty;
                $rowTotalInclTax = $rowTotal + $taxAmountItem;

                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->variant_id,
                    'name' => $item->product->title,
                    'sku' => $item->variant ? $item->variant->sku : $item->product->sku,
                    'variant_color' => $item->variant ? $item->variant->color->name : null,
                    'variant_size' => $item->variant ? $item->variant->size->name : null,
                    'price' => $effectivePrice,
                    'original_price' => $basePrice,
                    'discount_amount' => $discountAmount,
                    'tax_amount' => $taxAmountItem,
                    'quantity' => $item->qty,
                    'row_total' => $rowTotal,
                    'row_total_incl_tax' => $rowTotalInclTax,
                ]);

                // Decrement stock based on item type
                if ($item->variant) {
                    $item->variant->decrement('stock_quantity', $item->qty);
                } else {
                    $item->product->decrement('stock_quantity', $item->qty);
                }
            }
            
            // Handle cart clearing after successful order creation
            if (Auth::check()) {
                ProductCart::whereIn('id', $selectedIds)->delete();
            } else {
                $cart = collect(Session::get('cart', []));
                $remainingCart = $cart->whereNotIn('uniqueId', $selectedIds);
                Session::put('cart', $remainingCart->values()->all());
            }

            DB::commit();
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
