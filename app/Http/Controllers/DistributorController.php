<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distributor;

class DistributorController extends Controller
{
    public function index()
    {
        // List + pagination
        $distributors = Distributor::orderByDesc('created_at')->paginate(10);
        return view('admin.distributor.index', compact('distributors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_pt'         => 'required|string|max:150',
            'contact_person'  => 'nullable|string|max:150',
            'phone'           => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:150',
            'province'        => 'nullable|string|max:100',
            'regency'         => 'nullable|string|max:100',
            'district'        => 'nullable|string|max:100',
            'village'         => 'nullable|string|max:100',
            'rt'              => 'nullable|string|max:5',
            'rw'              => 'nullable|string|max:5',
            'kode_pos'        => 'nullable|string|max:10',
            'alamat_lengkap'  => 'nullable|string',
            'coordinate'      => 'nullable|string|max:50',
            'notes'           => 'nullable|string',
            'is_active'       => 'required|boolean',
        ]);

        // Map field name model
        $payload = [
            'name_pt'        => $data['name_pt'],
            'contact_person' => $data['contact_person'] ?? null,
            'phone'          => $data['phone'] ?? null,
            'email'          => $data['email'] ?? null,
            'province'       => $data['province'] ?? null,
            'regency'        => $data['regency'] ?? null,
            'district'       => $data['district'] ?? null,
            'village'        => $data['village'] ?? null,
            'rt'             => $data['rt'] ?? null,
            'rw'             => $data['rw'] ?? null,
            'kode_pos'       => $data['kode_pos'] ?? null,
            'alamat_lengkap' => $data['alamat_lengkap'] ?? null,
            'coordinate'     => $data['coordinate'] ?? null,
            'notes'          => $data['notes'] ?? null,
            'is_active'      => (bool) $data['is_active'],
        ];

        Distributor::create($payload);

        return redirect()
            ->route('distributor.index')
            ->with('success', 'Distributor berhasil ditambahkan.');
    }

    public function edit(Distributor $distributor)
    {
        // Tampilkan form edit
        return view('admin.distributor.edit', compact('distributor'));
    }

    public function update(Request $request, Distributor $distributor)
    {
        $data = $request->validate([
            'name_pt'         => 'required|string|max:150',
            'contact_person'  => 'nullable|string|max:150',
            'phone'           => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:150',
            'province'        => 'nullable|string|max:100',
            'regency'         => 'nullable|string|max:100',
            'district'        => 'nullable|string|max:100',
            'village'         => 'nullable|string|max:100',
            'rt'              => 'nullable|string|max:5',
            'rw'              => 'nullable|string|max:5',
            'kode_pos'        => 'nullable|string|max:10',
            'alamat_lengkap'  => 'nullable|string',
            'coordinate'      => 'nullable|string|max:50',
            'notes'           => 'nullable|string',
            'is_active'       => 'required|boolean',
        ]);

        $distributor->update($data);

        return redirect()
            ->route('distributor.index')
            ->with('success', 'Distributor berhasil diperbarui.');
    }

    public function destroy(Distributor $distributor)
    {
        // HAPUS PERMANEN (abaikan soft delete)
        $distributor->forceDelete();

        return redirect()
            ->route('distributor.index')
            ->with('success', 'Distributor berhasil dihapus permanen.');
    }

    // Optional: kalau butuh detail per distributor
    public function show(Distributor $distributor)
    {
        return view('admin.distributor.show', compact('distributor'));
    }
}
