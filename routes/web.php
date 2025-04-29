<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\OTPVerificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

Route::get('/', function () {
    return view('home');
})->name('home');


// Guest Routes
Route::middleware('guest')->group(function () {
    // Registration Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Password Reset Links
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Password Reset
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');

    // OTP Verification Routes
    Route::get('/otp/verify/{email}', [OTPVerificationController::class, 'showOtpForm'])->name('otp.verify');
    Route::post('/otp/verify', [OTPVerificationController::class, 'verifyOtp'])->name('otp.verify.post');
    Route::post('/otp/resend/{email}', [OTPVerificationController::class, 'resendOtp'])->name('otp.resend');
    // Optional: If you need a GET version for testing
    Route::get('/otp/resend/{email}', [OTPVerificationController::class, 'resendOtp'])->name('otp.resend.get');
});

// Customer Routes
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])
        ->name('customer.dashboard');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
