<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\VarianProduk;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\PembayaranPemesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;

class PesananController extends Controller
{
    public function index()
    {
        $listPemesanan = Pemesanan::with('pembayaran')
            ->where('pengguna_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();
        $produks = Produk::with(['gambars', 'varians'])->get();

        return view('pelanggan.pemesanan.index', compact('listPemesanan', 'produks'));
    }

    public function storeVarian(Request $request)
    {
        $user = Auth::user();

        // Validasi input varian dan jumlah
        $request->validate([
            'varians' => 'required|array',
            'varians.*.selected' => 'required|boolean',
            'varians.*.qty' => 'required|integer|min:1',
        ]);

        // Cari atau buat quotation draft
        $quotation = Quotation::firstOrCreate([
            'user_id' => $user->id,
            'status' => 'draft'
        ], [
            'kode_quotation' => 'QT-' . strtoupper(Str::random(6)),
            'alamat_pengiriman' => $request->input('alamat_pengiriman', ''), // Alamat pengiriman
            'catatan_tambahan' => $request->input('catatan_tambahan', ''), // Catatan tambahan
            'total_harga' => 0,
            'termin_count' => 0,
        ]);

        $totalHarga = 0;

        // Loop untuk menyimpan detail varian produk ke dalam quotation
        foreach ($request->varians as $varianId => $data) {
            if (!isset($data['selected']) || !$data['selected']) continue;

            // Validasi jumlah stok
            $qty = (int) $data['qty'];
            $varian = VarianProduk::findOrFail($varianId);

            if ($varian->stok < $qty) {
                return back()->with('error', 'Stok tidak mencukupi untuk varian ' . $varian->tipe);
            }

            // Simpan detail ke quotation_detail
            QuotationDetail::create([
                'quotation_id' => $quotation->id,
                'product_id' => $varian->produk_id,
                'varian_produk_id' => $varian->id,
                'qty' => $qty,
                'harga_satuan' => $varian->harga,
                'subtotal' => $qty * $varian->harga,
            ]);

            $totalHarga += $qty * $varian->harga;
        }

        // Update total harga quotation
        $quotation->update(['total_harga' => $totalHarga]);

        // Redirect ke halaman detail quotation
        return redirect()->route('quotation.show', $quotation->id)->with('success', 'Produk berhasil ditambahkan!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'selected_items'     => 'required|array',
            'metode_pembayaran'  => 'required|in:termin_1x_lunas,termin_2x,termin_3x',
            'catatan'            => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        // 1) Ambil alamat default
        $alamat = $user->alamatPenggunas()->where('is_default', true)->first();
        if (! $alamat) {
            return back()->withErrors(['Alamat belum diset sebagai default.']);
        }

        // 2) Ambil cart dan filter item
        $cart = Cart::where('user_id', $user->id)
            ->with('items.varianProduk.produk.gambars')
            ->firstOrFail();

        $items = $cart->items->whereIn('id', $request->selected_items);
        if ($items->isEmpty()) {
            return back()->withErrors(['Tidak ada item yang dipilih.']);
        }

        // 3) Hitung total
        $total = $items->sum(fn($it) => $it->quantity * $it->price);

        DB::beginTransaction();
        try {
            // 4) Generate kode unik
            do {
                $kode = 'INS' . now()->format('YmdHis') . Str::upper(Str::random(4));
            } while (Pemesanan::where('kode_pemesanan', $kode)->exists());

            // 5) Simpan header pemesanan
            $pemesanan = Pemesanan::create([
                'kode_pemesanan'        => $kode,
                'pengguna_id'           => $user->id,
                'alamat_pengiriman_id'  => $alamat->id,
                'tanggal_pemesanan'     => now(),
                'total_harga'           => $total,
                'metode_pembayaran'     => $request->metode_pembayaran,
                'catatan_pelanggan'     => $request->catatan,
                'status_po'             => 'menunggu',
                'status_pemesanan'      => 'menunggu',
            ]);

            // 6) Simpan detail baris
            foreach ($items as $it) {
                DetailPemesanan::create([
                    'pemesanan_id'     => $pemesanan->id,
                    'varian_produk_id' => $it->varian_produk_id,
                    'kuantitas'        => $it->quantity,
                    'harga_satuan'     => $it->price,
                    'subtotal'         => $it->quantity * $it->price,
                ]);
            }

            // 7) Siapkan termin berdasarkan metode
            $terms = match ($request->metode_pembayaran) {
                'termin_2x' => 2,
                'termin_3x' => 3,
                default     => 1,
            };

            // Hitung besar termin 1 => 50% total. Sisanya dibagi rata ke termin lain.
            if ($terms > 1) {
                $firstAmount = round($total * 0.5, 2);
                $remaining   = $total - $firstAmount;
                $restAmount  = round($remaining / ($terms - 1), 2);
            } else {
                // Untuk termin tunggal: penuh
                $firstAmount = $total;
            }

            for ($i = 1; $i <= $terms; $i++) {
                if ($i === 1) {
                    $amount = $firstAmount;
                } elseif ($i < $terms) {
                    $amount = $restAmount;
                } else {
                    // Pastikan jumlahnya tepat dengan memperhitungkan pembulatan
                    $sumPrev = $firstAmount + ($restAmount * ($terms - 2));
                    $amount  = $total - $sumPrev;
                }

                PembayaranPemesanan::create([
                    'pemesanan_id'      => $pemesanan->id,
                    'termin_ke'         => $i,
                    'jumlah_dibayar'    => $amount,
                    'tanggal_pembayaran' => null,
                    'status_verifikasi' => 'menunggu',
                ]);
            }

            // 8) Hapus cart items
            CartItem::whereIn('id', $request->selected_items)->delete();

            DB::commit();

            return redirect()
                ->route('pemesanan.pembayaran', ['pemesanan_id' => $pemesanan->id])
                ->with('success', 'Checkout berhasil. Silakan unggah PO dan bukti pembayaran.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['Terjadi kesalahan saat checkout: ' . $e->getMessage()]);
        }
    }

    public function pembayaran($pemesanan_id)
    {
        $user = auth()->user();

        // Ambil pemesanan sesuai ID dan milik user ini
        $pemesanan = Pemesanan::where('id', $pemesanan_id)
            ->where('pengguna_id', $user->id)
            ->with('pembayaran') // relasi pembayaran_pemesanan
            ->firstOrFail();

        if (!$pemesanan) {
            return redirect()->route('pemesanan.index')->with('error', 'Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        // Jika memang butuh daftar produk (misal untuk dropdown), bisa tetap diambil
        $produks = Produk::with(['gambars', 'varians'])->get();

        return view('pelanggan.pemesanan.pembayaran', compact('pemesanan', 'produks'));
    }

    public function uploadPO(Request $request, $id)
    {
        $request->validate([
            'file_po'  => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'nomor_po' => 'required|string|max:255',
        ]);

        $pemesanan = Pemesanan::where('id', $id)->where('pengguna_id', auth()->id())->firstOrFail();

        $path = $request->file('file_po')->store('po', 'public');
        $pemesanan->update([
            'file_po'   => $path,
            'nomor_po'  => $request->nomor_po,
            'status_po' => 'menunggu'
        ]);

        return back()->with('success', 'File PO dan Nomor PO berhasil diunggah.');
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_transfer' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pembayaran = PembayaranPemesanan::where('id', $id)
            ->whereHas('pemesanan', function ($q) {
                $q->where('pengguna_id', auth()->id());
            })->firstOrFail();

        $path = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
        $pembayaran->update([
            'bukti_transfer' => $path,
            'tanggal_pembayaran' => now(),
            'status_verifikasi' => 'menunggu',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    public function hapusBukti($id)
    {
        $userId = auth()->id();

        $pembayaran = PembayaranPemesanan::where('id', $id)
            ->whereHas('pemesanan', function ($q) use ($userId) {
                $q->where('pengguna_id', $userId);
            })->firstOrFail();

        // Hapus file dari storage jika ada
        if ($pembayaran->bukti_transfer && Storage::disk('public')->exists($pembayaran->bukti_transfer)) {
            Storage::disk('public')->delete($pembayaran->bukti_transfer);
        }

        // Reset kolom
        $pembayaran->update([
            'bukti_transfer' => null,
            'status_verifikasi' => 'menunggu',
            'tanggal_pembayaran' => null,
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil dihapus.');
    }

    public function hapusPO($id)
    {
        $pemesanan = Pemesanan::where('id', $id)
            ->where('pengguna_id', auth()->id())
            ->firstOrFail();

        if ($pemesanan->file_po && Storage::disk('public')->exists($pemesanan->file_po)) {
            Storage::disk('public')->delete($pemesanan->file_po);
        }

        $pemesanan->update([
            'file_po' => null,
            'status_po' => 'menunggu',
        ]);

        return back()->with('success', 'File PO berhasil dihapus.');
    }

    public function detail($pemesanan_id)
    {
        $user = auth()->user();

        // Ownership check!
        $pesanan = Pemesanan::with([
            'detailPemesanan.varianProduk.produk.gambars',
            'pembayaran'
        ])
            ->where('id', $pemesanan_id)
            ->where('pengguna_id', $user->id)
            ->firstOrFail();

        $produks = Produk::with(['gambars', 'varians'])->get();

        return view('pelanggan.pemesanan.detail', compact('pesanan', 'produks'));
    }


    public function invoice(Request $request, $id)
    {
        $terminKe = $request->query('termin'); // Contoh ?termin=2

        $user = auth()->user();

        $pemesanan = Pemesanan::with([
            'pengguna',
            'alamatPengiriman',
            'detailPemesanan.varianProduk.produk.gambars',
            'pembayaran'
        ])
            ->where('id', $id)
            ->where('pengguna_id', $user->id) // Ownership check!
            ->firstOrFail();

        // Ambil termin yang dipilih
        $termin = $pemesanan->pembayaran
            ->where('termin_ke', $terminKe)
            ->first();

        if (!$termin) {
            abort(404, 'Termin pembayaran tidak ditemukan.');
        }

        $pdf = Pdf::loadView('pelanggan.pemesanan.invoice', compact('pemesanan', 'termin'))
            ->setPaper('A4', 'portrait');

        $filename = 'Invoice-' . ($pemesanan->kode_pemesanan ?? $pemesanan->id) . '-Termin' . $terminKe . '.pdf';

        return $pdf->stream($filename);
    }
}
