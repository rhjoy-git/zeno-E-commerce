@extends('layouts.admin')
@section('title', 'Create Variant - ' . $product->title)
@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white shadow-md p-6">
        <div class="flex justify-between items-center mb-2">
            <h1 class="text-2xl font-semibold text-gray-800">Create New Variants</h1>
            <a href="{{ route('admin.products.variants.index', $product) }}"
                class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors text-base">
                Back to Variants
            </a>
        </div>

        <div class="bg-white border border-gray-200 p-6">
            <form action="{{ route('admin.products.variants.store', $product) }}" method="POST" id="variantForm">
                @csrf

                <div id="variants-container">
                    <!-- First variant row -->
                    <div
                        class="variant-row grid grid-cols-2 md:grid-cols-4 gap-6 mb-6 p-4 border border-gray-200 ">
                        <!-- Color Selection -->
                        <div>
                            <label for="color_id_0" class="block text-sm font-medium text-gray-700 mb-1">Color <span
                                    class="text-red-500">*</span></label>
                            <select id="color_id_0" name="variants[0][color_id]" data-index="0"
                                class="color-select mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black"
                                required>
                                <option value="">Select Color</option>
                                @foreach ($colors as $color)
                                <option value="{{ $color->id }}" {{ old('variants.0.color_id')==$color->id ? 'selected'
                                    : '' }}>{{ $color->name }}</option>
                                @endforeach
                            </select>
                            <div class="color-error text-sm text-red-600 mt-1 hidden"></div>
                        </div>

                        <!-- Size Selection -->
                        <div>
                            <label for="size_id_0" class="block text-sm font-medium text-gray-700 mb-1">Size <span
                                    class="text-red-500">*</span></label>
                            <select id="size_id_0" name="variants[0][size_id]" data-index="0"
                                class="size-select mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black"
                                required>
                                <option value="">Select Size</option>
                                @foreach ($sizes as $size)
                                <option value="{{ $size->id }}" {{ old('variants.0.size_id')==$size->id ? 'selected' :
                                    '' }}>{{ $size->name }}</option>
                                @endforeach
                            </select>
                            <div class="size-error text-sm text-red-600 mt-1 hidden"></div>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price_0" class="block text-sm font-medium text-gray-700 mb-1">Price (৳) <span
                                    class="text-red-500">*</span></label>
                            <input type="number" step="0.01" min="0" id="price_0" name="variants[0][price]"
                                value="{{ old('variants.0.price', $product->price) }}"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black"
                                required>
                        </div>

                        <!-- Stock Quantity -->
                        <div>
                            <label for="stock_quantity_0" class="block text-sm font-medium text-gray-700 mb-1">Stock
                                Quantity <span class="text-red-500">*</span></label>
                            <input type="number" min="0" id="stock_quantity_0" name="variants[0][stock_quantity]"
                                value="{{ old('variants.0.stock_quantity', 0) }}"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black"
                                required>
                        </div>

                        <!-- Stock Alert -->
                        <div>
                            <label for="stock_alert_0" class="block text-sm font-medium text-gray-700 mb-1">Stock Alert
                                Level</label>
                            <input type="number" min="0" id="stock_alert_0" name="variants[0][stock_alert]"
                                value="{{ old('variants.0.stock_alert') }}"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black">
                        </div>

                        <!-- SKU -->
                        <div>
                            <label for="sku_0" class="block text-sm font-medium text-gray-700">SKU <span
                                    class="text-red-500">*</span></label>
                            <div class="mt-1 flex">
                                <input type="text" id="sku_0" name="variants[0][sku]"
                                    value="{{ old('variants.0.sku') }}"
                                    class="sku-input block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required />
                                <button type="button" data-index="0"
                                    class="generate-sku-btn inline-flex items-center border border-l-0 border-gray-300 bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                    Generate
                                </button>
                            </div>
                            <div class="sku-error text-sm text-red-600 mt-1 hidden"></div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status_0" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status_0" name="variants[0][status]"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black">
                                <option value="active" {{ old('variants.0.status', 'active' )=='active' ? 'selected'
                                    : '' }}>Active</option>
                                <option value="inactive" {{ old('variants.0.status')=='inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>

                        <!-- Remove button -->
                        <div class="flex items-end">
                            <button type="button" class="remove-variant-btn text-red-500 hover:text-red-700 hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <button type="button" id="add-variant-btn"
                        class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors text-base">
                        + Add Another Variant
                    </button>

                    <button type="submit"
                        class="px-6 py-2 bg-black text-white hover:bg-gray-800 transition-colors text-base">
                        Create Variants
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let variantCount = 1;
        const variantsContainer = document.getElementById('variants-container');
        const addVariantBtn = document.getElementById('add-variant-btn');
        
        // Add variant button click handler
        addVariantBtn.addEventListener('click', function() {
            const newIndex = variantCount;
            const newVariantRow = document.createElement('div');
            newVariantRow.className = 'variant-row grid grid-cols-2 md:grid-cols-4 gap-6 mb-6 p-4 border border-gray-200 ';
            newVariantRow.innerHTML = `
                <!-- Color Selection -->
                <div>
                    <label for="color_id_${newIndex}" class="block text-sm font-medium text-gray-700 mb-1">Color <span class="text-red-500">*</span></label>
                    <select id="color_id_${newIndex}" name="variants[${newIndex}][color_id]" data-index="${newIndex}" class="color-select mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black" required>
                        <option value="">Select Color</option>
                        @foreach ($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                    <div class="color-error text-sm text-red-600 mt-1 hidden"></div>
                </div>

                <!-- Size Selection -->
                <div>
                    <label for="size_id_${newIndex}" class="block text-sm font-medium text-gray-700 mb-1">Size <span class="text-red-500">*</span></label>
                    <select id="size_id_${newIndex}" name="variants[${newIndex}][size_id]" data-index="${newIndex}" class="size-select mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black" required>
                        <option value="">Select Size</option>
                        @foreach ($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                    <div class="size-error text-sm text-red-600 mt-1 hidden"></div>
                </div>

                <!-- Price -->
                <div>
                    <label for="price_${newIndex}" class="block text-sm font-medium text-gray-700 mb-1">Price (৳) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" id="price_${newIndex}" name="variants[${newIndex}][price]" value="{{ $product->price }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black" required>
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label for="stock_quantity_${newIndex}" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity <span class="text-red-500">*</span></label>
                    <input type="number" min="0" id="stock_quantity_${newIndex}" name="variants[${newIndex}][stock_quantity]" value="0" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black" required>
                </div>

                <!-- Stock Alert -->
                <div>
                    <label for="stock_alert_${newIndex}" class="block text-sm font-medium text-gray-700 mb-1">Stock Alert Level</label>
                    <input type="number" min="0" id="stock_alert_${newIndex}" name="variants[${newIndex}][stock_alert]" value="" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black">
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku_${newIndex}" class="block text-sm font-medium text-gray-700">SKU <span class="text-red-500">*</span></label>
                    <div class="mt-1 flex">
                        <input type="text" id="sku_${newIndex}" name="variants[${newIndex}][sku]" value="" class="sku-input block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required />
                        <button type="button" data-index="${newIndex}" class="generate-sku-btn inline-flex items-center border border-l-0 border-gray-300 bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                            Generate
                        </button>
                    </div>
                    <div class="sku-error text-sm text-red-600 mt-1 hidden"></div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status_${newIndex}" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status_${newIndex}" name="variants[${newIndex}][status]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- Remove button -->
                <div class="flex items-end">
                    <button type="button" class="remove-variant-btn text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            `;
            
            variantsContainer.appendChild(newVariantRow);
            variantCount++;
            
            // Show remove buttons if there's more than one variant
            updateRemoveButtonsVisibility();
            
            // Add event listeners to the new selects
            const newColorSelect = newVariantRow.querySelector('.color-select');
            const newSizeSelect = newVariantRow.querySelector('.size-select');
            const newSkuInput = newVariantRow.querySelector('.sku-input');
            const newGenerateSkuBtn = newVariantRow.querySelector('.generate-sku-btn');
            
            newColorSelect.addEventListener('change', function() {
                validateVariantCombination(this);
            });
            
            newSizeSelect.addEventListener('change', function() {
                validateVariantCombination(this);
            });
            
            newSkuInput.addEventListener('input', function() {
                validateSku(this);
            });
            
            newGenerateSkuBtn.addEventListener('click', function() {
                generateSku(this);
            });
        });
        
        // Remove variant button handler (event delegation)
        variantsContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-variant-btn')) {
                const variantRow = e.target.closest('.variant-row');
                if (document.querySelectorAll('.variant-row').length > 1) {
                    variantRow.remove();
                    updateRemoveButtonsVisibility();
                }
            }
        });
        
        // Update remove buttons visibility
        function updateRemoveButtonsVisibility() {
            const removeButtons = document.querySelectorAll('.remove-variant-btn');
            removeButtons.forEach(btn => {
                if (document.querySelectorAll('.variant-row').length > 1) {
                    btn.classList.remove('hidden');
                } else {
                    btn.classList.add('hidden');
                }
            });
        }
        
        // Validate variant combination (color + size)
        function validateVariantCombination(selectElement) {
            const index = selectElement.dataset.index;
            const colorSelect = document.getElementById(`color_id_${index}`);
            const sizeSelect = document.getElementById(`size_id_${index}`);
            const colorError = colorSelect.parentElement.querySelector('.color-error');
            const sizeError = sizeSelect.parentElement.querySelector('.size-error');
            
            const colorId = colorSelect.value;
            const sizeId = sizeSelect.value;
            
            // Reset errors
            colorError.classList.add('hidden');
            sizeError.classList.add('hidden');
            colorError.textContent = '';
            sizeError.textContent = '';
            
            if (!colorId || !sizeId) return;
            
            // Check if combination already exists
            fetch('{{ route("admin.products.variants.checkCombination", $product->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    color_id: colorId,
                    size_id: sizeId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    colorError.textContent = 'This color and size combination already exists for this product.';
                    colorError.classList.remove('hidden');
                    sizeError.textContent = 'This color and size combination already exists for this product.';
                    sizeError.classList.remove('hidden');
                    
                    // Disable form submission for this variant
                    colorSelect.setCustomValidity('Combination exists');
                    sizeSelect.setCustomValidity('Combination exists');
                } else {
                    colorSelect.setCustomValidity('');
                    sizeSelect.setCustomValidity('');
                }
            })
            .catch(error => {
                console.error('Error validating variant combination:', error);
            });
        }
        
        // Validate SKU
        function validateSku(skuInput) {
            const index = skuInput.id.split('_')[1];
            const skuError = skuInput.parentElement.parentElement.querySelector('.sku-error');
            const sku = skuInput.value.trim();
            
            // Clear previous timeout to prevent multiple fetch calls
            clearTimeout(skuInput.validationTimeout);
            
            // Only start validation if the input is long enough
            if (sku.length >= 3) {
                // Set a new timeout to wait for user to stop typing
                skuInput.validationTimeout = setTimeout(() => {
                    fetch('{{ route("admin.products.variants.checkSku", $product->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ sku: sku })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.isAvailable) {
                            skuError.textContent = data.message;
                            skuError.classList.remove('hidden');
                            skuInput.setCustomValidity('SKU already exists');
                        } else {
                            skuError.classList.add('hidden');
                            skuInput.setCustomValidity('');
                        }
                    })
                    .catch(error => {
                        console.error('Error validating SKU:', error);
                    });
                }, 500);
            } else {
                // Reset validation state if input is too short
                skuError.classList.add('hidden');
                skuInput.setCustomValidity('');
            }
        }
        
        // Generate SKU
        function generateSku(button) {
            const index = button.dataset.index;
            const skuInput = document.getElementById(`sku_${index}`);
            const skuError = skuInput.parentElement.parentElement.querySelector('.sku-error');
            
            const randomSKU = 'PROD-VAR-' + Math.floor(10000 + Math.random() * 99999);
            skuInput.value = randomSKU;
            
            // Validate the generated SKU
            fetch('{{ route("admin.products.variants.checkSku", $product->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ sku: randomSKU })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.isAvailable) {
                    skuError.textContent = data.message;
                    skuError.classList.remove('hidden');
                    skuInput.setCustomValidity('SKU already exists');
                } else {
                    skuError.classList.add('hidden');
                    skuInput.setCustomValidity('');
                }
            })
            .catch(error => {
                console.error('Error validating SKU:', error);
            });
        }
        
        // Add event listeners to initial elements
        const initialColorSelect = document.querySelector('.color-select');
        const initialSizeSelect = document.querySelector('.size-select');
        const initialSkuInput = document.querySelector('.sku-input');
        const initialGenerateSkuBtn = document.querySelector('.generate-sku-btn');
        
        if (initialColorSelect) {
            initialColorSelect.addEventListener('change', function() {
                validateVariantCombination(this);
            });
        }
        
        if (initialSizeSelect) {
            initialSizeSelect.addEventListener('change', function() {
                validateVariantCombination(this);
            });
        }
        
        if (initialSkuInput) {
            initialSkuInput.addEventListener('input', function() {
                validateSku(this);
            });
        }
        
        if (initialGenerateSkuBtn) {
            initialGenerateSkuBtn.addEventListener('click', function() {
                generateSku(this);
            });
        }
        
        // Initialize remove button visibility
        updateRemoveButtonsVisibility();
    });
</script>
@endsection