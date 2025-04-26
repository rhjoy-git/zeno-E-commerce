<!-- New Arrivals Section -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="text-left mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">New Arrivals You Can’t Miss</h2>
        <p class="text-gray-600">Fresh drops, bold designs, and iconic fits—get them before they’re gone!</p>
    </div>

    <!-- Category Filters -->
    <div class="flex flex-wrap justify-start gap-2 mb-8">
        <button onclick="filterProducts('all')"
            class="px-4 py-2 rounded bg-gray-900 text-white text-sm font-medium filter-btn active">
            All
        </button>
        <button onclick="filterProducts('men')"
            class="px-4 py-2 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm font-medium filter-btn">
            Men
        </button>
        <button onclick="filterProducts('women')"
            class="px-4 py-2 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm font-medium filter-btn">
            Women
        </button>
        <button onclick="filterProducts('kids')"
            class="px-4 py-2 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm font-medium filter-btn">
            Kids
        </button>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Product Cards -->
        <!-- Men's Products -->
        <div class="group relative bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300"
            data-categories="men women">
            <div class="aspect-square bg-gray-100 rounded-t-lg relative overflow-hidden">
                <span class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
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
                <span class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
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
                <span class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
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
                <span class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
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
                <span class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
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
                <span class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
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
                <span class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
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
                <span class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded z-10">
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
            Show More
        </button>
    </div>
</section>

<script>
    function filterProducts(category) {
        // Remove active class from all buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-gray-900', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        });

        // Add active class to clicked button
        event.target.classList.add('active', 'bg-gray-900', 'text-white');
        event.target.classList.remove('bg-gray-100', 'text-gray-700');

        // Get all product cards
        const products = document.querySelectorAll('[data-categories]');
        // Filter products
        
        products.forEach(product => {
            const categories = product.dataset.categories.split(' ');
            if (category === 'all' || categories.includes(category)) {
                product.classList.remove('hidden');
            } else {
                product.classList.add('hidden');
            }
        });

    }
</script>