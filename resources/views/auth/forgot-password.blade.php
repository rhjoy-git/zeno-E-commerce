@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')
<div
    class="min-h-screen bg-gradient-to-r from-indigo-50 via-white to-indigo-50 flex items-center justify-center py-12 px-6">
    <div class="w-full max-w-md bg-white -xl shadow-lg p-8 space-y-6">
        <div class="flex justify-center mb-6">
            <img class="h-8 w-auto" src="{{ asset('images/Zeno.png') }}" alt="Logo">
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800">Forgot Password?</h2>

        @if (session('status'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4">
            <p class="text-green-700">{{ session('status') }}</p>
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" name="email" required autofocus
                    class="mt-1 block w-full -md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent -md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Send Reset Link
            </button>
        </form>

        <div class="text-center text-sm">
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800">
                Back to login
            </a>
        </div>
    </div>
</div>
@endsection