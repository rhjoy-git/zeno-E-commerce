@extends('layouts.admin')
@section('title', 'Create New Product')
@section('content')
@include('admin.partials.bashboard-header')

<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Product</h2>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Basic Information Card -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Basic Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Product Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div>
                        <label for="short_des" class="block text-sm font-medium text-gray-700 mb-1">Short Description
                            *</label>
                        <textarea id="short_des" name="short_des" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>{{ old('short_des') }}</textarea>
                        @error('short_des')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Selection -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                        <select id="category_id" name="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : ''
                                }}>
                                {{ $category->categoryName }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Brand Selection -->
                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">Brand *</label>
                        <select id="brand_id" name="brand_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id')==$brand->id ? 'selected' : '' }}>
                                {{ $brand->brandName }}
                            </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing & Inventory Card -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Pricing & Inventory</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}"
                                class="block w-full pl-7 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0.00" required>
                        </div>
                        @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Discount -->
                    <div>
                        <label for="discount" class="block text-sm font-medium text-gray-700 mb-1">Discount</label>
                        <div class="flex items-center">
                            <input type="checkbox" id="discount" name="discount" value="1" {{ old('discount')
                                ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="discount" class="ml-2 block text-sm text-gray-700">Apply Discount</label>
                        </div>
                    </div>

                    <!-- Discount Price (shown only if discount is checked) -->
                    <div id="discountPriceContainer" style="{{ old('discount') ? '' : 'display: none;' }}">
                        <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-1">Discount Price
                            *</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" step="0.01" id="discount_price" name="discount_price"
                                value="{{ old('discount_price') }}"
                                class="block w-full pl-7 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0.00" {{ old('discount') ? 'required' : '' }}>
                        </div>
                        @error('discount_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Status *</label>
                        <select id="stock" name="stock"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="1" {{ old('stock', 1) ? 'selected' : '' }}>In Stock</option>
                            <option value="0" {{ !old('stock', 1) ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>

                    <!-- Star Rating -->
                    <div>
                        <label for="star" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                        <select id="star" name="star"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="0" {{ old('star')==0 ? 'selected' : '' }}>No Rating</option>
                            <option value="1" {{ old('star')==1 ? 'selected' : '' }}>1 Star</option>
                            <option value="2" {{ old('star')==2 ? 'selected' : '' }}>2 Stars</option>
                            <option value="3" {{ old('star')==3 ? 'selected' : '' }}>3 Stars</option>
                            <option value="4" {{ old('star')==4 ? 'selected' : '' }}>4 Stars</option>
                            <option value="5" {{ old('star')==5 ? 'selected' : '' }}>5 Stars</option>
                        </select>
                    </div>

                    <!-- Remark -->
                    <div>
                        <label for="remark" class="block text-sm font-medium text-gray-700 mb-1">Remark</label>
                        <select id="remark" name="remark"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="regular" {{ old('remark')=='regular' ? 'selected' : '' }}>Regular</option>
                            <option value="popular" {{ old('remark')=='popular' ? 'selected' : '' }}>Popular</option>
                            <option value="new" {{ old('remark')=='new' ? 'selected' : '' }}>New</option>
                            <option value="top" {{ old('remark')=='top' ? 'selected' : '' }}>Top</option>
                            <option value="special" {{ old('remark')=='special' ? 'selected' : '' }}>Special</option>
                            <option value="trending" {{ old('remark')=='trending' ? 'selected' : '' }}>Trending</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Images Card -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Product Images</h3>

                <!-- Main Product Image -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Main Product Image *</label>
                    <div class="mt-1 flex items-center">
                        <input type="file" id="image" name="image" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            required>
                    </div>
                    @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Product Details Card -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Product Details</h3>

                <!-- Full Description -->
                <div class="mb-6">
                    <label for="des" class="block text-sm font-medium text-gray-700 mb-1">Full Description *</label>
                    <textarea id="des" name="des" rows="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required>{{ old('des') }}</textarea>
                    @error('des')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Images -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="img1" class="block text-sm font-medium text-gray-700 mb-1">Additional Image
                            1</label>
                        <input type="file" id="img1" name="img1" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div>
                        <label for="img2" class="block text-sm font-medium text-gray-700 mb-1">Additional Image
                            2</label>
                        <input type="file" id="img2" name="img2" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div>
                        <label for="img3" class="block text-sm font-medium text-gray-700 mb-1">Additional Image
                            3</label>
                        <input type="file" id="img3" name="img3" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div>
                        <label for="img4" class="block text-sm font-medium text-gray-700 mb-1">Additional Image
                            4</label>
                        <input type="file" id="img4" name="img4" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <!-- Color & Size -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                        <input type="text" id="color" name="color" value="{{ old('color') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g. Red, Blue, Black">
                    </div>
                    <div>
                        <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                        <input type="text" id="size" name="size" value="{{ old('size') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g. S, M, L, XL">
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.products.index') }}"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Show/hide discount price field based on discount checkbox
    document.getElementById('discount').addEventListener('change', function() {
        const discountPriceContainer = document.getElementById('discountPriceContainer');
        const discountPriceInput = document.getElementById('discount_price');
        
        if (this.checked) {
            discountPriceContainer.style.display = 'block';
            discountPriceInput.required = true;
        } else {
            discountPriceContainer.style.display = 'none';
            discountPriceInput.required = false;
            discountPriceInput.value = '';
        }
    });
</script>
@endsection