<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id'
        ]);
        // dd($request->all());
        $variantId = $request->variant_id;
        if ($variantId === '') {
            $variantId = null;
        }

        $product = Product::findOrFail($request->product_id);

        // Initialize variables
        $price = $product->price;
        $size = null;
        $color = null;

        if ($request->variant_id) {
            $variant = ProductVariant::findOrFail($request->variant_id);
            $price = $variant->price;
            $size = $variant->size_id;
            $color = $variant->color_id;
        }

        // For authenticated users
        if (Auth::check()) {
            $cartItem = $this->addToDatabaseCart($request, $price, $size, $color);
            return response()->json([
                'success' => true,
                'message' => '"' . $product->name . '" added to cart',
                'cart_count' => $this->getCartCount()
            ]);
        }

        // For guests
        $cartItem = $this->addToSessionCart($request, $product, $price, $color, $size);
        return response()->json([
            'success' => true,
            'message' => '"' . $product->name . '" added to cart',
            'cart_count' => $this->getCartCount()
        ]);
    }

    private function addToDatabaseCart(Request $request, $price, $size = null, $color = null)
    {
        $userId = Auth::id();

        // Check if item already exists in cart
        $existingItem = ProductCart::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($existingItem) {
            // Update quantity if item exists
            $existingItem->qty += $request->qty;
            $existingItem->save();
            return $existingItem;
        }

        // Create new cart item
        return ProductCart::create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'variant_id' => $request->variant_id,
            'color' => $color,
            'size' => $size,
            'qty' => $request->qty,
            'price' => $price
        ]);
    }

    private function addToSessionCart(Request $request, $product, $price, $color = null, $size = null)
    {
        $cart = Session::get('cart', []);
        $uniqueId = $this->generateCartItemId($request->product_id, $request->variant_id, $color, $size);
        // Get product image safely
        $productImage = null;
        if ($product->images && $product->images->count() > 0) {
            $productImage = $product->images->first()->url;
        }

        if (isset($cart[$uniqueId])) {
            // Update quantity if item exists
            $cart[$uniqueId]['qty'] += $request->qty;
        } else {
            // Add new item to cart
            $cart[$uniqueId] = [
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'color' => $color,
                'size' => $size,
                'qty' => $request->qty,
                'price' => $price,
                'product_name' => $product->name,
                'product_image' => $productImage,
                'product_slug' => $product->slug
            ];
        }

        Session::put('cart', $cart);
        return $cart[$uniqueId];
    }

    private function generateCartItemId($productId, $variantId, $color, $size)
    {
        return md5(implode('|', [
            $productId,
            $variantId,
            $color,
            $size
        ]));
    }
    public function index()
    {
        $cartItems = [];
        $totalItems = 0;

        if (Auth::check()) {
            $cartItems = ProductCart::with([
                'product' => function ($q) {
                    $q->where('status', 'active');
                },
                'variant.color',
                'variant.size'
            ])
                ->where('user_id', Auth::id())
                ->get();
            // dd($cartItems);
            $totalItems = $cartItems->sum('qty');
        } else {
            $sessionCart = Session::get('cart', []);
            foreach ($sessionCart as $id => $item) {
                $product = Product::with(['primaryImage', 'variants.size', 'variants.color'])->find($item['product_id']);
                if (!$product) continue;

                $totalItems += $item['qty'];

                $cartItems[] = (object) [
                    'id'       => $id,
                    'product'  => $product,
                    'variant'  => $item['variant_id'] ? ProductVariant::with(['size', 'color'])->find($item['variant_id']) : null,
                    'qty'      => $item['qty'],
                    'price'    => $item['price'],
                    'subtotal' => $item['qty'] * $item['price'],
                    'color'    => $item['color'] ?? null,
                    'size'     => $item['size'] ?? null,
                ];
            }
        }

        return view('customer.cart-item', compact('cartItems', 'totalItems'));
    }
    public function getVariantPrice(Request $request)
    {
        $productId = $request->product_id;
        $colorId   = $request->color_id;
        $sizeId    = $request->size_id;

        $variant = ProductVariant::with(['size', 'color'])
            ->where('product_id', $productId)
            ->when($colorId, fn($q) => $q->where('color_id', $colorId))
            ->when($sizeId, fn($q) => $q->where('size_id', $sizeId))
            ->first();

        if (!$variant) {
            return response()->json(['error' => 'Variant not found'], 404);
        }

        return response()->json([
            'id'             => $variant->id,
            'price'          => $variant->price,
            'stock_quantity' => $variant->stock_quantity,
            'sku'            => $variant->sku,
            'color'          => $variant->color?->name,
            'size'           => $variant->size?->name,
        ]);
    }
    public function getSizes(Request $request)
    {
        $productId = $request->product_id;
        $colorId   = $request->color_id;

        $sizes = ProductVariant::with('size')
            ->where('product_id', $productId)
            ->where('color_id', $colorId)
            ->get()
            ->pluck('size')
            ->unique('id')
            ->values();

        return response()->json($sizes);
    }
    public function getColors(Request $request)
    {
        $productId = $request->product_id;
        $sizeId   = $request->size_id;

        $colors = ProductVariant::with('color')
            ->where('product_id', $productId)
            ->where('size_id', $sizeId)
            ->get()
            ->pluck('color')
            ->unique('id')
            ->values();

        return response()->json($colors);
    }

    public function update(Request $request, $item)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        if (Auth::check()) {
            $cartItem = ProductCart::where('user_id', Auth::id())->findOrFail($item);
            $cartItem->qty = $request->qty;
            $cartItem->save();
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$item])) {
                $cart[$item]['qty'] = $request->qty;
                Session::put('cart', $cart);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart_count' => $this->getCartCount()

        ]);
    }

    public function remove($item)
    {
        if (Auth::check()) {
            $cartItem = ProductCart::where('user_id', Auth::id())->findOrFail($item);
            $cartItem->delete();
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$item])) {
                unset($cart[$item]);
                Session::put('cart', $cart);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function getCartCount()
    {
        if (Auth::check()) {
            return ProductCart::where('user_id', Auth::id())->sum('qty');
        }

        $cart = Session::get('cart', []);
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['qty'];
        }
        return $count;
    }

    public function syncCart()
    {
        if (Auth::check()) {
            $sessionCart = Session::get('cart', []);

            if (!empty($sessionCart)) {
                foreach ($sessionCart as $item) {
                    // Check if item already exists in database
                    $existingItem = ProductCart::where('user_id', Auth::id())
                        ->where('product_id', $item['product_id'])
                        ->where('variant_id', $item['variant_id'])
                        ->where('color', $item['color'])
                        ->where('size', $item['size'])
                        ->first();

                    if ($existingItem) {
                        // Update quantity
                        $existingItem->qty += $item['qty'];
                        $existingItem->save();
                    } else {
                        // Create new item
                        ProductCart::create([
                            'user_id' => Auth::id(),
                            'product_id' => $item['product_id'],
                            'variant_id' => $item['variant_id'],
                            'color' => $item['color'],
                            'size' => $item['size'],
                            'qty' => $item['qty'],
                            'price' => $item['price']
                        ]);
                    }
                }

                // Clear session cart after syncing
                Session::forget('cart');
            }
        }

        return response()->json([
            'success' => true,
            'cart_count' => $this->getCartCount()
        ]);
    }

    public static function getCartCountStatic()
    {
        if (Auth::check()) {
            return ProductCart::with(['product' => function ($q) {
                $q->where('status', 'active');
            }])->where('user_id', Auth::id())->sum('qty');
        }

        $cart = Session::get('cart', []);
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['qty'];
        }
        return $count;
    }

    private function calculateItemTotal($item)
    {
        $price = $item->price;
        $quantity = $item->qty;

        // Use discount price if available
        if ($item->product->discount && $item->product->discount_price) {
            $price = $item->product->discount_price;
        }

        return [
            'item_total' => $price * $quantity,
            'item_price' => $price,
            'original_total' => $item->product->price * $quantity,
            'discount' => ($item->product->price * $quantity) - ($price * $quantity)
        ];
    }
}
