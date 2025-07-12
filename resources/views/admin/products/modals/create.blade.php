@extends('layouts.admin')
@section('title', 'Create New Product')
@section('content')


<div class="container mx-auto px-4 py-6">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-black">Add New Product</h2>
            <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-black">
                ← Back to Products
            </a>
        </div>
        {{-- Flash Message --}}
        @php
        $flashType = session('success') ? 'success' : (session('error') ? 'error' : null);
        $flashMessage = session('success') ?? session('error');
        @endphp

        @if ($flashType && $flashMessage)
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="px-4 py-2 rounded mb-4 transition duration-500
               {{ $flashType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $flashMessage }}
        </div>
        @endif
        {{-- Validation Errors --}}
        @if ($errors->any())
        <div class="px-4 py-2 rounded mb-4 bg-red-100 text-red-800">
            <h3 class="font-medium">Please fix the following errors:</h3>
            <ul class="mt-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="productForm" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
            class="space-y-8 divide-y divide-gray-200">
            @csrf

            <!-- Basic Information Section -->
            <div class="pt-8">
                <div class="mb-6">
                    <h3 class="text-xl font-medium leading-6 text-gray-900">Product Information</h3>
                </div>

                <div class="grid grid-cols-1 gap-y-4 gap-x-2 sm:grid-cols-12">
                    <!-- Category -->
                    <div class="sm:col-span-2">
                        <label for="category_id" class="block text-base font-medium text-black">Category</label>
                        <div class="mt-1">
                            <select id="category_id" name="category_id"
                                class="block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' :
                                    '' }}>
                                    {{ $category->categoryName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Brand -->
                    <div class="sm:col-span-2">
                        <label for="brand_id" class="block text-base font-medium text-black">Brand</label>
                        <div class="mt-1">
                            <select id="brand_id" name="brand_id"
                                class="block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id')==$brand->id ? 'selected' : '' }}>
                                    {{ $brand->brandName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="sm:col-span-4">
                        <label for="title" class="block text-base font-medium text-black">Product Title *</label>
                        <div class="mt-1">
                            <input type="text" id="title" value="{{ old('title') }}" name="title"
                                placeholder="Enter Title Here" required
                                class="block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                        </div>
                        <p id="title-error" class="mt-1 text-base text-red-600 hidden"></p>
                    </div>

                    <!-- SKU -->
                    <div class="sm:col-span-2">
                        <label for="sku" class="block text-base font-medium text-black">SKU *</label>
                        <div class="mt-1 flex">
                            <div class="relative flex w-full">
                                <input type="text" id="sku" name="sku" value="{{ old('sku') }}" required
                                    class="block w-full border-gray-300 pr-16 text-sm focus:border-black focus:ring-black" />
                                <button type="button" id="generateSKU"
                                    class="absolute right-0 top-0 h-full border-l px-2 text-sm font-medium text-black focus:outline-none focus:ring-0 focus:ring-offset-0">
                                    Generate
                                </button>
                            </div>
                        </div>
                        <p id="sku-error" class="mt-1 text-base text-red-600 hidden"></p>
                    </div>

                    <!-- Price -->
                    <div class="sm:col-span-2">
                        <label for="price" class="block text-base font-medium text-black">Base Price *</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-black sm:text-sm">TK</span>
                            </div>
                            <input type="text" step="0.01" min="0" id="price" name="price" value="{{ old('price') }}"
                                required
                                class="block w-full pl-8 pr-10 border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-black sm:text-sm">BDT</span>
                            </div>
                        </div>
                    </div>

                    <!-- Discount Price -->
                    <input type="hidden" name="discount" id="discount" value="0">
                    <div class="sm:col-span-2">
                        <label for="discount_price" class="block text-base font-medium text-black">Discount
                            Price</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-black sm:text-sm">TK</span>
                            </div>
                            <input type="text" step="0.1" min="0" id="discount_price" name="discount_price"
                                value="{{ old('discount_price') }}"
                                class="block w-full pl-8 pr-10 border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-black sm:text-sm">BDT</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Quantity -->
                    <div class="sm:col-span-2">
                        <label for="stock_quantity" class="block text-base font-medium text-black">Stock
                            Quantity</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-black sm:text-sm">PCS</span>
                            </div>
                            <input type="text" min="0" id="stock_quantity" name="stock_quantity"
                                value="{{ old('stock_quantity') }}"
                                class="block w-full pl-10 pr-4 border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                        </div>
                    </div>

                    <!-- Stock Alert -->
                    <div class="sm:col-span-2">
                        <label for="stock_alert" class="block text-base font-medium text-black">Low Stock
                            Alert</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-black sm:text-sm">PCS</span>
                            </div>
                            <input type="text" min="0" id="stock_alert" name="stock_alert"
                                value="{{ old('stock_alert') }}" placeholder="Ex: 50"
                                class="block w-full pl-10 pr-4 border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                        </div>
                    </div>
                    <!-- Product Tags -->
                    <div class="sm:col-span-4">
                        <label for="tags" class="block text-base font-medium text-black">Product Tags</label>
                        <div class="mt-1">
                            <input type="text" id="tags" name="tags" placeholder="Add tags (separate with commas)"
                                class="block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                            <div id="tagsContainer" class="mt-2 flex flex-wrap gap-2"></div>
                            <input type="hidden" id="tagsHidden" name="tags_array">
                        </div>
                    </div>
                    <!-- Status -->
                    <div class="sm:col-span-2">
                        <label for="status" class="block text-base font-medium text-black">Status</label>
                        <div class="mt-1">
                            <select id="status" name="status"
                                class="block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                                <option value="active" {{ old('status', 'active' )=='active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Inactive
                                </option>
                                <option value="discontinued" {{ old('status')=='discontinued' ? 'selected' : '' }}>
                                    Discontinued</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="pt-8">
                <div class="mb-6">
                    <h3 class="text-xl font-medium leading-6 text-gray-900">Product Details</h3>
                </div>

                <div class="grid grid-cols-1 gap-y-4 gap-x-2 sm:grid-cols-12">
                    <!-- Short Description -->
                    <div class="sm:col-span-6">
                        <label for="short_des" class="block text-base font-medium text-black">Short
                            Description</label>
                        <div class="mt-1">
                            <textarea id="short_des" name="short_des" rows="3"
                                placeholder="Enter Product Short Description"
                                class="block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">{{ old('short_des') }}</textarea>
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="sm:col-span-6">
                        <label for="specifications"
                            class="block text-base font-medium text-black">Specifications</label>
                        <div class="mt-1">
                            <textarea id="specifications" name="specifications" rows="3"
                                class="block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm"
                                placeholder='{"key": "value", ...}'>{{ old('specifications') }}</textarea>
                        </div>
                        <p class="mt-1 text-base text-black">Enter specifications in JSON format.</p>
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-12">
                        <label for="description" class="block text-base font-medium text-black">Description</label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="4"
                                class="block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Variants Section -->
            <div class="pt-8" id="variantsSection">
                <div class="mb-6">
                    <h3 class="text-xl font-medium leading-6 text-gray-900">Product Variants</h3>
                    <p class="mt-1 text-base text-black">Add color variants with sizes and images</p>
                </div>

                <div id="variantsComponent">
                    <!-- Variant Form -->
                    <div class="p-4 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            <!-- Color Selection -->
                            <div class="sm:col-span-2">
                                <label class="block text-base font-medium text-black">Color *</label>
                                <select id="variantColor"
                                    class="mt-1 block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                                    <option value="">Select Color</option>
                                    @foreach ($colors as $color)
                                    <option value="{{ $color->id }}" data-name="{{ $color->name }}"
                                        data-code="{{ $color->hex_code }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                                <div id="colorPreview" class="mt-2 flex items-center hidden">
                                    <span class="mr-2 text-base">Color:</span>
                                    <div id="colorBox" class="h-5 w-5 border"></div>    
                                    <span id="colorName" class="ml-2 text-base"></span>
                                </div>
                            </div>

                            <!-- Size Selection -->
                            <div class="sm:col-span-2">
                                <label class="block text-base font-medium text-black">Sizes *</label>
                                <div class="mt-1 flex">
                                    <select id="sizeSelect"
                                        class="block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                                        <option value="">Select Size</option>
                                        @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}" data-name="{{ $size->name }}">
                                            {{ $size->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="addSizeBtn"
                                        class="ml-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium text-white bg-black focus:outline-none focus:ring-0 focus:ring-offset-0">
                                        Add
                                    </button>
                                </div>

                                <!-- Selected Sizes -->
                                <div id="selectedSizes" class="mt-2 flex flex-wrap gap-2"></div>
                            </div>

                            <!-- Price -->
                            <div class="sm:col-span-2">
                                <label class="block text-base font-medium text-black">Price *</label>
                                <input type="text" step="0.01" min="0" id="variantPrice"
                                    class="mt-1 block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                            </div>

                            <!-- Stock Quantity -->
                            <div class="sm:col-span-2">
                                <label class="block text-base font-medium text-black">Stock Qty</label>
                                <input type="text" min="0" id="variantStockQuantity"
                                    class="mt-1 block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                            </div>

                            <!-- Stock Alert -->
                            <div class="sm:col-span-2">
                                <label class="block text-base font-medium text-black">Stock Alert</label>
                                <input type="text" min="0" id="variantStockAlert"
                                    class="mt-1 block w-full border-gray-300 focus:border-black focus:ring-black sm:text-sm">
                            </div>

                            <!-- Image Upload -->
                            <div class="sm:col-span-2">
                                <label class="block text-base font-medium text-black">Images (Max 10)</label>
                                <div class="mt-1">
                                    <input type="file" id="variantImages" multiple accept="image/*" class="hidden">
                                    <label for="variantImages"
                                        class="cursor-pointer bg-black text-white w-full block px-3 py-2 text-sm font-medium text-center">
                                        Upload Images
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Image Previews -->
                        <div class="mt-4">
                            <div id="imagePreviews" class="mt-2 flex flex-wrap gap-2"></div>
                        </div>

                        <!-- Add Variant Button -->
                        <div class="mt-4 flex justify-end">
                            <button type="button" id="addVariantBtn"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium text-white bg-black focus:outline-none focus:ring-0 focus:ring-offset-0">
                                Add Variant
                            </button>
                        </div>
                    </div>

                    <!-- Variants Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-base font-medium text-black uppercase tracking-wider">
                                        Color</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-base font-medium text-black uppercase tracking-wider">
                                        Sizes</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-base font-medium text-black uppercase tracking-wider">
                                        Price</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-base font-medium text-black uppercase tracking-wider">
                                        Stock</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-base font-medium text-black uppercase tracking-wider">
                                        Images</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-base font-medium text-black uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody id="variantsTableBody" class="bg-white divide-y divide-gray-200">
                                <tr id="noVariantsRow">
                                    <td colspan="6" class="px-6 py-4 text-center text-base text-black">No variants
                                        added
                                        yet</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Hidden inputs for variants will be added dynamically -->
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-5">
                <div class="flex justify-end">
                    <button type="button" id="cancelBtn"
                        class="bg-white py-2 px-4 border border-gray-300 text-base font-medium text-black focus:outline-none focus:ring-0 focus:ring-offset-0">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent text-base font-medium text-white bg-black focus:outline-none focus:ring-0 focus:ring-offset-0">
                        Save Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
            // Product Form
            const productForm = document.getElementById('productForm');
            const generateSKUBtn = document.getElementById('generateSKU');
            const discountPriceInput = document.getElementById('discount_price');
            const discountCheckbox = document.getElementById('discount');
            const cancelBtn = document.getElementById('cancelBtn');
            // Tags functionality
            const tagsInput = document.getElementById('tags');
            const tagsContainer = document.getElementById('tagsContainer');
            const tagsHiddenInput = document.getElementById('tagsHidden');
            let tags = [];

            // Handle tag input
            tagsInput.addEventListener('keydown', function(e) {
                // Add tag when comma or enter is pressed
                if (e.key === ',' || e.key === 'Enter') {
                    e.preventDefault();
                    const tagValue = this.value.trim();

                    if (tagValue && !tags.includes(tagValue)) {
                        tags.push(tagValue);
                        renderTags();
                        this.value = '';
                    }
                }
            });

            // Handle pasting tags
            tagsInput.addEventListener('paste', function(e) {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text');
                const pastedTags = pasteData.split(',')
                    .map(tag => tag.trim())
                    .filter(tag => tag.length > 0);

                pastedTags.forEach(tag => {
                    if (!tags.includes(tag)) {
                        tags.push(tag);
                    }
                });

                renderTags();
                this.value = '';
            });

            // Render tags to the UI
            function renderTags() {
                tagsContainer.innerHTML = '';
                tagsHiddenInput.value = JSON.stringify(tags);

                tags.forEach((tag, index) => {
                    const tagElement = document.createElement('span');
                    tagElement.className =
                        'inline-flex items-center px-2 py-1 text-sm font-medium bg-gray-100 text-black rounded';
                    tagElement.innerHTML = `
            ${tag}
            <button type="button" class="ml-1 inline-flex text-black focus:outline-none" data-index="${index}">
                &times;
            </button>`;
                    tagsContainer.appendChild(tagElement);
                });

                // Add event listeners to remove buttons
                document.querySelectorAll('#tagsContainer button').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        tags.splice(index, 1);
                        renderTags();
                    });
                });
            }

            // Initialize with any existing tags (if editing)
            if (tagsHiddenInput.value) {
                try {
                    tags = JSON.parse(tagsHiddenInput.value);
                    renderTags();
                } catch (e) {
                    console.error('Error parsing tags:', e);
                }
            }

            // Variants Component
            const variantsComponent = {
                variants: [],
                newVariant: {
                    color_id: '',
                    color_name: '',
                    color_code: '',
                    sizes: [],
                    price: '',
                    stock_quantity: '',
                    stock_alert: '',
                    images: [],
                    previews: []
                },

                init: function() {
                    // Color selection
                    const variantColor = document.getElementById('variantColor');
                    variantColor.addEventListener('change', this.updateColorInfo.bind(this));

                    // Size selection
                    document.getElementById('addSizeBtn').addEventListener('click', this.addSize.bind(
                        this));

                    // Image upload
                    document.getElementById('variantImages').addEventListener('change', this
                        .handleImageUpload.bind(this));

                    // Add variant
                    document.getElementById('addVariantBtn').addEventListener('click', this.addVariant.bind(
                        this));

                    // Cancel button
                    cancelBtn.addEventListener('click', () => window.history.back());

                    // Discount price toggle
                    if (discountPriceInput && discountCheckbox) {
                        discountPriceInput.addEventListener('input', function() {
                            let value = parseFloat(this.value);

                            if (isNaN(value)) {
                                discountCheckbox.value = "0";
                                return;
                            }

                            if (value < 0) {
                                // Add Tailwind error styling
                                this.classList.add('border', 'border-red-500', 'ring-1',
                                    'ring-red-400', 'focus:ring-red-500');

                                setTimeout(() => {
                                    this.value = Math.abs(value).toFixed(2);
                                    discountCheckbox.value = "1";

                                    // Remove Tailwind error styling
                                    this.classList.remove('border-red-500', 'ring-1',
                                        'ring-red-400', 'focus:ring-red-500');
                                }, 500);
                            } else {
                                discountCheckbox.value = value > 0 ? "1" : "0";

                                // Remove error styling if corrected
                                this.classList.remove('border-red-500', 'ring-1', 'ring-red-400',
                                    'focus:ring-red-500');
                            }

                        });
                    }

                    // Generate SKU
                    if (generateSKUBtn) {
                        generateSKUBtn.addEventListener('click', this.generateSKU.bind(this));
                    }
                },

                updateColorInfo: function() {
                    const variantColor = document.getElementById('variantColor');
                    const selectedOption = variantColor.options[variantColor.selectedIndex];
                    const colorPreview = document.getElementById('colorPreview');
                    const colorBox = document.getElementById('colorBox');
                    const colorName = document.getElementById('colorName');

                    if (variantColor.value) {
                        this.newVariant.color_id = variantColor.value;
                        this.newVariant.color_name = selectedOption.dataset.name;
                        this.newVariant.color_code = selectedOption.dataset.code;

                        colorBox.style.backgroundColor = this.newVariant.color_code;
                        colorName.textContent = this.newVariant.color_name;
                        colorPreview.classList.remove('hidden');
                    } else {
                        this.newVariant.color_id = '';
                        this.newVariant.color_name = '';
                        this.newVariant.color_code = '';
                        colorPreview.classList.add('hidden');
                    }
                },

                addSize: function() {
                    const sizeSelect = document.getElementById('sizeSelect');
                    const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];

                    if (!sizeSelect.value) return;

                    // Check if size already exists
                    const sizeExists = this.newVariant.sizes.some(size => size.id === sizeSelect.value);
                    if (sizeExists) return;

                    // Add to sizes array
                    this.newVariant.sizes.push({
                        id: sizeSelect.value,
                        name: selectedOption.dataset.name
                    });

                    // Update UI
                    this.renderSelectedSizes();

                    // Reset select
                    sizeSelect.value = '';
                },

                renderSelectedSizes: function() {
                    const selectedSizesContainer = document.getElementById('selectedSizes');
                    selectedSizesContainer.innerHTML = '';

                    this.newVariant.sizes.forEach((size, index) => {
                        const sizeElement = document.createElement('span');
                        sizeElement.className =
                            'inline-flex items-center px-2 py-1 text-base font-medium bg-gray-100 text-black';
                        sizeElement.innerHTML = `
                    <span>${size.name}</span>
                    <button type="button" class="ml-1 inline-flex text-black focus:outline-none" data-index="${index}">
                        &times;
                    </button>
                `;
                        selectedSizesContainer.appendChild(sizeElement);
                    });

                    // Add event listeners to remove buttons
                    document.querySelectorAll('#selectedSizes button').forEach(button => {
                        button.addEventListener('click', (e) => {
                            const index = parseInt(e.currentTarget.dataset.index);
                            this.newVariant.sizes.splice(index, 1);
                            this.renderSelectedSizes();
                        });
                    });
                },

                handleImageUpload: function(event) {
                    const files = event.target.files;
                    if (!files.length) return;

                    const remainingSlots = 10 - this.newVariant.images.length;
                    if (remainingSlots <= 0) return;

                    const filesToAdd = Array.from(files).slice(0, remainingSlots);
                    const imagePreviews = document.getElementById('imagePreviews');

                    filesToAdd.forEach(file => {
                        this.newVariant.images.push(file);

                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.newVariant.previews.push(e.target.result);

                            // Create preview element
                            const previewElement = document.createElement('div');
                            previewElement.className = 'relative';
                            previewElement.innerHTML = `
                        <img src="${e.target.result}" class="h-20 w-20 object-cover border">
                        <button type="button" class="absolute top-0 right-0 bg-red-500 text-white w-5 h-5 flex items-center justify-center -mt-1 -mr-1" data-index="${this.newVariant.previews.length - 1}">
                            ×
                        </button>
                    `;
                            imagePreviews.appendChild(previewElement);

                            // Add event listener to remove button
                            previewElement.querySelector('button').addEventListener('click', (
                                e) => {
                                const index = parseInt(e.currentTarget.dataset.index);
                                this.removeImage(index);
                            });
                        };
                        reader.readAsDataURL(file);
                    });
                },

                removeImage: function(index) {
                    this.newVariant.previews.splice(index, 1);
                    this.newVariant.images.splice(index, 1);
                    this.renderImagePreviews();
                },

                renderImagePreviews: function() {
                    const imagePreviews = document.getElementById('imagePreviews');
                    imagePreviews.innerHTML = '';

                    this.newVariant.previews.forEach((preview, index) => {
                        const previewElement = document.createElement('div');
                        previewElement.className = 'relative';
                        previewElement.innerHTML = `
                    <img src="${preview}" class="h-20 w-20 object-cover border">
                    <button type="button" class="absolute top-0 right-0 bg-red-500 text-white w-5 h-5 flex items-center justify-center -mt-1 -mr-1" data-index="${index}">
                        ×
                    </button>
                `;
                        imagePreviews.appendChild(previewElement);

                        // Add event listener to remove button
                        previewElement.querySelector('button').addEventListener('click', (e) => {
                            const index = parseInt(e.currentTarget.dataset.index);
                            this.removeImage(index);
                        });
                    });
                },

                addVariant: function() {
                    // Validate required fields
                    if (!this.newVariant.color_id || this.newVariant.sizes.length === 0) {
                        alert('Please fill all required fields: Color, and Size');
                        return;
                    }

                    // Check if color already exists in variants
                    if (this.variants.some(v => v.color_id === this.newVariant.color_id)) {
                        alert('This color variant already exists');
                        return;
                    }

                    // Add the variant
                    this.variants.push({
                        ...this.newVariant,
                        sizes: [...this.newVariant.sizes],
                        images: [...this.newVariant.images],
                        previews: [...this.newVariant.previews]
                    });

                    // Reset form
                    this.resetVariantForm();

                    // Update UI
                    this.renderVariantsTable();
                },

                resetVariantForm: function() {
                    this.newVariant = {
                        color_id: '',
                        color_name: '',
                        color_code: '',
                        sizes: [],
                        price: '',
                        stock_quantity: '',
                        stock_alert: '',
                        images: [],
                        previews: []
                    };

                    // Reset form fields
                    document.getElementById('variantColor').value = '';
                    document.getElementById('variantPrice').value = '';
                    document.getElementById('variantStockQuantity').value = '';
                    document.getElementById('variantStockAlert').value = '';
                    document.getElementById('variantImages').value = '';
                    document.getElementById('colorPreview').classList.add('hidden');
                    document.getElementById('selectedSizes').innerHTML = '';
                    document.getElementById('imagePreviews').innerHTML = '';
                },

                renderVariantsTable: function() {
                    const variantsTableBody = document.getElementById('variantsTableBody');
                    const noVariantsRow = document.getElementById('noVariantsRow');

                    // Clear existing rows except the "no variants" row
                    variantsTableBody.innerHTML = '';
                    if (this.variants.length === 0) {
                        variantsTableBody.appendChild(noVariantsRow);
                        return;
                    }

                    // Add each variant as a row
                    this.variants.forEach((variant, index) => {
                        const row = document.createElement('tr');
                        row.dataset.index = index;

                        // Color cell
                        const colorCell = document.createElement('td');
                        colorCell.className = 'px-6 py-4 whitespace-nowrap';
                        colorCell.innerHTML = `
                    <div class="flex items-center">
                        <div class="h-5 w-5 border" style="background-color: ${variant.color_code}"></div>
                        <span class="ml-2">${variant.color_name}</span>
                    </div>
                `;
                        row.appendChild(colorCell);

                        // Sizes cell
                        const sizesCell = document.createElement('td');
                        sizesCell.className = 'px-6 py-4 whitespace-nowrap';
                        const sizesContainer = document.createElement('div');
                        sizesContainer.className = 'flex flex-wrap gap-1';

                        variant.sizes.forEach(size => {
                            const sizeElement = document.createElement('span');
                            sizeElement.className =
                                'inline-flex items-center px-2 py-1 text-base font-medium bg-gray-100 text-black';
                            sizeElement.innerHTML = `
                        <span>${size.name}</span>
                    `;
                            sizesContainer.appendChild(sizeElement);
                        });

                        sizesCell.appendChild(sizesContainer);
                        row.appendChild(sizesCell);

                        // Price cell
                        const priceCell = document.createElement('td');
                        priceCell.className = 'px-6 py-4 whitespace-nowrap text-base text-black';
                        priceCell.textContent = '$' + variant.price;
                        row.appendChild(priceCell);

                        // Stock cell
                        const stockCell = document.createElement('td');
                        stockCell.className = 'px-6 py-4 whitespace-nowrap text-base text-black';
                        stockCell.textContent = variant.stock_quantity || '';
                        row.appendChild(stockCell);

                        // Images cell
                        const imagesCell = document.createElement('td');
                        imagesCell.className = 'px-6 py-4 whitespace-nowrap';
                        const imagesContainer = document.createElement('div');
                        imagesContainer.className = 'flex -space-x-1';

                        variant.previews.forEach(preview => {
                            const img = document.createElement('img');
                            img.src = preview;
                            img.className = 'h-8 w-8 ring-2 ring-white object-cover';
                            imagesContainer.appendChild(img);
                        });

                        imagesCell.appendChild(imagesContainer);
                        row.appendChild(imagesCell);

                        // Actions cell
                        const actionsCell = document.createElement('td');
                        actionsCell.className = 'px-6 py-4 whitespace-nowrap text-base text-black';
                        actionsCell.innerHTML = `
                    <button type="button" class="text-red-600 hover:text-red-900" data-index="${index}">
                        Remove
                    </button>
                `;
                        row.appendChild(actionsCell);

                        variantsTableBody.appendChild(row);
                    });

                    // Add event listeners to remove buttons
                    document.querySelectorAll('#variantsTableBody button').forEach(button => {
                        button.addEventListener('click', (e) => {
                            const index = parseInt(e.currentTarget.dataset.index);
                            this.removeVariant(index);
                        });
                    });
                },

                removeVariant: function(index) {
                    this.variants.splice(index, 1);
                    this.renderVariantsTable();
                },

                generateSKU: function() {
                    const titleInput = document.getElementById('title');
                    const skuInput = document.getElementById('sku');

                    const randomPart = Math.random().toString(36).substring(2, 6).toUpperCase();
                    const titlePart = titleInput.value ?
                        titleInput.value.substring(0, 3).toUpperCase().replace(/\s/g, '') :
                        'PRO';
                    const datePart = new Date().getFullYear().toString().substring(2);

                    skuInput.value = `${titlePart}-${datePart}-${randomPart}`;
                },

                prepareFormData: function() {
                    const form = document.getElementById('productForm');

                    // Clear any existing hidden inputs
                    document.querySelectorAll('[name^="variants"]').forEach(el => el.remove());

                    // Add hidden inputs for variants
                    this.variants.forEach((variant, index) => {
                        // Add variant data
                        this.addHiddenInput(form, `variants[${index}][color_id]`, variant.color_id);
                        this.addHiddenInput(form, `variants[${index}][color_name]`, variant
                            .color_name);
                        this.addHiddenInput(form, `variants[${index}][color_code]`, variant
                            .color_code);
                        this.addHiddenInput(form, `variants[${index}][price]`, variant.price);
                        this.addHiddenInput(form, `variants[${index}][stock_quantity]`, variant
                            .stock_quantity);
                        this.addHiddenInput(form, `variants[${index}][stock_alert]`, variant
                            .stock_alert);

                        // Add sizes
                        variant.sizes.forEach((size, sizeIndex) => {
                            this.addHiddenInput(form,
                                `variants[${index}][sizes][${sizeIndex}][id]`, size.id);
                            this.addHiddenInput(form,
                                `variants[${index}][sizes][${sizeIndex}][name]`, size
                                .name);
                        });

                        // Add images (need to create actual file inputs)
                        variant.images.forEach((image, imgIndex) => {
                            const input = document.createElement('input');
                            input.type = 'file';
                            input.name = `variants[${index}][images][]`;
                            input.className = 'hidden';

                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(image);
                            input.files = dataTransfer.files;

                            form.appendChild(input);
                        });
                    });
                },

                addHiddenInput: function(form, name, value) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = name;
                    input.value = value;
                    form.appendChild(input);
                }
            };

            // Initialize the variants component
            variantsComponent.init();

            // Form submission
            productForm.addEventListener('submit', function(e) {
                // Prepare the form data with variants
                variantsComponent.prepareFormData();
            });

            // Bind variant price, stock quantity, and stock alert to the newVariant object
            document.getElementById('variantPrice').addEventListener('input', function() {
                variantsComponent.newVariant.price = this.value;
            });

            document.getElementById('variantStockQuantity').addEventListener('input', function() {
                variantsComponent.newVariant.stock_quantity = this.value;
            });

            document.getElementById('variantStockAlert').addEventListener('input', function() {
                variantsComponent.newVariant.stock_alert = this.value;
            });
        });
</script>
@endsection