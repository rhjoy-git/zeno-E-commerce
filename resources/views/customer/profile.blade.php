@extends('layouts.app')
@section('title', __('Profile Settings'))
@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">{{__('Profile Settings')}}</h1>
            @include('partials.user-dropdown')
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Sidebar Navigation -->
                <div class="md:col-span-1">
                    <div class="bg-white shadow rounded-lg p-4">
                        <nav class="space-y-2">
                            @if (Gate::allows('isAdmin'))
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center p-3 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                Dashboard
                            </a>
                            @else
                            <a href="{{ route('customer.dashboard') }}"
                                class="flex items-center p-3 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                Dashboard
                            </a>
                            @endif

                            <a href="{{ route('customer.orders') }}"
                                class="flex items-center p-3 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                My Orders
                            </a>
                            <a href="{{ route('customer.wishlist') }}"
                                class="flex items-center p-3 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                                Wishlist
                            </a>
                            <a href="{{ route('customer.addresses') }}"
                                class="flex items-center p-3 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Addresses
                            </a>
                            <a href="{{ route('profile') }}"
                                class="flex items-center p-3 text-indigo-600 bg-indigo-50 rounded-lg font-medium">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile Settings
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Profile Settings Content -->
                <div class="md:col-span-3 space-y-6">
                    <!-- Personal Information Form -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">{{__('Personal Information')}}</h2>

                        <form action="{{ route('profile.info.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Profile Picture -->
                            <div class="mb-6">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <img id="avatar-preview"
                                            class="w-20 h-20 rounded-full object-cover border-2 border-gray-200"
                                            src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}"
                                            alt="{{ Auth::user()->name }}">
                                        <button type="button" onclick="document.getElementById('avatar-upload').click()"
                                            class="absolute bottom-0 right-0 bg-indigo-600 text-white p-1 rounded-full hover:bg-indigo-700 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </button>
                                        <input id="avatar-upload" type="file" name="avatar" class="hidden"
                                            accept="image/*" onchange="previewImage(this)">
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">JPG, GIF or PNG. Max size of 2MB</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email (read-only) -->
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                    Address</label>
                                <input type="email" id="email" value="{{ Auth::user()->email }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed"
                                    disabled>
                            </div>

                            {{--
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                    Number</label>
                                <input type="tel" id="phone" name="phone"
                                    value="{{ old('phone', Auth::user()->phone) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Information
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Password Change Form -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">Change Password</h2>

                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Current Password -->
                            <div class="mb-4">
                                <label for="current_password"
                                    class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                <input type="password" id="current_password" name="current_password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New
                                    Password</label>
                                <input type="password" id="password" name="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-6">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('avatar-preview');
        const file = input.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}";
        }
    }
</script>
@endsection