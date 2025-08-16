@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<div
    class="min-h-screen bg-gradient-to-r from-indigo-50 via-white to-indigo-50 flex items-center justify-center py-12 px-6">
    <div class="w-full max-w-md bg-white -xl shadow-lg p-8 space-y-6">
        <div class="flex justify-center mb-6">
            <img class="h-8 w-auto" src="{{ asset('images/Zeno.png') }}" alt="Logo">
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800">Reset Password</h2>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus readonly
                    class="mt-1 block w-full -md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full -md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required
                    class="mt-1 block w-full -md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent -md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Reset Password
            </button>
        </form>
    </div>
</div>
@endsection