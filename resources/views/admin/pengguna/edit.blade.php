@extends('admin.components.app')

@section('content')
<main class="main-content p-4 bg-light" id="mainContent">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-semibold text-dark m-0">✏️ Edit Akun Pengguna</h4>
            <a href="{{ route('admin.kelola-akun') }}" class="btn btn-sm text-white" style="background-color: #8B0000;">
                ⬅️ Kembali
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <strong>Periksa kembali input Anda:</strong>
                </div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <div class="card shadow border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('admin.kelola-akun.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-dark">👤 Nama Lengkap</label>
                        <input type="text" name="name" class="form-control border-dark-subtle" id="name"
                            value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-dark">📧 Email</label>
                        <input type="email" name="email" class="form-control border-dark-subtle" id="email"
                            value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold text-dark">🛡️ Role</label>
                        <select name="role" id="role" class="form-select border-dark-subtle" required>
                            <option value="" disabled selected>-- Pilih Role --</option>
                            <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                            <option value="pelanggan" {{ $user->hasRole('pelanggan') ? 'selected' : '' }}>Pelanggan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label fw-semibold text-dark">🔓 Status Akun</label>
                        <select name="is_active" id="is_active" class="form-select border-dark-subtle">
                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-dark">🔒 Password Baru <small class="text-muted">(opsional)</small></label>
                        <input type="password" name="password" class="form-control border-dark-subtle" id="password" placeholder="Biarkan kosong jika tidak diubah">
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.kelola-akun') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn text-white" style="background-color: #8B0000;">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</main>
@endsection
