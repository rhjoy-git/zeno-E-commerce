@extends('layouts.admin')
@section('title', 'Create Variant - ' . $product->title)
@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white shadow-md p-6">
        <div class="flex justify-between items-center mb-2">
            <h1 class="text-2xl font-semibold text-gray-800">Create New Variant</h1>
            <a href="{{ route('admin.products.variants.index', $product) }}"
                class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors text-base">
                Back to Variants
            </a>
        </div>

        <div class="bg-white border border-gray-200 p-6">
            <form action="{{ route('admin.products.variants.store', $product) }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <!-- Color Selection -->
                    <div>
                        <label for="color_id" class="block text-sm font-medium text-gray-700 mb-1">Color <span
                                class="text-red-500">*</span></label>
                        <select id="color_id" name="color_id"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black">
                            <option value="">Select Color</option>
                            @foreach ($colors as $color)
                            <option value="{{ $color->id }}" {{ old('color_id')==$color->id ? 'selected' : '' }}>
                                {{ $color->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('color_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Size Selection -->
                    <div>
                        <label for="size_id" class="block text-sm font-medium text-gray-700 mb-1">Size <span
                                class="text-red-500">*</span></label>
                        <select id="size_id" name="size_id"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black">
                            <option value="">Select Size</option>
                            @foreach ($sizes as $size)
                            <option value="{{ $size->id }}" {{ old('size_id')==$size->id ? 'selected' : '' }}>
                                {{ $size->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('size_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                            Price (৳) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" min="0" id="price" name="price"
                            value="{{ old('price', $product->price) }}"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black">
                        @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock Quantity -->
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock
                            Quantity <span class="text-red-500">*</span></label>
                        <input type="number" min="0" id="stock_quantity" name="stock_quantity"
                            value="{{ old('stock_quantity', 0) }}"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black">
                        @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock Alert -->
                    <div>
                        <label for="stock_alert" class="block text-sm font-medium text-gray-700 mb-1">Stock Alert
                            Level</label>
                        <input type="number" min="0" id="stock_alert" name="stock_alert"
                            value="{{ old('stock_alert') }}"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black">
                        @error('stock_alert')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700">SKU <span
                                class="text-red-500">*</span></label>
                        <div class="mt-1 flex ">
                            <input type="text" id="sku" name="sku" value="{{ old('sku') }}" required
                                class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            <button type="button" id="generateSKU"
                                class="inline-flex items-center border border-l-0 border-gray-300 bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                Generate
                            </button>
                        </div>
                        <p id="sku-error" class="mt-1 text-sm text-red-600 hidden"></p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-black focus:border-black">
                            <option value="active" {{ old('status', 'active' )=='active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                        @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-black text-white hover:bg-gray-800 transition-colors text-base">
                        Create Variant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Generate SKU --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const generateSKUBtn = document.getElementById('generateSKU');
    const skuInput = document.getElementById('sku');
    const skuError = document.getElementById('sku-error');
    let skuValidationTimeout;

    // This function handles the actual validation
    const checkSkuAvailability = (sku) => {
        console.log('Validating SKU:', sku);
        fetch('{{ route("admin.products.variants.checkSku", ["product" => $product->id]) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ sku: sku })
        })
        .then(response => response.json())
        .then(data => {  
            console.log('SKU validation response:', data);          
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
    };

    skuInput.addEventListener('input', function() {
        const sku = this.value.trim();
        // Clear previous timeout to prevent multiple fetch calls
        clearTimeout(skuValidationTimeout);

        // Only start validation if the input is long enough
        if (sku.length >= 3) {
            // Set a new timeout to wait for user to stop typing
            skuValidationTimeout = setTimeout(() => {
                checkSkuAvailability(sku);
            }, 500);
        } else {
            // Reset validation state if input is too short
            skuError.classList.add('hidden');
            skuInput.setCustomValidity('');
        }
    });

    // Handle the "Generate SKU" button separately
    if (generateSKUBtn) {
        generateSKUBtn.addEventListener('click', function() {
            const randomSKU = 'PROD-VAR-' + Math.floor(10000 + Math.random() * 99999);
            skuInput.value = randomSKU;
            checkSkuAvailability(randomSKU);
        });
    }

    // Clear validation when form is submitted
    const productForm = document.getElementById('productForm');
    if (productForm) {
        productForm.addEventListener('submit', function() {
            skuInput.setCustomValidity('');
        });
    }

    // Cancel button functionality
    const cancelBtn = document.getElementById('cancelBtn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            window.location.reload();
        });
    }
});
</script>
@endsection