<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('home');
})->name('home');


// Guest Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

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
// hzrsplfbjebrkfkq
// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
