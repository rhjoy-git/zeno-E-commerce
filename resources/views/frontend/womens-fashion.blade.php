<!-- Men’s Fashion Section -->
<div x-data="slider({
    categories: [{
            title: 'Graffiti T-shirts',
            subtitle: 'Get Personalised Design',
            image: '{{ asset('images/w1.jpg') }}'
        },
        {
            title: 'Crop Solid Tshirt',
            subtitle: 'Minimal is the key',
            image: '{{ asset('images/w2.jpg') }}'
        },
        {
            title: 'Spicy Jacket',
            subtitle: 'Get Personalised Design',
            image: '{{ asset('images/w3.jpg') }}'

        },
        {
            title: 'Formal Attire',
            subtitle: 'Office & Events',
            image: '{{ asset('images/watch.jpg') }}'
        },
    ],
})" class="relative max-w-7xl mx-auto sm:px-6 md:px-10 lg:px-8 py-16 ">
    <!-- Hero Banner -->
    <div class="relative h-[400px] bg-cover bg-center flex items-center justify-center text-center"
        style="background-image: url('{{ asset('images/womens-banner.jpg') }}');">
        <div class="bg-black bg-opacity-40 w-full h-full absolute top-0 left-0"></div>
        <div class="relative z-10 text-white">
            <h2 class="text-5xl font-semibold tracking-wide uppercase font-megumi ">WOMEN’S FASHION</h2>
            <p class="mt-2 text-lg tracking-wider">From streetwear to formals, shop the latest styles</p>
        </div>
    </div>

    <!-- Category Slider -->
    <div class="mt-4 overflow-hidden relative">
        <div class="flex gap-3 overflow-x-hidden scroll-smooth no-scrollbar" x-ref="slider"
            @scroll.debounce.50="updateProgress" style="scroll-behavior: smooth;">
            <!-- Category Cards -->
            <template x-for="(category, index) in categories" :key="index">
                <div @click="goToCategory(category)"
                    class="relative min-w-[calc(33.333%-1rem)] bg-white cursor-pointer group overflow-hidden">
                    <!-- Image Container -->
                    <div class="w-full h-96 overflow-hidden">
                        <img :src="category.image" :alt="category.title"
                            class="w-full h-full object-cover transform transition-transform duration-500">
                    </div>

                    <!-- Content - Separated with gap and aligned left -->
                    <div class="pt-6 text-left mt-2">
                        <h3 class="text-2xl font-normal font-megumi uppercase " x-text="category.title"></h3>
                        <p class="text-lg text-gray-800 capitalize" x-text="category.subtitle"></p>
                    </div>
                </div>
            </template>
        </div>

        <div class="flex items-center justify-between mt-6 gap-4">
            <!-- Progress Bar -->
            <div class="flex-1 h-1.5 bg-gray-100 rounded-full">
                <div class="h-full bg-indigo-600 transition-all duration-300 rounded-full"
                    :style="{ width: `${progress}%` }">
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex items-center gap-2">
                <button @click="scrollLeft" :disabled="progress === 0"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <!-- Left arrow SVG -->
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.5 14L4.5 9L9.5 4" stroke="black" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M20.5 20V13C20.5 11.9391 20.0786 10.9217 19.3284 10.1716C18.5783 9.42143 17.5609 9 16.5 9H4.5"
                            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <button @click="scrollRight" :disabled="progress >= 100"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <!-- Right arrow SVG -->
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 14L20.5 9L15.5 4" stroke="black" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M4.5 20V13C4.5 11.9391 4.92143 10.9217 5.67157 10.1716C6.42172 9.42143 7.43913 9 8.5 9H20.5"
                            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Men's Products Section -->
    <section class="max-w-7xl mx-auto mt-10">
        <div class="text-left mb-8">
            <p class="text-gray-800 text-xl font-semibold uppercase">level up</p>
            <h2 class="text-[40px] font-normal text-black mb-2 font-megumi  tracking-tight ">Your Fashion Game</h2>
        </div>
        <!-- Product Grid -->
        @include('products.index', ['products' => $products])

        <!-- Show More Button -->
        <div class="mt-16 text-center">
            <button onclick="window.location.href='{{ route('products.list') }}'"
                class="bg-black text-white px-10 py-3 text-xl transition-colors tracking-[2px] font-semibold uppercase">
                Find My Style
            </button>
        </div>
    </section>
</div>