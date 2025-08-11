@extends('layouts.admin')
@section('title', 'Admin Profile')
@section('content')

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Profile Settings Content -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Personal Information Form -->
                <div class="bg-white shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">{{ __('Personal Information') }}</h2>
                    <form action="{{ route('profile.info.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Profile Picture -->
                        <div class="mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <img id="avatar-preview" class="w-20 h-20 -full object-cover border-2 border-gray-200"
                                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                        alt="{{ Auth::user()->name }}">
                                    <button type="button" onclick="document.getElementById('avatar-upload').click()"
                                        class="absolute bottom-0 right-0 bg-indigo-600 text-white p-1 -full hover:bg-indigo-700 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </button>
                                    <input id="avatar-upload" type="file" name="avatar" class="hidden" accept="image/*"
                                        onchange="previewImage(this)">
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">JPG, GIF or PNG. Max size of 2MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full
                                Name</label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', Auth::user()->name) }}"
                                class="w-full px-3 py-2 border border-gray-300 -md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email (read-only) -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                Address</label>
                            <input type="email" id="email" value="{{ Auth::user()->email }}"
                                class="w-full px-3 py-2 border border-gray-300 -md shadow-sm bg-gray-100 cursor-not-allowed"
                                disabled>
                        </div>

                        <!-- Phone -->
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                Number</label>
                            <input type="tel" id="phone" name="phone"
                                value="{{ old('phone', Auth::user()->phone) }}"
                                class="w-full px-3 py-2 border border-gray-300 -md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 border border-transparent -md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Information
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Password Change Form -->
                <div class="bg-white shadow  p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Change Password</h2>
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Current Password -->
                        <div class="mb-4">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current
                                Password</label>
                            <input type="password" id="current_password" name="current_password"
                                class="w-full px-3 py-2 border border-gray-300 -md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New
                                Password</label>
                            <input type="password" id="password" name="password"
                                class="w-full px-3 py-2 border border-gray-300 -md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm
                                New
                                Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full px-3 py-2 border border-gray-300 -md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 border border-transparent -md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
                
            </div>
    </main>

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
                preview.src =
                    "{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}";
            }
        }
    </script>
@endsection
