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
use Barryvdh\DomPDF\Facade\Pdf;

class PembelianVarianProdukController extends Controller
{
    public function index()
    {
        // 1) Ambil grup per PO
        $groups = PembelianVarianProduk::query()
            ->with(['distributor:id,name_pt,contact_person'])
            ->select(
                'po_code',
                'distributor_id',
                DB::raw('COUNT(*) as items'),
                DB::raw('SUM(total_harga) as grand_total'),
                DB::raw('MIN(tanggal_beli) as first_date'),
                DB::raw('MAX(tanggal_beli) as last_date')
            )
            ->groupBy('po_code', 'distributor_id')
            ->orderByDesc('last_date')
            ->paginate(10);

        // 2) Ambil item untuk semua po_code yang tampil di halaman ini agar efisien
        $poCodes = $groups->pluck('po_code')->all();

        $itemsByPo = PembelianVarianProduk::with([
            'varian.produk:id,nama_produk',
            'distributor:id,name_pt,contact_person'
        ])
            ->whereIn('po_code', $poCodes)
            ->orderBy('tanggal_beli')
            ->get()
            ->groupBy('po_code');

        // === Ringkasan Pengeluaran (hanya status selesai) ===
        $tz = 'Asia/Jakarta';
        $now = Carbon::now($tz);

        $todayStart = $now->copy()->startOfDay();
        $todayEnd   = $now->copy()->endOfDay();

        $weekStart  = $now->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd    = $now->copy()->endOfWeek(Carbon::SUNDAY);

        $monthStart = $now->copy()->startOfMonth();
        $monthEnd   = $now->copy()->endOfMonth();

        $yearStart  = $now->copy()->startOfYear();
        $yearEnd    = $now->copy()->endOfYear();

        $pengeluaran = [
            'harian'   => PembelianVarianProduk::where('status', 'selesai')
                ->whereBetween('updated_at', [$todayStart, $todayEnd])
                ->sum('total_harga'),
            'mingguan' => PembelianVarianProduk::where('status', 'selesai')
                ->whereBetween('updated_at', [$weekStart, $weekEnd])
                ->sum('total_harga'),
            'bulanan'  => PembelianVarianProduk::where('status', 'selesai')
                ->whereBetween('updated_at', [$monthStart, $monthEnd])
                ->sum('total_harga'),
            'tahunan'  => PembelianVarianProduk::where('status', 'selesai')
                ->whereBetween('updated_at', [$yearStart, $yearEnd])
                ->sum('total_harga'),
        ];

        // === Counter order per status ===
        $statusCounts = PembelianVarianProduk::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status'); // hasil: ['draft'=>x, 'dipesan'=>y, ...]

        // Tambahan ringkasan "sedang berjalan" (opsional)
        $runningStatuses = ['draft', 'dipesan', 'dikirim', 'diterima_sebagian'];
        $sedangBerjalanCount = PembelianVarianProduk::whereIn('status', $runningStatuses)->count();
        $selesaiCount = (int) ($statusCounts['selesai'] ?? 0);

        return view('admin.pembelian.index', [
            'groups'             => $groups,
            'itemsByPo'          => $itemsByPo,
            'pengeluaran'        => $pengeluaran,
            'statusCounts'       => $statusCounts,
            'selesaiCount'       => $selesaiCount,
            'sedangBerjalanCount' => $sedangBerjalanCount,
        ]);
    }

