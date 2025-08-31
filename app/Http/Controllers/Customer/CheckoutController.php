<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cartItems = [];
        $totals = [
            'order_value' => 0,
            'total_discount' => 0,
            'vat_amount' => 0,
            'total_price' => 0
        ];

        if (Auth::check()) {
            $cartItems = ProductCart::with([
                'product.primaryImage',
                'productVariant.color',
                'productVariant.size'
            ])->where('user_id', Auth::id())->get();

            $totals = $this->calculateCheckoutTotals($cartItems);
        } else {
            $sessionCart = Session::get('cart', []);
            foreach ($sessionCart as $id => $itemData) {
                $product = Product::with('images')->find($itemData['product_id']);

                $cartItems[] = (object) [
                    'id' => $id,
                    'product' => $product,
                    'productVariant' => $itemData['variant_id'] ? ProductVariant::find($itemData['variant_id']) : null,
                    'color' => $itemData['color'],
                    'size' => $itemData['size'],
                    'qty' => $itemData['qty'],
                    'price' => $itemData['price'],
                    'product_name' => $product->title,
                    'product_image' => $product->images->first()->image_path ?? '/images/placeholder.jpg'
                ];
            }
            $totals = $this->calculateCheckoutTotals($cartItems);
        }
        dd($cartItems, $totals);
        return view('customer.checkout', compact('cartItems', 'totals'));
    }

    private function calculateCheckoutTotals($cartItems)
    {
        $orderValue = 0;
        $totalDiscount = 0;
        $vatRate = 0.05;

        foreach ($cartItems as $item) {
            $itemTotal = $item->price * $item->qty;
            $orderValue += $itemTotal;

            // Calculate discount if product has discount
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
        // Validate the request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,bkash,mobile-banking,card'
        ]);

        // Here you would:
        // 1. Create an order record
        // 2. Create order items from cart
        // 3. Process payment based on method
        // 4. Clear the cart
        // 5. Send confirmation email

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully',
            'order_id' => 'ORD123456' // Generated order ID
        ]);
    }
}
