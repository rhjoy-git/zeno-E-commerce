@extends('layouts.app')
@section('title', 'Register')
@section('content')
<x-auth.form-card title="Create Account" subtitle="Join our community today">
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <x-auth.input name="name" label="Full Name" required />
        <x-auth.input name="email" type="email" label="Email Address" required />
        <x-auth.input name="password" type="password" label="Password" required />
        <x-auth.input name="password_confirmation" type="password" label="Confirm Password" required />
        
        @error('password')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        <x-auth.button>
            Register
        </x-auth.button>
    </form>

    <div class="mt-6 text-center text-sm">
        <span class="text-gray-600">Already have an account?</span>
        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
            Login
        </a>
    </div>
</x-auth.form-card>
@endsection