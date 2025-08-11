<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestingController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OTPVerificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Product\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;

// ==================== Public Routes ====================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about.us');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact.us');
Route::post('/contact-us', [HomeController::class, 'sendContactMessage'])->name('contact.us.send');
Route::fallback(function () {
    abort(404);
});
// Product Routes
Route::get('/products', [CustomerProductController::class, 'index'])->name('products.list');
Route::get('/products/{id}', [CustomerProductController::class, 'show'])->name('products.show');

// Public cart routes 
Route::prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/items', [CartController::class, 'index'])->name('cart.items');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// ==================== Guest Routes ====================

Route::middleware('guest')->group(function () {
    // Registration
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Forgot Password
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Reset Password
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

    // OTP Verification
    Route::get('/otp/verify/{email}', [OTPVerificationController::class, 'showOtpForm'])->name('otp.verify');
    Route::post('/otp/verify', [OTPVerificationController::class, 'verifyOtp'])->name('otp.verify.post');
    Route::post('/otp/resend/{email}', [OTPVerificationController::class, 'resendOtp'])->name('otp.resend');
    Route::get('/otp/resend/{email}', [OTPVerificationController::class, 'resendOtp'])->name('otp.resend.get');
});

// ==================== Authenticated Routes ====================

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::put('/profile/info', [ProfileController::class, 'updateProfile'])->name('profile.info.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// ==================== Customer Routes ====================

Route::middleware(['auth', 'customer'])->name('customer.')->group(function () {
    Route::controller(CustomerDashboardController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/orders', 'orders')->name('orders');
        Route::get('/orders/{id}', 'orderDetails')->name('order.details');
        Route::get('/addresses', 'addresses')->name('addresses');
        Route::get('/addresses/{id}', 'addressDetails')->name('address.details');
    });

    // Wish list
    Route::get('/wishlist', [WishlistController::class, 'getWishList'])->name('wishlist');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
});

// ==================== Admin Routes ====================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    // Brands
    Route::resource('brands', BrandController::class);
    Route::get('brands/{brand}/product/create', [AdminProductController::class, 'create'])->name('brands.products.create');

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::get('categories/{category}/product/create', [AdminProductController::class, 'create'])->name('categories.products.create');
    Route::post('/admin/categories/{category}/update-status', [CategoryController::class, 'updateStatus']);

    // Products
    Route::resource('products', AdminProductController::class);
    // Update product status
    Route::post('/products/{product}/update-status', [AdminProductController::class, 'updateStatus'])->name('products.updateStatus');
    // Update product stock
    Route::post('/products/{product}/update-stock', [AdminProductController::class, 'updateStock'])->name('admin.products.updateStock');


    // Customers
    Route::resource('customers', CustomerController::class);
    Route::get('customers/data', [CustomerController::class, 'data'])->name('customers.data');
    Route::get('customers/export', [CustomerController::class, 'export'])->name('customers.export');

    // Orders
    Route::resource('orders', OrderController::class);

    // Reports
    Route::resource('reports', ReportController::class);

    // Settings
    Route::resource('settings', SettingController::class);

    // Profile
});

// ==================== Misc Routes ====================

Route::get('/testing', [TestingController::class, 'index'])->name('testing');

// Optional Frontend Brand Route (Commented Out)
// Route::get('/brand/{id}', [BrandController::class, 'show'])->name('brand.products');
