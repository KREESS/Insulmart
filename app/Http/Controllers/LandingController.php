<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produk;

class LandingController extends Controller
{
    public function index()
    {
        $produks = Produk::with(['gambars', 'varians'])->get();
        return view('welcome', compact('produks'));
    }

    public function katalog()
    {
        $products = Produk::with(['gambars', 'varians'])->get();
        return view('katalog-produk', compact('products'));
    }

    public function galeri()
    {
        return view('galeri');
    }

    public function kontak()
    {
        return view('hubungi-kami');
    }
}
