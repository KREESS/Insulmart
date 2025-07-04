<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        return view('admin.produk'); // atau sesuai path view kamu
    }

    // Tampilkan form tambah produk
    public function create()
    {
        return view('admin.tambah-produk'); // arahkan ke form tambah produk
    }

    // Simpan data produk (opsional jika kamu mau CRUD lengkap)
    public function store(Request $request)
    {
        // Validasi sederhana
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|max:2048'
        ]);

        // Simpan gambar
        $gambar = $request->file('gambar')->store('produk', 'public');

        // Simpan ke database (jika sudah ada model Produk)
        // Produk::create([
        //     'nama' => $request->nama,
        //     'deskripsi' => $request->deskripsi,
        //     'harga' => $request->harga,
        //     'gambar' => $gambar,
        // ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }
}
