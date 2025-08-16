<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Fav Icon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}" sizes="180x180" />
    {{-- Font Awesome Icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Swiper Slider --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    {{-- Alpine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- google albert font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    {{-- Preloader CSS --}}
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}">

    <title>Zeno - Shopping</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-white text-black font-sans antialiased">
    <!-- Preloader -->
    @include('partials.preloader')
    @include('frontend.navbar')
    @include('partials.flash-messages')
    @include('frontend.heroSection')
    @include('frontend.new-arrivals')
    <hr>
    @include('frontend.mens-fashion')
    <hr>
    @include('frontend.womens-fashion')
    <hr>
    @include('frontend.kids-fashion')
    @include('partials.membership')
    <hr>
    @include('frontend.footer')
    <div id="notification-container" class="fixed top-20 right-4 z-[9999] space-y-3 w-80 max-w-[90vw]"></div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('slider', (config) => ({
                categories: config.categories,
                progress: 0,
                activeCategory: 0,
                itemWidth: 0,
                visibleItems: 3,
                maxScroll: 0,
                totalItems: 0,

                init() {
                    this.$nextTick(() => {
                        this.calculateDimensions();
                        // Update progress after scroll animation completes
                        this.$refs.slider.addEventListener('scroll', this.updateProgress.bind(
                            this));
                        window.addEventListener('resize', this.calculateDimensions.bind(this));
                    });
                },

                calculateDimensions() {
                    const slider = this.$refs.slider;
                    if (!slider || !slider.children[0]) return;

                    this.itemWidth = slider.children[0].offsetWidth + 16;
                    this.visibleItems = Math.floor(slider.clientWidth / this.itemWidth);
                    this.maxScroll = slider.scrollWidth - slider.clientWidth;
                    this.totalItems = slider.children.length;
                    this.updateProgress();
                },

                updateProgress() {
                    const slider = this.$refs.slider;
                    if (!slider) return;

                    const scrollLeft = slider.scrollLeft;
                    this.maxScroll = slider.scrollWidth - slider.clientWidth;
                    this.progress = this.maxScroll > 0 ? Math.min((scrollLeft / this.maxScroll) * 100,
                        100) : 0;
                    this.activeCategory = Math.round(scrollLeft / this.itemWidth);
                },

                scrollLeft() {
                    const slider = this.$refs.slider;
                    const scrollAmount = this.itemWidth * this.visibleItems;
                    const newPosition = Math.max(slider.scrollLeft - scrollAmount, 0);

                    slider.scrollTo({
                        left: newPosition,
                        behavior: 'smooth'
                    });

                    setTimeout(() => this.updateProgress(), 300);
                },

                scrollRight() {
                    const slider = this.$refs.slider;
                    const scrollAmount = this.itemWidth * this.visibleItems;
                    const newPosition = Math.min(slider.scrollLeft + scrollAmount, this.maxScroll);

                    slider.scrollTo({
                        left: newPosition,
                        behavior: 'smooth'
                    });

                    setTimeout(() => this.updateProgress(), 300);
                },

                goToCategory(category) {
                    console.log('Selected category:', category);
                }
            }));
        });
    </script>

    <!-- Include Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            slidesPerView: 1,

            // If you need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Navigation arrows
            // navigation: {
            //     nextEl: '.swiper-button-next',
            //     prevEl: '.swiper-button-prev',
            // },
            // Optional autoplay
            autoplay: {
                delay: 5000,
            },
        });
    </script>
    <script src="{{ asset('js/preloader.js') }}"></script>
    <script src="{{ asset('js/notification.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const productId = btn.getAttribute('data-product-id');
                    const productPrice = btn.getAttribute('data-price');
                    const color = btn.getAttribute('data-color') ?? '';
                    const size = btn.getAttribute('data-size') ?? '';
                    const cartData = {
                        product_id: productId,
                        color: color,
                        size: size,
                        qty: 1,
                        price: productPrice
                    };

                    // Show loading state
                    const originalText = btn.innerHTML;
                    btn.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg> Adding...`;
                    btn.disabled = true;
                    console.log(cartData);
                    fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(cartData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                NotificationSystem.show({
                                    type: 'success',
                                    title: 'Added to cart',
                                    message: data.message,

                                    duration: 5000,
                                    action: {
                                        text: 'View Cart',
                                        onclick: `window.location.href='{{ route('cart.items') }}'`
                                    }
                                });
                                updateCartCounter(data.cartCount);
                                // Show warning if quantity was adjusted
                                if (data.actualQtyAdded < cartData.qty) {
                                    setTimeout(() => {
                                        NotificationSystem.show({
                                            type: 'warning',
                                            title: 'Quantity adjusted',
                                            message: `Only ${data.actualQtyAdded} available in stock.`,
                                            duration: 4000
                                        });
                                    }, 500);
                                }
                            } else {
                                NotificationSystem.show({
                                    type: 'error',
                                    title: 'Failed to add to cart',
                                    message: data.message,
                                    duration: 5000
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            NotificationSystem.show({
                                type: 'error',
                                title: 'Error',
                                message: 'An error occurred while adding to cart',
                                duration: 5000
                            });
                        })
                        .finally(() => {
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        });
                });
            });

            function updateCartCounter(count) {
                const cartCounter = document.querySelector('.cart-counter');
                if (cartCounter) {
                    cartCounter.textContent = count;
                }
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
