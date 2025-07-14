<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produk;
use Illuminate\Support\Str;



class ProdukPenggunaController extends Controller
{
    public function index()
    {
        $products = Produk::with(['gambars', 'varians'])->get();
        return view('produk', compact('products'));
    }


    public function detail($slug)
    {
        $produk = Produk::with(['gambars', 'varians'])->get()
            ->first(function ($item) use ($slug) {
                return Str::slug($item->nama_produk) === $slug;
            });

        if (!$produk) {
            abort(404);
        }

        return view('detail-produk', compact('produk'));
    }
}
