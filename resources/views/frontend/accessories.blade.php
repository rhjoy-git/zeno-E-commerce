<!-- Men’s Fashion Section -->
<div x-data="slider({
    categories: [{
            title: 'Casual Wear',
            subtitle: 'Everyday Essentials',
            image: '{{ asset('images/kids.jpg') }}'
        },
        {
            title: 'Formal Attire',
            subtitle: 'Office & Events',
            image: '{{ asset('images/mens.jpg') }}'
        },
        {
            title: 'Formal Attire',
            subtitle: 'Office & Events',
            image: '{{ asset('images/women.jpg') }}'

        },
        {
            title: 'Formal Attire',
            subtitle: 'Office & Events',
            image: '{{ asset('images/watch.jpg') }}'
        },
    ],
})" class="relative bg-gray-50 max-w-7xl mx-auto py-12">
    <!-- Hero Banner -->
    <div class="relative h-80 bg-cover bg-center flex items-center justify-center text-center"
        style="background-image: url('{{ asset('images/womens-banner.jpg') }}');">
        <div class="bg-black bg-opacity-40 w-full h-full absolute top-0 left-0"></div>
        <div class="relative z-10 text-white">
            <h2 class="text-3xl font-bold uppercase">accessories</h2>
            <p class="mt-1 text-sm">Complete your look with the perfect add-ons.</p>
        </div>
    </div>

    <!-- Category Slider -->
    <div class="mt-6 px-4 overflow-hidden relative">
        <div class="flex space-x-4 overflow-x-hidden scroll-smooth no-scrollbar" x-ref="slider"
            @scroll.debounce.50="updateProgress" style="scroll-behavior: smooth;">
            <!-- Category Cards -->
            <template x-for="(category, index) in categories" :key="index">
                <div @click="goToCategory(category)"
                    class="relative min-w-[calc(33.333%-1rem)] bg-white h-80 cursor-pointer group overflow-hidden rounded-xl shadow-sm hover:shadow-lg transition-all duration-300"
                    :class="{ 'ring-2 ring-indigo-500': activeCategory === index }">
                    <!-- Image Container -->
                    <div class="absolute inset-0 overflow-hidden">
                        <img :src="category.image" :alt="category.title"
                            class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent">
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold mb-1" x-text="category.title"></h3>
                        <p class="text-sm opacity-90" x-text="category.subtitle"></p>
                        <button
                            class="mt-3 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-xs font-medium hover:bg-white/30 transition-colors">
                            Shop Collection →
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <div class="flex items-center justify-between mt-4 gap-4">
            <!-- Progress Bar -->
            <div class="flex-1 h-1.5 bg-gray-100 rounded-full">
                <div class="h-full bg-indigo-600 transition-all duration-300 rounded-full"
                    :style="{ width: `${progress}%` }"></div>
            </div>

            <!-- Navigation -->
            <div class="flex items-center gap-2">
                <button @click="scrollLeft" :disabled="progress === 0"
                    class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <!-- Left arrow SVG -->
                    <svg width="29" height="28" viewBox="0 0 29 28" class="w-7 h-7" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M25.3114 12.1249C27.2783 12.1249 28.8728 13.6919 28.8728 15.6249V24.1249H25.8202V15.6249C25.8202 15.3487 25.5924 15.1249 25.3114 15.1249H5.59274L12.9082 22.3142L10.7497 24.4355L0.828639 14.6855C0.232576 14.0997 0.232576 13.15 0.828639 12.5642L10.7497 2.81421L12.9082 4.93553L5.59274 12.1249H25.3114Z"
                            fill="black" />
                    </svg>
                </button>
                <button @click="scrollRight" :disabled="progress >= 100"
                    class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <!-- Right arrow SVG -->
                    <svg width="29" height="28" viewBox="0 0 29 28" class="w-7 h-7" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.68858 12.1249C1.72167 12.1249 0.127178 13.6919 0.127178 15.6249V24.1249H3.17981V15.6249C3.17981 15.3487 3.40759 15.1249 3.68858 15.1249H23.4073L16.0918 22.3142L18.2503 24.4355L28.1714 14.6855C28.7674 14.0997 28.7674 13.15 28.1714 12.5642L18.2503 2.81421L16.0918 4.93553L23.4073 12.1249H3.68858Z"
                            fill="#111827" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Accessories Products Section -->
    <section class="px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="text-left mb-8">
            <p class="text-gray-800 font-semibold uppercase">Timeless</p>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Pieces For Every Moment</h2>
        </div>
        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Product Cards -->
            <!-- Women's Products -->
            <div class="group relative bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300"
                data-categories="men women">
                <div class="aspect-square bg-gray-100 rounded-t-lg relative overflow-hidden">
                    <span
                        class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
                        New
                    </span>
                    <button
                        class="absolute top-2 right-2 p-2 text-gray-600 hover:text-red-500 bg-white/80 rounded-full z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <img src="{{ asset('images/pro1.jpg') }}" alt="Product"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900">Men's Casual Shirt</h3>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-lg font-bold text-gray-900">$49.99</span>
                        <span class="text-sm text-gray-500 line-through">$69.99</span>
                        <span class="text-sm text-green-600">Save 29%</span>
                    </div>
                </div>
                <div
                    class="absolute inset-x-0 bottom-0 p-4 bg-white/90 backdrop-blur opacity-0 group-hover:opacity-100 transition-opacity duration-300 h-1/5">
                    <div class="flex items-end gap-2">
                        <button
                            class="flex-1 bg-gray-700 text-white py-2 rounded-md hover:bg-gray-900 transition-colors text-sm font-medium">
                            Add to Cart
                        </button>
                        <button
                            class="flex-1 bg-gray-700 text-white py-2 rounded-md hover:bg-gray-900 transition-colors text-sm font-medium">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Women's Products -->
            <div class="group relative bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300"
                data-categories="women">
                <div class="aspect-square bg-gray-100 rounded-t-lg relative overflow-hidden">
                    <span
                        class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
                        New
                    </span>
                    <button
                        class="absolute top-2 right-2 p-2 text-gray-600 hover:text-red-500 bg-white/80 rounded-full z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <img src="{{ asset('images/pro2.jpg') }}" alt="Product"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900">Women's Summer Dress</h3>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-lg font-bold text-gray-900">$79.99</span>
                        <span class="text-sm text-gray-500 line-through">$49.99</span>
                        <span class="text-sm text-green-600">Save 20%</span>
                    </div>
                </div>
                <div
                    class="absolute inset-x-0 bottom-0 p-4 bg-white/90 backdrop-blur opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button
                        class="w-full bg-gray-700 text-white py-2 rounded-md hover:bg-gray-900 transition-colors text-sm font-medium">
                        Add to Wishlist
                    </button>
                </div>
            </div>

            <!-- Kids Products -->
            <div class="group relative bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300"
                data-categories="kids">
                <div class="aspect-square bg-gray-100 rounded-t-lg relative overflow-hidden">
                    <span
                        class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
                        New
                    </span>
                    <button
                        class="absolute top-2 right-2 p-2 text-gray-600 hover:text-red-500 bg-white/80 rounded-full z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <img src="{{ asset('images/pro3.jpg') }}" alt="Product"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900">Kids' Colorful Backpack</h3>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-lg font-bold text-gray-900">$34.99</span>
                        <span class="text-sm text-gray-500 line-through">$49.99</span>
                    </div>
                </div>
                <div
                    class="absolute inset-x-0 bottom-0 p-4 bg-white/90 backdrop-blur opacity-0 group-hover:opacity-100 transition-opacity duration-300 h-1/5">
                    <div class="flex items-end gap-2">
                        <button
                            class="flex-1 bg-gray-700 text-white py-2 rounded-md hover:bg-gray-900 transition-colors text-sm font-medium">
                            Add to Cart
                        </button>
                        <button
                            class="flex-1 bg-gray-700 text-white py-2 rounded-md hover:bg-gray-900 transition-colors text-sm font-medium">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300"
                data-categories="men">
                <div class="aspect-square bg-gray-100 rounded-t-lg relative overflow-hidden">
                    <span
                        class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
                        New
                    </span>
                    <button
                        class="absolute top-2 right-2 p-2 text-gray-600 hover:text-red-500 bg-white/80 rounded-full z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <img src="{{ asset('images/pro4.jpg') }}" alt="Product"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900">Music Box</h3>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-lg font-bold text-gray-900">$79.99</span>
                    </div>
                </div>
                <div
                    class="absolute inset-x-0 bottom-0 p-4 bg-white/90 backdrop-blur opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button
                        class="w-full bg-gray-700 text-white py-2 rounded-md hover:bg-gray-900 transition-colors text-sm font-medium">
                        Add to Wishlist
                    </button>
                </div>
            </div>

            <div class="group relative bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300"
                data-categories="women">
                <div class="aspect-square bg-gray-100 rounded-t-lg relative overflow-hidden">
                    <span
                        class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
                        New
                    </span>
                    <button
                        class="absolute top-2 right-2 p-2 text-gray-600 hover:text-red-500 bg-white/80 rounded-full z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <img src="{{ asset('images/pro2.jpg') }}" alt="Product"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900">Women's Summer Dress</h3>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-lg font-bold text-gray-900">$79.99</span>
                        <span class="text-sm text-gray-500 line-through">$49.99</span>
                        <span class="text-sm text-green-600">Save 20%</span>
                    </div>
                </div>
                <div
                    class="absolute inset-x-0 bottom-0 p-4 bg-white/90 backdrop-blur opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button
                        class="w-full bg-gray-700 text-white py-2 rounded-md hover:bg-gray-900 transition-colors text-sm font-medium">
                        Add to Wishlist
                    </button>
                </div>
            </div>

            <div class="group relative bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300"
                data-categories="women">
                <div class="aspect-square bg-gray-100 rounded-t-lg relative overflow-hidden">
                    <span
                        class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
                        New
                    </span>
                    <button
                        class="absolute top-2 right-2 p-2 text-gray-600 hover:text-red-500 bg-white/80 rounded-full z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <img src="{{ asset('images/pro2.jpg') }}" alt="Product"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900">Women's Summer Dress</h3>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-lg font-bold text-gray-900">$79.99</span>
                        <span class="text-sm text-gray-500 line-through">$49.99</span>
                        <span class="text-sm text-green-600">Save 20%</span>
                    </div>
                </div>
                <div
                    class="absolute inset-x-0 bottom-0 p-4 bg-white/90 backdrop-blur opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button
                        class="w-full bg-gray-700 text-white py-2 rounded-md hover:bg-gray-900 transition-colors text-sm font-medium">
                        Add to Wishlist
                    </button>
                </div>
            </div>

            <div class="group relative bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300"
                data-categories="women">
                <div class="aspect-square bg-gray-100 rounded-t-lg relative overflow-hidden">
                    <span
                        class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
                        New
                    </span>
                    <button
                        class="absolute top-2 right-2 p-2 text-gray-600 hover:text-red-500 bg-white/80 rounded-full z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <img src="{{ asset('images/pro2.jpg') }}" alt="Product"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900">Women's Summer Dress</h3>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-lg font-bold text-gray-900">$79.99</span>
                        <span class="text-sm text-gray-500 line-through">$49.99</span>
                        <span class="text-sm text-green-600">Save 20%</span>
                    </div>
                </div>
                <div
                    class="absolute inset-x-0 bottom-0 p-4 bg-white/90 backdrop-blur opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button
                        class="w-full bg-gray-700 text-white py-2 rounded-md hover:bg-gray-900 transition-colors text-sm font-medium">
                        Add to Wishlist
                    </button>
                </div>
            </div>

            <div class="group relative bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300"
                data-categories="women">
                <div class="aspect-square bg-gray-100 rounded-t-lg relative overflow-hidden">
                    <span
                        class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
                        New
                    </span>
                    <button
                        class="absolute top-2 right-2 p-2 text-gray-600 hover:text-red-500 bg-white/80 rounded-full z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <img src="{{ asset('images/pro2.jpg') }}" alt="Product"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900">Women's Summer Dress</h3>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-lg font-bold text-gray-900">$79.99</span>
                        <span class="text-sm text-gray-500 line-through">$49.99</span>
                        <span class="text-sm text-green-600">Save 20%</span>
                    </div>
                </div>
                <div
                    class="absolute inset-x-0 bottom-0 p-4 bg-white/90 backdrop-blur opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button
                        class="w-full bg-gray-700 text-white py-2 rounded-md hover:bg-gray-900 transition-colors text-sm font-medium">
                        Add to Wishlist
                    </button>
                </div>
            </div>

        </div>

        <!-- Show More Button -->
        <div class="mt-8 text-center">
            <button
                class="bg-gray-800 text-white px-8 py-3 rounded-md hover:bg-gray-900 hover:font-bold transition-colors font-medium">
                Complete My Look
            </button>
        </div>
    </section>
</div>