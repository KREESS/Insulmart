<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pemesanan;
use App\Models\User;
use App\Models\DetailPemesanan;
use App\Models\PembayaranPemesanan;
use Carbon\Carbon;
use App\Models\PembelianVarianProduk;
use App\Models\Distributor;
use App\Models\ArmadaPengiriman;
use App\Models\ChatMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $tz  = 'Asia/Jakarta';
        $now = Carbon::now($tz);

        // ==== Agg utama ====
        $totalProduk           = Produk::count();
        $totalPesanan          = Pemesanan::count();
        $totalPelanggan        = User::role('pelanggan')->count();
        $totalPesananSelesai   = Pemesanan::where('status_pemesanan', 'selesai')->count();
        $totalPesananBatal     = Pemesanan::where('status_pemesanan', 'dibatalkan')->count();
        $totalPesananMenunggu  = Pemesanan::where('status_pemesanan', 'menunggu')->count();
        $totalPesananAktif     = $totalPesanan - ($totalPesananSelesai + $totalPesananBatal);

        // Aktivitas terbaru
        $recentOrders   = Pemesanan::latest()->limit(5)->get();
        $recentProducts = Produk::latest()->limit(3)->get();
        $recentPayments = PembayaranPemesanan::latest()->limit(3)->get();

        // ==== Ringkasan pendapatan/pengeluaran (PAKAI updated_at) ====
        // Pendapatan (order selesai) → updated_at
        $pendapatanHarian = Pemesanan::where('status_pemesanan', 'selesai')
            ->whereDate('updated_at', $now->toDateString())
            ->sum('total_harga');

        $pendapatanMingguan = Pemesanan::where('status_pemesanan', 'selesai')
            ->whereBetween('updated_at', [$now->copy()->startOfWeek(Carbon::MONDAY), $now->copy()->endOfWeek(Carbon::SUNDAY)])
            ->sum('total_harga');

        $pendapatanBulanan = Pemesanan::where('status_pemesanan', 'selesai')
            ->whereMonth('updated_at', $now->month)
            ->whereYear('updated_at', $now->year)
            ->sum('total_harga');

        $pendapatanTahunan = Pemesanan::where('status_pemesanan', 'selesai')
            ->whereYear('updated_at', $now->year)
            ->sum('total_harga');

        $pendapatanBulanIni = $pendapatanBulanan;

        // Pengeluaran (pembelian selesai) → **GANTI ke updated_at**
        $pengeluaranHarian = PembelianVarianProduk::where('status', 'selesai')
            ->whereDate('updated_at', $now->toDateString())
            ->sum('total_harga');

        $pengeluaranMingguan = PembelianVarianProduk::where('status', 'selesai')
            ->whereBetween('updated_at', [$now->copy()->startOfWeek(Carbon::MONDAY), $now->copy()->endOfWeek(Carbon::SUNDAY)])
            ->sum('total_harga');

        $pengeluaranBulanan = PembelianVarianProduk::where('status', 'selesai')
            ->whereMonth('updated_at', $now->month)
            ->whereYear('updated_at', $now->year)
            ->sum('total_harga');

        $pengeluaranTahunan = PembelianVarianProduk::where('status', 'selesai')
            ->whereYear('updated_at', $now->year)
            ->sum('total_harga');

        // ==== Data MINGGUAN (bulan berjalan, pakai updated_at semuanya) ====
        $labelsWeeks            = [];
        $weeklyOrderCounts      = []; // Pesanan selesai (count)
        $weeklyPurchaseCounts   = []; // Pembelian selesai (count)
        $weeklyIncomes          = []; // Pendapatan (sum)
        $weeklyExpenses         = []; // Pengeluaran (sum)

        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth   = $now->copy()->endOfMonth();

        for ($i = 0; $i < 6; $i++) {
            $startWeek = $startOfMonth->copy()->addWeeks($i)->startOfWeek(Carbon::MONDAY);
            $endWeek   = $startWeek->copy()->endOfWeek(Carbon::SUNDAY);

            if ($startWeek->gt($endOfMonth)) break;
            if ($endWeek->gt($endOfMonth)) $endWeek = $endOfMonth;

            $labelsWeeks[] = 'Minggu ' . (count($labelsWeeks) + 1);

            // Pesanan selesai (count) — updated_at
            $weeklyOrderCounts[] = Pemesanan::where('status_pemesanan', 'selesai')
                ->whereBetween('updated_at', [$startWeek, $endWeek])
                ->count();

            // Pembelian selesai (count) — **updated_at**
            $weeklyPurchaseCounts[] = PembelianVarianProduk::where('status', 'selesai')
                ->whereBetween('updated_at', [$startWeek, $endWeek])
                ->count();

            // Pendapatan (sum) — updated_at
            $weeklyIncomes[] = Pemesanan::where('status_pemesanan', 'selesai')
                ->whereBetween('updated_at', [$startWeek, $endWeek])
                ->sum('total_harga');

            // Pengeluaran (sum) — **updated_at**
            $weeklyExpenses[] = PembelianVarianProduk::where('status', 'selesai')
                ->whereBetween('updated_at', [$startWeek, $endWeek])
                ->sum('total_harga');
        }

        // ==== Data BULANAN (tahun berjalan, pakai updated_at semuanya) ====
        Carbon::setLocale('id');
        $labelsMonths           = [];
        $monthlyOrderCounts     = [];
        $monthlyPurchaseCounts  = [];
        $monthlyIncomes         = [];
        $monthlyExpenses        = [];

        for ($m = 1; $m <= $now->month; $m++) {
            $startM = Carbon::create($now->year, $m, 1, 0, 0, 0, $tz)->startOfMonth();
            $endM   = $startM->copy()->endOfMonth();

            $labelsMonths[] = $startM->translatedFormat('M Y'); // contoh: "Jan 2025"

            // Pesanan selesai (count) — updated_at
            $monthlyOrderCounts[] = Pemesanan::where('status_pemesanan', 'selesai')
                ->whereBetween('updated_at', [$startM, $endM])
                ->count();

            // Pembelian selesai (count) — **updated_at**
            $monthlyPurchaseCounts[] = PembelianVarianProduk::where('status', 'selesai')
                ->whereBetween('updated_at', [$startM, $endM])
                ->count();

            // Pendapatan (sum) — updated_at
            $monthlyIncomes[] = Pemesanan::where('status_pemesanan', 'selesai')
                ->whereBetween('updated_at', [$startM, $endM])
                ->sum('total_harga');

            // Pengeluaran (sum) — **updated_at**
            $monthlyExpenses[] = PembelianVarianProduk::where('status', 'selesai')
                ->whereBetween('updated_at', [$startM, $endM])
                ->sum('total_harga');
        }

        // === Overall (Pendapatan - Pengeluaran) ===
        $labaRugiHarian   = $pendapatanHarian   - $pengeluaranHarian;
        $labaRugiMingguan = $pendapatanMingguan - $pengeluaranMingguan;
        $labaRugiBulanan  = $pendapatanBulanan  - $pengeluaranBulanan;
        $labaRugiTahunan  = $pendapatanTahunan  - $pengeluaranTahunan;

        // === Ringkasan Pembelian (tanpa waktu) ===
        $totalPembelian            = PembelianVarianProduk::count();
        $totalPembelianSelesai     = PembelianVarianProduk::where('status', 'selesai')->count();
        $totalPembelianDibatalkan  = PembelianVarianProduk::where('status', 'dibatalkan')->count();
        $totalPembelianRetur       = PembelianVarianProduk::where('status', 'dikembalikan_ke_supplier')->count();

        $totalPembelianAktif = PembelianVarianProduk::whereNotIn('status', [
            'selesai',
            'dibatalkan',
            'dikembalikan_ke_supplier'
        ])->count();

        // Aktivitas terbaru
        $recentOrders      = Pemesanan::latest()->limit(5)->get();
        $recentProducts    = Produk::latest()->limit(3)->get();
        $recentPayments    = PembayaranPemesanan::latest()->limit(3)->get();
        $recentPurchases   = PembelianVarianProduk::latest()->limit(5)->get();

        $recentDistributors = class_exists(Distributor::class)
            ? Distributor::latest()->limit(3)->get()
            : collect();

        $recentCustomers = User::role('pelanggan')->latest()->limit(3)->get();

        $recentArmadas = class_exists(ArmadaPengiriman::class)
            ? ArmadaPengiriman::latest()->limit(3)->get()
            : collect();

        $recentChats = ChatMessage::orderByDesc('created_at')->limit(10)->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'totalPelanggan',
            'recentOrders',
            'recentProducts',
            'recentPayments',
            'totalPesananSelesai',
            'totalPesananBatal',
            'totalPesananAktif',
            'totalPesananMenunggu',
            'pendapatanHarian',
            'pendapatanMingguan',
            'pendapatanBulanan',
            'pendapatanTahunan',
            'pendapatanBulanIni',
            'pengeluaranHarian',
            'pengeluaranMingguan',
            'pengeluaranBulanan',
            'pengeluaranTahunan',

            // Mingguan
            'labelsWeeks',
            'weeklyOrderCounts',
            'weeklyPurchaseCounts',
            'weeklyIncomes',
            'weeklyExpenses',

            // Bulanan
            'labelsMonths',
            'monthlyOrderCounts',
            'monthlyPurchaseCounts',
            'monthlyIncomes',
            'monthlyExpenses',

            // Overall
            'labaRugiHarian',
            'labaRugiMingguan',
            'labaRugiBulanan',
            'labaRugiTahunan',

            // Pembelian
            'totalPembelian',
            'totalPembelianAktif',
            'totalPembelianSelesai',
            'totalPembelianDibatalkan',
            'totalPembelianRetur',

            // Recent
            'recentPurchases',
            'recentDistributors',
            'recentCustomers',
            'recentArmadas',
            'recentChats',
        ));
    }
}
