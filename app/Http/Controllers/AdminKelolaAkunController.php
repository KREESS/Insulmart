<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminKelolaAkunController extends Controller
{
    public function index(Request $request)
    {
        $roleFilter = $request->input('role');

        $users = \App\Models\User::when($roleFilter, function ($query) use ($roleFilter) {
            $query->whereHas('roles', function ($q) use ($roleFilter) {
                $q->where('name', $roleFilter);
            });
        })->with('roles')->get(); // bisa ditambahkan paginate() jika perlu

        return view('admin.pengguna.kelola-akun', compact('users', 'roleFilter'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pengguna.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,pelanggan',
            'is_active' => 'required|boolean',
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_active = $request->is_active;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->syncRoles([$request->role]);

        $user->save();

        return redirect()->route('admin.kelola-akun.edit', $user->id)
            ->with('success', 'Akun berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Opsional: Cegah admin menghapus dirinya sendiri
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Kamu tidak dapat menghapus akunmu sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.kelola-akun')->with('success', 'User berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'Status akun berhasil diperbarui.');
    }
}
