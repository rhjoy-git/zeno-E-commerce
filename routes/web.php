<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\OTPVerificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Guest Routes
Route::middleware('guest')->group(function () {
    // Registration Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');
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
    Route::get('/otp/verify/{email}', [OTPVerificationController::class, 'showOtpForm'])
        ->name('otp.verify');
    Route::post('/otp/verify', [OTPVerificationController::class, 'verifyOtp'])->name('otp.verify.post');
    Route::post('/otp/resend/{email}', [OTPVerificationController::class, 'resendOtp'])
        ->name('otp.resend');
    // Optional: If you need a GET version for testing
    Route::get('/otp/resend/{email}', [OTPVerificationController::class, 'resendOtp'])
        ->name('otp.resend.get');
});

Route::middleware('auth')->group(function () {
    // Profile View
    Route::get('/profile', [ProfileController::class, 'showProfile'])
        ->name('profile');

    // Profile Update
    Route::put('/profile/info', [ProfileController::class, 'updateProfile'])
        ->name('profile.info.update');

    // Password Update
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');
});
// Customer Routes
Route::middleware(['auth', 'customer'])->controller(CustomerDashboardController::class)->name('customer.')->group(function () {
    Route::get('/dashboard', 'dashboard')
        ->name('dashboard');
    Route::get('/orders', 'orders')
        ->name('orders');
    Route::get('/orders/{id}', 'orderDetails')
        ->name('order.details');
    Route::get('/wishlist', 'wishlist')
        ->name('wishlist');
    Route::get('/wishlist/{id}', 'wishlistDetails')
        ->name('wishlist.details');
    Route::get('/cart', 'cart')
        ->name('cart');
    Route::get('/cart/{id}', 'cartDetails')
        ->name('cart.details');
    Route::get('/addresses', 'addresses')
        ->name('addresses');
    Route::get('/addresses/{id}', 'addressDetails')
        ->name('address.details');
    // Uncomment if needed:
    // Route::get('/notifications', 'notifications')->name('notifications');
    // Route::get('/notifications/{id}', 'notificationDetails')->name('notification.details');
});
// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])
        ->name('dashboard');
    Route::get('orders', [OrderController::class, 'index'])
        ->name('orders.index');
    // Route::get('products', [ProductController::class, 'index'])
    //     ->name('products.index');
    Route::get('categories', [CategoryController::class, 'index'])
        ->name('categories.index');
    Route::get('customers', [CustomerController::class, 'index'])
        ->name('customers.index');
    Route::get('reports', [ReportController::class, 'index'])
        ->name('reports.index');
    Route::get('settings', [SettingController::class, 'index'])
        ->name('settings');
    Route::resource('brands', BrandController::class);

    Route::resource('products', ProductController::class);
    // Route::resource('categories', CategoryController::class);
    // Route::resource('customers', CustomerController::class);
    // Route::resource('orders', OrderController::class);
    // Route::resource('reports', ReportController::class);
    // Route::resource('settings', SettingController::class);
});

// Frontend Routes
// Route::get('/brand/{id}', [BrandController::class, 'show'])
//     ->name('brand.products');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
