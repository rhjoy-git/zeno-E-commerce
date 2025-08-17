<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
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

        $product->variants()->create($validated + ['created_by' => auth()->id()]);

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

        $variant->update($validated + ['updated_by' => auth()->id()]);

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant updated successfully');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        $variant->delete();

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant deleted successfully');
    }
}
