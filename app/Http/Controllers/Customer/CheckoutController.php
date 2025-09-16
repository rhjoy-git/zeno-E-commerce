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
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return back()->withErrors(['error' => 'No items selected for checkout.']);
        }

        $cartItems = ProductCart::with(['product', 'variant'])
            ->whereIn('id', $selectedItems)
            ->where('user_id', Auth::id())
            ->get();

        // Check if valid items were found and return JSON error
        if ($cartItems->isEmpty()) {
            return back()->withErrors(['error' => 'No valid items found in your cart.']);
        }

        // Calculation logic remains the same
        $orderTotal = 0;
        $discountTotal = 0;

        foreach ($cartItems as $cartItem) {
            $price = $cartItem->variant
                ? $cartItem->variant->price
                : $cartItem->product->price;

            $discountPrice = $cartItem->variant
                ? $cartItem->variant->discount_price
                : $cartItem->product->discount_price;

            $finalPrice = $discountPrice ?: $price;

            $orderTotal += $finalPrice * $cartItem->qty;

            if ($discountPrice) {
                $discountTotal += ($price - $discountPrice) * $cartItem->qty;
            }
        }

        $vat = $orderTotal * 0.05;
        $grandTotal = $orderTotal + $vat;

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'subtotal' => $orderTotal,
            'discount' => $discountTotal,
            'vat' => $vat,
            'grand_total' => $grandTotal,
            'status' => 'pending'
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'qty' => $item->qty,
                'price' => $item->variant ? $item->variant->price : $item->product->price,
                'discount_price' => $item->variant ? $item->variant->discount_price : $item->product->discount_price,
            ]);
        }

        // Instead of returning a view, return a JSON response with a redirect URL.
        return response()->json([
            'success' => true,
            'message' => 'Checkout successful.',
            'redirect_url' => route('customer.checkout', ['orderId' => $order->id])
        ]);
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
