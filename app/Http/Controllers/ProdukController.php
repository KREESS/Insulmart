<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('varians')->get();
        return view('admin.produk', compact('produks'));
    }

    // Tampilkan form tambah produk
    public function create()
    {
        return view('admin.tambah-produk');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis_produk' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'gambar'       => 'required|array|min:3',
            'gambar.*'     => 'image|max:2048',
            'varian'       => 'required|array',
            'varian.*.tipe'      => 'required|string',
            'varian.*.ukuran'    => 'required|string',
            'varian.*.ketebalan' => 'required|numeric',
            'varian.*.densitas'  => 'required|numeric',
            'varian.*.harga'     => 'required|numeric',
            'varian.*.stok'      => 'required|numeric',
        ]);

        // Tentukan jenis produk
        $jenisProduk = $request->jenis_produk !== 'lainnya'
            ? $request->jenis_produk
            : $request->jenis_produk_baru;

        // Simpan data produk utama (tanpa gambar karena gambar masuk tabel terpisah)
        $produk = Produk::create([
            'nama_produk'  => $request->nama_produk,
            'jenis_produk' => $jenisProduk,
            'deskripsi'    => $request->deskripsi,
        ]);

        // Simpan gambar-gambar ke tabel gambar_produks
        foreach ($request->file('gambar') as $image) {
            $path = $image->store('produk', 'public');
            $produk->gambars()->create([
                'path' => $path
            ]);
        }

        // Simpan semua varian produk
        foreach ($request->varian as $v) {
            $produk->varians()->create([
                'tipe'      => $v['tipe'],
                'ukuran'    => $v['ukuran'],
                'ketebalan' => $v['ketebalan'],
                'densitas'  => $v['densitas'],
                'harga'     => $v['harga'],
                'stok'      => $v['stok'],
            ]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk dan variannya berhasil ditambahkan!');
    }

    public function show(Produk $produk)
    {
        return view('admin.detail-produk', compact('produk'));
    }

    public function edit($id)
    {
        $produk = Produk::with(['gambars', 'varians'])->findOrFail($id);
        return view('admin.edit-produk', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis_produk' => 'required|string',
            'jenis_produk_baru' => $request->jenis_produk === 'lainnya' ? 'required|string|max:255' : 'nullable',
            'deskripsi' => 'nullable|string',
            'varian' => 'nullable|array',
            'varian.*.tipe' => 'required_with:varian|string',
            'varian.*.ukuran' => 'required_with:varian|string',
            'varian.*.ketebalan' => 'required_with:varian|numeric',
            'varian.*.densitas' => 'required_with:varian|numeric',
            'varian.*.harga' => 'required_with:varian|numeric',
            'varian.*.stok' => 'required_with:varian|numeric',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $produk = Produk::findOrFail($id);

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'jenis_produk' => $request->jenis_produk === 'lainnya' ? $request->jenis_produk_baru : $request->jenis_produk,
            'deskripsi' => $request->deskripsi,
        ]);

        // Update varian
        $produk->varians()->delete();
        if ($request->has('varian')) {
            foreach ($request->varian as $v) {
                $produk->varians()->create($v);
            }
        }

        // Simpan gambar baru jika diupload
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('produk', 'public');
                $produk->gambars()->create(['path' => $path]);
            }
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroyGambar($id)
    {
        $gambar = ProdukGambar::findOrFail($id);
        if (Storage::exists('public/' . $gambar->path)) {
            Storage::delete('public/' . $gambar->path);
        }
        $gambar->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus gambar-gambar terkait (jika ada relasi)
        foreach ($produk->gambars as $gambar) {
            Storage::delete($gambar->path);
            $gambar->delete();
        }

        // Hapus varian
        $produk->varians()->delete();

        // Hapus produk
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
