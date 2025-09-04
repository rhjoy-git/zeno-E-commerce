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
            'color' => 'nullable|string|max:200',
            'size' => 'nullable|string|max:200',
            'variant_id' => 'nullable|exists:product_variants,id'
        ]);
        // dd($request->all());
        $variantId = $request->variant_id;
        if ($variantId === '') {
            $variantId = null;
        }

        $product = Product::findOrFail($request->product_id);

        // Calculate price based on variant or product base price
        $price = $product->price;
        if ($request->variant_id) {
            $variant = ProductVariant::find($request->variant_id);
            if ($variant) {
                $price = $variant->price;
            }
        }

        // Check if product is on sale
        if ($product->sale_price && $product->sale_price < $price) {
            $price = $product->sale_price;
        }

        // For authenticated users
        if (Auth::check()) {
            $cartItem = $this->addToDatabaseCart($request, $price);
            return response()->json([
                'success' => true,
                'message' => '"' . $product->name . '" added to cart',
                'cart_count' => $this->getCartCount()
            ]);
        }

        // For guests
        $cartItem = $this->addToSessionCart($request, $product, $price);
        return response()->json([
            'success' => true,
            'message' => '"' . $product->name . '" added to cart',
            'cart_count' => $this->getCartCount()
        ]);
    }

    private function addToDatabaseCart(Request $request, $price)
    {
        $userId = Auth::id();

        // Check if item already exists in cart
        $existingItem = ProductCart::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->where('color', $request->color)
            ->where('size', $request->size)
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
            'color' => $request->color,
            'size' => $request->size,
            'qty' => $request->qty,
            'price' => $price
        ]);
    }

    private function addToSessionCart(Request $request, $product, $price)
    {
        $cart = Session::get('cart', []);
        $uniqueId = $this->generateCartItemId($request);

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
                'color' => $request->color,
                'size' => $request->size,
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

    private function generateCartItemId(Request $request)
    {
        return md5(implode('|', [
            $request->product_id,
            $request->variant_id,
            $request->color,
            $request->size
        ]));
    }

    public function index()
    {
        $cartItems = [];
        $totalItems = 0;

        if (Auth::check()) {

            $cartItems = ProductCart::with([
                'product.images',
                'product.variants.size',
                'product.variants.color',
                'variant',
                'variant.size',
                'variant.color'
            ])
                ->where('user_id', Auth::id())
                ->get();
            $totalItems = $cartItems->sum('qty');

            // dd($cartItems);
            // Transform to a simplified array
            $formattedItems = $cartItems->map(function ($cartItem) {
                return [
                    'product' => [
                        'id' => $cartItem->product->id ?? 'N/A',
                        'name' => $cartItem->product->title ?? 'N/A',
                        'price' => $cartItem->product->price ?? 'N/A',
                        'images' => $cartItem->product->images->map(function ($image) {
                            return [
                                'id' => $image->id,
                                'path' => Storage::url($image->image_path),
                                'is_primary' => $image->is_primary
                            ];
                        }),
                        'variants' => $cartItem->product->variants->where('status', 'active')->map(function ($variant) {
                            return [
                                'id' => $variant->id,
                                'color_id' => $variant->color_id,
                                'color_name' => $variant->color ? $variant->color->name : null,
                                'color_hex' => $variant->color ? $variant->color->hex_code : null,
                                'size_id' => $variant->size_id,
                                'size_name' => $variant->size ? $variant->size->name : null,
                                'price' => $variant->price,
                                'stock_quantity' => $variant->stock_quantity,
                                'sku' => $variant->sku
                            ];
                        })->values()
                    ],
                    'selected_variant' => [
                        'id' => $cartItem->id ?? 'N/A',
                        'size' => $cartItem->size ?? 'N/A',
                        'color' => $cartItem->color ?? 'N/A',
                    ],
                    'quantity' => $cartItem->qty ?? 'N/A',
                    'subtotal' => $cartItem->subtotal ?? 'N/A',
                    'price' => $cartItem->price ?? 'N/A',
                ];
            })->toArray();

            // Output as JSON
            echo json_encode($formattedItems, JSON_PRETTY_PRINT);
            exit;
        } else {
            $sessionCart = Session::get('cart', []);
            foreach ($sessionCart as $id => $item) {
                $product = Product::with('images')->find($item['product_id']);

                if (!$product) continue; // Skip if product not found

                $totalItems += $item['qty'];

                $cartItems[] = (object) array_merge([
                    'id' => $id,
                    'session_id' => $id,
                    'product' => $product,
                    'variant' => $item['variant_id'] ? ProductVariant::with(['size', 'color'])->find($item['variant_id']) : null,
                    'color' => $item['color'],
                    'size' => $item['size'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'original_price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'product_code' => $product->sku ?? 'N/A',
                    'product_name' => $product->name,
                    'product_image' => $product->images->first()->image_path ?? '/images/placeholder.jpg' // Fixed this line
                ], $item);
            }
        }

        return view('customer.cart-item', compact('cartItems', 'totalItems'));
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
            'message' => 'Cart updated successfully'
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
            return ProductCart::where('user_id', Auth::id())->sum('qty');
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
