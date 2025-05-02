<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand'])
            ->when($request->search, function ($q) use ($request) {
                return $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('short_des', 'like', '%' . $request->search . '%');
            })
            ->when($request->category, function ($q) use ($request) {
                return $q->where('category_id', $request->category);
            })
            ->when($request->brand, function ($q) use ($request) {
                return $q->where('brand_id', $request->brand);
            })
            ->when($request->stock == 'in_stock', function ($q) {
                return $q->where('stock', '>', 0);
            })
            ->when($request->stock == 'out_of_stock', function ($q) {
                return $q->where('stock', '<=', 0);
            })
            ->when($request->rating, function ($q) use ($request) {
                return $q->where('star', '>=', $request->rating);
            })
            ->when($request->sort == 'newest', function ($q) {
                return $q->latest();
            })
            ->when($request->sort == 'price_high', function ($q) {
                return $q->orderBy('price', 'desc');
            })
            ->when($request->sort == 'price_low', function ($q) {
                return $q->orderBy('price', 'asc');
            }) // Default sorting if none specified
            ->when(!$request->sort, function ($q) {
                return $q->latest();
            });

        $products = $query->paginate(10);
        $categories = Category::all();
        $brands = Brand::all();
        // dd($products, $categories, $brands);
        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.modals.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'short_des' => 'required|string|max:500',
            'price' => 'required|numeric',
            'discount' => 'nullable|boolean',
            'discount_price' => 'nullable|required_if:discount,1|numeric',
            'image' => 'required|image|max:2048',
            'stock' => 'required|boolean',
            'star' => 'nullable|numeric|min:0|max:5',
            'remark' => 'nullable|in:popular,new,top,special,trending,regular',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'des' => 'required|string',
            'color' => 'nullable|string|max:200',
            'size' => 'nullable|string|max:200',
            'img1' => 'nullable|image|max:2048',
            'img2' => 'nullable|image|max:2048',
            'img3' => 'nullable|image|max:2048',
            'img4' => 'nullable|image|max:2048',
        ]);

        // Handle main product image upload
        $imagePath = $request->file('image')->store('products', 'public');
        $validated['image'] = $imagePath;

        // Create the product
        $product = Product::create([
            'title' => $validated['title'],
            'short_des' => $validated['short_des'],
            'price' => $validated['price'],
            'discount' => $validated['discount'] ?? false,
            'discount_price' => $validated['discount_price'] ?? null,
            'image' => $validated['image'],
            'stock' => $validated['stock'],
            'star' => $validated['star'] ?? 0,
            'remark' => $validated['remark'] ?? 'regular',
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
        ]);

        // Handle additional images
        $imagePaths = [];
        foreach (['img1', 'img2', 'img3', 'img4'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $imagePaths[$imgField] = $request->file($imgField)->store('product_details', 'public');
            }
        }

        // Create product details
        $product->details()->create([
            'img1' => $imagePaths['img1'] ?? null,
            'img2' => $imagePaths['img2'] ?? null,
            'img3' => $imagePaths['img3'] ?? null,
            'img4' => $imagePaths['img4'] ?? null,
            'des' => $validated['des'],
            'color' => $validated['color'] ?? null,
            'size' => $validated['size'] ?? null,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
