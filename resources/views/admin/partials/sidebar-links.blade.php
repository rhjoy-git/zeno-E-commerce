<!-- Dashboard (remains unchanged) -->
<a href="{{ route('admin.dashboard') }}"
    class="group flex items-center px-2 py-2 text-sm font-medium  {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
    </svg>
    Dashboard
</a>

<!-- Products with Submenu -->
<div x-data="{ open: {{ request()->routeIs('admin.products.*') ? 'true' : 'false' }} }">
    <button @click="open = !open"
        class="w-full group flex items-center px-2 py-2 text-sm font-medium  {{ request()->routeIs('admin.products.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.products.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
        <span class="flex-1 text-left">Products</span>
        <svg :class="{'transform rotate-90': open}" class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <div x-show="open" x-collapse class="ml-5 pl-2 mt-1 space-y-1">
        <a href="{{ route('admin.products.index') }}"
            class="group flex items-center px-2 py-2 text-sm font-medium  {{ request()->routeIs('admin.products.index') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
            <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.products.index') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            Show Products
        </a>
        <a href="{{ route('admin.products.create') }}"
            class="group flex items-center px-2 py-2 text-sm font-medium  {{ request()->routeIs('admin.products.create') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
            <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.products.create') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add Product
        </a>
    </div>
</div>

<!-- Brands -->
<a href="{{ route('admin.brands.index') }}"
    class="group flex items-center px-2 py-2 text-sm font-medium  {{ request()->routeIs('admin.brands.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.brands.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
    </svg>
    Brands
</a>
<!-- Categories -->
<a href="{{ route('admin.categories.index') }}"
    class="group flex items-center px-2 py-2 text-sm font-medium  {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
    Categories
</a>


<!-- Continue with other menu items (Orders, Customers, Reports, Settings) as simple links -->
<!-- Orders -->
<a href="{{ route('admin.orders.index') }}"
    class="group flex items-center px-2 py-2 text-sm font-medium  {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.orders.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
    </svg>
    Orders
</a>

<!-- Customers -->
<a href="{{ route('admin.customers.index') }}"
    class="group flex items-center px-2 py-2 text-sm font-medium  {{ request()->routeIs('admin.customers.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.customers.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
    Customers
</a>

<!-- Reports -->
<a href="{{ route('admin.reports.index') }}"
    class="group flex items-center px-2 py-2 text-sm font-medium  {{ request()->routeIs('admin.reports.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.reports.*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    Reports
</a>

<!-- Settings -->
<a href="{{ route('admin.settings.index') }}"
    class="group flex items-center px-2 py-2 text-sm font-medium  {{ request()->routeIs('admin.settings') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.settings') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
    Settings
</a>