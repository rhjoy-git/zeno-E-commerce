<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public $products = [
        [
            'image' => 'images/1.jpg',
            'title' => "Men's Casual Shirt",
            'price' => 49.99,
            'badge' => 'New',
            'stock' => true,
            'categories' => 'men women',
        ],
        [
            'image' => 'images/2.jpg',
            'title' => 'Vintage Hoodie',
            'price' => 89.99,
            'badge' => 'Sale',
            'stock' => false,
            'categories' => 'men',
        ],
        [
            'image' => 'images/3.jpg',
            'title' => 'Ladies T-Shirt',
            'price' => 29.99,
            'badge' => 'Hot',
            'stock' => true,
            'categories' => 'women',
        ],
        [
            'image' => 'images/4.jpg',
            'title' => 'Running Shoes',
            'price' => 119.99,
            'badge' => 'New',
            'stock' => false,
            'categories' => 'men women',
        ],
        [
            'image' => 'images/5.jpg',
            'title' => 'Winter Jacket',
            'price' => 149.99,
            'badge' => 'Limited',
            'stock' => true,
            'categories' => 'kids women',
        ],
        [
            'image' => 'images/6.jpg',
            'title' => 'Winter Jacket',
            'price' => 149.99,
            'badge' => 'Limited',
            'stock' => false,
            'categories' => 'men women',
        ],
        [
            'image' => 'images/7.jpg',
            'title' => 'Winter Jacket',
            'price' => 149.99,
            'badge' => 'Limited',
            'stock' => true,
            'categories' => 'kids women',
        ],
        [
            'image' => 'images/8.jpg',
            'title' => 'Winter Jacket',
            'price' => 149.99,
            'badge' => 'Limited',
            'stock' => false,
            'categories' => 'men women',
        ],
    ];
    public function index()
    {
        return view('frontend.product-list', ['products' => $this->products]);
    }
    public function show(string $id)
    {
        return view('frontend.product-details', ['products' => $this->products]);
    }

    public function getVariants(Request $request)
    {
        try {
            $productId = $request->input('product_id');

            // Fetch the product with its variants, colors, sizes, etc.
            $product = Product::with([
                'variants.color',
                'variants.size',
                'images'
            ])->findOrFail($productId);

            // Format the data for the frontend
            $response = [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'discount_price' => $product->discount ? $product->discount_price : null,
                'has_variants' => $product->has_variants,
                'short_description' => $product->short_description,
                'images' => $product->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'path' => Storage::url($image->image_path),
                        'is_primary' => $image->is_primary
                    ];
                }),
                // Only include active variants
                'variants' => $product->variants->where('status', 'active')->map(function ($variant) {
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
            ];
            // dd($response);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Product not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
