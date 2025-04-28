@extends('layouts.app')
@section('title', 'Verify OTP')
@section('content')

<div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)"
    class="min-h-screen bg-gradient-to-r from-indigo-50 via-white to-indigo-50 flex items-center justify-center py-12 px-6">
    <div x-show="show" x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
        class="w-full mx-auto max-w-md bg-white rounded-2xl shadow-lg p-8 space-y-6 ">

        {{-- Brand Icon --}}
        <div class="flex justify-center mb-6 p-3">
            <img class="h-6 w-auto shadow-lg" src="{{ asset('images/Zeno.png') }}" alt="Brand Logo">
        </div>

        {{-- Verify OTP --}}
        <form method="POST" action="{{ route('otp.verify.post') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-4">
                <x-auth.input id="otp" name="otp" type="text" label="OTP Verification" required />
            </div>

            <x-auth.button>
                Verify OTP
            </x-auth.button>
            <div class="text-right font-semibold text-xs">
                <a href="#" onclick="event.preventDefault(); document.getElementById('resend-form').submit();"
                    class="text-blue-600 hover:underline">
                    Resend OTP
                </a>
                <form id="resend-form" action="{{ route('otp.resend', ['email' => $email]) }}" method="POST"
                    class="hidden">
                    @csrf
                </form>
            </div>

        </form>
    </div>
    @endsection