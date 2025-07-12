@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<!-- Main Content -->
<main>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Revenue -->
            <div class="bg-white shadow -lg p-6">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 -full mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                        <p class="text-2xl font-semibold text-gray-800">$24,780.00</p>
                        <p class="text-xs text-green-600">+12.5% from last month</p>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white shadow -lg p-6">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 -full mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <p class="text-2xl font-semibold text-gray-800">1,245</p>
                        <p class="text-xs text-green-600">+8.3% from last month</p>
                    </div>
                </div>
            </div>

            <!-- Customers -->
            <div class="bg-white shadow -lg p-6">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 -full mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Customers</p>
                        <p class="text-2xl font-semibold text-gray-800">856</p>
                        <p class="text-xs text-green-600">+5.7% from last month</p>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="bg-white shadow -lg p-6">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 -full mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Products</p>
                        <p class="text-2xl font-semibold text-gray-800">342</p>
                        <p class="text-xs text-green-600">+3.2% from last month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Revenue Chart -->
            <div class="bg-white shadow -lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Revenue Overview</h3>
                    <select
                        class="text-sm border border-gray-300 -md pl-2 pr-7 py-1 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option selected>Last 12 Months</option>
                    </select>
                </div>
                <div class="h-64">
                    <!-- Chart placeholder - replace with your actual chart implementation -->
                    <div class="flex items-center justify-center h-full  ">
                        <p class="text-gray-500">Revenue Chart</p>
                    </div>
                </div>
            </div>

            <!-- Sales Chart -->
            <div class="bg-white shadow -lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Sales Overview</h3>
                    <select
                        class="text-sm border border-gray-300 -md pl-2 pr-7 py-1 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option selected>Last 12 Months</option>
                    </select>
                </div>
                <div class="h-64">
                    <!-- Chart placeholder - replace with your actual chart implementation -->
                    <div class="flex items-center justify-center h-full  ">
                        <p class="text-gray-500">Sales Chart</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders & Top Products -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Orders -->
            <div class="bg-white shadow -lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @for($i = 0; $i < 5; $i++) <div class="px-6 py-4 hover: transition-colors duration-150">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Order #ORD-2023-{{ str_pad(1000 + $i, 4,
                                    '0', STR_PAD_LEFT) }}</p>
                                <p class="text-xs text-gray-500">Placed on {{ now()->subDays($i)->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">${{ number_format(rand(50, 500), 2) }}</p>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 -full text-xs font-medium bg-green-100 text-green-800">
                                    Completed
                                </span>
                            </div>
                        </div>
                </div>
                @endfor
            </div>
            <div class="px-6 py-4 border-t border-gray-200  text-right">
                <a href="{{ route('admin.orders.index') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-900">View all orders</a>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white shadow -lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Top Selling Products</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach(['Wireless Headphones', 'Smart Watch', 'Bluetooth Speaker', 'Laptop Backpack', 'Phone Charger']
                as $index => $product)
                <div class="px-6 py-4 hover: transition-colors duration-150">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 -md bg-indigo-100 flex items-center justify-center">
                            <span class="text-indigo-600">{{ $index + 1 }}</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">{{ $product }}</p>
                            <p class="text-xs text-gray-500">{{ rand(50, 200) }} sold</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="text-sm font-medium text-gray-900">${{ number_format(rand(20, 200) + (rand(0,
                                99)/100), 2) }}</p>
                            <p class="text-xs text-green-600">+{{ rand(5, 30) }}%</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="px-6 py-4 border-t border-gray-200  text-right">
                <a href="{{ route('admin.products.index') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-900">View all products</a>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection