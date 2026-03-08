<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('admin/dashboard', function () {
        return view('content.admin.dashboard.index');
    })->name('admin.dashboard.index');
    Route::get('member', [RegisterController::class, 'index'])->name('member.index');
    Route::get('member/edit/{id}', [RegisterController::class, 'edit'])->name('member.edit');
    Route::put('member/update/{id}', [RegisterController::class, 'update'])->name('member.update');
    Route::get('member/create', [RegisterController::class, 'createInAdmin'])->name('member.create');
    Route::post('member/store', [RegisterController::class, 'storeInAdmin'])->name('member.store');
    Route::delete('member/destroy/{id}', [RegisterController::class, 'destroy'])->name('member.destroy');
});

// User Routes
Route::middleware(['auth', 'user'])->group(function () {

    Route::get('user/dashboard', function () {
        return view('content.user.dashboard.index');
    })->name('user.dashboard.index');
});
