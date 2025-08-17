<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VariantController extends Controller
{
    public function index(Product $product)
    {
        $variants = $product->variants()->with(['color', 'size'])->get();
        return view('admin.products.variants.index', compact('product', 'variants'));
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
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:product_sizes,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'stock_alert' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|unique:product_variants,sku',
            'image' => 'nullable|image|max:2048'
        ]);

        $variant = $product->variants()->create($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products/variants', 'public');
            $variant->update(['image_path' => $path]);
        }

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
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:product_sizes,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'stock_alert' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|unique:product_variants,sku,' . $variant->id,
            'image' => 'nullable|image|max:2048'
        ]);

        $variant->update($validated);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($variant->image_path) {
                Storage::disk('public')->delete($variant->image_path);
            }

            $path = $request->file('image')->store('products/variants', 'public');
            $variant->update(['image_path' => $path]);
        }

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant updated successfully');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        if ($variant->image_path) {
            Storage::disk('public')->delete($variant->image_path);
        }

        $variant->delete();

        return back()->with('success', 'Variant deleted successfully');
    }
}
