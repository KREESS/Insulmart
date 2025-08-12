<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AdminPesananController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Pemesanan::with([
            'pengguna', // relasi ke tabel users (pelanggan) --> BUKAN 'user'
            'detailPemesanan.varianProduk', // detail_pemesanan + varian_produk
            'pembayaran', // relasi ke pembayaran_pemesanan (bukan pembayaranPemesanan)
        ]);

        // Filter search jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pengguna', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                })
                    ->orWhere('kode_pemesanan', 'like', "%$search%");
            });
        }
        // Filter status jika ada
        if ($request->filled('status')) {
            $query->where('status_pemesanan', $request->status);
        }

        $pemesanans = $query->latest()->paginate(12);

        // Tidak ada variabel $pengguna di compact!
        return view('admin.pesanan.index', compact('pemesanans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pemesanan' => 'required|in:menunggu,diproses,selesai,dibatalkan'
        ]);
        $pesanan = \App\Models\Pemesanan::findOrFail($id);
        $pesanan->status_pemesanan = $request->status_pemesanan;
        $pesanan->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Status pesanan berhasil diupdate.');
    }

    public function updateStatusPo(Request $request, $id)
    {
        $request->validate([
            'status_po' => 'required|in:belum upload,menunggu,disetujui,ditolak'
        ]);
        $pesanan = \App\Models\Pemesanan::findOrFail($id);

        // Opsional: Jika file_po kosong, paksa ke "belum upload"
        if (empty($pesanan->file_po)) {
            $pesanan->status_po = 'belum upload';
        } else {
            $pesanan->status_po = $request->status_po;
        }
        $pesanan->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Status PO berhasil diupdate.');
    }

    public function updateStatusVerif(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:diterima,menunggu,ditolak'
        ]);
        $bayar = \App\Models\PembayaranPemesanan::findOrFail($id);
        $bayar->status_verifikasi = $request->status_verifikasi;
        $bayar->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Status verifikasi pembayaran berhasil diupdate.');
    }

    public function updateCatatan(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:250'
        ]);
        $bayar = \App\Models\PembayaranPemesanan::findOrFail($id);
        $bayar->catatan_admin = $request->catatan_admin;
        $bayar->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Catatan berhasil diupdate.');
    }

    public function export(Request $request)
    {
        $query = \App\Models\Pemesanan::with(['pengguna', 'detailPemesanan.varianProduk', 'pembayaran']);

        // Jika user klik "Ekspor Semua", jangan pakai filter
        if (!$request->filled('all')) {
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereHas('pengguna', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    })
                        ->orWhere('kode_pemesanan', 'like', "%$search%");
                });
            }
            if ($request->filled('status')) {
                $query->where('status_pemesanan', $request->status);
            }
        }

        $data = $query->get();

        // Laravel Excel, misal: composer require maatwebsite/excel
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\PemesananExport($data), 'pesanan.xlsx');
    }

    public function suratJalan($id)
    {
        $pemesanan = \App\Models\Pemesanan::with([
            'pengguna',
            'detailPemesanan.varianProduk.produk',
            'alamatPengiriman'
        ])->findOrFail($id);

        // Verify status
        if (!in_array($pemesanan->status_pemesanan, ['diproses', 'selesai'])) {
            return back()->with('error', 'Surat jalan hanya dapat diakses untuk pesanan yang diproses atau selesai.');
        }

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.pesanan.surat-jalan', compact('pemesanan'));

        // Set paper
        $pdf->setPaper('A4', 'portrait');

        // Download PDF with name
        return $pdf->stream('Surat_Jalan_' . $pemesanan->kode_pemesanan . '.pdf');
    }
}
