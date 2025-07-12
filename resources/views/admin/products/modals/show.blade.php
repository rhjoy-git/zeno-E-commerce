@extends('layouts.admin')
@section('title', 'Product Details')
@section('content')


<div class="container mx-auto px-4 py-6">
    <div class="w-full">
        <div class="bg-white overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800">Product Details</h3>
                <div>
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                        class="inline-flex items-center px-5 py-3 bg-black text-white text-sm">
                        <i class="fas fa-edit mr-1"></i> Edit Product
                    </a>
                </div>
            </div>
            <div class="p-6">
                <!-- General Information Section -->
                <div class="flex flex-col md:flex-row gap-6 mb-8">
                    <div class="w-full md:w-1/3">
                        <div class="text-center mb-4">
                            @if($product->images->where('is_primary', true)->first())
                            <img src="{{ asset('storage/' . $product->images->where('is_primary', true)->first()->image_path) }}"
                                class="w-full max-h-80 object-contain rounded" alt="{{ $product->title }}">
                            @elseif($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                class="w-full max-h-80 object-contain rounded" alt="{{ $product->title }}">
                            @else
                            <div class="bg-gray-100 flex items-center justify-center rounded" style="height: 300px;">
                                <span class="text-gray-500">No Image Available</span>
                            </div>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <div class="text-center">
                                <span class="text-gray-600 text-sm">Stock Status</span>
                                <div
                                    class="{{ $product->stock_quantity <= $product->stock_alert ? 'text-red-600' : 'text-green-600' }} font-medium text-lg">
                                    {{ $product->stock_quantity }} units
                                </div>
                                @if($product->stock_alert)
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                    <div class="{{ $product->stock_quantity <= $product->stock_alert ? 'bg-red-600' : 'bg-green-600' }} h-2.5 rounded-full"
                                        style="width: {{ min(100, ($product->stock_quantity / ($product->stock_alert * 2)) * 100) }}%;">
                                    </div>
                                </div>
                                <div
                                    class="mt-1 text-xs {{ $product->stock_quantity <= $product->stock_alert ? 'text-red-600' : 'text-green-600' }}">
                                    @if($product->stock_quantity <= $product->stock_alert)
                                        <i class="fas fa-exclamation-circle"></i> Below alert level ({{
                                        $product->stock_alert }})
                                        @else
                                        <i class="fas fa-check-circle"></i> Above alert level
                                        @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-2/3">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $product->title }}</h2>
                        <p class="text-gray-500 mb-4">{{ $product->short_des }}</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h5 class="font-semibold text-lg text-blue-800 mb-3">Basic Information</h5>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">SKU:</span>
                                        <span>{{ $product->sku }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Category:</span>
                                        <span>
                                            @if($product->category)
                                            {{ $product->category->categoryName }}
                                            @if($product->category->parent)
                                            ({{ $product->category->parent->categoryName }})
                                            @endif
                                            @else
                                            <span class="text-gray-500">Not assigned</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Brand:</span>
                                        <span>
                                            @if($product->brand)
                                            {{ $product->brand->brandName }}
                                            @else
                                            <span class="text-gray-500">Not assigned</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Status:</span>
                                        <span>
                                            @if($product->status == 'active')
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                            @elseif($product->status == 'inactive')
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Inactive</span>
                                            @else
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Discontinued</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Slug:</span>
                                        <span class="text-gray-600">{{ $product->slug }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 p-4 rounded-lg">
                                <h5 class="font-semibold text-lg text-green-800 mb-3">Pricing & Sales</h5>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Base Price:</span>
                                        <span>${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Discount:</span>
                                        <span>
                                            @if($product->discount && $product->discount_price)
                                            <span class="text-green-600">${{ number_format($product->discount_price, 2)
                                                }}</span>
                                            ({{ number_format((($product->price - $product->discount_price) /
                                            $product->price) * 100, 2) }}% off)
                                            @else
                                            <span class="text-gray-500">No discount</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Profit Margin:</span>
                                        <span>
                                            @php
                                            $costPrice = 0; // Replace with actual cost price field
                                            $sellingPrice = $product->discount ? $product->discount_price :
                                            $product->price;
                                            $margin = $costPrice > 0 ? (($sellingPrice - $costPrice) / $costPrice) * 100
                                            : 0;
                                            @endphp
                                            <span class="{{ $margin >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($margin, 2) }}%
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Total Stock Value:</span>
                                        <span>
                                            ${{ number_format($product->stock_quantity * ($product->discount ?
                                            $product->discount_price : $product->price), 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($product->tags->count() > 0)
                        <div class="mt-4">
                            <span class="font-medium text-gray-700">Tags:</span>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($product->tags as $tag)
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ $tag->tag
                                    }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Tabs for Additional Information -->
                <div class="mt-8">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px" id="product-tabs" role="tablist">
                                <li class="mr-2">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg active" id="variants-tab"
                                        data-tabs-target="#variants" type="button" role="tab" aria-controls="variants"
                                        aria-selected="true">Variants</button>
                                </li>
                                <li class="mr-2">
                                    <button
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        id="details-tab" data-tabs-target="#details" type="button" role="tab"
                                        aria-controls="details" aria-selected="false">Details</button>
                                </li>
                                <li class="mr-2">
                                    <button
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        id="images-tab" data-tabs-target="#images" type="button" role="tab"
                                        aria-controls="images" aria-selected="false">Images</button>
                                </li>
                                <li class="mr-2">
                                    <button
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        id="reviews-tab" data-tabs-target="#reviews" type="button" role="tab"
                                        aria-controls="reviews" aria-selected="false">Reviews</button>
                                </li>
                            </ul>
                        </div>
                        <div id="product-tabs-content" class="p-4">
                            <!-- Variants Tab -->
                            <div class="hidden p-4 rounded-lg bg-gray-50" id="variants" role="tabpanel"
                                aria-labelledby="variants-tab">
                                @if($product->variants->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Color</th>
                                                <th scope="col" class="px-6 py-3">Size</th>
                                                <th scope="col" class="px-6 py-3">SKU</th>
                                                <th scope="col" class="px-6 py-3">Price</th>
                                                <th scope="col" class="px-6 py-3">Stock</th>
                                                <th scope="col" class="px-6 py-3">Status</th>
                                                <th scope="col" class="px-6 py-3">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product->variants as $variant)
                                            <tr class="bg-white border-b hover:bg-gray-50 text-gray-800">
                                                <td class="px-6 py-4">
                                                    @if($variant->color)
                                                    <div class="flex items-center">
                                                        <span
                                                            class="w-5 h-5 rounded-full border border-gray-200 inline-block mr-2"
                                                            style="background-color: {{ $variant->hex_code }}"></span>
                                                        {{ $variant->color }}
                                                    </div>
                                                    @else
                                                    <span class="text-gray-400">N/A</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">{{ $variant->size ?? 'N/A' }}</td>
                                                <td class="px-6 py-4">{{ $variant->sku ?? $product->sku }}</td>
                                                <td class="px-6 py-4">${{ number_format($variant->price, 2) }}</td>
                                                <td
                                                    class="px-6 py-4 {{ $variant->stock_quantity <= $variant->stock_alert ? 'text-red-600' : '' }}">
                                                    {{ $variant->stock_quantity }}
                                                    @if($variant->stock_alert && $variant->stock_quantity <= $variant->
                                                        stock_alert)
                                                        <i class="fas fa-exclamation-circle ml-1"
                                                            title="Below stock alert level"></i>
                                                        @endif
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if($variant->status == 'active')
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                                    @else
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex space-x-2">
                                                        <button class="p-1 text-blue-600 hover:text-blue-800"
                                                            data-modal-target="#variantModal{{ $variant->id }}"
                                                            data-modal-toggle="variantModal{{ $variant->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <a href="#" class="p-1 text-blue-600 hover:text-blue-800">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="p-4 text-sm text-blue-700 bg-blue-50 rounded-lg">
                                    No variants found for this product.
                                </div>
                                @endif
                            </div>

                            <!-- Details Tab -->
                            <div class="hidden p-4 rounded-lg bg-gray-50" id="details" role="tabpanel"
                                aria-labelledby="details-tab">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h5 class="font-semibold text-lg mb-3">Description</h5>
                                        <div class="p-4 bg-white border border-gray-200 rounded-lg">
                                            {!! $product->productDetail->description ?? '<span class="text-gray-500">No
                                                description provided</span>' !!}
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-lg mb-3">Specifications</h5>
                                        <div class="p-4 bg-white border border-gray-200 rounded-lg">
                                            @if($product->productDetail && $product->productDetail->specifications)
                                            @php
                                            $specs = json_decode($product->productDetail->specifications, true);
                                            @endphp
                                            @if($specs && is_array($specs))
                                            <div class="space-y-2">
                                                @foreach($specs as $key => $value)
                                                <div class="flex justify-between">
                                                    <span class="font-medium">{{ $key }}:</span>
                                                    <span>{{ $value }}</span>
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            {!! $product->productDetail->specifications !!}
                                            @endif
                                            @else
                                            <span class="text-gray-500">No specifications provided</span>
                                            @endif
                                        </div>

                                        <h5 class="font-semibold text-lg mt-6 mb-3">Warranty</h5>
                                        <div class="p-4 bg-white border border-gray-200 rounded-lg">
                                            {{ $product->productDetail->warranty ?? 'No warranty information' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Images Tab -->
                            <div class="hidden p-4 rounded-lg bg-gray-50" id="images" role="tabpanel"
                                aria-labelledby="images-tab">
                                @if($product->images->count() > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    @foreach($product->images as $image)
                                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                            class="w-full h-48 object-cover" alt="Product Image">
                                        <div class="p-2">
                                            <div class="flex justify-between items-center">
                                                <span
                                                    class="text-xs px-2 py-1 rounded-full {{ $image->is_primary ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $image->is_primary ? 'Primary' : 'Secondary' }}
                                                </span>
                                                <div class="flex space-x-1">
                                                    <button class="p-1 text-yellow-500 hover:text-yellow-700"
                                                        title="Set as primary">
                                                        <i class="fas fa-star"></i>
                                                    </button>
                                                    <button class="p-1 text-red-500 hover:text-red-700"
                                                        title="Delete image">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @if($image->variant)
                                            <div class="mt-1 text-xs text-gray-500">
                                                Variant:
                                                @if($image->variant->color)
                                                <span
                                                    class="w-3 h-3 rounded-full border border-gray-200 inline-block align-middle"
                                                    style="background-color: {{ $image->variant->color }}"></span>
                                                @endif
                                                {{ $image->variant->color ?? '' }} {{ $image->variant->size ?? '' }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="p-4 text-sm text-blue-700 bg-blue-50 rounded-lg">
                                    No images uploaded for this product.
                                </div>
                                @endif
                            </div>

                            <!-- Reviews Tab -->
                            <div class="hidden p-4 rounded-lg bg-gray-50" id="reviews" role="tabpanel"
                                aria-labelledby="reviews-tab">
                                @if($product->reviews->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Rating</th>
                                                <th scope="col" class="px-6 py-3">Review</th>
                                                <th scope="col" class="px-6 py-3">Customer</th>
                                                <th scope="col" class="px-6 py-3">Date</th>
                                                <th scope="col" class="px-6 py-3">Status</th>
                                                <th scope="col" class="px-6 py-3">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product->reviews as $review)
                                            <tr class="bg-white border-b hover:bg-gray-50">
                                                <td class="px-6 py-4">
                                                    @for($i = 1; $i <= 5; $i++) @if($i <=$review->rating)
                                                        <i class="fas fa-star text-yellow-400"></i>
                                                        @else
                                                        <i class="far fa-star text-yellow-400"></i>
                                                        @endif
                                                        @endfor
                                                </td>
                                                <td class="px-6 py-4">{{ Str::limit($review->description, 100) }}</td>
                                                <td class="px-6 py-4">{{ $review->customer->name ?? 'Unknown' }}</td>
                                                <td class="px-6 py-4">{{ $review->created_at->format('M d, Y') }}</td>
                                                <td class="px-6 py-4">
                                                    @if($review->status == 'approved')
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                                                    @elseif($review->status == 'pending')
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                    @else
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex space-x-2">
                                                        <button class="p-1 text-blue-600 hover:text-blue-800"
                                                            data-modal-target="#reviewModal{{ $review->id }}"
                                                            data-modal-toggle="reviewModal{{ $review->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        @if($review->status != 'approved')
                                                        <button class="p-1 text-green-600 hover:text-green-800"
                                                            title="Approve">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        @endif
                                                        @if($review->status != 'rejected')
                                                        <button class="p-1 text-red-600 hover:text-red-800"
                                                            title="Reject">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="p-4 text-sm text-blue-700 bg-blue-50 rounded-lg">
                                    No reviews yet for this product.
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Variant Detail Modals -->
@foreach($product->variants as $variant)
<div id="variantModal{{ $variant->id }}" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">Variant Details</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="variantModal{{ $variant->id }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Color:</span>
                        <span>
                            @if($variant->color)
                            <div class="flex items-center">
                                <span class="w-5 h-5 rounded-full border border-gray-200 inline-block mr-2"
                                    style="background-color: {{ $variant->color }}"></span>
                                {{ $variant->color }}
                            </div>
                            @else
                            <span class="text-gray-400">N/A</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Size:</span>
                        <span>{{ $variant->size ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">SKU:</span>
                        <span>{{ $variant->sku ?? $product->sku }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Price:</span>
                        <span>${{ number_format($variant->price, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Stock Quantity:</span>
                        <span>{{ $variant->stock_quantity }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Stock Alert:</span>
                        <span>{{ $variant->stock_alert ?? 'Not set' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Status:</span>
                        <span>
                            @if($variant->status == 'active')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Inactive</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Created:</span>
                        <span>{{ $variant->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Last Updated:</span>
                        <span>{{ $variant->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button data-modal-hide="variantModal{{ $variant->id }}" type="button"
                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">Close</button>
                <a href="#"
                    class="ms-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Edit
                    Variant</a>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- Review Detail Modals -->
@foreach($product->reviews as $review)
<div id="reviewModal{{ $review->id }}" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">Review Details</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="reviewModal{{ $review->id }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <div>
                    <span class="font-medium text-gray-700">Rating:</span>
                    <div class="mt-1">
                        @for($i = 1; $i <= 5; $i++) @if($i <=$review->rating)
                            <i class="fas fa-star text-yellow-400"></i>
                            @else
                            <i class="far fa-star text-yellow-400"></i>
                            @endif
                            @endfor
                    </div>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Customer:</span>
                    <span class="ml-2">{{ $review->customer->name ?? 'Unknown' }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Date:</span>
                    <span class="ml-2">{{ $review->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Status:</span>
                    <span class="ml-2">
                        @if($review->status == 'approved')
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                        @elseif($review->status == 'pending')
                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @else
                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Review:</span>
                    <div class="mt-2 p-3 bg-gray-50 border border-gray-200 rounded">
                        {{ $review->description }}
                    </div>
                </div>
            </div>
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button data-modal-hide="reviewModal{{ $review->id }}" type="button"
                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">Close</button>
                @if($review->status != 'approved')
                <button type="button"
                    class="ms-3 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Approve</button>
                @endif
                @if($review->status != 'rejected')
                <button type="button"
                    class="ms-3 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Reject</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('[data-tabs-target]');
        const tabContents = document.querySelectorAll('[role="tabpanel"]');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = document.querySelector(tab.getAttribute('data-tabs-target'));
                
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                
                // Show selected tab content
                target.classList.remove('hidden');
                
                // Update active tab styling
                tabs.forEach(t => {
                    t.classList.remove('border-blue-600', 'text-blue-600');
                    t.classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                });
                
                tab.classList.add('border-blue-600', 'text-blue-600');
                tab.classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
            });
        });
        
        // Initialize first tab as active
        if (tabs.length > 0) {
            tabs[0].classList.add('border-blue-600', 'text-blue-600');
            tabs[0].classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
            document.querySelector(tabs[0].getAttribute('data-tabs-target')).classList.remove('hidden');
        }
    });
</script>

@endpush
@endsection