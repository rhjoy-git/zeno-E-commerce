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
</style>
@endpush
@section('content')
<div class="max-w-7xl mx-auto px-2 py-8" id="cart-container">
    <h1 class="ms-6 text-4xl font-bold uppercase mb-2 font-megumi ">Your Bag <span class="text-base font-normal">({{
            $totalItems }} items)</span>
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
                    @if($item->product)
                    <!-- Product Item -->
                    <div class="relative flex gap-4 items-start py-6 border-t-2 border-gray-200 cart-item"
                        data-item-id="{{ $item->id }}"
                        data-price="{{ $item->product->discount && $item->product->discount_price ? $item->product->discount_price : $item->product->price }}"
                        data-original-price="{{ $item->product->price }}" data-qty="{{ $item->qty }}">

                        <!-- Product Image with Checkbox -->
                        <div class="relative w-64 h-64 flex-shrink-0 bg-gray-100 overflow-hidden">
                            <!-- Checkbox positioned on image -->
                            <div class="absolute top-2 left-2 z-10">
                                <input type="checkbox"
                                    class="item-checkbox w-5 h-5 border-2 border-black appearance-none checked:bg-black checked:border-black relative cursor-pointer focus:ring-0 ring-offset-0 focus:ring-offset-0 outline-none focus:outline-none checked:hover:bg-black"
                                    checked>
                            </div>
                            <img class="w-full h-full object-cover"
                                src="{{ '/storage'.'/'.$item->product->primaryImage->image_path }}"
                                alt="{{ $item->product->title }}">
                        </div>

                        <!-- Product Details -->
                        <div class="flex-1 min-w-0 font-semibold">
                            <p class="font-semibold text-2xl mb-2">{{ $item->product->title }}</p>
                            <p class="text-xs font-normal text-gray-600 mb-2 uppercase tracking-wider">PRODUCT CODE:
                                {{ $item->product->sku }}</p>

                            <!-- Color Selection -->
                            <div class="mb-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-base text-gray-800 font-medium">COLOR:</span>
                                    <span class="text-base">
                                        {{ $item->variant->color->name ?? $item->color ?? 'N/A' }}
                                    </span>
                                </div>
                                @if($item->product->variants && $item->product->variants->count() > 0)
                                <div class="flex gap-2">
                                    @php
                                    $uniqueColors = $item->product->variants->unique('color_id')->pluck('color');
                                    @endphp
                                    @foreach($uniqueColors as $color)
                                    @if($color)
                                    <button
                                        class="w-4 h-4 border border-gray-300 {{ $item->variant && $item->variant->color_id == $color->id ? 'border-2 border-black' : '' }}"
                                        style="background-color: {{ $color->hex_code }}"
                                        title="{{ $color->name }}"></button>
                                    @endif
                                    @endforeach
                                </div>
                                @else
                                <p class="text-sm text-gray-500">Random color</p>
                                @endif
                            </div>

                            <!-- Price -->
                            <div class="mb-4">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium uppercase">Price:</span>
                                    <p class="text-base text-gray-800">
                                        @if($item->product->discount > 0 && $item->product->discount_price)
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

                                @if($item->product->discount > 0 && $item->product->discount_price)
                                @php
                                $savings = $item->product->price - $item->product->discount_price;
                                $percentage = ($savings / $item->product->price) * 100;
                                @endphp
                                <p class="text-xs text-gray-600 mt-1">
                                    YOU SAVE ${{ number_format($savings, 2) }} ({{ round($percentage) }}%)
                                </p>
                                @endif
                            </div>

                            <!-- Size and Quantity -->
                            <div class="flex flex-wrap items-center gap-4 mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium">SIZE:</span>
                                    @if($item->product->availableSizes && $item->product->availableSizes->count() > 0)
                                    <select
                                        class="px-1.5 py-1 bg-gray-200 border-none focus:outline-none focus:ring-0 text-sm w-16 cursor-pointer">
                                        @foreach($item->product->availableSizes ?? [] as $size)
                                        <option>{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                    @else
                                    <p class="text-sm text-gray-500">Free Size</p>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium">QTY:</span>
                                    <select
                                        class="item-qty px-1.5 py-1 bg-gray-200 border-none focus:outline-none focus:ring-0 text-sm w-12 cursor-pointer">
                                        @for($i = 1; $i <= 10; $i++) <option value="{{ $i }}" {{ $item->qty == $i ?
                                            'selected' : '' }}>{{ $i }} </option>
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
                                <p class="text-sm text-gray-500 mb-6">Are you sure you want to remove this product?</p>
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
                <a href="{{ route('customer.checkout') }}"
                    class="w-full bg-black text-white py-3 px-4 font-medium focus:outline-none focus:bg-gray-800 mt-6 mb-4 inline-block text-center">
                    PROCEED TO CHECKOUT
                </a>
                <!-- Delivery & Return Policy -->
                <div class="text-center text-sm">
                    <a href="{{ route('delivery.return.policy') }}" class="underline">Delivery & Return Policy</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Cart calculator state
    const cartState = {
        orderValue: 0,
        totalDiscount: 0,
        vatAmount: 0,
        totalPrice: 0,
        items: new Map()
    };

    // Initialize the cart
    function initCart() {
        // Get all cart items
        const cartItems = document.querySelectorAll('.cart-item');
        
        cartItems.forEach(item => {
            const itemId = item.dataset.itemId;
            const price = parseFloat(item.dataset.price);
            const originalPrice = parseFloat(item.dataset.originalPrice);
            const qty = parseInt(item.dataset.qty);
            const checkbox = item.querySelector('.item-checkbox');
            const qtySelect = item.querySelector('.item-qty');
            
            // Calculate initial item totals
            const itemTotal = price * qty;
            const itemDiscount = (originalPrice * qty) - itemTotal;
            
            // Store item data
            cartState.items.set(itemId, {
                selected: checkbox.checked,
                price: price,
                originalPrice: originalPrice,
                qty: qty,
                total: itemTotal,
                discount: itemDiscount
            });
            
            // Add event listeners
            checkbox.addEventListener('change', function() {
                updateItemSelection(itemId, this.checked);
            });
            
            qtySelect.addEventListener('change', function() {
                updateItemQty(itemId, parseInt(this.value));
            });
            
            // Remove item functionality
            const removeBtn = item.querySelector('.remove-item');
            const confirmModal = item.querySelector('.confirmation-modal');
            const cancelRemove = item.querySelector('.cancel-remove');
            const confirmRemove = item.querySelector('.confirm-remove');
            
            removeBtn.addEventListener('click', function() {
                confirmModal.classList.remove('hidden');
            });
            
            cancelRemove.addEventListener('click', function() {
                confirmModal.classList.add('hidden');
            });
            
            confirmRemove.addEventListener('click', function() {
                removeCartItem(itemId);
                confirmModal.classList.add('hidden');
            });
        });
        
        // Initialize coupon section
        initCouponSection();
        
        // Calculate initial totals
        calculateTotals();
    }

    function updateItemSelection(itemId, isSelected) {
        const item = cartState.items.get(itemId);
        if (item) {
            item.selected = isSelected;
            calculateTotals();
        }
    }

    function updateItemQty(itemId, newQty) {
        const item = cartState.items.get(itemId);
        if (item) {
            item.qty = newQty;
            item.total = item.price * newQty;
            item.discount = (item.originalPrice * newQty) - item.total;
            calculateTotals();
        }
    }

    function calculateTotals() {
        cartState.orderValue = 0;
        cartState.totalDiscount = 0;
        
        // Calculate totals from selected items only
        cartState.items.forEach(item => {
            if (item.selected) {
                cartState.orderValue += item.total;
                cartState.totalDiscount += item.discount;
            }
        });
        
        // Calculate VAT and total
        const vatRate = 0.05;
        cartState.vatAmount = cartState.orderValue * vatRate;
        cartState.totalPrice = cartState.orderValue + cartState.vatAmount;
        
        // Update UI
        updateTotalsUI();
    }

    function updateTotalsUI() {
        document.getElementById('order-value').textContent = formatCurrency(cartState.orderValue);
        document.getElementById('total-discount').textContent = `- ${formatCurrency(cartState.totalDiscount)}`;
        document.getElementById('vat-amount').textContent = formatCurrency(cartState.vatAmount);
        document.getElementById('total-price').textContent = formatCurrency(cartState.totalPrice);
        
        // Show/hide discount based on value
        const discountContainer = document.getElementById('discount-container');
        discountContainer.style.display = cartState.totalDiscount > 0 ? 'flex' : 'none';
    }

    function formatCurrency(amount) {
        return `$${amount.toFixed(2)}`;
    }

    function removeCartItem(itemId) {
        // Send AJAX request to remove item
        fetch(`/cart/remove/${itemId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove item from DOM and recalculate
                const itemElement = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                if (itemElement) {
                    itemElement.remove();
                    cartState.items.delete(itemId);
                    calculateTotals();
                }
            } else {
                alert('Failed to remove item');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing the item');
        });
    }

    function initCouponSection() {
        const couponSection = document.getElementById('coupon-section');
        const couponButtonTemplate = document.getElementById('coupon-button-template');
        const couponFieldTemplate = document.getElementById('coupon-field-template');
        
        // Initially show the button
        couponSection.appendChild(couponButtonTemplate.content.cloneNode(true));
        
        // Add event listener for showing coupon field
        couponSection.addEventListener('click', function(e) {
            if (e.target.classList.contains('show-coupon-field')) {
                couponSection.innerHTML = '';
                couponSection.appendChild(couponFieldTemplate.content.cloneNode(true));
            } else if (e.target.classList.contains('apply-coupon')) {
                const couponCode = couponSection.querySelector('.coupon-code').value;
                alert(`Applying coupon: ${couponCode}`);
            } else if (e.target.classList.contains('cancel-coupon')) {
                couponSection.innerHTML = '';
                couponSection.appendChild(couponButtonTemplate.content.cloneNode(true));
            }
        });
    }    
    
    // Initialize the cart when page loads
    initCart();
});


</script>
@endsection