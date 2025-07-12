<!-- Newsletter Section -->
<section class="relative py-20 px-4 text-center overflow-hidden mt-10">
    <!-- Background Image with Subtle Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/newsletter-bg.jpg') }}" alt="Fashion background"
            class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-white/60"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-3xl mx-auto">

        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Join Our Style Community</h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto text-lg">Get curated fashion insights, exclusive offers,
            and 15% off your first purchase.</p>

        <form class="flex flex-col sm:flex-row justify-center items-center gap-3 max-w-xl mx-auto">
            <input type="email" placeholder="Your email address" required
                class="px-5 py-3 w-full -lg border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800 placeholder-gray-400 shadow-sm transition-all">
            <button type="submit"
                class="w-full sm:w-auto bg-gray-800 text-white px-8 py-3 -lg hover:bg-gray-900 transition-colors font-medium shadow-md hover:shadow-lg">
                Subscribe
            </button>
        </form>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-gray-600 max-w-5xl mx-auto">
            <div class="flex items-center justify-center gap-2 bg-white p-3 -lg shadow-sm">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm">Zero spam policy</span>
            </div>
            <div class="flex items-center justify-center gap-2 bg-white p-3 -lg shadow-sm">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm">Member-only deals</span>
            </div>
            <div class="flex items-center justify-center gap-2 bg-white p-3 -lg shadow-sm">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm">Easy unsubscribe</span>
            </div>
        </div>
    </div>
</section>