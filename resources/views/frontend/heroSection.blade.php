<!-- Hero Section -->
<div class="relative overflow-hidden h-[90vh] min-h-[400px]">
    <!-- Slider main container -->
    <div class="swiper h-full">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide">
                <div class="w-full h-full flex items-center justify-center text-center relative">
                    <div class="relative z-10 text-white px-4 max-w-2xl">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-md">New Season Arrivals</h1>
                        <p class="text-lg md:text-xl mb-8 drop-shadow-md">Discover our curated collection for modern
                            lifestyles</p>
                        <button
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 text-lg transition-colors">
                            Shop Now
                        </button>
                    </div>
                    <img src="{{ asset('images/slider1.jpg')}}" alt="Slide 1"
                        class="absolute inset-0 w-full h-full object-cover">
                </div>
            </div>

            <div class="swiper-slide">
                <div class="w-full h-full flex items-center justify-center text-center relative">
                    <div class="relative z-10 text-white px-4 max-w-2xl">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-md">Summer Sale</h1>
                        <p class="text-lg md:text-xl mb-8 drop-shadow-md">Up to 50% off selected items</p>
                        <button
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 text-lg transition-colors">
                            Explore Offers
                        </button>
                    </div>
                    <img src="{{ asset('images/slider2.jpg')}}" alt="Slide 2"
                        class="absolute inset-0 w-full h-full object-cover">
                </div>
            </div>

            <div class="swiper-slide">
                <div class="w-full h-full flex items-center justify-center text-center relative">
                    <div class="relative z-10 text-white px-4 max-w-2xl">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-md">Summer Sale</h1>
                        <p class="text-lg md:text-xl mb-8 drop-shadow-md">Up to 50% off selected items</p>
                        <button
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 text-lg transition-colors">
                            Explore Offers
                        </button>
                    </div>
                    <img src="{{ asset('images/slider3.jpg')}}" alt="Slide 3"
                        class="absolute inset-0 w-full h-full object-cover">
                </div>
            </div>
        </div>

        <!-- Navigation buttons -->
        <div class="absolute inset-0 flex items-center justify-between z-10 px-4">
            <button
                class="swiper-button-prev !w-10 !h-10 bg-white/30 hover:bg-white/50 rounded-full p-2 backdrop-blur-sm !static !mt-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button
                class="swiper-button-next !w-10 !h-10 bg-white/30 hover:bg-white/50 rounded-full p-2 backdrop-blur-sm !static !mt-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>

<style>
    .swiper-pagination-bullet {
        height: 10px !important;
        width: 10px !important;
        background: white !important;
    }

    .swiper-button-next,
    .swiper-button-prev{
        color: white !important;
    }
    .swiper-button-prev::after,
    .swiper-button-next::after {
        content: none !important;
    }

    .swiper-button-prev,
    .swiper-button-next {
        position: static !important;
        margin-top: 0 !important;
    }
</style>