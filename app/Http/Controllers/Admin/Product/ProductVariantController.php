<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
        if (!$product->has_variants) {
            abort(404, 'This product does not have variants enabled.');
        }

        $variants = $product->variants()->with(['color', 'size'])->get();
        $colors = Color::all();
        $sizes = ProductSize::all();

        return view('admin.products.variants.index', compact('product', 'variants', 'colors', 'sizes'));
    }

    public function create(Product $product)
    {
        $colors = Color::all();
        $sizes = ProductSize::all();

        return view('admin.products.variants.create', compact('product', 'colors', 'sizes'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:product_sizes,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'stock_alert' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|unique:product_variants,sku',
            'status' => 'required|in:active,inactive'
        ]);

        $product->variants()->create($validated + ['created_by' => Auth::id()]);

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant created successfully');
    }

    public function edit(Product $product, ProductVariant $variant)
    {
        $colors = Color::all();
        $sizes = ProductSize::all();

        return view('admin.products.variants.edit', compact('product', 'variant', 'colors', 'sizes'));
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        $validated = $request->validate([
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:product_sizes,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'stock_alert' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|unique:product_variants,sku,' . $variant->id,
            'status' => 'required|in:active,inactive'
        ]);

        $variant->update($validated + ['updated_by' => Auth::id()]);

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant updated successfully');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        $variant->delete();

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant deleted successfully');
    }

    protected function generateSku($title)
    {
        $prefix = strtoupper(substr(preg_replace('/[^a-z]/i', '', $title), 0, 3));
        $random = mt_rand(10000, 99999);
        return $prefix . '-' . $random;
    }

    public function checkSku(Request $request, Product $product)
    {
        $request->validate([
            'sku' => 'required|string|max:255',
        ]);

        $sku = $request->input('sku');
        $isAvailable = !ProductVariant::where('product_id', $product->id)
            ->where('sku', $sku)
            ->exists();

        return response()->json([
            'isAvailable' => $isAvailable,
            'productID' => $product->id,
            'sku' => $sku,
            'message' => $isAvailable ? 'SKU is available' : 'SKU is already taken'
        ]);
    }
}
