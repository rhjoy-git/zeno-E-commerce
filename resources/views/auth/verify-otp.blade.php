@extends('layouts.app')
@section('title', 'Verify OTP')
@section('content')
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)"
        class="min-h-screen bg-gradient-to-r from-indigo-50 via-white to-indigo-50 flex items-center justify-center py-12 px-6">
        <div x-show="show" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
            class="w-full mx-auto max-w-md bg-white shadow-lg p-8 space-y-6">

            {{-- Brand Icon --}}
            <div class="flex justify-center mb-6 p-3">
                <img class="h-6 w-auto shadow-lg" src="{{ asset('images/Zeno.png') }}" alt="Brand Logo">
            </div>

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                    <div class="text-red-700">
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if ($user->otp_expires_at && now()->gt($user->otp_expires_at))
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4">
                    <div class="text-yellow-700">
                        <p>Your OTP has expired. Please request a new one.</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('otp.verify.post') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-4">
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">
                        Enter 6-digit OTP
                    </label>
                    <input id="otp" name="otp" type="text" inputmode="numeric" pattern="[0-9]{6}" value="{{ old('otp') }}"
                        class="block w-full border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required autofocus autocomplete="one-time-code"
                        x-bind:readonly="{{ $user->otp_expires_at && now()->gt($user->otp_expires_at) ? 'true' : 'false' }}">
                    @error('otp')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 text-center text-sm text-gray-600">
                    @if ($user->otp_expires_at)
                        Expires in: <span id="countdown" class="text-rose-600"></span>
                    @endif
                </div>

                <button type="submit" id="verify-btn"
                    class="w-full flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    x-bind:disabled="{{ $user->otp_expires_at && now()->gt($user->otp_expires_at) ? 'true' : 'false' }}"
                    x-bind:class="{{ $user->otp_expires_at && now()->gt($user->otp_expires_at) ? '\'bg-gray-400 cursor-not-allowed hover:bg-gray-400\'' : '\'bg-indigo-600 hover:bg-indigo-700\'' }}">
                    Verify OTP
                </button>
            </form>

            <div class="text-center text-sm mt-4">
                <form method="POST" action="{{ route('otp.resend', ['token' => $token]) }}">
                    @csrf
                    <button type="submit" class="text-indigo-600 hover:text-indigo-800 font-medium"
                        @if ($user->otp_expires_at && now()->lt($user->otp_expires_at)) disabled @endif>
                        Resend OTP
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if ($user->otp_expires_at)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const expiryTime = new Date("{{ \Carbon\Carbon::parse($user->otp_expires_at)->format('Y-m-d H:i:s') }}")
                    .getTime();
                const countdownDisplay = document.getElementById('countdown');
                const resendBtn = document.querySelector('form[action*="resend"] button');
                const verifyBtn = document.getElementById('verify-btn');
                const otpInput = document.getElementById('otp');

                function updateCountdown() {
                    const now = Date.now();
                    const remaining = Math.floor((expiryTime - now) / 1000);

                    if (remaining <= 0) {
                        countdownDisplay.textContent = '00:00';
                        resendBtn.disabled = false;
                        resendBtn.classList.remove('text-gray-400', 'cursor-not-allowed');
                        resendBtn.classList.add('text-indigo-600', 'hover:text-indigo-800');
                        verifyBtn.disabled = true;
                        verifyBtn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                        verifyBtn.classList.add('bg-gray-400', 'cursor-not-allowed', 'hover:bg-gray-400');
                        otpInput.readOnly = true;
                        return;
                    }

                    const minutes = String(Math.floor(remaining / 60)).padStart(2, '0');
                    const seconds = String(remaining % 60).padStart(2, '0');
                    countdownDisplay.textContent = `${minutes}:${seconds}`;
                    resendBtn.disabled = true;
                    resendBtn.classList.remove('text-indigo-600', 'hover:text-indigo-800');
                    resendBtn.classList.add('text-gray-400', 'cursor-not-allowed');
                    verifyBtn.disabled = false;
                    verifyBtn.classList.remove('bg-gray-400', 'cursor-not-allowed', 'hover:bg-gray-400');
                    verifyBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                    otpInput.readOnly = false;

                    setTimeout(updateCountdown, 1000);
                }

                updateCountdown();
            });
        </script>
    @endif
@endsection
