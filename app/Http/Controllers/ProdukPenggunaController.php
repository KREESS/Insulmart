<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produk;
use Illuminate\Support\Str;



class ProdukPenggunaController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        // query produk (sesuai kode kamu)
        $produks = Produk::with(['gambars', 'varians'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('nama_produk', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%")
                        ->orWhereHas('varians', function ($v) use ($q) {
                            $v->where('tipe', 'like', "%{$q}%");
                        });
                });
            })
            ->orderBy('nama_produk')
            ->get();

        // 👉 ambil quick tags dari kolom jenis_produk (unique, non-null)
        $suggestions = Produk::query()
            ->whereNotNull('jenis_produk')
            ->select('jenis_produk')
            ->distinct()
            ->orderBy('jenis_produk')
            ->pluck('jenis_produk')
            ->filter()
            ->values()
            ->all();

        return view('produk', compact('produks', 'suggestions'));
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
