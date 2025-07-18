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
use App\Http\Controllers\AdminKelolaAkunController;
use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\Pengguna\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
// ======== BATAS =========


// =========== NO ROLE LANDING PAGE ===========
Route::get('/', [LandingController::class, 'index'])->name('landing');
// =========== BATAS =============


// =========== KATALOG PRODUK ===========
Route::get('/katalog-produk', [LandingController::class, 'katalog'])->name('katalog-produk.pengguna');
// ============ BATAS =============


// ======== GALERI ===========
Route::get('/galeri', [LandingController::class, 'galeri'])->name('galeri.pengguna');
// ======== BATAS =============


// ======== HUBUNGI KAMI ===========
Route::get('/hubungi-kami', [LandingController::class, 'kontak'])->name('kontak.pengguna');
// ======== BATAS =============




// ======== LOGIN ========
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// ============ BATAS =============


// ======== REGISTER ========
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
// ============ BATAS =============


// ======== RESET PASSWORD ========
Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
// Menampilkan form reset password (dari email)
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
// Mengupdate password baru
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');
// ============ BATAS =============


// ======== Produk ========
Route::get('/produk', [ProdukPenggunaController::class, 'index'])->name('produk.pengguna.index');
Route::get('/produk/detail/{slug}', [ProdukPenggunaController::class, 'detail'])->name('produk.detail');
// ============ BATAS =============


// ======== LIVE CHAT ========
Route::post('/live-chat/start', [LiveChatController::class, 'startChat']);
Route::post('/live-chat/send', [LiveChatController::class, 'sendMessage']);
Route::get('/live-chat/messages/{chat_id}', [LiveChatController::class, 'getMessages']);
// ============ BATAS =============



// ======== PROTEKSI UMUM UNTUK YANG SUDAH LOGIN ========
Route::middleware(['auth'])->group(function () {


    // =========== PROFILE ===========
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    // ============ BATAS =============


    // =========== ADMIN ===========
    Route::middleware(['role:admin'])->group(function () {
        // ======= DASHBOARD ADMIN ========
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        // ============ BATAS =============


        // =========== KELOLA PRODUK ADMIN ===========
        Route::get('/admin/produk', [ProdukController::class, 'index'])->name('produk.index');
        Route::delete('/admin/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::get('/admin/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/admin/produk/tambah-produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/admin/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');
        Route::get('/admin/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/admin/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/admin/produk/gambar/{id}', [ProdukController::class, 'destroyGambar'])->name('produk.gambar.destroy');
        // ============ BATAS =============


        // ======== LIVE CHAT ADMIN ========
        Route::get('/admin/chat', [AdminChatController::class, 'index'])->name('admin.chat');
        Route::get('/admin/chat/{id}', [AdminChatController::class, 'show'])->name('admin.chat.show');
        Route::post('/admin/chat/{chat}/reply', [AdminChatController::class, 'reply'])->name('admin.chat.reply');
        Route::post('/admin/chat/{chat}/typing', [AdminChatController::class, 'setTypingStatus'])->name('admin.chat.typing');
        Route::get('/admin/chat/{chat}/typing-status', [AdminChatController::class, 'getTypingStatus'])->name('admin.chat.typing_status');
        Route::get('/admin/live-chat/messages/{chat}', [AdminChatController::class, 'getMessages'])->name('admin.chat.messages');
        // ============ BATAS =============


        // ======== MANAGE PENGGUNA ========
        Route::get('/admin/pengguna', [AdminKelolaAkunController::class, 'index'])->name('admin.kelola-akun');
        Route::get('/admin/pengguna/{id}', [AdminKelolaAkunController::class, 'edit'])->name('admin.kelola-akun.edit');
        Route::put('/admin/pengguna/{id}/edit', [AdminKelolaAkunController::class, 'update'])->name('admin.kelola-akun.update');
        Route::delete('/admin/pengguna/{id}', [AdminKelolaAkunController::class, 'destroy'])->name('admin.kelola-akun.destroy');
        Route::patch('/admin/kelola-akun/{id}/toggle-active', [AdminKelolaAkunController::class, 'toggleActive'])->name('admin.kelola-akun.toggle-active');
        // ============ BATAS =============


        // =========== ADMIN PESANAN ===========
        Route::get('/admin/pesanan', [AdminPesananController::class, 'index'])->name('admin.kelola-akun');
        // ============ BATAS =============
    });


    // ======== DASHBOARD PELANGGAN ========
    Route::middleware(['role:pelanggan'])->group(function () {


        // ======== DASHBOARD PELANGGAN ========
        Route::get('/pelanggan/dashboard', function () {
            return view('pelanggan.dashboard');
        })->name('pelanggan.dashboard');
        // ============ BATAS =============


        // ============ PESANAN/ORDER ============
        Route::get('/penawaran-saya', [PesananController::class, 'penawaran'])->name('pengguna.quotation');
        Route::get('/riwayat-pemesanan', [PesananController::class, 'riwayat'])->name('pengguna.pemesanan');
        Route::post('/store-varian', [PesananController::class, 'storeVarian'])->name('store-varian');
        // ============ BATAS =============


        // ============ Cart =============
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{varianProduk}', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
        Route::put('/cart/update/{cartItemId}', [CartController::class, 'update'])->name('cart.update');
        Route::post('/keranjang/tambah', [CartController::class, 'store'])->name('keranjang.tambah');
        // ============ BATAS =============


    });
});
