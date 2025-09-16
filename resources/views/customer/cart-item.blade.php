@extends('layouts.master-layout')
@section('title', 'Your Bag')
@section('content')
<div class="max-w-7xl mx-auto px-2 py-8">
    {{-- @php
    echo "
    <pre>";
        print_r($cartItems[0]);
    echo "</pre>";
    @endphp --}}
    <h1 class="ms-6 text-4xl font-bold uppercase mb-2 font-megumi ">Your Bag <span
            class="text-base font-normal">({{$totalItems}}
            items)</span>
    </h1>
    <div class="flex flex-col lg:flex-row gap-8">
        @if(!empty($cartItems))
        <!-- Left Column - Product Items -->
        <div class="lg:w-[60%] xl:w-[58%] bg-white">
            <div class="ms-6">
                <p class="text-gray-800 font-medium">You have items in your Bag - Check Out now and make them yours.
                </p>
            </div>

            <div class="px-6 py-6">
                <!-- Product Items Container -->
                <div class="space-y-2" x-data>
                    <!-- Product Item  -->
                    @foreach ($cartItems as $cartItem)
                    <div class="relative flex gap-4 items-start py-6 border-t-2 border-gray-200">
                        <!-- Product Image with Checkbox -->
                        <div class="relative w-64 h-64 flex-shrink-0 bg-gray-100 overflow-hidden">
                            <!-- Checkbox positioned on image -->
                            <div class="absolute top-2 left-2 z-10">
                                <input type="checkbox" checked x-ref="checkbox"
                                    class="w-5 h-5 border-2 border-black appearance-none checked:bg-black checked:border-black relative cursor-pointer focus:ring-0 focus:ring-offset-0 focus:outline-none">
                            </div>
                            <img class="w-full h-full object-cover"
                                src="{{ asset('storage/' . $cartItem->product->primaryImage->image_path) }}"
                                alt="{{ $cartItem->product->title }}">
                        </div>
                        <!-- Product Details -->
                        <div class="flex-1 min-w-0 font-semibold">
                            <p class="font-semibold text-2xl mb-2">{{ $cartItem->product->title }}</p>
                            @if ($cartItem->variant)
                            <p class="text-xs font-normal text-gray-600 mb-2 uppercase tracking-wider">PRODUCT CODE:
                                {{$cartItem->variant->sku}}</p>@else<p
                                class="text-xs font-normal text-gray-600 mb-2 uppercase tracking-wider">PRODUCT CODE:
                                {{$cartItem->product->sku}}</p>@endif
                            <!-- Color Selection -->
                            <div class="mb-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-base text-gray-800 font-medium">COLOR:</span>
                                    @if ($cartItem->variant)
                                    <span class="text-base">{{$cartItem->variant->color->name}}</span>
                                    @else
                                    <span class="text-base">Random Color</span>
                                    @endif
                                </div>
                                @if ($cartItem->variant)
                                <div class="flex gap-2">
                                    <button class="w-6 h-6 border-2 border-black"
                                        style="background-color: {{ $cartItem->variant->color->hex_code }}"></button>
                                </div>
                                @endif
                            </div>
                            <!-- Price -->
                            <div class="mb-4">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium uppercase">Price:</span>

                                    @php
                                    $realPrice = $cartItem->variant ? $cartItem->variant->price :
                                    $cartItem->product->price;
                                    $discountPrice = $cartItem->variant ? $cartItem->variant->discount_price :
                                    $cartItem->product->discount_price;
                                    @endphp

                                    @if ($discountPrice)
                                    <p class="text-base text-gray-800">
                                        <span class="text-[#E71046] line-through mr-2">${{ number_format($realPrice, 2)
                                            }}</span>
                                        <span class="text-black font-medium text-lg">${{ number_format($discountPrice,
                                            2) }}</span>
                                    </p>
                                    @else
                                    <p class="text-base text-gray-800">
                                        <span class="text-black font-medium text-lg">${{ number_format($realPrice, 2)
                                            }}</span>
                                    </p>
                                    @endif
                                </div>

                                @if ($discountPrice)
                                @php
                                $youSave = $realPrice - $discountPrice;
                                $savePercentage = ($realPrice > 0) ? ($youSave / $realPrice) * 100 : 0;
                                @endphp
                                <p class="text-xs text-gray-600 mt-1">
                                    YOU SAVE ${{ number_format($youSave, 2) }} ({{ round($savePercentage) }}%)
                                </p>
                                @endif
                            </div>
                            <!-- Size and Quantity - Inline -->
                            <div class="flex flex-wrap items-center gap-4 mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium">SIZE:</span>
                                    @if ($cartItem->variant)
                                    <span class="px-1.5 py-1 text-sm bg-gray-200">
                                        {{ $cartItem->variant->size->name}}
                                    </span>
                                    @else
                                    <span class="px-1.5 py-1 text-sm bg-gray-200">
                                        Free Size
                                    </span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium">QTY:</span>
                                    <select
                                        class="px-1.5 py-1 bg-gray-200 border-none focus:outline-none focus:ring-0 text-sm w-12 cursor-pointer product-qty-selector"
                                        data-cart-item-id="{{ $cartItem->id }}"
                                        data-product-id="{{ $cartItem->product_id }}"
                                        data-variant-id="{{ $cartItem->variant_id }}">
                                        @for ($i = 1; $i <= 10; $i++) <option value="{{ $i }}" {{ $cartItem->qty == $i ?
                                            'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>
                            <!-- Remove Button -->
                            <button class="text-sm underline uppercase font-medium tracking-wider hover:text-gray-600">
                                REMOVE ITEM
                            </button>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- Right Column - Order Summary -->
        <div class="lg:w-[40%] xl:w-[42%] bg-white">
            <h1 class="text-2xl font-bold mb-4 uppercase ms-6  font-megumi ">Order Summary</h1>
            <div class="px-6 pb-6">
                <hr class="block lg:w-auto lg:h-[2px] lg:bg-gray-200 lg:border-none lg:mx-0">
                <!-- Order Totals -->
                <div class="space-y-3 my-4">
                    <div class="flex justify-between">
                        <span>Order value</span>
                        <span class="font-semibold">$69.97</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Discount</span>
                        <span class="font-semibold text-green-600">- $9.97</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="uppercase">VAT 5%</span>
                        <span class="font-semibold">$3.00</span>
                    </div>


                    <!-- Coupon Section -->
                    <div class="flex justify-between items-center" x-data="{ showCouponField: false, couponCode: '',
                                    applyCoupon() {
                                            alert(`Applying coupon: ${this.couponCode}`);
                                         } }">
                        <span>Coupon discount</span>
                        <template x-if="!showCouponField">
                            <button @click="showCouponField = true"
                                class="text-sm font-semibold underline hover:no-underline">
                                Apply coupon
                            </button>
                        </template>
                        <template x-if="showCouponField">
                            <div class="flex gap-2 items-center">
                                <input type="text" placeholder="Enter code" x-model="couponCode"
                                    class="text-sm p-2 border border-black focus:outline-none focus:border-black w-32 uppercase"
                                    maxlength="7">
                                <button @click="applyCoupon()"
                                    class="text-sm font-semibold underline hover:no-underline">
                                    Apply
                                </button>
                                <button @click="showCouponField = false; couponCode = ''"
                                    class="text-sm font-semibold px-2 hover:bg-gray-100">
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
                    <span>$63.00</span>
                </div>


                <!-- Checkout Button -->
                <a href="{{ route('customer.checkout') }}"
                    class="w-full bg-black text-white py-3 px-4 font-medium focus:outline-none focus:bg-gray-800 mt-6 mb-4 inline-block text-center">
                    PROCEED TO CHECKOUT
                </a>


                <!-- Delivery & Return Policy -->
                <div class="text-center text-sm">
                    <a href="#" class="underline">Delivery & Return Policy</a>
                </div>
            </div>
        </div>
        @else
        <div>
            Empty Cart
        </div>
        @endif
    </div>
</div>
@endsection