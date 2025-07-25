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

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();
        $totalPesanan = Pemesanan::count();
        $totalPelanggan = User::role('pelanggan')->count();
        $totalPesanan = Pemesanan::count();
        $totalPesananSelesai = Pemesanan::where('status_pemesanan', 'selesai')->count();
        $totalPesananBatal   = Pemesanan::where('status_pemesanan', 'dibatalkan')->count();
        $totalPesananMenunggu = Pemesanan::where('status_pemesanan', 'menunggu')->count();


        $totalPesananAktif = $totalPesanan - ($totalPesananSelesai + $totalPesananBatal);

        // Ambil aktivitas terbaru
        $recentOrders = Pemesanan::latest()->limit(5)->get();
        $recentProducts = Produk::latest()->limit(3)->get();
        $recentPayments = PembayaranPemesanan::latest()->limit(3)->get();

        // Hitung pendapatan bulan ini (status selesai)
        $pendapatanBulanIni = \App\Models\Pemesanan::where('status_pemesanan', 'selesai')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->sum('total_harga');

        $today      = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek(); // Senin, bisa diganti Minggu pakai ->locale('id')->startOfWeek(Carbon::SUNDAY)
        $now        = Carbon::now();

        // Pendapatan hari ini
        $pendapatanHarian = Pemesanan::where('status_pemesanan', 'selesai')
            ->whereDate('updated_at', $today)
            ->sum('total_harga');

        // Pendapatan minggu ini
        $pendapatanMingguan = Pemesanan::where('status_pemesanan', 'selesai')
            ->whereBetween('updated_at', [$startOfWeek, $now])
            ->sum('total_harga');

        // Pendapatan bulan ini
        $pendapatanBulanan = Pemesanan::where('status_pemesanan', 'selesai')
            ->whereMonth('updated_at', $now->month)
            ->whereYear('updated_at', $now->year)
            ->sum('total_harga');

        // Hitung label minggu & jumlah pesanan selesai per minggu (bulan ini)
        $startOfMonth = Carbon::now()->startOfMonth();
        $now = Carbon::now();

        $weeks = [];
        $labels = [];
        $data = [];

        $temp = $startOfMonth->copy();
        while ($temp->lt($now)) {
            $weekLabel = 'Minggu ' . $temp->weekOfMonth;
            $labels[] = $weekLabel;

            $start = $temp->copy()->startOfWeek();
            $end = $temp->copy()->endOfWeek();

            $count = Pemesanan::where('status_pemesanan', 'selesai')
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $data[] = $count;

            $temp->addWeek();
        }

        $start = Carbon::now()->startOfMonth();
        $now = Carbon::now();

        $labels = [];
        $orderCounts = [];
        $incomes = [];

        for ($i = 1; $i <= 5; $i++) {
            $startWeek = $start->copy()->addWeeks($i - 1)->startOfWeek();
            $endWeek = $start->copy()->addWeeks($i - 1)->endOfWeek();

            $labels[] = 'Minggu ' . $i;
            // Jumlah pesanan selesai
            $orderCounts[] = Pemesanan::where('status_pemesanan', 'selesai')
                ->whereBetween('created_at', [$startWeek, $endWeek])
                ->count();
            // Total pendapatan (sum total_harga pesanan selesai)
            $incomes[] = Pemesanan::where('status_pemesanan', 'selesai')
                ->whereBetween('created_at', [$startWeek, $endWeek])
                ->sum('total_harga');
        }

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'totalPelanggan',
            'recentOrders',
            'recentProducts',
            'recentPayments',
            'labels',
            'data',
            'orderCounts',
            'incomes',
            'totalPesananSelesai',
            'totalPesananBatal',
            'totalPesananAktif',
            'pendapatanBulanIni',
            'pendapatanHarian',
            'pendapatanMingguan',
            'pendapatanBulanan',
            'totalPesananMenunggu',
        ));
    }
}
