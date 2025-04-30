<nav x-data="{ 
    isMobileMenuOpen: false, 
    searchOpen: false,
    activeMenu: null,
    activeSubmenu: null,
    activeUser: false
}" class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Bar Overlay -->
        <div x-show="searchOpen" x-cloak class="absolute inset-0 bg-white z-50" @click.away="searchOpen = false">
            <div class="container mx-auto h-16 flex items-center justify-between px-4">
                <form class="flex-1 flex max-w-3xl mx-auto" action="/search">
                    <input type="text" placeholder="Search products..."
                        class="w-full px-4 py-2 text-lg border-b-2 border-gray-300 focus:border-indigo-600 outline-none"
                        autofocus>
                    <button type="button" @click="searchOpen = false" class="ml-4 text-gray-600 hover:text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex justify-between items-center h-16 relative">
            <!-- Logo -->
            <a href="/" class="flex-shrink-0">
                <img class="h-8 w-auto" src="{{asset('images/Zeno.png')}}" alt="Zeno Logo">
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex md:items-center md:space-x-8 flex-1 justify-center relative">
                <!-- Men Menu -->
                <button @mouseenter="activeMenu = 'men'" @mouseleave="activeMenu = null"
                    class="text-gray-700 hover:text-indigo-600 px-3 py-2 transition-colors uppercase">
                    Men
                </button>
                <a href="#" class="text-gray-700 hover:text-indigo-600 px-3 py-2 transition-colors uppercase">Women</a>
                <a href="#" class="text-gray-700 hover:text-indigo-600 px-3 py-2 transition-colors uppercase">Kid</a>
                <a href="#"
                    class="text-gray-700 hover:text-indigo-600 px-3 py-2 transition-colors uppercase">Accessories</a>
                <a href="#"
                    class="text-red-600 hover:text-red-700 px-3 py-2 transition-colors font-semibold uppercase">Sale</a>
            </div>
            <!-- Full-width Mega Menu -->
            <div @mouseenter="activeMenu = 'men'" @mouseleave="activeMenu = null"
                class="absolute top-3/4 left-0 right-0 w-full z-20" x-show="activeMenu === 'men'" x-cloak>
                <div class="bg-white shadow-xl py-8 px-4 border-t border-gray-100 rounded-md mt-5">
                    <!-- Grid Container -->
                    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8">
                        <!-- Categories Column -->
                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-900 text-lg mb-4">Men's Categories</h3>
                            <div class="grid grid-cols-2 gap-x-6 gap-y-3">
                                <div class="relative group" @mouseenter="activeSubmenu = 'clothing'"
                                    @mouseleave="activeSubmenu = null">
                                    <button
                                        class="w-full text-left text-gray-700 hover:text-indigo-600 flex justify-between items-center">
                                        Clothing
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                    <!-- Submenu -->
                                    <div x-show="activeSubmenu === 'clothing'" @mouseenter="activeSubmenu = 'clothing'"
                                        @mouseleave="activeSubmenu = null"
                                        class="absolute left-full top-0 bg-white p-4 shadow-lg w-64 rounded-lg border border-gray-100 z-30">
                                        <a href="#" class="block py-2 px-4 hover:bg-gray-50 rounded">T-Shirts</a>
                                        <a href="#" class="block py-2 px-4 hover:bg-gray-50 rounded">Shirts</a>
                                        <a href="#" class="block py-2 px-4 hover:bg-gray-50 rounded">Jeans</a>
                                        <a href="#" class="block py-2 px-4 hover:bg-gray-50 rounded">Shorts</a>
                                    </div>
                                </div>

                                <!-- Repeat similar structure for other categories -->
                                <div class="relative group">
                                    <button
                                        class="w-full text-left text-gray-700 hover:text-indigo-600">Footwear</button>
                                </div>
                                <div class="relative group">
                                    <button
                                        class="w-full text-left text-gray-700 hover:text-indigo-600">Accessories</button>
                                </div>
                                <div class="relative group">
                                    <button
                                        class="w-full text-left text-gray-700 hover:text-indigo-600">Sportswear</button>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Collection -->
                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-900 text-lg mb-4">Featured Collections</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <a href="#" class="group">
                                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ asset('images/men-summer.jpg') }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                                            alt="Summer Collection">
                                    </div>
                                    <p class="mt-2 text-sm font-medium">Summer Essentials</p>
                                </a>
                                <a href="#" class="group">
                                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ asset('images/men-formal.jpg') }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                                            alt="Formal Wear">
                                    </div>
                                    <p class="mt-2 text-sm font-medium">Formal Wear</p>
                                </a>
                            </div>
                        </div>

                        <!-- Brands & Offers -->
                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-900 text-lg mb-4">Top Brands</h3>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="#"
                                    class="p-1 bg-gray-50 hover:text-indigo-600 hover:bg-gray-100 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('images/nike.png') }}"
                                        class="h-10 w-fit object-contain scale-150" alt="Nike">
                                </a>
                                <a href="#"
                                    class="p-1 bg-gray-50 hover:text-indigo-600 hover:bg-gray-100 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('images/adidas.png') }}"
                                        class="h-10 w-fit object-contain scale-150" alt="Adidas">
                                </a>
                                <a href="#"
                                    class="p-1 bg-gray-50 hover:text-indigo-600 hover:bg-gray-100 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('images/puma.png') }}"
                                        class="h-10 w-fit object-contain scale-150" alt="Puma">
                                </a>
                                <a href="#"
                                    class="p-1 bg-gray-50 hover:text-indigo-600 hover:bg-gray-100 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('images/levis.png') }}"
                                        class="h-10 w-fit object-contain scale-150" alt="Levi's">
                                </a>
                            </div>
                        </div>

                        <!-- Promo Banner -->
                        <div class="relative rounded-xl overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/special-offer.jpg') }}" alt="Men's Special Offer"
                                class="w-full h-full object-cover absolute inset-0">
                            <div class="relative p-6 h-full flex flex-col justify-end bg-gradient-to-t from-black/60">
                                <h3 class="text-2xl font-bold text-white mb-2">Season Final Sale</h3>
                                <p class="text-white/90">Up to 60% off selected items</p>
                                <button
                                    class="mt-4 bg-white text-gray-900 px-6 py-2 rounded-full w-fit text-sm font-medium hover:text-indigo-600 hover:bg-gray-100">
                                    Shop Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Icons -->
            <div class="flex items-center space-x-4 relative">
                <!-- Search Icon -->
                <button @click="searchOpen = true" class="p-2 text-gray-600 hover:text-indigo-600 md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <div class="hidden md:flex items-center space-x-4">
                    <button @click="searchOpen = true" class="p-2 text-gray-600 hover:text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <!-- Toggle Button -->
                    @include('partials.user-dropdown')
                    {{-- <button @click="activeUser = !activeUser" class="p-2 text-gray-600 hover:text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </button>
                    <div x-show="activeUser" @click.away="activeUser = false" x-transition
                        class="absolute top-3/4 left-0 right-0 w-52 z-20 bg-white shadow-lg rounded-md text-center mx-auto mt-6 overflow-hidden">
                        @auth
                        <a href="{{ route('customer.dashboard') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:text-indigo-600 hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:text-indigo-600 hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>
                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:text-indigo-600 hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            Orders
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:text-indigo-600 hover:bg-gray-100 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Logout
                            </button>
                        </form>
                        @endauth
                        @guest
                        <div class="flex justify-center items-center">
                            <a href="{{ route('login') }}"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:text-indigo-600 hover:bg-gray-100 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Login
                            </a>
                            <span class="text-gray-400">|</span>
                            <a href="{{ route('register') }}"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:text-indigo-600 hover:bg-gray-100 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                                Register
                            </a>
                        </div>
                        @endguest
                    </div> --}}
                    <!-- Dropdown Menu -->

                    <!-- Cart Icon -->
                    <button class="p-2 text-gray-600 hover:text-indigo-600 relative">
                        <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.25 1H2.636C3.146 1 3.591 1.343 3.723 1.835L4.106 3.272M4.106 3.272C9.67664 3.11589 15.2419 3.73515 20.642 5.112C19.818 7.566 18.839 9.95 17.718 12.25H6.5M4.106 3.272L6.5 12.25M6.5 12.25C5.70435 12.25 4.94129 12.5661 4.37868 13.1287C3.81607 13.6913 3.5 14.4544 3.5 15.25H19.25M5 18.25C5 18.4489 4.92098 18.6397 4.78033 18.7803C4.63968 18.921 4.44891 19 4.25 19C4.05109 19 3.86032 18.921 3.71967 18.7803C3.57902 18.6397 3.5 18.4489 3.5 18.25C3.5 18.0511 3.57902 17.8603 3.71967 17.7197C3.86032 17.579 4.05109 17.5 4.25 17.5C4.44891 17.5 4.63968 17.579 4.78033 17.7197C4.92098 17.8603 5 18.0511 5 18.25ZM17.75 18.25C17.75 18.4489 17.671 18.6397 17.5303 18.7803C17.3897 18.921 17.1989 19 17 19C16.8011 19 16.6103 18.921 16.4697 18.7803C16.329 18.6397 16.25 18.4489 16.25 18.25C16.25 18.0511 16.329 17.8603 16.4697 17.7197C16.6103 17.579 16.8011 17.5 17 17.5C17.1989 17.5 17.3897 17.579 17.5303 17.7197C17.671 17.8603 17.75 18.0511 17.75 18.25Z"
                                stroke="#071630" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">0</span>
                    </button>
                    <!-- Wishlist Icon -->
                    <button class="p-2 text-gray-600 hover:text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="md:hidden p-2 text-gray-600 hover:text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden" x-show="isMobileMenuOpen" @click.away="isMobileMenuOpen = false">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#"
                    class="block px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-gray-100 uppercase">Men</a>
                <a href="#"
                    class="block px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-gray-100 uppercase">Women</a>
                <a href="#"
                    class="block px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-gray-100 uppercase">Kid</a>
                <a href="#"
                    class="block px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-gray-100 uppercase">Accessories</a>
                <a href="#"
                    class="block px-3 py-2 text-red-600 hover:text-indigo-600 hover:bg-gray-100 uppercase">Sale</a>
            </div>
        </div>
    </div>
</nav>