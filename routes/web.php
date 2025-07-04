<?php

// Laravel Routes for Web Application
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
// ======== BATAS =========

// =========== NO ROLE LANDING PAGE ===========
Route::get('/', function () {
    return view('welcome');
});

Route::get('/produk', function () {
    return view('produk');
});

Route::get('/katalog-produk', function () {
    return view('katalog_produk');
});

Route::get('/galeri', function () {
    return view('galeri');
});

Route::get('/hubungi-kami', function () {
    return view('hubungi_kami');
});

Route::get('/hubungi-kami', function () {
    return view('hubungi_kami');
});
// ======== BATAS ===========

// ======== LOGIN ========
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ======== REGISTER ========
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


// ======== DASHBOARD ADMIN ========
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
});

// ========DASHBOARD PELANGGAN========
Route::middleware(['role:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', function () {
        return view('pelanggan.dashboard');
    })->name('pelanggan.dashboard');
});
