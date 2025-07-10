<?php

// Laravel Routes for Web Application

use App\Http\Controllers\AdminChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProdukPenggunaController;
use App\Http\Controllers\LiveChatController;
// ======== BATAS =========


// =========== NO ROLE LANDING PAGE ===========
Route::get('/', [LandingController::class, 'index'])->name('landing');


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


// ======== RESET PASSWORD ========
Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
// Menampilkan form reset password (dari email)
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
// Mengupdate password baru
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');


// ======== Produk ========
Route::get('/produk/detail/{slug}', [ProdukPenggunaController::class, 'detail'])->name('produk.detail');


// ======== LIVE CHAT ========
Route::post('/live-chat/start', [LiveChatController::class, 'startChat']);
Route::post('/live-chat/send', [LiveChatController::class, 'sendMessage']);
Route::get('/live-chat/messages/{chat_id}', [LiveChatController::class, 'getMessages']);



// ======== PROTEKSI UMUM UNTUK YANG SUDAH LOGIN ========
Route::middleware(['auth'])->group(function () {

    // ======== LIVE CHAT ADMIN ========
    Route::get('/admin/chat', [AdminChatController::class, 'index'])->name('admin.chat');
    Route::get('/admin/chat/{id}', [AdminChatController::class, 'show'])->name('admin.chat.show');
    Route::post('/admin/chat/{chat}/reply', [AdminChatController::class, 'reply'])->name('admin.chat.reply');
    Route::post('/admin/chat/{chat}/typing', [AdminChatController::class, 'setTypingStatus'])->name('admin.chat.typing');
    Route::get('/admin/chat/{chat}/typing-status', [AdminChatController::class, 'getTypingStatus'])->name('admin.chat.typing_status');
    Route::get('/admin/live-chat/messages/{chat}', [AdminChatController::class, 'getMessages'])->name('admin.chat.messages');

    // ======== DASHBOARD ADMIN ========
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/admin/produk', [ProdukController::class, 'index'])->name('produk.index');
        Route::delete('/admin/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::get('/admin/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/admin/produk/tambah-produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/admin/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');

        Route::get('/admin/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/admin/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/admin/produk/gambar/{id}', [ProdukController::class, 'destroyGambar'])->name('produk.gambar.destroy');
    });

    // ======== DASHBOARD PELANGGAN ========
    Route::middleware(['role:pelanggan'])->group(function () {
        Route::get('/pelanggan/dashboard', function () {
            return view('pelanggan.dashboard');
        })->name('pelanggan.dashboard');
    });
});
