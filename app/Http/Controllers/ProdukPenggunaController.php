<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class ProdukPenggunaController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        // --- Ambil quick tags dari kolom jenis_produk (TRIM + unik + urut) ---
        // Pakai pluck() biar hasilnya Collection<string>
        $suggestions = Produk::query()
            ->whereNotNull('jenis_produk')
            ->selectRaw('TRIM(jenis_produk) AS jp')
            ->whereRaw('TRIM(jenis_produk) <> ""')
            ->groupBy('jp')
            ->orderBy('jp')
            ->pluck('jp'); // Collection of strings

        // Deteksi apakah "q" sama persis dengan salah satu jenis (setelah trim+lower)
        $normalizedJenis = $suggestions->map(fn($v) => mb_strtolower(trim($v)))->all();
        $qLower = mb_strtolower($q);
        $isJenisExact = ($q !== '') && in_array($qLower, $normalizedJenis, true);

        // --- Builder produk ---
        $produkQuery = Produk::query();

        if ($q !== '') {
            // Escape wildcard utk LIKE
            $needle = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q) . '%';

            if ($isJenisExact) {
                // MODE EXACT JENIS: tampilkan SEMUA item jenis tsb (tanpa kepotong keyword lain)
                $produkQuery->whereRaw('LOWER(TRIM(jenis_produk)) = ?', [$qLower]);
            } else {
                // MODE PENCARIAN UMUM: nama/sku/deskripsi/jenis (LIKE & exact) + varian
                $produkQuery->where(function ($root) use ($needle, $qLower) {
                    $root->where(function ($w) use ($needle, $qLower) {
                        $w->where('nama_produk', 'like', $needle)
                            ->orWhere('sku', 'like', $needle)
                            ->orWhere('deskripsi', 'like', $needle)
                            ->orWhere('jenis_produk', 'like', $needle)
                            ->orWhereRaw('LOWER(TRIM(jenis_produk)) = ?', [$qLower]);
                    })
                        ->orWhereHas('varians', function ($v) use ($needle) {
                            $v->where('nama_varian', 'like', $needle)
                                ->orWhere('kode_varian', 'like', $needle);
                        })
                        ->orWhereHas('varianProduks', function ($v) use ($needle) {
                            $v->where('nama_varian', 'like', $needle)
                                ->orWhere('kode_varian', 'like', $needle);
                        });
                });
            }
        }

        // Eager-load relasi yang mungkin ada (aman buat blade)
        $withRels = [];
        if (method_exists(Produk::class, 'gambars'))        $withRels[] = 'gambars';
        if (method_exists(Produk::class, 'varians'))        $withRels[] = 'varians';
        if (method_exists(Produk::class, 'varianProduks'))  $withRels[] = 'varianProduks';

        // Urut & paginate (pakai withQueryString biar q nempel)
        $produks = $produkQuery
            ->with($withRels)
            ->orderByDesc('created_at')
            ->paginate(24)
            ->withQueryString();

        // Cart (aman kalau belum login)
        $cart = Auth::check()
            ? (Auth::user()->cart ?? Cart::firstOrCreate(['user_id' => Auth::id()]))
            : null;

        // NOTE: sesuaikan nama view sesuai punyamu (di contoh terakhir kamu pakai 'produk')
        return view('produk', compact('produks', 'suggestions', 'cart'));
    }

    public function detail($slug)
    {
        $produk = Produk::with(['gambars', 'varians'])->get()
            ->first(function ($item) use ($slug) {
                return Str::slug($item->nama_produk) === $slug;
            });
        $produks = Produk::with(['gambars', 'varians'])->get();
        $cartCount = auth()->check() && auth()->user()->cart
            ? auth()->user()->cart->items()->sum('quantity')
            : 0;

        if (!$produk) {
            abort(404);
        }

        return view('detail-produk', compact('produk', 'produks', 'cartCount'));
    }
}
