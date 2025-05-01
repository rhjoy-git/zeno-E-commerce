<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    // Index - List all brands
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('admin.brands.index', compact('brands'));
    }
    // Route

    // Controller Method
    public function show($id)
    {
        $brand = Brand::with('products')->findOrFail($id);
        return view('frontend.brand-products', compact('brand'));
    }
    // Store - Create new brand
    public function store(Request $request)
    {
        $request->validate([
            'brandName' => 'required|string|max:50',
            'brandImg' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('brandImg')->store('brands', 'public');

        Brand::create([
            'brandName' => $request->brandName,
            'brandImg' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Brand created successfully!');
    }

    // Update - Edit existing brand
    public function update(Request $request, $id)
    {
        $request->validate([
            'brandName' => 'required|string|max:50',
            'brandImg' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $brand = Brand::findOrFail($id);
        $data = ['brandName' => $request->brandName];

        if ($request->hasFile('brandImg')) {
            Storage::delete('public/' . $brand->brandImg);
            $data['brandImg'] = $request->file('brandImg')->store('brands', 'public');
        }

        $brand->update($data);
        return redirect()->back()->with('success', 'Brand updated successfully!');
    }

    // Destroy - Delete brand
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // Check if brand has products
        if ($brand->products()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete brand with associated products');
        }

        $brand->delete();
        return redirect()->back()->with('success', 'Brand deleted successfully');
    }
}
