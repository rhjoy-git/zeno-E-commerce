<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('parent')
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->when(request('search'), function ($query) {
                $query->where('category_name', 'like', '%' . request('search') . '%');
            })
            ->latest()
            ->paginate(20);

        // Get only parent categories for dropdowns
        $parentCategories = Category::whereNull('parent_id')
            ->when(request('status') === 'active', function ($query) {
                $query->where('status', 'active');
            })
            ->get();

        return view('admin.categories.index', [
            'categories' => $categories,
            'parentCategories' => $parentCategories
        ]);
    }

    // Show - find Category by id
    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        // dd($Category);
        return view('admin.categories.category-products', compact('category'));
    }
    // Store - Create new Category
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:50|unique:categories,category_name',
            'parent_id' => 'nullable|integer|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'category_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Changed from categoryImg to category_image
        ]);

        $imagePath = $request->file('category_image')->store('images/categories', 'public'); // Changed from categoryImg to category_image

        Category::create([
            'category_name' => $request->category_name,
            'parent_id' => $request->parent_id,
            'status' => $request->status ?? 'active',
            'category_image' => $imagePath, // Changed from categoryImg to category_image
        ]);

        return redirect()->back()->with('success', 'Category created successfully!');
    }

    // Update - Edit existing Category
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'category_name' => 'required|string|max:50|unique:categories,category_name,' . $id,
            'parent_id' => 'nullable|integer|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Changed from categoryImg to category_image
        ]);

        $category = Category::findOrFail($id);
        $data = [
            'category_name' => $request->category_name,
            'parent_id' => $request->parent_id,
            'status' => $request->status ?? 'active',
        ];

        if ($request->hasFile('category_image')) {
            // Delete old image if exists
            if ($category->category_image) {
                Storage::delete('public/' . $category->category_image);
            }
            $data['category_image'] = $request->file('category_image')->store('images/categories', 'public'); 
        }

        $category->update($data);
        return redirect()->back()->with('success', 'Category updated successfully!');
    }
    // Update Category Status
    public function updateStatus(Request $request, Category $category)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $category->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }


    // Destroy - Delete Category
    public function destroy($id)
    {
        $Category = Category::findOrFail($id);

        // Check if Category has products
        if ($Category->products()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete Category with associated products');
        }

        $Category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
