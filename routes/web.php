<?php

// Import semua controller yang digunakan di routing
use App\Http\Controllers\AdminCartController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;


// ======================
// AUTH ROUTES (LOGIN & REGISTER)
// ======================

// Menampilkan halaman login
Route::get('/', [LoginController::class, 'index'])->name('login.index');

// Proses login user
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

// Menampilkan halaman register
Route::get('/register', [RegisterController::class, 'create'])->name('register.create');

// Proses registrasi user baru
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Logout user
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ======================
// ADMIN ROUTES
// ======================

Route::middleware(['auth', 'admin']) // Hanya bisa diakses oleh user login & role admin
->prefix('admin') // Semua URL diawali /admin
->name('admin.') // Prefix name route admin.
->group(function () {

    // Dashboard admin
    Route::get('dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
    
    // CRUD data member (menggunakan RegisterController)
    Route::resource('member', RegisterController::class);

    // CRUD kategori buku
    Route::resource('category', CategoryController::class);

    // CRUD buku
    Route::resource('book', BookController::class);

    // CRUD pembayaran
    Route::resource('payment', PaymentController::class);

    // Proses bayar manual oleh admin
    Route::post('/payment/{id}/pay',[PaymentController::class,'pay'])
        ->name('payment.pay');

    // Approve pembayaran
    Route::post('/payment/{id}/approve', [PaymentController::class, 'approve'])
        ->name('payment.approve');

    // Reject pembayaran
    Route::post('/payment/{id}/reject', [PaymentController::class, 'reject'])
        ->name('payment.reject');
        
    // Generate invoice pembayaran
    Route::get('/payment/{id}/invoice',[PaymentController::class,'invoice'])
        ->name('payment.invoice');

    // Melihat semua cart user (admin view)
    Route::get('cart', [AdminCartController::class, 'index'])
        ->name('cart.index');

    // Halaman laporan (report)
    Route::get('report', [ReportController::class, 'index'])
        ->name('report.index');

    // Data grafik laporan (biasanya untuk chart JS)
    Route::get('report/chart', [ReportController::class, 'chartReport'])
        ->name('report.graphic');

    // Laporan produk (penjualan per produk)
    Route::get('admin/report/products', [ReportController::class, 'productReport'])
        ->name('report.products');

});


// ======================
// USER ROUTES
// ======================

Route::prefix('user')->middleware('auth')->group(function () {

    // Dashboard user/member
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])
        ->name('user.dashboard');

    // Halaman about
    Route::get('/about', function () {
        return view('content.user.about');
    })->name('about');

    // Melihat cart user
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    // Menambahkan item ke cart
    Route::post('/cart/add/{id}', [CartController::class, 'add'])
        ->name('cart.add');

    // Checkout cart (buat order)
    Route::post('/cart/checkout', [CartController::class, 'checkout'])
        ->name('cart.checkout');

    // Menghapus item dari cart
    Route::delete('/user/cart/remove/{id}', [CartController::class,'remove'])
        ->name('cart.remove');

    // Buy now (langsung beli tanpa masuk cart)
    Route::post('/buy-now/{id}', [OrderController::class, 'buyNow'])
        ->name('buy.now');
});