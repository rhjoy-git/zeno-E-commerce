<div id="product-cart-popup" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-4xl max-h-[90vh] overflow-hidden relative  shadow-lg">

        <!-- Close Button -->
        <button id="popup-close"
            class="absolute top-4 right-4 z-20 bg-white w-10 h-10 flex items-center justify-center text-gray-600 hover:text-gray-800">
            <i class="fas fa-times text-lg"></i>
        </button>

        <div class="flex flex-col lg:flex-row h-full">
            <!-- Product Image Section -->
            <div class="lg:w-1/2 flex flex-col items-center justify-center bg-gray-50 p-8">
                <div class="mb-4">
                    <img id="popup-main-image" src="" alt="Product" class="w-96 h-96 object-cover  border">
                </div>

                <!-- Thumbnails -->
                <div id="popup-thumbnails" class="flex gap-2 overflow-x-auto"></div>
            </div>

            <!-- Product Details -->
            <div class="lg:w-1/2 p-8 overflow-y-auto">
                <!-- Product Header -->
                <div class="mb-4">
                    <h2 id="popup-title" class="text-2xl font-bold text-black mb-2"></h2>
                    <p id="popup-description" class="text-gray-600 text-sm"></p>
                </div>

                <!-- Price Section -->
                <div class="mb-4">
                    <span id="popup-price" class="text-2xl font-bold text-black"></span>
                </div>

                <!-- Variants (Color + Size) -->
                <div id="popup-variants">
                    <!-- Color -->
                    <div id="popup-colors" class="mb-4 hidden">
                        <h3 class="text-base font-semibold text-black mb-3">Color</h3>
                        <div id="color-options" class="flex gap-3"></div>
                    </div>

                    <!-- Size -->
                    <div id="popup-sizes" class="mb-4 hidden">
                        <h3 class="text-base font-semibold text-black mb-3">Size</h3>
                        <div id="size-options" class="grid grid-cols-4 gap-2"></div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="mb-4">
                    <h3 class="text-base font-semibold text-black mb-3">Quantity</h3>
                    <div class="flex items-center">
                        <div class="flex items-center border-2 border-gray-300 ">
                            <button id="qty-decrease" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" id="popup-quantity" value="1"
                                class="w-12 text-center border-0 py-2 font-medium" min="1" max="99">
                            <button id="qty-increase" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 mb-4">
                    <button id="popup-add-to-cart"
                        class="flex-1 px-6 py-3 bg-black text-white font-medium flex items-center justify-center gap-2">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                    <button
                        class="flex-1 px-6 py-3 border-2 border-black text-black font-medium flex items-center justify-center gap-2">
                        <i class="fas fa-heart"></i>
                        Wishlist
                    </button>
                </div>

                <!-- Features -->
                <div id="popup-features" class="hidden mb-4 grid grid-cols-2 gap-3 mb-6 text-base text-gray-600">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-truck text-black"></i>
                        Free Shipping
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-undo text-black"></i>
                        30-day Returns
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shield-alt text-black"></i>
                        2-Year Warranty
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-headset text-black"></i>
                        24/7 Support
                    </div>
                </div>

                <!-- View Details Link -->
                <div class="text-center border-t pt-4">
                    <a href="#" class="text-black font-medium inline-flex items-center gap-1">
                        View Full Product Details
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>