    public function create(Request $request)
    {
        // Ambil varian beserta produk untuk dropdown
        $varians = VarianProduk::with(['produk:id,nama_produk'])
            ->orderByDesc('id')
            ->get(['id', 'produk_id', 'tipe', 'stok']);

        // Ambil distributor aktif untuk dropdown
        $distributors = Distributor::where('is_active', true)
            ->orderBy('name_pt')
            ->get(['id', 'name_pt', 'contact_person', 'notes']);

        // Jika sedang menambahkan item ke PO yang sama
        $activePoCode = $request->query('po_code');

        return view('admin.pembelian.create', compact('varians', 'distributors', 'activePoCode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'po_code'         => ['nullable', 'string', 'max:30'],
            'varian_id'       => ['required', 'exists:varian_produks,id'],
            'distributor_id'  => ['required', 'exists:distributors,id'],
            'qty'             => ['required', 'integer', 'min:1'],
            'harga_satuan'    => ['required', 'integer', 'min:0'],
            'tanggal_beli'    => ['required', 'date'],
            'status'          => [
                'required',
                Rule::in(['draft', 'dipesan', 'dikirim', 'diterima_sebagian', 'selesai', 'dibatalkan', 'dikembalikan_ke_supplier']),
            ],
            'catatan'         => ['nullable', 'string', 'max:255'],
        ]);

        // Hitung total & normalisasi tanggal (WIB)
        $qty         = (int) $validated['qty'];
        $hargaSatuan = (int) $validated['harga_satuan'];
        $total       = $qty * $hargaSatuan;

        $tanggalBeliWIB = Carbon::parse($validated['tanggal_beli'])
            ->setTimezone('Asia/Jakarta');

        // Generate po_code jika kosong
        $poCode = trim($validated['po_code'] ?? '');
        if ($poCode === '') {
            // format: PO-YYYYMMDD-ABCDE (acak)
            $poCode = 'PO-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // (opsional) pastikan unik sederhana
            while (PembelianVarianProduk::where('po_code', $poCode)->exists()) {
                $poCode = 'PO-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            }
        }

        PembelianVarianProduk::create([
            'po_code'       => $poCode,
            'varian_id'     => $validated['varian_id'],
            'distributor_id' => $validated['distributor_id'],
            'qty'           => $qty,
            'harga_satuan'  => $hargaSatuan,
            'total_harga'   => $total,
            'tanggal_beli'  => $tanggalBeliWIB,
            'status'        => $validated['status'],
            'catatan'       => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->route('pembelian.index')
            ->with('success', 'Pembelian berhasil ditambahkan. Kode PO: ' . $poCode);
    }

    public function show(PembelianVarianProduk $pembelian)
    {
        $pembelian->load('varian.produk');
        return view('admin.pembelian.show', compact('pembelian'));
    }

    public function edit(PembelianVarianProduk $pembelian)
    {
        $varians = VarianProduk::with('produk:id,nama_produk')->get(['id', 'produk_id', 'tipe']);
        $distributors = Distributor::where('is_active', true)
            ->orderBy('name_pt')
            ->get(['id', 'name_pt', 'contact_person', 'notes']);

        return view('admin.pembelian.edit', compact('pembelian', 'varians', 'distributors'));
    }

    public function update(Request $request, PembelianVarianProduk $pembelian)
    {
        // 1) Validasi input (tetap lengkap, karena pada UI field yang dikunci tetap dikirim via hidden/readonly)
        $data = $request->validate([
            'varian_id'       => 'required|exists:varian_produks,id',
            'distributor_id'  => 'required|exists:distributors,id',
            'qty'             => 'required|integer|min:1',
            'harga_satuan'    => 'required|integer|min:0',
            'tanggal_beli'    => 'required|date',
            'status'          => 'required|in:draft,dipesan,dikirim,diterima_sebagian,selesai,dibatalkan,dikembalikan_ke_supplier',
            'catatan'         => 'nullable|string|max:255',
        ]);

        $terminalStatuses = ['selesai', 'dibatalkan', 'dikembalikan_ke_supplier'];
        $progressStatuses = ['dipesan', 'dikirim', 'diterima_sebagian'];

        // 2) Jika status lama terminal → tolak semua perubahan
        if (in_array($pembelian->status, $terminalStatuses, true)) {
            return back()
                ->withErrors(['status' => 'Transaksi berstatus final (' . $pembelian->status . '). Data tidak dapat diubah.'])
                ->withInput();
        }

        // 3) Normalisasi dasar
        $data['tanggal_beli'] = Carbon::parse($data['tanggal_beli'])->setTimezone('Asia/Jakarta');

        // 4) Jika status lama progress → hanya izinkan ganti status. Field lain dikunci di server.
        if (in_array($pembelian->status, $progressStatuses, true)) {
            $data = array_merge($pembelian->only([
                'varian_id',
                'distributor_id',
                'qty',
                'harga_satuan',
                'tanggal_beli',
                'catatan'
            ]), [
                'status' => $data['status'],
            ]);

            // Hitung ulang total_harga dari nilai lama (qty & harga_satuan tidak berubah)
            $data['total_harga'] = (int)($pembelian->qty) * (int)($pembelian->harga_satuan);
        } else {
            // status lama draft → bebas edit, hitung total_harga dari input baru
            $data['total_harga'] = (int) $data['qty'] * (int) $data['harga_satuan'];
        }

        // 5) Simpan + penyesuaian stok (transaction + row locking)
        DB::transaction(function () use ($pembelian, $data) {
            // Snapshot lama
            $oldStatus   = $pembelian->getOriginal('status');
            $oldVarianId = (int) $pembelian->getOriginal('varian_id');
            $oldQty      = (int) $pembelian->getOriginal('qty');

            // Update model
            $pembelian->fill($data);
            $pembelian->save();

            // Nilai baru (setelah fill/save)
            $newStatus   = $pembelian->status;
            $newVarianId = (int) $pembelian->varian_id;
            $newQty      = (int) $pembelian->qty;

            // Kunci baris varian terdampak
            $varianIdsToLock = array_unique([$oldVarianId, $newVarianId]);
            $varianMap = \App\Models\VarianProduk::whereIn('id', $varianIdsToLock)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // === LOGIKA PENYESUAIAN STOK ===
            // (A) non-selesai -> selesai : stok varian baru bertambah
            if ($oldStatus !== 'selesai' && $newStatus === 'selesai') {
                if (isset($varianMap[$newVarianId])) {
                    $v = $varianMap[$newVarianId];
                    $v->stok = (int)($v->stok ?? 0) + $newQty;
                    $v->save();
                }
                return;
            }

            // (B) tetap di 'selesai'
            if ($oldStatus === 'selesai' && $newStatus === 'selesai') {
                if ($oldVarianId !== $newVarianId) {
                    if (isset($varianMap[$oldVarianId])) {
                        $vv = $varianMap[$oldVarianId];
                        $vv->stok = (int)($vv->stok ?? 0) - $oldQty;
                        $vv->save();
                    }
                    if (isset($varianMap[$newVarianId])) {
                        $vn = $varianMap[$newVarianId];
                        $vn->stok = (int)($vn->stok ?? 0) + $newQty;
                        $vn->save();
                    }
                } else {
                    $diff = $newQty - $oldQty;
                    if ($diff !== 0 && isset($varianMap[$newVarianId])) {
                        $v = $varianMap[$newVarianId];
                        $v->stok = (int)($v->stok ?? 0) + $diff;
                        $v->save();
                    }
                }
                return;
            }

            // (C) dari 'selesai' -> non-selesai : rollback stok varian lama
            if ($oldStatus === 'selesai' && $newStatus !== 'selesai') {
                if (isset($varianMap[$oldVarianId])) {
                    $v = $varianMap[$oldVarianId];
                    $v->stok = (int)($v->stok ?? 0) - $oldQty;
                    $v->save();
                }
                return;
            }

            // (D) antar status non-selesai: stok tidak berubah
        });

        return redirect()
            ->route('pembelian.index')
            ->with('success', 'Pembelian berhasil diperbarui & stok disesuaikan.');
    }

    public function destroy(PembelianVarianProduk $pembelian)
    {
        $pembelian->delete();
        return redirect()->route('pembelian.index')
            ->with('success', 'Pembelian berhasil dihapus.');
    }

    public function downloadPoByCode(string $po_code)
    {
        // Ambil semua item untuk po_code ini
        $items = PembelianVarianProduk::with(['varian.produk', 'distributor'])
            ->where('po_code', $po_code)
            ->orderBy('tanggal_beli')
            ->get();

        if ($items->isEmpty()) {
            abort(404, 'PO tidak ditemukan atau belum memiliki item.');
        }

        // Supplier (distributor) — asumsi 1 PO = 1 distributor
        $supplier = optional($items->first())->distributor;

        // Ringkasan
        $grandTotal = (int) $items->sum('total_harga');
        $totalQty   = (int) $items->sum('qty');

        // Rentang tanggal
        $firstDate = $items->min('tanggal_beli');
        $lastDate  = $items->max('tanggal_beli');

        $fileName = $po_code . '-' . Str::slug(optional($supplier)->name_pt ?? 'po', '-') . '.pdf';

        if (class_exists(Pdf::class)) {
            $pdf = Pdf::loadView('admin.pembelian.po', [
                'po_code'    => $po_code,
                'items'      => $items,
                'supplier'   => $supplier,
                'grandTotal' => $grandTotal,
                'totalQty'   => $totalQty,
                'firstDate'  => $firstDate,
                'lastDate'   => $lastDate,
            ])->setPaper('A4', 'portrait');

            return $pdf->stream($fileName);  // tampil inline
        }

        // Fallback HTML bila dompdf belum tersedia
        return response(
            view('admin.pembelian.po', [
                'po_code'    => $po_code,
                'items'      => $items,
                'supplier'   => $supplier,
                'grandTotal' => $grandTotal,
                'totalQty'   => $totalQty,
                'firstDate'  => $firstDate,
                'lastDate'   => $lastDate,
            ])->render(),
            200
        )->header('Content-Type', 'text/html; charset=utf-8');
    }
}
