<?php

// Laravel Routes for Web Application
use App\Http\Controllers\AdminChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProdukPenggunaController;
use App\Http\Controllers\LiveChatController;
use App\Http\Controllers\AdminKelolaAkunController;
use App\Http\Controllers\Pengguna\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AlamatController;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPesananController;
use App\Http\Controllers\Admin\AdminArmadaController;
use App\Http\Controllers\Admin\PembelianProdukController;
use App\Http\Controllers\PembelianVarianProdukController;
// =========== BATAS ============


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
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        // ============ BATAS =============


        // =========== KELOLA PEMBELIAN VARIAN PRODUK ADMIN ===========
        Route::resource('/admin/pembelian', PembelianVarianProdukController::class);
        Route::get('/admin/pembelian-produk/{pembelian}/download-po', [PembelianVarianProdukController::class, 'downloadPo'])->name('pembelian.produk.downloadPo');
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
        Route::get('/admin/produk/{produk}/ajax-varians', [ProdukController::class, 'ajaxVarians'])->name('produk.ajax-varians');
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
        Route::get('/admin/kelola-akun-ajax', [AdminKelolaAkunController::class, 'ajax'])->name('admin.kelola-akun.ajax');
        // ============ BATAS =============


        // =========== ADMIN PESANAN ===========
        Route::get('/admin/pesanan', [AdminPesananController::class, 'index'])->name('admin.pesanan');
        Route::get('/admin/pesanan1', [AdminPesananController::class, 'index'])->name('admin.pesanan.index');
        Route::get('/admin/pesanan11', [AdminPesananController::class, 'index'])->name('admin.pesanan.edit');
        Route::patch('/admin/pesanan/{id}/update-status', [AdminPesananController::class, 'updateStatus'])->name('admin.pesanan.updateStatus');
        Route::patch('/admin/pesanan/{id}/update-status-po', [AdminPesananController::class, 'updateStatusPo'])->name('admin.pesanan.updateStatusPo');
        Route::patch('/admin/pembayaran/{id}/update-status-verif', [AdminPesananController::class, 'updateStatusVerif'])->name('admin.pembayaran.updateStatusVerif');
        Route::patch('/admin/pembayaran/{id}/update-catatan', [AdminPesananController::class, 'updateCatatan'])->name('admin.pembayaran.updateCatatan');
        Route::get('/admin/pesanan/export', [AdminPesananController::class, 'export'])->name('admin.pesanan.export');
        Route::get('/admin/pesanan/{id}/surat-jalan', [AdminPesananController::class, 'suratJalan'])->name('admin.pesanan.suratJalan');
        // ============ BATAS =============


        // =========== Armada Pengiriman ===========
        Route::get('/admin/armada', [AdminArmadaController::class, 'index'])->name('admin.armada-pengiriman');
        Route::get('/admin/armada/create', [AdminArmadaController::class, 'create'])->name('admin.armada-create');
        Route::post('/admin/armada/store', [AdminArmadaController::class, 'store'])->name('admin.armada-store');
        Route::get('/admin/armada/{id}/edit', [AdminArmadaController::class, 'edit'])->name('admin.armada-edit');
        Route::put('/admin/armada/{id}/update', [AdminArmadaController::class, 'update'])->name('admin.armada-update');
        Route::delete('/admin/armada/{id}/delete', [AdminArmadaController::class, 'destroy'])->name('admin.armada-delete');
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
        Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/keranjang/tambah', [CartController::class, 'store'])->name('keranjang.tambah');
        Route::put('/cart/update/{cartItemId}', [CartController::class, 'update'])->name('cart.update');
        // ============ BATAS =============


        // ============ Cart =============
        Route::get('/alamat', [AlamatController::class, 'index'])->name('alamat.index');
        Route::get('/alamat/create', [AlamatController::class, 'create'])->name('alamat.create');
        Route::post('/alamat/store', [AlamatController::class, 'store'])->name('alamat.store');
        Route::get('/alamat/{alamat}/edit', [AlamatController::class, 'edit'])->name('alamat.edit');
        Route::put('/alamat/{alamat}', [AlamatController::class, 'update'])->name('alamat.update');
        Route::delete('/alamat/{alamat}', [AlamatController::class, 'destroy'])->name('alamat.destroy');
        Route::post('/alamat/{id}/default', [AlamatController::class, 'setDefault'])->name('alamat.default');
        // ============ BATAS =============


        // ============ Checkout/Pemesanan =============
        Route::post('/checkout', [PesananController::class, 'store'])->name('keranjang.checkout');
        Route::get('/pesanan/{pemesanan_id}', [PesananController::class, 'pembayaran'])->name('pemesanan.pembayaran');
        Route::post('/pemesanan/{id}/upload-po', [PesananController::class, 'uploadPO'])->name('pemesanan.upload_po');
        Route::post('/pembayaran/{id}/upload-bukti', [PesananController::class, 'uploadBukti'])->name('pemesanan.upload_bukti');
        Route::delete('/pembayaran/{id}/hapus-bukti', [PesananController::class, 'hapusBukti'])->name('pemesanan.hapus_bukti');
        Route::delete('/pemesanan/{id}/hapus-po', [PesananController::class, 'hapusPO'])->name('pemesanan.hapus_po');
        Route::get('/pesanan-saya', [PesananController::class, 'index'])->name('pemesanan.index');
        Route::get('/pesanan/update/{pemesanan_id}', [PesananController::class, 'detail'])->name('pemesanan.detail');
        Route::get('/pemesanan/{id}/invoice', [PesananController::class, 'invoice'])->name('pemesanan.invoice');
        // ============ BATAS =============
    });
});
