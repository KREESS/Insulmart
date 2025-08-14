<?php

namespace App\Http\Controllers;

use App\Models\PembelianVarianProduk;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Distributor;

class PembelianVarianProdukController extends Controller
{
    public function index()
    {
        $pembelians = PembelianVarianProduk::with('varian.produk')
            ->orderBy('tanggal_beli', 'desc')
            ->get();
        return view('admin.pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        // Ambil varian beserta produk untuk dropdown
        $varians = VarianProduk::with(['produk:id,nama_produk'])
            ->orderByDesc('id')
            ->get(['id', 'produk_id', 'tipe', 'stok']); // sesuaikan kolom bila perlu

        // Ambil distributor aktif untuk dropdown
        $distributors = Distributor::where('is_active', true)
            ->orderBy('name_pt')
            ->get(['id', 'name_pt', 'contact_person', 'notes']);

        return view('admin.pembelian.create', compact('varians', 'distributors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'varian_id'       => ['required', 'exists:varian_produks,id'],
            'distributor_id'  => ['required', 'exists:distributors,id'], // wajib pilih distributor
            'qty'             => ['required', 'integer', 'min:1'],
            'harga_satuan'    => ['required', 'integer', 'min:0'],
            'tanggal_beli'    => ['required', 'date'],
            'status'          => [
                'required',
                Rule::in(['draft', 'dipesan', 'dikirim', 'diterima_sebagian', 'selesai', 'dibatalkan', 'dikembalikan_ke_supplier']),
            ],
            'catatan'         => ['nullable', 'string', 'max:255'],
        ]);

        // Hitung total dan normalisasi tanggal (WIB)
        $qty          = (int) $validated['qty'];
        $hargaSatuan  = (int) $validated['harga_satuan'];
        $total        = $qty * $hargaSatuan;

        $tanggalBeliWIB = Carbon::parse($validated['tanggal_beli'])
            ->setTimezone('Asia/Jakarta');

        // Simpan
        PembelianVarianProduk::create([
            'varian_id'      => $validated['varian_id'],
            'distributor_id' => $validated['distributor_id'],
            'qty'            => $qty,
            'harga_satuan'   => $hargaSatuan,
            'total_harga'    => $total,
            'tanggal_beli'   => $tanggalBeliWIB,
            'status'         => $validated['status'],
            'catatan'        => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->route('pembelian.index')
            ->with('success', 'Pembelian berhasil ditambahkan.');
    }

    public function show(PembelianVarianProduk $pembelian)
    {
        $pembelian->load('varian.produk');
        return view('admin.pembelian.show', compact('pembelian'));
    }

    public function edit(PembelianVarianProduk $pembelian)
    {
        $varians = VarianProduk::with('produk')->get();
        return view('admin.pembelian.edit', compact('pembelian', 'varians'));
    }

    public function update(Request $request, PembelianVarianProduk $pembelian)
    {
        $data = $request->validate([
            'varian_id'      => 'required|exists:varian_produks,id',
            'qty'            => 'required|integer|min:1',
            'harga_satuan'   => 'required|integer|min:0',
            'tanggal_beli'   => 'required|date',
            'status'         => 'required|in:draft,dipesan,dikirim,diterima_sebagian,selesai,dibatalkan,dikembalikan_ke_supplier',
            'catatan'        => 'nullable|string|max:255',
        ]);

        // Normalisasi field turunan
        $data['total_harga']  = $data['qty'] * $data['harga_satuan'];
        $data['tanggal_beli'] = Carbon::parse($data['tanggal_beli'])->setTimezone('Asia/Jakarta');

        DB::transaction(function () use ($pembelian, $data) {
            // Simpan nilai lama untuk menentukan penyesuaian stok
            $oldStatus   = $pembelian->getOriginal('status');
            $oldVarianId = $pembelian->getOriginal('varian_id');
            $oldQty      = (int) $pembelian->getOriginal('qty');

            $newStatus   = $data['status'];
            $newVarianId = (int) $data['varian_id'];
            $newQty      = (int) $data['qty'];

            // Update data pembelian dulu
            $pembelian->fill($data);
            $pembelian->save();

            // ==== LOGIKA PENYESUAIAN STOK ====
            // Kita kunci baris varian yang terdampak agar aman dari race condition
            $varianIdsToLock = array_unique([$oldVarianId, $newVarianId]);
            $varianMap = VarianProduk::whereIn('id', $varianIdsToLock)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // 1) Dari status selain 'selesai' -> ke 'selesai'  ==> stok naik (varian baru)
            if ($oldStatus !== 'selesai' && $newStatus === 'selesai') {
                $varian = $varianMap[$newVarianId];
                $varian->stok = ($varian->stok ?? 0) + $newQty;
                $varian->save();
                return; // selesai
            }

            // 2) Tetap 'selesai' -> 'selesai'
            if ($oldStatus === 'selesai' && $newStatus === 'selesai') {
                // a) Varian berganti: kurangi stok varian lama, tambah stok varian baru
                if ($oldVarianId !== $newVarianId) {
                    $oldVar = $varianMap[$oldVarianId];
                    $newVar = $varianMap[$newVarianId];

                    $oldVar->stok = ($oldVar->stok ?? 0) - $oldQty;
                    $oldVar->save();

                    $newVar->stok = ($newVar->stok ?? 0) + $newQty;
                    $newVar->save();
                } else {
                    // b) Varian sama: sesuaikan selisih qty
                    $diff = $newQty - $oldQty; // bisa + atau -
                    if ($diff !== 0) {
                        $varian = $varianMap[$newVarianId];
                        $varian->stok = ($varian->stok ?? 0) + $diff;
                        $varian->save();
                    }
                }
                return; // selesai
            }

            // 3) Dari 'selesai' -> status lain  ==> stok turunkan kembali (rollback)
            if ($oldStatus === 'selesai' && $newStatus !== 'selesai') {
                $varian = $varianMap[$oldVarianId];
                $varian->stok = ($varian->stok ?? 0) - $oldQty;
                $varian->save();
                return; // selesai
            }

            // 4) Transisi lain (draft/dipesan/dikirim/diterima_sebagian/dibatalkan/dikembalikan_ke_supplier)
            //     -> Tidak ada perubahan stok di sini (sesuaikan jika perlu).
        });

        return redirect()->route('pembelian.index')
            ->with('success', 'Pembelian berhasil diperbarui & stok disesuaikan.');
    }

    public function destroy(PembelianVarianProduk $pembelian)
    {
        $pembelian->delete();
        return redirect()->route('pembelian.index')
            ->with('success', 'Pembelian berhasil dihapus.');
    }

    public function downloadPo(PembelianVarianProduk $pembelian)
    {
        // Ambil relasi untuk isi PO
        $pembelian->load(['varian.produk']);

        $produk    = optional($pembelian->varian->produk)->nama_produk ?? '-';
        $kodePo    = 'PO-' . str_pad((string)$pembelian->id, 6, '0', STR_PAD_LEFT);
        $fileName  = $kodePo . '-' . Str::slug($produk, '-') . '.pdf';

        // Cek apakah dompdf tersedia
        $dompdfFacade = 'Barryvdh\\DomPDF\\Facade\\Pdf';

        if (class_exists($dompdfFacade)) {
            /** @var \Barryvdh\DomPDF\PDF $pdf */
            $pdf = $dompdfFacade::loadView('admin.pembelian.po', [
                'pembelian' => $pembelian,
                'kodePo'    => $kodePo,
            ])->setPaper('A4', 'portrait');

            // STREAM (preview di browser), bukan download
            return $pdf->stream($fileName); // tampil inline (user bisa klik download dari viewer)
        }

        // Fallback: tampilkan HTML (tanpa attachment)
        $html = view('admin.pembelian.po', [
            'pembelian' => $pembelian,
            'kodePo'    => $kodePo,
        ])->render();

        return response($html, 200)
            ->header('Content-Type', 'text/html; charset=utf-8');
    }
}
