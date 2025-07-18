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
        $produks = Produk::with(['gambars', 'varians'])->get();
        return view('katalog-produk', compact('produks'));
    }

    public function galeri()
    {
        $produks = Produk::with(['gambars', 'varians'])->get();
        return view('galeri', compact('produks'));
    }

    public function kontak()
    {
        $produks = Produk::with(['gambars', 'varians'])->get();
        return view('hubungi-kami', compact('produks'));
    }
}
