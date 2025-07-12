@extends('layouts.master-layout')
@section('title', 'Your Bag')
@section('content')
<div class="max-w-7xl mx-auto px-2 py-8">
    <h1 class="ms-6 text-4xl font-bold uppercase mb-2 font-megumi ">Your Bag <span class="text-base font-normal">(2 items)</span>
    </h1>
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Left Column - Product Items -->
        <div class="lg:w-[60%] xl:w-[58%] bg-white">
            <div class="ms-6">
                <p class="text-gray-800 font-medium">You have items in your bag - check out now and make them yours.
                </p>
            </div>

            <div class="px-6 py-6">
                <!-- Product Items Container -->
                <div class="space-y-2" x-data>
                    <!-- Product Item 1 -->
                    <div class="relative flex gap-4 items-start py-6 border-t-2 border-gray-200">
                        <!-- Product Image with Checkbox -->
                        <div class="relative w-64 h-64 flex-shrink-0 bg-gray-100 overflow-hidden">
                            <!-- Checkbox positioned on image -->
                            <div class="absolute top-2 left-2 z-10">
                                <input type="checkbox" checked x-ref="checkbox"
                                    class="w-5 h-5 border-2 border-black appearance-none checked:bg-black checked:border-black relative cursor-pointer focus:ring-0 focus:ring-offset-0 focus:outline-none">
                            </div>
                            <img class="w-full h-full object-cover" src="{{ asset('images/cartimg.jpg')}}"
                                alt="Denim High Premium">
                        </div>
                        <!-- Product Details -->
                        <div class="flex-1 min-w-0 font-semibold">
                            <p class="font-semibold text-2xl mb-2">Denim High Premium</p>
                            <p class="text-xs font-normal text-gray-600 mb-2 uppercase tracking-wider">PRODUCT CODE:
                                QWI879</p>
                            <!-- Color Selection -->
                            <div class="mb-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-base text-gray-800 font-medium">COLOR:</span>
                                    <span class="text-base">Black Nue</span>
                                </div>
                                <div class="flex gap-2">
                                    <button class="w-4 h-4 bg-white border-2 border-black"></button>
                                    <button class="w-4 h-4 bg-black border border-gray-300"></button>
                                    <button class="w-4 h-4 bg-gray-500 border border-gray-300"></button>
                                    <button class="w-4 h-4 bg-blue-800 border border-gray-300"></button>
                                </div>
                            </div>
                            <!-- Price -->
                            <div class="mb-4">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium uppercase">Price:</span>
                                    <p class="text-base text-gray-800">
                                        <span class="text-[#E71046] line-through mr-2">$96.50</span>
                                        <span class="text-black font-medium text-lg">$39.99</span>
                                    </p>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">YOU SAVE $56.51 (59%)</p>
                            </div>
                            <!-- Size and Quantity - Inline -->
                            <div class="flex flex-wrap items-center gap-4 mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium">SIZE:</span>
                                    <select
                                        class="px-1.5 py-1 bg-gray-200 border-none focus:outline-none focus:ring-0 text-sm w-16 cursor-pointer">
                                        <option>XXL</option>
                                        <option>XL</option>
                                        <option>L</option>
                                        <option selected>M</option>
                                        <option>S</option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium">QTY:</span>
                                    <select
                                        class="px-1.5 py-1 bg-gray-200 border-none focus:outline-none focus:ring-0 text-sm w-12 cursor-pointer">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option selected>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Remove Button -->
                            <button class="text-sm underline uppercase font-medium tracking-wider hover:text-gray-600">
                                REMOVE ITEM
                            </button>
                        </div>
                    </div><!-- Product Item 2 -->
                    <div class="relative flex gap-4 items-start py-6 border-t-2 border-gray-200">
                        <!-- Product Image with Checkbox -->
                        <div class="relative w-64 h-64 flex-shrink-0 bg-gray-100 overflow-hidden">
                            <!-- Checkbox positioned on image -->
                            <div class="absolute top-2 left-2 z-10">
                                <input type="checkbox" checked x-ref="checkbox"
                                    class="w-5 h-5 border-2 border-black appearance-none checked:bg-black checked:border-black relative cursor-pointer focus:ring-0 focus:ring-offset-0 focus:outline-none">
                            </div>
                            <img class="w-full h-full object-cover" src="{{ asset('images/cartimg.jpg')}}"
                                alt="Denim High Premium">
                        </div>
                        <!-- Product Details -->
                        <div class="flex-1 min-w-0 font-semibold">
                            <p class="font-semibold text-2xl mb-2">Denim High Premium</p>
                            <p class="text-xs font-normal text-gray-600 mb-2 uppercase tracking-wider">PRODUCT CODE:
                                QWI879</p>
                            <!-- Color Selection -->
                            <div class="mb-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-base text-gray-800 font-medium">COLOR:</span>
                                    <span class="text-base">Black Nue</span>
                                </div>
                                <div class="flex gap-2">
                                    <button class="w-4 h-4 bg-white border-2 border-black"></button>
                                    <button class="w-4 h-4 bg-black border border-gray-300"></button>
                                    <button class="w-4 h-4 bg-gray-500 border border-gray-300"></button>
                                    <button class="w-4 h-4 bg-blue-800 border border-gray-300"></button>
                                </div>
                            </div>
                            <!-- Price -->
                            <div class="mb-4">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium uppercase">Price:</span>
                                    <p class="text-base text-gray-800">
                                        <span class="text-[#E71046] line-through mr-2">$96.50</span>
                                        <span class="text-black font-medium text-lg">$39.99</span>
                                    </p>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">YOU SAVE $56.51 (59%)</p>
                            </div>
                            <!-- Size and Quantity - Inline -->
                            <div class="flex flex-wrap items-center gap-4 mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium">SIZE:</span>
                                    <select
                                        class="px-1.5 py-1 bg-gray-200 border-none focus:outline-none focus:ring-0 text-sm w-16 cursor-pointer">
                                        <option>XXL</option>
                                        <option>XL</option>
                                        <option>L</option>
                                        <option selected>M</option>
                                        <option>S</option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-base text-gray-800 font-medium">QTY:</span>
                                    <select
                                        class="px-1.5 py-1 bg-gray-200 border-none focus:outline-none focus:ring-0 text-sm w-12 cursor-pointer">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option selected>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Remove Button -->
                            <button class="text-sm underline uppercase font-medium tracking-wider hover:text-gray-600">
                                REMOVE ITEM
                            </button>
                        </div>
                    </div>
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
    </div>
</div>
@endsection