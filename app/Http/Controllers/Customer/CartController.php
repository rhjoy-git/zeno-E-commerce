<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // For authenticated users
            $cartItems = Auth::user()->cartItems()->with('product')->get();
        } else {
            // For guests
            $cartItems = collect(Session::get('cart', []));

            // If you need full product details for guests, you might need to load them:
            $productIds = $cartItems->pluck('product_id')->unique();
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            $cartItems = $cartItems->map(function ($item) use ($products) {
                $item['product'] = $products[$item['product_id']] ?? null;
                return $item;
            });
        }

        return view('customer.cart-item', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check product availability
        if ($product->stock_quantity <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'This product is currently out of stock',
            ], 400);
        }

        // Calculate the final price (considering discount if available)
        $finalPrice = $product->discount ? $product->discount_price : $product->price;

        // Ensure requested quantity doesn't exceed available stock
        $requestedQty = $request->qty;
        $adjusted = false;
        if ($product->stock_quantity < $requestedQty) {
            $requestedQty = $product->stock_quantity;
            $adjusted = true; // Indicate that quantity was adjusted
        }

        if (Auth::check()) {
            // For authenticated users - store in database
            $cartItem = ProductCart::where([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'color' => $request->color ?? '',
                'size' => $request->size ?? ''
            ])->first();

            if ($cartItem) {
                // Item already exists - update quantity
                $newQty = $cartItem->qty + $requestedQty;

                // Check if new quantity exceeds stock
                if ($product->stock_quantity < $newQty) {
                    $newQty = $product->stock_quantity;
                }

                $cartItem->update([
                    'qty' => $newQty,
                    'price' => $finalPrice // Update price in case discount changed
                ]);
            } else {
                // Create new cart item
                $cartItem = ProductCart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'color' => $request->color ?? '',
                    'size' => $request->size ?? '',
                    'qty' => $requestedQty,
                    'price' => $finalPrice
                ]);
            }

            $cartCount = Auth::user()->cartItems()->sum('qty');
        } else {
            // For guests - store in session
            $cart = Session::get('cart', []);

            $key = $this->getCartItemKey($request->product_id, $request->color, $request->size);

            if (isset($cart[$key])) {
                // Item exists - update quantity
                $newQty = $cart[$key]['qty'] + $requestedQty;

                // Check stock
                if ($product->stock_quantity < $newQty) {
                    $newQty = $product->stock_quantity;
                }

                $cart[$key]['qty'] = $newQty;
                $cart[$key]['price'] = $finalPrice; // Update price
            } else {
                // Create new cart item
                $cart[$key] = [
                    'product_id' => $request->product_id,
                    'color' => $request->color ?? 'default',
                    'size' => $request->size ?? 'default',
                    'qty' => $requestedQty,
                    'price' => $finalPrice,
                    'added_at' => now()->toDateTimeString()
                ];
            }

            Session::put('cart', $cart);
            $cartCount = array_sum(array_column($cart, 'qty'));
        }

        return response()->json([
            'success' => true,
            'message' => $adjusted ? 'Quantity adjusted to available stock' : 'Product added to cart',
            'cartCount' => $cartCount,
            
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        if (Auth::check()) {
            $cartItem = Auth::user()->cartItems()->findOrFail($id);
            $cartItem->update(['qty' => $request->qty]);
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['qty'] = $request->qty;
                Session::put('cart', $cart);
            }
        }

        return redirect()->back()->with('success', 'Cart updated');
    }

    public function remove($id)
    {
        if (Auth::check()) {
            Auth::user()->cartItems()->where('id', $id)->delete();
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                Session::put('cart', $cart);
            }
        }

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    // Helper method to generate unique key for guest cart items
    protected function getCartItemKey($productId, $color, $size)
    {
        return $productId . '_' . ($color ?? 'default') . '_' . ($size ?? 'default');
    }

    // Optional: Method to merge guest cart with user cart after login
    public function mergeGuestCartWithUserCart($user)
    {
        if (Session::has('cart')) {
            $guestCart = Session::get('cart');

            foreach ($guestCart as $item) {
                ProductCart::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'product_id' => $item['product_id'],
                        'color' => $item['color'],
                        'size' => $item['size']
                    ],
                    [
                        'qty' => $item['qty'],
                        'price' => $item['price']
                    ]
                );
            }

            Session::forget('cart');
        }
    }
}
