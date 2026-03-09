<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Admin Routes
Route::middleware(['auth', 'admin'])
->prefix('admin')
->name('admin.')
->group(function () {

    Route::get('admin/dashboard', function () {
        return view('content.admin.dashboard.index');
    })->name('admin.dashboard.index');
    
    Route::resource('member', RegisterController::class);

    Route::resource('category', CategoryController::class);

    Route::resource('book', BookController::class);

    Route::resource('payment', PaymentController::class);

    Route::post('/payment/{id}/pay',[PaymentController::class,'pay'])
        ->name('payment.pay');
        
    Route::get('/payment/{id}/invoice',[PaymentController::class,'invoice'])
        ->name('payment.invoice');

});

// User Routes

Route::prefix('user')->middleware('auth')->group(function () {

    Route::get('/dashboard', [MemberDashboardController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/about', function () {
        return view('content.user.about');
    })->name('about');

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add/{id}', [CartController::class, 'add'])
        ->name('cart.add');

    Route::post('/cart/checkout', [CartController::class, 'checkout'])
        ->name('cart.checkout');

    Route::delete('/user/cart/remove/{id}', [CartController::class,'remove'])
        ->name('cart.remove');

    Route::post('/buy-now/{id}', [OrderController::class, 'buyNow'])
        ->name('buy.now');
});