<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Tag;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand', 'images' => function ($q) {
            $q->where('is_primary', true);
        }])->latest()->paginate(20);

        $categories = Category::active()->get();
        $brands     = Brand::active()->get();
        $tags       = Tag::all();

        return view('admin.products.index', compact('products', 'categories', 'brands', 'tags'));
    }

    public function create()
    {
        return view('admin.products.modals.create', [
            'categories' => Category::active()->get(),
            'brands' => Brand::active()->get(),
            'tags' => Tag::all(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $product = Product::create([
                'title' => $request->title,
                'short_description' => $request->short_description,
                'price' => $request->price,
                // 'discount' => $request->boolean('discount'),
                // 'discount_price' => $request->discount ? $request->discount_price : null,
                'stock_quantity' => $request->stock_quantity ?? 0,
                'stock_alert' => $request->stock_alert,
                'status' => $request->status,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'slug' => Str::slug($request->title) . '-' . uniqid(),
                'sku' => $request->sku ?? $this->generateSku($request->title),
                'has_variants' => $request->boolean('has_variants'),
            ]);

            // Handle tags
            if ($request->filled('tags')) {
                $product->tags()->sync($request->tags);
            }

            // Handle primary image
            if ($request->hasFile('primary_image')) {
                $path = $request->file('primary_image')->store('products/images', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => true
                ]);
            }

            // Handle additional images
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $image) {
                    $path = $image->store('products/images', 'public');
                    $product->images()->create(['image_path' => $path]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }

    public function show(Product $product)
    {
        $product->load([
            'category',
            'brand',
            'tags',
            'images',
            'variants.color',
            'variants.size',
            'reviews'
        ]);

        return view('admin.products.modals.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.modals.edit', [
            'product' => $product,
            'categories' => Category::active()->get(),
            'brands' => Brand::active()->get(),
            'tags' => Tag::all(),
            'selectedTags' => $product->tags->pluck('id')->toArray()
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::beginTransaction();

        try {
            $product->update([
                'title' => $request->title,
                'short_description' => $request->short_description,
                'price' => $request->price,
                // 'discount' => $request->boolean('discount'),
                // 'discount_price' => $request->discount ? $request->discount_price : null,
                'stock_quantity' => $request->stock_quantity ?? 0,
                'stock_alert' => $request->stock_alert,
                'status' => $request->status,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'has_variants' => $request->has_variants,
            ]);

            // Handle tags
            $product->tags()->sync($request->tags ?? []);

            // Handle primary image update
            if ($request->hasFile('primary_image')) {
                // Delete old primary image if exists
                $oldPrimary = $product->images()->where('is_primary', true)->first();
                if ($oldPrimary) {
                    Storage::disk('public')->delete($oldPrimary->image_path);
                    $oldPrimary->delete();
                }

                // Store new primary image
                $path = $request->file('primary_image')->store('products/images', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => true
                ]);
            }

            // Handle additional images
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $image) {
                    $path = $image->store('products/images', 'public');
                    $product->images()->create(['image_path' => $path]);
                }
            }

            // Handle image removals
            if ($request->filled('remove_images')) {
                $imagesToDelete = $product->images()
                    ->whereIn('id', $request->remove_images)
                    ->get();

                foreach ($imagesToDelete as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            // Delete associated images
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            // Detach tags
            $product->tags()->detach();

            // Delete variants if any
            $product->variants()->delete();

            // Delete the product
            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    public function updateStatus(Product $product, $status)
    {
        if (!in_array($status, ['active', 'inactive', 'discontinued'])) {
            return response()->json(['error' => 'Invalid status'], 400);
        }

        $product->update(['status' => $status]);

        return response()->json(['success' => true]);
    }

    public function updateStock(Product $product, Request $request)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0'
        ]);

        $product->update(['stock_quantity' => $request->stock_quantity]);

        return response()->json(['success' => true]);
    }

    protected function generateSku($title)
    {
        $prefix = strtoupper(substr(preg_replace('/[^a-z]/i', '', $title), 0, 3));
        $random = mt_rand(1000, 9999);
        return $prefix . '-' . $random;
    }
}
