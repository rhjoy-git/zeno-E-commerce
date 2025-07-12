@extends('layouts.admin')
@section('title', 'Edit Product')
@section('content')



<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Product: {{ $product->title }}</h2>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Information Card -->
            <div class=" rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Basic Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Product Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $product->title) }}"
                            class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500"
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
                            class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>{{ old('short_des', $product->short_des) }}</textarea>
                        @error('short_des')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Selection -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                        <select id="category_id" name="category_id"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('category_id') ? 'border-red-500' : 'border-gray-400' }}"
                            required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) ==
                                $category->id)>
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
                            class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('brand_id') ? 'border-red-500' : 'border-gray-400' }}"
                            required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) ==
                                $brand->id)>
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
            <div class=" rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Pricing & Inventory</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" step="0.01" id="price" name="price"
                                value="{{ old('price', $product->price) }}"
                                class="block w-full pl-7 pr-12 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500"
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
                            <input type="checkbox" id="discount" name="discount" value="1" {{ old('discount',
                                $product->discount) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-1 focus:ring-blue-200
                            focus:ring-offset-0 focus:outline-none">
                            <label for="discount" class="ml-2 block text-sm text-gray-700">Apply Discount</label>
                        </div>
                    </div>

                    <!-- Discount Price -->
                    <div id="discountPriceContainer"
                        style="{{ old('discount', $product->discount) ? '' : 'display: none;' }}">
                        <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-1">Discount Price
                            *</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" step="0.01" id="discount_price" name="discount_price"
                                value="{{ old('discount_price', $product->discount_price) }}"
                                class="block w-full pl-7 pr-12 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0.00" {{ old('discount', $product->discount) ? 'required' : '' }}>
                        </div>
                        @error('discount_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Status *</label>
                        <select id="stock" name="stock"
                            class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="1" {{ old('stock', $product->stock) ? 'selected' : '' }}>In Stock</option>
                            <option value="0" {{ !old('stock', $product->stock) ? 'selected' : '' }}>Out of Stock
                            </option>
                        </select>
                    </div>

                    <!-- Stock Quantity -->
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock
                            Quantity</label>
                        <input type="text" id="stock_quantity" name="stock_quantity"
                            value="{{ old('stock_quantity', $product->stock_quantity) }}"
                            class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock Alert Level -->
                    <div>
                        <label for="stock_alert" class="block text-sm font-medium text-gray-700 mb-1">Stock Alert
                            Level</label>
                        <input type="text" id="stock_alert" name="stock_alert"
                            value="{{ old('stock_alert', $product->stock_alert) }}"
                            class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @error('stock_alert')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Star Rating -->
                    <div>
                        <label for="star" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                        <select id="star" name="star"
                            class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="0" {{ old('star', $product->star) == 0 ? 'selected' : '' }}>No Rating
                            </option>
                            <option value="1" {{ old('star', $product->star) == 1 ? 'selected' : '' }}>1 Star</option>
                            <option value="2" {{ old('star', $product->star) == 2 ? 'selected' : '' }}>2 Stars</option>
                            <option value="3" {{ old('star', $product->star) == 3 ? 'selected' : '' }}>3 Stars</option>
                            <option value="4" {{ old('star', $product->star) == 4 ? 'selected' : '' }}>4 Stars</option>
                            <option value="5" {{ old('star', $product->star) == 5 ? 'selected' : '' }}>5 Stars</option>
                        </select>
                    </div>

                    <!-- Remark -->
                    <div>
                        <label for="remark" class="block text-sm font-medium text-gray-700 mb-1">Remark</label>
                        <select id="remark" name="remark"
                            class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="regular" {{ old('remark', $product->remark) == 'regular' ? 'selected' : ''
                                }}>Regular</option>
                            <option value="popular" {{ old('remark', $product->remark) == 'popular' ? 'selected' : ''
                                }}>Popular</option>
                            <option value="new" {{ old('remark', $product->remark) == 'new' ? 'selected' : '' }}>New
                            </option>
                            <option value="top" {{ old('remark', $product->remark) == 'top' ? 'selected' : '' }}>Top
                            </option>
                            <option value="special" {{ old('remark', $product->remark) == 'special' ? 'selected' : ''
                                }}>Special</option>
                            <option value="trending" {{ old('remark', $product->remark) == 'trending' ? 'selected' : ''
                                }}>Trending</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Images Card -->
            <div class=" rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Product Images</h3>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
                    <!-- Current Main Image -->
                    <div class="">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Main Image</label>
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->title }}"
                            class="h-32 w-32 object-contain border rounded-lg">
                    </div>
                    <!-- Current Additional Images -->
                    @if($product->productDetail)
                    @foreach(range(1, 4) as $i)
                    @php $img = "img{$i}"; @endphp
                    @if($product->productDetail->$img)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Image {{ $i }}</label>
                        <img src="{{ asset('storage/'.$product->productDetail->$img) }}"
                            class="h-32 w-32 object-cover border rounded-lg">
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>

                <!-- Main Product Image Update -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Update Main Image</label>
                    <div class="mt-1 flex items-center">
                        <input type="file" id="image" name="image" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-200 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Images Update -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="img1" class="block text-sm font-medium text-gray-700 mb-1">Update Image 1</label>
                        <input type="file" id="img1" name="img1" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-200 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div>
                        <label for="img2" class="block text-sm font-medium text-gray-700 mb-1">Update Image 2</label>
                        <input type="file" id="img2" name="img2" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-200 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div>
                        <label for="img3" class="block text-sm font-medium text-gray-700 mb-1">Update Image 3</label>
                        <input type="file" id="img3" name="img3" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-200 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div>
                        <label for="img4" class="block text-sm font-medium text-gray-700 mb-1">Update Image 4</label>
                        <input type="file" id="img4" name="img4" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-200 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>
            </div>

            <!-- Product Details Card -->
            <div class=" rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Product Details</h3>

                <!-- Full Description -->
                <div class="mb-6">
                    <label for="des" class="block text-sm font-medium text-gray-700 mb-1">Full Description *</label>
                    <textarea id="des" name="des" rows="5"
                        class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required>{{ old('des', $product->productDetail->des ?? '') }}</textarea>
                    @error('des')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color & Size -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                        <input type="text" id="color" name="color"
                            value="{{ old('color', $product->productDetail->color ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g. Red, Blue, Black">
                    </div>
                    <div>
                        <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                        <input type="text" id="size" name="size"
                            value="{{ old('size', $product->productDetail->size ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g. S, M, L, XL">
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.products.index') }}"
                    class="px-6 py-2 border border-gray-400 rounded-lg text-gray-700 hover: transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    Update Product
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
        }
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const discountCheckbox = document.getElementById('discount');
        if (discountCheckbox) {
            discountCheckbox.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection