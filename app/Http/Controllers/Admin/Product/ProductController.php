<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::with([
            'category',
            'brand',
            'images' => function ($q) {
                $q->where('is_primary', true);
            }
        ])->withAvg('approvedReviews as avg_rating', 'rating')
            ->when($request->search, function ($q) use ($request) {
                return $q->where(function ($q2) use ($request) {
                    $q2->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('short_des', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->category, function ($q) use ($request) {
                return $q->where('category_id', $request->category);
            })
            ->when($request->brand, function ($q) use ($request) {
                return $q->where('brand_id', $request->brand);
            })
            ->when($request->stock == 'in_stock', function ($q) {
                return $q->where('stock_quantity', '>', 0);
            })
            ->when($request->stock == 'out_of_stock', function ($q) {
                return $q->where('stock_quantity', '<=', 0);
            })
            ->when($request->rating, function ($q) use ($request) {
                return $q->having('avg_rating', '>=', $request->rating);
            })
            ->when($request->sort == 'newest', function ($q) {
                return $q->latest();
            })
            ->when($request->sort == 'price_high', function ($q) {
                return $q->orderBy('price', 'desc');
            })
            ->when($request->sort == 'price_low', function ($q) {
                return $q->orderBy('price', 'asc');
            })
            ->when(!$request->sort, function ($q) {
                return $q->latest();
            });

        $products = $query->paginate(20);
        $categories = Category::all();
        $brands = Brand::all();
        // dd($products);
        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(?Brand $brand = null, ?Category $category = null)
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.modals.create', [
            'categories' => $categories,
            'brands' => $brands,
            'categorySelected' => $category?->id,
            'brandSelected' => $brand?->id,
            'colors' => Color::all(),
            'sizes' => ProductSize::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // dd($request->all());
            // Validate the request data
            $validated = $request->validate([
                'title' => 'required|string|max:200',
                'short_des' => 'nullable|string|max:500',
                'price' => 'required|numeric|min:0',
                'discount' => 'nullable|boolean',
                'discount_price' => 'required_if:discount,1|numeric|min:0',
                'sku' => 'required|string|max:100|unique:products,sku',
                'stock_quantity' => 'nullable|numeric|min:0',
                'stock_alert' => 'nullable|numeric|min:0',
                'status' => 'nullable|in:active,inactive,discontinued',
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
                'description' => 'nullable|string',
                'specifications' => 'nullable|string',
                'tags_array' => 'nullable|string',
                'variants' => 'required|array|min:1',
                'variants.*.color_id' => 'required|exists:colors,id',
                'variants.*.price' => 'required|numeric|min:0',
                'variants.*.stock_quantity' => 'nullable|numeric|min:0',
                'variants.*.stock_alert' => 'nullable|numeric|min:0',
                'variants.*.sizes' => 'required|array|min:1',
                'variants.*.sizes.*.id' => 'required|exists:product_sizes,id'
            ], [
                'variants.required' => 'At least one variant is required.',
                'variants.*.color_id.required' => 'Color is required for all variants.',
                'variants.*.sizes.required' => 'At least one size is required for each variant.',
                'variants.*.sizes.*.id.required' => 'Size selection is invalid.',
            ]);

            // Create the main product
            $product = Product::create([
                'title' => $validated['title'],
                'short_des' => $validated['short_des'] ?? null,
                'price' => $validated['price'],
                'discount' => (bool) $validated['discount'],
                'discount_price' => $validated['discount_price'] ?? null,
                'sku' => $validated['sku'],
                'stock_quantity' => $validated['stock_quantity'] ?? 0,
                'stock_alert' => $validated['stock_alert'] ?? null,
                'status' => $validated['status'],
                'category_id' => $validated['category_id'],
                'brand_id' => $validated['brand_id'],
                'slug' => Str::slug($validated['title']) . '-' . uniqid(),
            ]);

            // Create product details
            $product->productDetail()->create([
                'description' => $validated['description'] ?? null,
                'specifications' => $validated['specifications'] ?? null,
            ]);

            // Handle tags
            if ($request->filled('tags_array')) {
                $tags = json_decode($request->input('tags_array'), true);

                foreach ($tags as $tag) {
                    if (!empty($tag)) {
                        $product->tags()->create([
                            'tag' => $tag
                        ]);
                    }
                }
            }

            // Handle variants
            foreach ($request->input('variants') as $variantIndex => $variantData) {
                foreach ($variantData['sizes'] as $size) {
                    // Create variant for each size
                    $variant = $product->variants()->create([
                        'color' => $variantData['color_name'],
                        'hex_code' => $variantData['color_code'],
                        'size' => $size['name'],
                        'stock_quantity' => $variantData['stock_quantity'] ?? 0,
                        'stock_alert' => $variantData['stock_alert'] ?? null,
                        'price' => $variantData['price'],
                        'status' => 'active',
                        'sku' => $validated['sku'] . '-' . $variantData['color_id'] . '-' . $size['id'],
                    ]);

                    // Handle variant images if they exist
                    if ($request->hasFile("variants.{$variantIndex}.images")) {
                        foreach ($request->file("variants.{$variantIndex}.images") as $image) {
                            $imagePath = $image->store('images/products/variants', 'public');

                            $isFirstVariant = $variantIndex === 0;
                            $isFirstSize = $size['id'] === $variantData['sizes'][0]['id'];

                            $product->images()->create([
                                'image_path' => $imagePath,
                                'variant_id' => $variant->id,
                                'is_primary' => $isFirstVariant && $isFirstSize,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::with([
                'category' => function ($query) {
                    $query->with('parent');
                },
                'brand',
                'productDetail',
                'tags',
                'variants',
                'images' => function ($query) {
                    $query->orderBy('is_primary', 'desc');
                },
                'reviews' => function ($query) {
                    $query->with('customerProfile')->latest();
                }
            ])->findOrFail($id);

            // Calculate profit margin (assuming you have cost_price in your DB)
            $costPrice = $product->cost_price ?? 0; // Replace with your actual cost price field
            $sellingPrice = $product->discount ? $product->discount_price : $product->price;
            $margin = $costPrice > 0 ? (($sellingPrice - $costPrice) / $costPrice) * 100 : 0;

            // Add calculated fields to product object
            $product->profit_margin = $margin;
            $product->stock_value = $product->stock_quantity * $sellingPrice;

            return view('admin.products.modals.show', compact('product'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load product details: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $product = Product::with(['category', 'brand', 'productDetail'])->findOrFail($id);
            $categories = Category::all();
            $brands = Brand::all();

            return view('admin.products.modals.edit', compact('product', 'categories', 'brands'));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $product = Product::with(['productDetail', 'productImages'])->findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:200',
                'short_des' => 'required|string|max:500',
                'price' => 'required|numeric|min:0',
                'discount' => 'nullable|boolean',
                'discount_price' => 'nullable|required_if:discount,1|numeric',
                'sku' => 'required|string|max:100|unique:products,sku,' . $id,
                'stock' => 'nullable|boolean',
                'stock_quantity' => 'nullable|required_if:stock,1|numeric',
                'stock_alert' => 'nullable|numeric',
                'star' => 'nullable|numeric|min:0|max:5',
                'remark' => 'required|in:popular,new,top,special,trending,regular',
                'status' => 'required|in:active,inactive,discontinued',
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
                'des' => 'required|string',
                'color' => 'required|string|max:200',
                'size' => 'required|string|max:200',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpg,png,jpeg|max:2048',
                'image_colors' => 'nullable|array',
                'image_colors.*' => 'nullable|string|max:50',
                'image_sizes' => 'nullable|array',
                'image_sizes.*' => 'nullable|string|max:50',
                'existing_images' => 'nullable|array',
                'existing_images.*' => 'numeric|exists:product_images,id',
            ]);

            // Update product
            $product->update([
                'title' => $validated['title'],
                'short_des' => $validated['short_des'],
                'price' => $validated['price'],
                'discount' => $validated['discount'] ?? false,
                'discount_price' => $validated['discount_price'] ?? null,
                'sku' => $validated['sku'],
                'stock' => $validated['stock'] ?? true,
                'stock_quantity' => $validated['stock_quantity'] ?? null,
                'stock_alert' => $validated['stock_alert'] ?? null,
                'star' => $validated['star'] ?? 0,
                'remark' => $validated['remark'],
                'status' => $validated['status'],
                'category_id' => $validated['category_id'],
                'brand_id' => $validated['brand_id'],
            ]);

            // Update product details
            if ($product->productDetail) {
                $product->productDetail()->update([
                    'des' => $validated['des'],
                    'color' => $validated['color'],
                    'size' => $validated['size'],
                ]);
            } else {
                $product->productDetail()->create([
                    'des' => $validated['des'],
                    'color' => $validated['color'],
                    'size' => $validated['size'],
                ]);
            }

            // Handle existing images - delete those not in the request
            if ($request->has('existing_images')) {
                $imagesToKeep = $request->input('existing_images', []);
                $imagesToDelete = $product->productImages()->whereNotIn('id', $imagesToKeep)->get();

                foreach ($imagesToDelete as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            } else {
                // If no existing images are selected, delete all
                foreach ($product->productImages as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }

            // Add new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('images/products', 'public');

                    $product->productImages()->create([
                        'image_path' => $imagePath,
                        'image_color' => $validated['image_colors'][$index] ?? null,
                        'image_size' => $validated['image_sizes'][$index] ?? null,
                        'status' => 'active'
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
    // Update the status of a product
    public function updateStatus(Request $request, Product $product)
    {

        $request->validate([
            'status' => 'required|in:active,inactive,discontinued'
        ]);

        $product->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
    // Update the stock of a product
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0'
        ]);

        $product->update([
            'stock_quantity' => $request->stock_quantity
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
}
