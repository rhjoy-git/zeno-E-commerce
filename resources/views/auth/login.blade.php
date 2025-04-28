@extends('layouts.app')
@section('title', 'Login')
@section('content')
<x-auth.form-card title="Welcome Back" subtitle="Please sign in to continue">
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <x-auth.input name="email" type="email" label="Email Address" required />
        <x-auth.input name="password" type="password" label="Password" required />

        <div class="flex items-center justify-between">
            <label class="flex items-center text-sm text-gray-600">
                <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-indigo-600 focus:ring-0">
                <span class="ml-2">Remember me</span>
            </label>

            <a href="" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold">
                Forgot Password?
            </a>
        </div>

        <x-auth.button>
            Login
        </x-auth.button>
    </form>

    <div class="mt-6 text-center text-sm">
        <span class="text-gray-600">Don't have an account?</span>
        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
            Register
        </a>
    </div>
</x-auth.form-card>
@endsection