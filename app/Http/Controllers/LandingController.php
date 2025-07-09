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
}
