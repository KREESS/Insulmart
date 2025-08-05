<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'perusahaan' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:50',
            'nomor_telepon' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            // Simpan ke public/storage/profile-photos
            $destination = public_path('storage/profile-photos');
            if (!file_exists($destination)) {
                mkdir($destination, 0775, true); // Buat folder jika belum ada
            }
            $file->move($destination, $filename);

            // Simpan path di database
            $user->profile_photo_path = 'storage/profile-photos/' . $filename;
            $user->save();
        }

        // Update basic info
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'perusahaan' => $request->perusahaan,
            'npwp' => $request->npwp,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
