<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}" sizes="180x180" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <title>Zeno - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100" x-data="{ mobileMenuOpen: true }">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                <div class="h-0 flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <!-- Logo -->
                    <div class="flex items-center flex-shrink-0 px-4">
                        <x-application-logo class="h-8 w-auto" />
                    </div>
                    <!-- Sidebar Navigation -->
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>

                        <!-- Orders -->
                        <a href="{{ route('admin.orders.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.orders.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Orders
                        </a>

                        <!-- Products -->
                        <a href="{{ route('admin.products.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.products.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.products.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Products
                        </a>

                        <!-- Categories {{ route('admin.categories.index') }}-->
                        <a href=""
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            Categories
                        </a>

                        <!-- Customers -->
                        <a href="{{ route('admin.customers.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.customers.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.customers.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Customers
                        </a>

                        <!-- Reports -->
                        <a href="{{ route('admin.reports.index') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.reports.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.reports.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Reports
                        </a>

                        <!-- Settings -->
                        <a href="{{ route('admin.settings') }}"
                            class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.settings') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.settings') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </a>
                    </nav>
                </div>
                <!-- Admin Profile Section -->
                <div class="flex-shrink-0 flex border-t border-gray-200 p-4 fixed bottom-0">
                    <a href="{{ route('profile') }}" class="flex-shrink-0 w-full group block">
                        <div class="flex items-center">
                            <div>
                                <img class="inline-block h-9 w-9 rounded-full"
                                    src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}"
                                    alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{
                                    Auth::user()->name }}</p>
                                <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">View profile</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Mobile top navigation -->
            <div class="md:hidden">
                <div class="flex items-center justify-between bg-white border-b border-gray-200 p-4">
                    <div>
                        <x-application-logo class="h-8 w-auto" />
                    </div>
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-gray-500 hover:text-gray-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Main content area -->
            <div class="flex-1 overflow-y-auto">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Mobile sidebar -->
    <div class="md:hidden" x-show="mobileMenuOpen" x-cloak @keydown.escape="mobileMenuOpen = false">
        <!-- Overlay -->
        <div class="fixed inset-0 z-40">
            <div class="absolute inset-0 bg-gray-600 opacity-75" @click="mobileMenuOpen = false"></div>
        </div>

        <!-- Sidebar container -->
        <div class="fixed inset-y-0 left-0 z-50 flex max-w-xs w-full">
            <!-- Sidebar content -->
            <div class="relative flex-1 flex flex-col w-full bg-white">
                <!-- Close button -->
                <div class="absolute top-0 right-0 -mr-14 p-2">
                    <button @click="mobileMenuOpen = false"
                        class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none">
                        <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Sidebar content -->
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <x-application-logo class="h-8 w-auto" />
                    </div>
                    <nav class="mt-5 px-2 space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}"
                            @click="mobileMenuOpen = false">
                            <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>

                        <!-- Orders -->
                        <a href="{{ route('admin.orders.index') }}"
                            class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}"
                            @click="mobileMenuOpen = false">
                            <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.orders.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Orders
                        </a>

                        <!-- Products -->
                        <a href="{{ route('admin.products.index') }}"
                            class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.products.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}"
                            @click="mobileMenuOpen = false">
                            <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.products.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Products
                        </a>

                        <!-- Categories -->
                        <a href="{{ route('admin.categories.index') }}"
                            class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}"
                            @click="mobileMenuOpen = false">
                            <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            Categories
                        </a>

                        <!-- Customers -->
                        <a href="{{ route('admin.customers.index') }}"
                            class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.customers.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}"
                            @click="mobileMenuOpen = false">
                            <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.customers.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Customers
                        </a>

                        <!-- Reports -->
                        <a href="{{ route('admin.reports.index') }}"
                            class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.reports.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}"
                            @click="mobileMenuOpen = false">
                            <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.reports.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Reports
                        </a>

                        <!-- Settings -->
                        <a href="{{ route('admin.settings') }}"
                            class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.settings') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}"
                            @click="mobileMenuOpen = false">
                            <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.settings') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </a>
                    </nav>
                </div>

                <!-- Profile section -->
                <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                    <a href="{{ route('profile') }}" class="flex-shrink-0 group block" @click="mobileMenuOpen = false">
                        <div class="flex items-center">
                            <div>
                                <img class="inline-block h-10 w-10 rounded-full"
                                    src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}"
                                    alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-base font-medium text-gray-700 group-hover:text-gray-900">{{
                                    Auth::user()->name }}</p>
                                <p class="text-sm font-medium text-gray-500 group-hover:text-gray-700">View profile</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Empty div to push sidebar to left -->
            <div class="flex-shrink-0 w-14">
                <!-- Force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>
</body>

</html>