@extends('layouts.master-layout')
@section('title', 'Your Bag')
@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .item-checkbox:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .color-option {
            width: 24px;
            height: 24px;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .color-option.selected {
            border-color: black;
        }

        .size-option {
            padding: 4px 8px;
            border: 1px solid #d1d5db;
            cursor: pointer;
            font-size: 14px;
            text-align: center;
            min-width: 40px;
        }

        .size-option.selected {
            border-color: black;
            background-color: black;
            color: white;
        }

        .size-option.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .variant-loading {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush
@section('content')
    <div class="max-w-7xl mx-auto px-2 py-8" id="cart-container">
        <h1 class="ms-6 text-4xl font-bold uppercase mb-2 font-megumi ">Your Bag <span
                class="text-base font-normal">({{ $totalItems }} items)</span>
        </h1>
        @if ($totalItems > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column - Product Items -->
                <div class="lg:w-[60%] xl:w-[58%] bg-white">
                    <div class="ms-6">
                        <p class="text-gray-800 font-medium">You have items in your bag - check out now and make them yours.
                        </p>
                    </div>
                    <div class="px-6 py-6">
                        <!-- Product Items Container -->
                        <div class="space-y-2" id="cart-items-container">
                            @foreach ($cartItems as $item)
                                @if ($item->product)
                                    <!-- Product Item -->
                                    <div class="relative flex gap-4 items-start py-6 border-t-2 border-gray-200 cart-item"
                                        data-item-id="{{ $item->id }}" data-product-id="{{ $item->product->id }}"
                                        data-price="{{ $item->variant && $item->variant->price ? $item->variant->price : ($item->product->discount && $item->product->discount_price ? $item->product->discount_price : $item->product->price) }}"
                                        data-original-price="{{ $item->product->price }}" data-qty="{{ $item->qty }}"
                                        data-has-variants="{{ $item->product->variants && $item->product->variants->count() > 0 ? 'true' : 'false' }}">

                                        <!-- Product Image with Checkbox -->
                                        <div class="relative w-64 h-64 flex-shrink-0 bg-gray-100 overflow-hidden">
                                            <!-- Checkbox positioned on image -->
                                            <div class="absolute top-2 left-2 z-10">
                                                <input type="checkbox"
                                                    class="item-checkbox w-5 h-5 border-2 border-black appearance-none checked:bg-black checked:border-black relative cursor-pointer focus:ring-0 ring-offset-0 focus:ring-offset-0 outline-none focus:outline-none checked:hover:bg-black"
                                                    checked>
                                            </div>
                                            <img class="w-full h-full object-cover"
                                                src="{{ '/storage' . '/' . $item->product->primaryImage->image_path }}"
                                                alt="{{ $item->product->title }}">
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1 min-w-0 font-semibold">
                                            <p class="font-semibold text-2xl mb-2">{{ $item->product->title }}</p>
                                            <p class="text-xs font-normal text-gray-600 mb-2 uppercase tracking-wider">
                                                PRODUCT CODE:
                                                {{ $item->product->sku }}</p>

                                            <!-- Color Selection -->
                                            <div class="mb-4">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <span class="text-base text-gray-800 font-medium">COLOR:</span>
                                                    <span class="text-base selected-color-text">
                                                        @if ($item->variant && $item->variant->color)
                                                            {{ $item->variant->color->name }}
                                                        @elseif($item->color)
                                                            {{ $item->color }}
                                                        @elseif($item->product->variants && $item->product->variants->count() > 0)
                                                            Select Color
                                                        @else
                                                            N/A
                                                        @endif
                                                    </span>
                                                    <div class="variant-loading color-loading"></div>
                                                </div>
                                                @if ($item->product->variants && $item->product->variants->count() > 0)
                                                    @php
                                                        $uniqueColors = $item->product->variants
                                                            ->unique('color_id')
                                                            ->pluck('color');
                                                        $selectedColorId = $item->variant
                                                            ? $item->variant->color_id
                                                            : null;
                                                    @endphp
                                                    <div class="flex gap-2 color-options">
                                                        @foreach ($uniqueColors as $color)
                                                            @if ($color)
                                                                <div class="color-option {{ $selectedColorId == $color->id ? 'selected' : '' }} "
                                                                    data-color-id="{{ $color->id }}"
                                                                    data-color-name="{{ $color->name }}"
                                                                    style="background-color: {{ $color->hex_code }}"
                                                                    title="{{ $color->name }}">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-sm text-gray-500">Random color</p>
                                                @endif
                                            </div>

                                            <!-- Size Selection -->
                                            <div class="mb-4">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <span class="text-base text-gray-800 font-medium">SIZE:</span>
                                                    <span class="text-base selected-size-text">
                                                        @if ($item->variant && $item->variant->size)
                                                            {{ $item->variant->size->name }}
                                                        @elseif($item->size)
                                                            {{ $item->size }}
                                                        @elseif($item->product->variants && $item->product->variants->count() > 0)
                                                            Select Size
                                                        @else
                                                            Free Size
                                                        @endif
                                                    </span>
                                                    <div class="variant-loading size-loading"></div>
                                                </div>
                                                @if ($item->product->variants && $item->product->variants->count() > 0)
                                                    @php
                                                        $selectedSizeId = $item->variant
                                                            ? $item->variant->size_id
                                                            : null;
                                                        $selectedColorId = $item->variant
                                                            ? $item->variant->color_id
                                                            : null;

                                                        // Get available sizes based on selected color
                                                        $availableSizes = $selectedColorId
                                                            ? $item->product->variants
                                                                ->where('color_id', $selectedColorId)
                                                                ->pluck('size')
                                                                ->unique('id')
                                                            : collect();
                                                    @endphp
                                                    <div class="flex gap-2 size-options">
                                                        @if ($selectedColorId)
                                                            @foreach ($availableSizes as $size)
                                                                @if ($size)
                                                                    <div class="size-option {{ $selectedSizeId == $size->id ? 'selected' : '' }}"
                                                                        data-size-id="{{ $size->id }}"
                                                                        data-size-name="{{ $size->name }}">
                                                                        {{ $size->name }}
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <p class="text-sm text-gray-500">Select a color first</p>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Price -->
                                            <div class="mb-4">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span
                                                        class="text-base text-gray-800 font-medium uppercase">Price:</span>
                                                    <p class="text-base text-gray-800 item-price"
                                                        id="price-{{ $item->id }}">
                                                        @if ($item->variant && $item->variant->price)
                                                            <span class="text-black font-medium text-lg">
                                                                ${{ number_format($item->variant->price, 2) }}
                                                            </span>
                                                        @elseif($item->product->discount > 0 && $item->product->discount_price)
                                                            <span class="text-[#E71046] line-through mr-2">
                                                                ${{ number_format($item->product->price, 2) }}
                                                            </span>
                                                            <span class="text-black font-medium text-lg">
                                                                ${{ number_format($item->product->discount_price, 2) }}
                                                            </span>
                                                        @else
                                                            <span class="text-black font-medium text-lg">
                                                                ${{ number_format($item->product->price, 2) }}
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>

                                                @if ($item->product->discount > 0 && $item->product->discount_price && !$item->variant)
                                                    @php
                                                        $savings =
                                                            $item->product->price - $item->product->discount_price;
                                                        $percentage = ($savings / $item->product->price) * 100;
                                                    @endphp
                                                    <p class="text-xs text-gray-600 mt-1">
                                                        YOU SAVE ${{ number_format($savings, 2) }}
                                                        ({{ round($percentage) }}%)
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Quantity -->
                                            <div class="flex flex-wrap items-center gap-4 mb-4">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-base text-gray-800 font-medium">QTY:</span>
                                                    <select
                                                        class="item-qty px-1.5 py-1 bg-gray-200 border-none focus:outline-none focus:ring-0 text-sm w-12 cursor-pointer">
                                                        @for ($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}"
                                                                {{ $item->qty == $i ? 'selected' : '' }}>
                                                                {{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Remove Button -->
                                            <button
                                                class="remove-item text-sm underline uppercase font-medium tracking-wider hover:text-gray-600"
                                                data-item-id="{{ $item->id }}">
                                                REMOVE ITEM
                                            </button>
                                        </div>

                                        <!-- Confirmation Modal -->
                                        <div
                                            class="confirmation-modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
                                            <div class="bg-white p-6 max-w-md w-full">
                                                <h3 class="text-lg font-medium text-gray-900 mb-4">Remove Item</h3>
                                                <p class="text-sm text-gray-500 mb-6">Are you sure you want to remove this
                                                    product?</p>
                                                <div class="flex justify-end space-x-3">
                                                    <button type="button"
                                                        class="cancel-remove px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Cancel
                                                    </button>
                                                    <button type="button"
                                                        class="confirm-remove px-4 py-2 bg-indigo-600 border border-transparent text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Confirm
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Right Column - Order Summary -->
                <div class="lg:w-[40%] xl:w-[42%] bg-white">
                    <h1 class="text-2xl font-bold mb-4 uppercase ms-6 font-megumi ">Order Summary</h1>
                    <div class="px-6 pb-6">
                        <hr class="block lg:w-auto lg:h-[2px] lg:bg-gray-200 lg:border-none lg:mx-0">
                        <!-- Order Totals -->
                        <div class="space-y-3 my-4">
                            <div class="flex justify-between">
                                <span>Order value</span>
                                <span class="font-semibold" id="order-value">$0.00</span>
                            </div>
                            <div class="flex justify-between" id="discount-container">
                                <span>Discount</span>
                                <span class="font-semibold text-green-600" id="total-discount">- $0.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="uppercase">VAT 5%</span>
                                <span class="font-semibold" id="vat-amount">$0.00</span>
                            </div>
                            <!-- Coupon Section -->
                            <div class="flex justify-between items-center" id="coupon-section">
                                <span>Coupon discount</span>
                                <template id="coupon-button-template">
                                    <button class="show-coupon-field text-sm font-semibold underline hover:no-underline">
                                        Apply coupon
                                    </button>
                                </template>
                                <template id="coupon-field-template">
                                    <div class="flex gap-2 items-center">
                                        <input type="text" placeholder="Enter code"
                                            class="coupon-code text-sm p-2 border border-black focus:outline-none focus:border-black w-32 uppercase"
                                            maxlength="7">
                                        <button class="apply-coupon text-sm font-semibold underline hover:no-underline">
                                            Apply
                                        </button>
                                        <button class="cancel-coupon text-sm font-semibold px-2 hover:bg-gray-100">
                                            ✕
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span class="font-semibold">FREE</span>
                            </div>
                        </div>
                        <!-- Total Price -->
                        <div class="flex justify-between font-semibold border-t-2 border-gray-200 pt-4 text-lg">
                            <span>Total Price</span>
                            <span id="total-price">$0.00</span>
                        </div>
                        <!-- Checkout Button -->
                        <form method="POST" action="{{ route('customer.checkout') }}" id="checkoutForm">
                            @csrf
                            <input type="hidden" name="selected_items" id="selectedItemsInput">
                            <button type="submit"
                                class="w-full bg-black text-white py-3 px-4 font-medium focus:outline-none focus:bg-gray-800 mt-6 mb-4 inline-block text-center">
                                Proceed to Checkout
                            </button>
                        </form>

                        <!-- Delivery & Return Policy -->
                        <div class="text-center text-sm">
                            <a href="{{ route('delivery.return.policy') }}" class="underline">Delivery & Return
                                Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <h2 class="text-2xl font-bold mb-4">Your bag is empty</h2>
                <a href="{{ route('products.list') }}" class="bg-black text-white px-6 py-3 inline-block">Continue
                    Shopping</a>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== Cart Calculator State =====
            const cartState = {
                orderValue: 0,
                totalDiscount: 0,
                vatAmount: 0,
                totalPrice: 0,
                items: new Map()
            };

            // ===== Initialize Cart =====
            function initCart() {
                const cartItems = document.querySelectorAll('.cart-item');

                cartItems.forEach(item => {
                    const itemId = item.dataset.itemId;
                    const productId = item.dataset.productId;
                    const price = parseFloat(item.dataset.price);
                    const originalPrice = parseFloat(item.dataset.originalPrice);
                    const qty = parseInt(item.dataset.qty);
                    const hasVariants = item.dataset.hasVariants === 'true';
                    const checkbox = item.querySelector('.item-checkbox');
                    const qtySelect = item.querySelector('.item-qty');

                    cartState.items.set(itemId, {
                        selected: checkbox.checked,
                        price: price,
                        originalPrice: originalPrice,
                        qty: qty,
                        total: price * qty,
                        discount: (originalPrice * qty) - (price * qty),
                        hasVariants: hasVariants,
                        colorId: item.querySelector('.color-option.selected')?.dataset.colorId ||
                            null,
                        sizeId: item.querySelector('.size-option.selected')?.dataset.sizeId || null
                    });

                    checkbox.addEventListener('change', () => updateItemSelection(itemId, checkbox
                        .checked));
                    qtySelect.addEventListener('change', () => updateItemQty(itemId, parseInt(qtySelect
                        .value)));

                    // === Variant Handlers ===
                    if (hasVariants) {
                        const colorOptions = item.querySelectorAll('.color-option');
                        const sizeOptions = item.querySelectorAll('.size-option');

                        colorOptions.forEach(option => {
                            option.addEventListener('click', () => {
                                const colorId = option.dataset.colorId;
                                const colorName = option.dataset.colorName;
                                selectColor(itemId, productId, colorId, colorName);
                            });
                        });

                        sizeOptions.forEach(option => {
                            option.addEventListener('click', () => {
                                if (option.classList.contains('disabled')) return;

                                const sizeId = option.dataset.sizeId;
                                const sizeName = option.dataset.sizeName;
                                selectSize(itemId, productId, sizeId, sizeName);
                            });
                        });
                    }

                    // Remove button
                    const removeBtn = item.querySelector('.remove-item');
                    removeBtn?.addEventListener('click', () => showRemoveConfirmation(itemId));

                    // Remove confirmation handlers
                    const cancelRemove = item.querySelector('.cancel-remove');
                    const confirmRemove = item.querySelector('.confirm-remove');

                    cancelRemove?.addEventListener('click', () => {
                        item.querySelector('.confirmation-modal').classList.add('hidden');
                    });

                    confirmRemove?.addEventListener('click', () => {
                        removeCartItem(itemId);
                    });
                });

                initCouponSection();
                calculateTotals();
            }

            // ===== Update Item Selection =====
            function updateItemSelection(itemId, isSelected) {
                const item = cartState.items.get(itemId);
                if (item) {
                    item.selected = isSelected;
                    calculateTotals();
                }
            }

            // ===== Update Qty =====
            function updateItemQty(itemId, newQty) {
                const item = cartState.items.get(itemId);
                if (item) {
                    item.qty = newQty;
                    item.total = item.price * newQty;
                    item.discount = (item.originalPrice * newQty) - item.total;
                    calculateTotals();
                }
            }

            // ===== Select Color =====
            function selectColor(itemId, productId, colorId, colorName) {
                const itemElement = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                if (!itemElement) return;

                // Update UI
                const colorOptions = itemElement.querySelectorAll('.color-option');
                colorOptions.forEach(opt => opt.classList.remove('selected'));
                itemElement.querySelector(`.color-option[data-color-id="${colorId}"]`).classList.add('selected');
                itemElement.querySelector('.selected-color-text').textContent = colorName;

                // Show loading
                itemElement.querySelector('.color-loading').style.display = 'inline-block';

                // Update state
                const item = cartState.items.get(itemId);
                if (item) {
                    item.colorId = colorId;
                }

                // Fetch available sizes for this color
                fetch(`/cart/get-sizes`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            color_id: colorId
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network response was not ok');
                        return res.json();
                    })
                    .then(sizes => {
                        // Update sizes UI
                        const sizesContainer = itemElement.querySelector('.size-options');
                        sizesContainer.innerHTML = '';

                        if (sizes.length > 0) {
                            sizes.forEach(size => {
                                if (size) {
                                    const sizeElement = document.createElement('div');
                                    sizeElement.className = 'size-option';
                                    sizeElement.dataset.sizeId = size.id;
                                    sizeElement.dataset.sizeName = size.name;
                                    sizeElement.textContent = size.name;

                                    sizeElement.addEventListener('click', () => {
                                        selectSize(itemId, productId, size.id, size.name);
                                    });

                                    sizesContainer.appendChild(sizeElement);
                                }
                            });

                            itemElement.querySelector('.selected-size-text').textContent = 'Select Size';
                        } else {
                            sizesContainer.innerHTML =
                                '<p class="text-sm text-gray-500">No sizes available</p>';
                            itemElement.querySelector('.selected-size-text').textContent = 'N/A';
                        }

                        // Reset size selection in state
                        if (item) {
                            item.sizeId = null;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching sizes:', error);
                        itemElement.querySelector('.size-options').innerHTML =
                            '<p class="text-sm text-red-500">Error loading sizes</p>';
                    })
                    .finally(() => {
                        itemElement.querySelector('.color-loading').style.display = 'none';
                    });
            }

            // ===== Select Size =====
            function selectSize(itemId, productId, sizeId, sizeName) {
                const itemElement = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                if (!itemElement) return;

                // Update UI
                const sizeOptions = itemElement.querySelectorAll('.size-option');
                sizeOptions.forEach(opt => opt.classList.remove('selected'));
                itemElement.querySelector(`.size-option[data-size-id="${sizeId}"]`).classList.add('selected');
                itemElement.querySelector('.selected-size-text').textContent = sizeName;

                // Show loading
                itemElement.querySelector('.size-loading').style.display = 'inline-block';

                // Update state
                const item = cartState.items.get(itemId);
                if (item) {
                    item.sizeId = sizeId;
                }

                // Fetch variant price
                fetch(`/cart/get-variant-price`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            color_id: item.colorId,
                            size_id: sizeId
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network response was not ok');
                        return res.json();
                    })
                    .then(variant => {
                        if (!variant.error) {
                            // Update price in UI
                            const priceElement = itemElement.querySelector('.item-price');
                            priceElement.innerHTML = `
                    <span class="text-black font-medium text-lg">
                        $${parseFloat(variant.price).toFixed(2)}
                    </span>
                `;

                            // Update state
                            if (item) {
                                const originalPrice = item.originalPrice;
                                item.price = parseFloat(variant.price);
                                item.total = item.price * item.qty;
                                item.discount = (originalPrice * item.qty) - item.total;
                                calculateTotals();
                            }

                            // Update data attributes
                            itemElement.dataset.price = variant.price;
                        } else {
                            console.error('Variant error:', variant.error);
                            alert('Selected variant is not available');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching variant price:', error);
                        alert('Error loading variant price');
                    })
                    .finally(() => {
                        itemElement.querySelector('.size-loading').style.display = 'none';
                    });
            }

            // ===== Calculate Totals =====
            function calculateTotals() {
                cartState.orderValue = 0;
                cartState.totalDiscount = 0;

                cartState.items.forEach(item => {
                    if (item.selected) {
                        cartState.orderValue += item.total;
                        cartState.totalDiscount += item.discount;
                    }
                });

                const vatRate = 0.05;
                cartState.vatAmount = cartState.orderValue * vatRate;
                cartState.totalPrice = cartState.orderValue + cartState.vatAmount;

                updateTotalsUI();
            }

            function updateTotalsUI() {
                document.getElementById('order-value').textContent = formatCurrency(cartState.orderValue);
                document.getElementById('total-discount').textContent =
                    `- ${formatCurrency(cartState.totalDiscount)}`;
                document.getElementById('vat-amount').textContent = formatCurrency(cartState.vatAmount);
                document.getElementById('total-price').textContent = formatCurrency(cartState.totalPrice);

                // Show/hide discount container
                const discountContainer = document.getElementById('discount-container');
                if (discountContainer) {
                    discountContainer.style.display = cartState.totalDiscount > 0 ? 'flex' : 'none';
                }
            }

            function formatCurrency(amount) {
                return `$${amount.toFixed(2)}`;
            }

            // ===== Show Remove Confirmation =====
            function showRemoveConfirmation(itemId) {
                const itemElement = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                if (itemElement) {
                    const modal = itemElement.querySelector('.confirmation-modal');
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                }
            }

            // ===== Remove Item =====
            function removeCartItem(itemId) {
                fetch(`/cart/remove/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network response was not ok');
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const itemElement = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                            if (itemElement) {
                                itemElement.remove();
                                cartState.items.delete(itemId);
                                calculateTotals();

                                // Update item count in the title
                                const totalItems = document.querySelectorAll('.cart-item').length;
                                const itemsSpan = document.querySelector('h1 span');
                                if (itemsSpan) {
                                    itemsSpan.textContent = `(${totalItems} items)`;
                                }

                                // Show empty cart message if no items left
                                if (totalItems === 0) {
                                    document.getElementById('cart-container').innerHTML = `
                            <div class="text-center py-12">
                                <h2 class="text-2xl font-bold mb-4">Your bag is empty</h2>
                                <a href="{{ route('products.list') }}" class="bg-black text-white px-6 py-3 inline-block">Continue Shopping</a>
                            </div>
                        `;
                                }
                            }
                        } else {
                            alert('Failed to remove item: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while removing the item');
                    });
            }

            // ===== Coupon Section =====
            function initCouponSection() {
                const couponSection = document.getElementById('coupon-section');
                const couponButtonTemplate = document.getElementById('coupon-button-template');
                const couponFieldTemplate = document.getElementById('coupon-field-template');

                if (!couponSection) return;

                // Initially show the button
                couponSection.innerHTML = '';
                couponSection.appendChild(couponButtonTemplate.content.cloneNode(true));

                // Add event listener for showing coupon field
                couponSection.addEventListener('click', function(e) {
                    if (e.target.classList.contains('show-coupon-field')) {
                        couponSection.innerHTML = '';
                        couponSection.appendChild(couponFieldTemplate.content.cloneNode(true));
                    } else if (e.target.classList.contains('apply-coupon')) {
                        const couponCode = couponSection.querySelector('.coupon-code').value;
                        alert(`Applying coupon: ${couponCode}`);
                        // Here you would make an API call to apply the coupon
                    } else if (e.target.classList.contains('cancel-coupon')) {
                        couponSection.innerHTML = '';
                        couponSection.appendChild(couponButtonTemplate.content.cloneNode(true));
                    }
                });
            }

            initCart();
        });

        document.querySelector('#checkoutForm').addEventListener('submit', function(e) {
            const selected = [];
            document.querySelectorAll('.cart-item .item-checkbox:checked').forEach(cb => {
                selected.push(cb.closest('.cart-item').dataset.itemId);
            });
            document.getElementById('selectedItemsInput').value = JSON.stringify(selected);
        });
        
    </script>
@endsection
