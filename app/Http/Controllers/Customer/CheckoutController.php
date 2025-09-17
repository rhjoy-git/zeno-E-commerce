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
            // dd($cartItems, $subtotal, $discountTotal, $taxAmount, $grandTotal);
            return view('customer.checkout', compact('cartItems', 'subtotal', 'discountTotal', 'taxAmount', 'grandTotal'));
        } catch (\Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage(), [
                'userId' => Auth::id(),
                'selectedItems' => $request->input('selected_items'),
            ]);
            return redirect()->route('cart.index')->withErrors(['checkout' => 'Something went wrong, please try again.']);
        }
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
