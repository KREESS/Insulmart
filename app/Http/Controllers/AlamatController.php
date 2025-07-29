<?php

namespace App\Http\Controllers;

use App\Models\AlamatPengguna;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;


class AlamatController extends Controller
{
    /**
     * Tampilkan daftar alamat pelanggan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua alamat milik user, sudah menyimpan nama wilayah langsung
        $alamat = AlamatPengguna::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->get();

        $produks = Produk::with(['gambars', 'varians'])->get();
        return view('pelanggan.alamat.index', compact('alamat', 'produks'));
    }

    public function create()
    {
        $produks = Produk::with(['gambars', 'varians'])->get();
        return view('pelanggan.alamat.create', compact('produks'));
    }

    /**
     * Simpan alamat baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'province'       => 'required|string',
            'regency'        => 'required|string',
            'district'       => 'required|string',
            'village'        => 'required|string',
            'rt'             => 'required|digits_between:1,5',
            'rw'             => 'required|digits_between:1,5',
            'kode_pos'       => 'required|string|max:10',
            'alamat_lengkap' => 'required|string|max:500',
            'koordinat'      => ['required', 'regex:/^-?\d{1,3}(\.\d+)?,\s*-?\d{1,3}(\.\d+)?$/'],
        ]);

        $data['is_default'] = false;
        $data['user_id'] = Auth::id();

        AlamatPengguna::create($data);

        return redirect()->route('alamat.index')
            ->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function setDefault($id)
    {
        $userId = Auth::id();

        DB::transaction(function () use ($userId, $id) {
            // 1) Reset semua alamat default milik user, kecuali yang akan diset
            AlamatPengguna::where('user_id', $userId)
                ->where('id', '<>', $id)
                ->update(['is_default' => false]);

            // 2) Tandai yang dipilih jadi default
            AlamatPengguna::where('user_id', $userId)
                ->where('id', $id)
                ->update(['is_default' => true]);
        });

        return redirect()->route('alamat.index')
            ->with('success', 'Alamat default berhasil diperbarui.');
    }

    /**
     * Tampilkan form edit alamat.
     */
    public function edit(AlamatPengguna $alamat)
    {
        // Pastikan pemilik
        if ($alamat->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit alamat ini.');
        }

        // Hanya pass model $alamat, field wilayah dan default akan ditampilkan sebagai disabled di view
        return view('pelanggan.alamat.edit', compact('alamat'));
    }

    /**
     * Update data alamat (hanya rt, rw, kode_pos, alamat_lengkap).
     */
    public function update(Request $request, AlamatPengguna $alamat)
    {
        // Pastikan pemilik
        if ($alamat->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui alamat ini.');
        }

        // Validasi
        $data = $request->validate([
            'rt'             => 'required|digits_between:1,5',
            'rw'             => 'required|digits_between:1,5',
            'kode_pos'       => 'required|string|max:10',
            'alamat_lengkap' => 'required|string|max:500',
            'koordinat'      => ['required', 'regex:/^-?\d{1,3}(\.\d+)?,\s*-?\d{1,3}(\.\d+)?$/'],
        ]);

        $alamat->update($data);

        return redirect()
            ->route('alamat.index')
            ->with('success', 'Alamat berhasil diperbarui.');
    }

    /**
     * Hapus alamat.
     */
    public function destroy(AlamatPengguna $alamat)
    {
        // Cek kalau bukan pemilik, langsung 403
        if ($alamat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus alamat ini.');
        }

        $alamat->delete();

        return redirect()
            ->route('alamat.index')
            ->with('success', 'Alamat berhasil dihapus.');
    }
}
