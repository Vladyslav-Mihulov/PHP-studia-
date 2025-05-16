<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\OrdersController;

Route::get('/', [HomepageController::class, 'show'])->name('home');
Route::post('/homepage/submit', [HomepageController::class, 'submit'])->name('home-submit');
Route::get('/cart', [HomepageController::class, 'cart'])->name('cart');
Route::post('/cart/submit', [HomepageController::class, 'submitCart'])->name('cart-submit');

Route::get('/orders', [OrdersController::class, 'show'])->name('orders');

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login/submit', [LoginController::class, 'submit'])->name('login-submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/registration', [RegistrationController::class, 'show'])->name('registration');
Route::post('/registration/submit', [RegistrationController::class, 'submit'])->name('registration-submit');

Route::get('/profile', [LoginController::class, 'showProfile'])->name('profile');

Route::get('/employee', function () {
    return view('employee');
})->name('employee');

Route::get('/admin', [AdminController::class, 'show'] )->name('admin');