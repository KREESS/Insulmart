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

class PesananController extends Controller
{
    public function penawaran()
    {
        return view('pelanggan.penawaran');
    }

    public function riwayat()
    {
        return view('pelanggan.riwayat-pemesanan');
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
}
