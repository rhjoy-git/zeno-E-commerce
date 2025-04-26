<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}" sizes="180x180" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <title>Zeno - E-Commerce</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    @include('frontend.navbar')
    @include('frontend.heroSection')
    @include('frontend.new-arrivals')
    <hr>
    @include('frontend.mens-fashion')
    <hr>
    @include('frontend.womens-fashion')
    <hr>
    @include('frontend.kids-fashion')
    <hr>
    @include('frontend.newsletter')
    @include('frontend.footer')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('slider', (config) => ({
                categories: config.categories,
                title: config.title,
                subtitle: config.subtitle,
                bannerImage: config.bannerImage,
                progress: 0,
                activeCategory: 0,
                itemWidth: 0,
                visibleItems: 3,
                maxScroll: 0,
                totalItems: 0,
        
                init() {
                    this.$nextTick(() => {
                        const slider = this.$refs.slider;
                        this.itemWidth = slider.children[0].offsetWidth + 16;
                        this.visibleItems = Math.floor(slider.clientWidth / this.itemWidth);
                        this.maxScroll = slider.scrollWidth - slider.clientWidth;
                        this.updateProgress();
                        this.totalItems = slider.children.length;
                    });
                },
        
                updateProgress() {
                    const slider = this.$refs.slider;
                    const scrollLeft = slider.scrollLeft;
                    this.maxScroll = slider.scrollWidth - slider.clientWidth;
                    this.progress = Math.min((scrollLeft / this.maxScroll) * 100, 100);
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
                },
        
                scrollRight() {
                    const slider = this.$refs.slider;
                    const scrollAmount = this.itemWidth * this.visibleItems;
                    const newPosition = Math.min(slider.scrollLeft + scrollAmount, this.maxScroll);
                    
                    slider.scrollTo({
                        left: newPosition,
                        behavior: 'smooth'
                    });
                },
        
                goToCategory(category) {
                    console.log('Selected category:', category);
                }
            }));
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Include Swiper JS -->
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
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        
        // Optional autoplay
        autoplay: {
            delay: 5000,
        },
    });
    </script>
</body>

</html>