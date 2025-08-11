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
use Illuminate\Support\Facades\DB;

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
            'nama_produk'         => 'required|string|max:255',
            'jenis_produk'        => 'required|string|max:255',
            'jenis_produk_baru'   => 'required_if:jenis_produk,lainnya|nullable|string|max:255',
            'deskripsi'           => 'nullable|string',

            'gambar'              => 'required|array|min:3',
            'gambar.*'            => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            'varian'                      => 'required|array|min:1',
            'varian.*.tipe'               => 'required|string|max:255',
            'varian.*.ukuran'             => 'required|string|max:255',
            'varian.*.ketebalan'          => 'required|numeric',
            'varian.*.densitas'           => 'required|numeric',
            'varian.*.harga'              => 'required|numeric|min:0',
            'varian.*.stok'               => 'required|integer|min:0',
            'varian.*.ketersediaan'       => 'nullable|string|max:50',
        ]);

        // Resolve jenis produk
        $jenisProduk = $request->jenis_produk !== 'lainnya'
            ? $request->jenis_produk
            : ($request->jenis_produk_baru ?? 'Lainnya');

        DB::beginTransaction();

        try {
            // Simpan data produk utama
            $produk = Produk::create([
                'nama_produk'  => $request->nama_produk,
                'jenis_produk' => $jenisProduk,
                'deskripsi'    => $request->deskripsi,
            ]);

            // Simpan gambar langsung ke public/storage/produk
            foreach ($request->file('gambar', []) as $image) {
                $ext = $image->getClientOriginalExtension();
                $filename = uniqid('prd_', true) . '.' . $ext;

                // Pastikan folder tujuan ada
                $destination = public_path('storage/produk');
                if (!file_exists($destination)) {
                    mkdir($destination, 0775, true);
                }

                // Simpan file
                $image->move($destination, $filename);

                // Simpan path ke DB
                $produk->gambars()->create([
                    'path' => 'produk/' . $filename
                ]);
            }

            // Mapping ketersediaan dari input ke status standar
            $normalizeStatus = function (?string $input, $stok) {
                if ($input === null || $input === '') {
                    return ((int)$stok > 0) ? 'Tersedia' : 'Habis';
                }
                $key = strtolower(trim($input));
                $map = [
                    'ready'     => 'Tersedia',
                    'tersedia'  => 'Tersedia',
                    'available' => 'Tersedia',
                    'habis'     => 'Habis',
                    'soldout'   => 'Habis',
                    'sold out'  => 'Habis',
                    'preorder'  => 'Preorder',
                    'pre-order' => 'Preorder',
                    'indent'    => 'Indent',
                ];
                return $map[$key] ?? ucfirst($key);
            };

            // Simpan semua varian produk
            foreach ($request->varian as $v) {
                $status = $normalizeStatus($v['ketersediaan'] ?? null, $v['stok']);

                $produk->varians()->create([
                    'tipe'                => $v['tipe'],
                    'ukuran'              => $v['ukuran'],
                    'ketebalan'           => $v['ketebalan'],
                    'densitas'            => $v['densitas'],
                    'harga'               => $v['harga'],
                    'stok'                => $v['stok'],
                    'status_ketersediaan' => $status,
                ]);
            }

            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Produk dan variannya berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
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
            'nama_produk'        => 'required|string|max:255',
            'jenis_produk'       => 'required|string',
            'jenis_produk_baru'  => $request->jenis_produk === 'lainnya' ? 'required|string|max:255' : 'nullable',
            'deskripsi'          => 'nullable|string',

            'varian'                 => 'nullable|array',
            'varian.*.id'            => 'nullable|integer',
            'varian.*.tipe'          => 'required_with:varian|string',
            'varian.*.ukuran'        => 'required_with:varian|string',
            'varian.*.ketebalan'     => 'required_with:varian|numeric',
            'varian.*.densitas'      => 'required_with:varian|numeric',
            'varian.*.harga'         => 'required_with:varian|numeric',
            'varian.*.stok'          => 'required_with:varian|numeric',
            'varian.*.ketersediaan'  => 'required_with:varian|string|max:50', // ← tambah validasi

            'gambar.*'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $produk = Produk::findOrFail($id);

        // Update field utama produk
        $produk->update([
            'nama_produk'  => $request->nama_produk,
            'jenis_produk' => $request->jenis_produk === 'lainnya'
                ? $request->jenis_produk_baru
                : $request->jenis_produk,
            'deskripsi'    => $request->deskripsi,
        ]);

        // =========================
        // UPDATE VARIAN
        // =========================
        $oldVarianIds  = $produk->varians->pluck('id')->toArray();
        $formVarianIds = [];

        if ($request->has('varian')) {
            foreach ($request->varian as $v) {
                if (!empty($v['id'])) {
                    // Update varian lama
                    $produk->varians()->where('id', $v['id'])->update([
                        'tipe'                => $v['tipe'],
                        'ukuran'              => $v['ukuran'],
                        'ketebalan'           => $v['ketebalan'],
                        'densitas'            => $v['densitas'],
                        'harga'               => $v['harga'],
                        'stok'                => $v['stok'],
                        'status_ketersediaan' => $v['ketersediaan'], // ← mapping dari form
                    ]);
                    $formVarianIds[] = $v['id'];
                } else {
                    // Tambah varian baru
                    $produk->varians()->create([
                        'tipe'                => $v['tipe'],
                        'ukuran'              => $v['ukuran'],
                        'ketebalan'           => $v['ketebalan'],
                        'densitas'            => $v['densitas'],
                        'harga'               => $v['harga'],
                        'stok'                => $v['stok'],
                        'status_ketersediaan' => $v['ketersediaan'], // ← mapping dari form
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
        // UPLOAD GAMBAR BARU → public/storage/produk (tetap)
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

                // Simpan path ke DB: produk/namafile.jpg
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

        // Path relatif ke storage disk 'public'
        $filePath = $gambar->path; // contoh: 'produk/nama-file.jpg'

        // Hapus file dari storage/app/public/produk/xxx.jpg
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Hapus data gambar di database
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
