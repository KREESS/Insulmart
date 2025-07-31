<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArmadaPengiriman;


class AdminArmadaController extends Controller
{
    /**
     * Menampilkan semua armada pengiriman.
     */
    public function index()
    {
        $armadas = ArmadaPengiriman::orderBy('nama')->get();
        return view('admin.armada.index', compact('armadas'));
    }

    /**
     * Menampilkan form untuk tambah armada baru.
     */
    public function create()
    {
        return view('admin.armada.create');
    }

    /**
     * Menyimpan data armada baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kapasitas_pack' => 'required|integer|min:1',
            'tarif_per_km' => 'required|numeric|min:0',
        ]);

        ArmadaPengiriman::create([
            'nama' => $request->nama,
            'kapasitas_pack' => $request->kapasitas_pack,
            'tarif_per_km' => $request->tarif_per_km,
        ]);

        return redirect()->route('admin.armada-pengiriman')->with('success', 'Armada berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit armada.
     */
    public function edit($id)
    {
        $armada = ArmadaPengiriman::findOrFail($id);
        return view('admin.armada.edit', compact('armada'));
    }

    /**
     * Memperbarui data armada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kapasitas_pack' => 'required|integer|min:1',
            'tarif_per_km' => 'required|numeric|min:0',
        ]);

        $armada = ArmadaPengiriman::findOrFail($id);
        $armada->update([
            'nama' => $request->nama,
            'kapasitas_pack' => $request->kapasitas_pack,
            'tarif_per_km' => $request->tarif_per_km,
        ]);

        return redirect()->route('admin.armada-pengiriman')->with('success', 'Armada berhasil diperbarui.');
    }

    /**
     * Menghapus armada.
     */
    public function destroy($id)
    {
        $armada = ArmadaPengiriman::findOrFail($id);
        $armada->delete();

        return redirect()->route('admin.armada-pengiriman')->with('success', 'Armada berhasil dihapus.');
    }
}
