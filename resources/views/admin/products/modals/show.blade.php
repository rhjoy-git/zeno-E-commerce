@extends('layouts.admin')
@section('title', 'Product Details')
@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white  p-6">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Product Details</h1>
                <p class="text-gray-600 mt-1">View complete product information</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.products.edit', $product) }}"
                    class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors text-base">
                    Edit Product
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="px-4 py-2 bg-black text-white hover:bg-gray-800 transition-colors text-base">
                    Back to Products
                </a>
            </div>
        </div>

        <!-- Product Details Card -->
        <div class="bg-white border border-gray-200">
            <!-- Product Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">{{ $product->title }}</h2>
                <p class="text-gray-600 mt-1">SKU: {{ $product->sku }}</p>
            </div>

            <!-- Product Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Product Image -->
                    <div>
                        @php
                        $primaryImage = $product->images->where('is_primary', true)->first();
                        @endphp
                        <img src="{{ $primaryImage ? Storage::url($primaryImage->image_path) : asset('images/default.png') }}"
                            alt="{{ $product->title }}" class="w-full h-auto max-h-[400px]">
                    </div>

                    <!-- Product Details -->
                    <div class="space-y-6">
                        <!-- Price Section -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Pricing</h3>
                            <div class="flex items-center space-x-4">
                                <span class="text-2xl font-bold text-gray-900">
                                    {{ number_format($product->price, 2) }}৳
                                </span>
                            </div>
                        </div>

                        <!-- Stock & Status -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Stock Quantity</p>
                                <p class="text-base text-gray-900">
                                    <span
                                        class="{{ $product->stock_quantity <= $product->stock_alert ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                    @if ($product->stock_quantity <= $product->stock_alert)
                                        <span class="text-sm text-red-500 ml-2">(Low stock alert)</span>
                                        @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Low Stock Alert</p>
                                <p class="text-base text-gray-900">{{ $product->stock_alert }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <p class="text-base">
                                    <span class="px-2 py-1 text-sm font-medium rounded-full 
                                    {{ $product->status === 'active'
                                        ? 'bg-green-100 text-green-800'
                                        : ($product->status === 'inactive'
                                            ? 'bg-gray-100 text-gray-800'
                                            : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Has Variants</p>
                                <p class="text-base text-gray-900">
                                    <span
                                        class="px-2 py-1 text-sm font-medium rounded-full 
                                            {{ $product->has_variants ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $product->has_variants ? 'Yes' : 'No' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Category</p>
                                <p class="text-base text-gray-900">{{ $product->category->category_name ??
                                    'Uncategorized' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Brand</p>
                                <p class="text-base text-gray-900">{{ $product->brand->brand_name ?? 'No brand' }}</p>
                            </div>
                        </div>

                        <!-- Short Description -->
                        @if($product->short_description)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Short Description</h3>
                            <div class="prose max-w-none text-base text-gray-700">
                                {{ $product->short_description }}
                            </div>
                        </div>
                        @endif

                        <!-- Product Tags -->
                        @if($product->tags->count() > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->tags as $tag)
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">
                                    {{ $tag->name }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Sections -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Variants Section -->
            @if ($product->has_variants && $product->variants->isNotEmpty())
            <div class="bg-white border border-gray-200 ">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Product Variants</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Option</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Price</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Stock</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">SKU</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($product->variants as $variant)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                        {{ $variant->option }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                        {{ number_format($variant->price, 2) }}৳
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                        {{ $variant->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                        {{ $variant->sku ?? 'N/A' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Additional Images -->
            @php
            $additionalImages = $product->images->where('is_primary', false);
            @endphp
            @if ($additionalImages->count() > 0)
            <div class="bg-white border border-gray-200 ">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Additional Images ({{ $additionalImages->count() }})
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach ($additionalImages as $image)
                        <div class="relative group">
                            <img src="{{ Storage::url($image->image_path) }}" alt="Product image {{ $loop->iteration }}"
                                class="w-full h-32 object-cover  border border-gray-200">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Metadata -->
        <div class="mt-6 bg-white border border-gray-200 ">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Product Metadata</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Created At</p>
                    <p class="text-base text-gray-900">{{ $product->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Updated At</p>
                    <p class="text-base text-gray-900">{{ $product->updated_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Images</p>
                    <p class="text-base text-gray-900">{{ $product->images->count() }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Tags</p>
                    <p class="text-base text-gray-900">{{ $product->tags->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection