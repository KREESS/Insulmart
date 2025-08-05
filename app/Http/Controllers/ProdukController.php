<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukGambar;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('varians')->get();
        $cart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);
        return view('admin.produk', compact('produks', 'cart'));
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

        foreach ($request->file('gambar') as $image) {
            // Generate nama unik
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();

            // Pastikan folder ada
            $destination = public_path('storage/produk');
            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            // Simpan ke public/storage/produk
            $image->move($destination, $filename);

            // Simpan path ke DB, cukup: storage/produk/namafile.jpg
            $produk->gambars()->create([
                'path' => 'storage/produk/' . $filename
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
        $varians = \App\Models\VarianProduk::where('produk_id', $produk->id)
            ->orderBy('tipe')
            ->paginate(10);

        return view('admin.detail-produk', compact('produk', 'varians'));
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

        // Update field utama produk
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'jenis_produk' => $request->jenis_produk === 'lainnya' ? $request->jenis_produk_baru : $request->jenis_produk,
            'deskripsi' => $request->deskripsi,
        ]);

        // =========================
        // UPDATE VARIAN
        // =========================

        $oldVarianIds = $produk->varians->pluck('id')->toArray();
        $formVarianIds = [];

        if ($request->has('varian')) {
            foreach ($request->varian as $v) {
                if (!empty($v['id'])) {
                    // Update varian lama
                    $produk->varians()->where('id', $v['id'])->update([
                        'tipe' => $v['tipe'],
                        'ukuran' => $v['ukuran'],
                        'ketebalan' => $v['ketebalan'],
                        'densitas' => $v['densitas'],
                        'harga' => $v['harga'],
                        'stok' => $v['stok'],
                    ]);
                    $formVarianIds[] = $v['id'];
                } else {
                    // Tambah varian baru
                    $produk->varians()->create([
                        'tipe' => $v['tipe'],
                        'ukuran' => $v['ukuran'],
                        'ketebalan' => $v['ketebalan'],
                        'densitas' => $v['densitas'],
                        'harga' => $v['harga'],
                        'stok' => $v['stok'],
                    ]);
                }
            }
            // Hapus varian lama yang tidak ada di form
            $toDelete = array_diff($oldVarianIds, $formVarianIds);
            if (!empty($toDelete)) {
                $produk->varians()->whereIn('id', $toDelete)->delete();
            }
        } else {
            // Jika user hapus semua varian di form
            $produk->varians()->delete();
        }

        // =========================
        // TAMBAH GAMBAR BARU SAJA (Gambar lama tetap, hapus manual jika mau)
        // =========================
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();

                // Pastikan folder tujuan ada
                $destination = public_path('storage/produk');
                if (!file_exists($destination)) {
                    mkdir($destination, 0775, true);
                }

                // Simpan file ke public/storage/produk
                $file->move($destination, $filename);

                // Simpan path ke DB, contoh: storage/produk/namafile.jpg
                $produk->gambars()->create([
                    'path' => 'produk/' . $filename
                ]);
            }
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }


    public function destroyGambar($id)
    {
        $gambar = ProdukGambar::findOrFail($id);

        // Path lengkap ke file di public
        $filePath = public_path($gambar->path);

        if (file_exists($filePath)) {
            unlink($filePath); // Hapus file
        }
        $gambar->delete(); // Hapus data di DB

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
