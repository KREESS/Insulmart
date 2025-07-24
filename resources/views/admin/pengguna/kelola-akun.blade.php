@extends('admin.components.app')
    <head>
        <title>@yield('title', 'Kelola Pengguna Admin | Insulmart')</title>
        <!-- Tag lain seperti meta, link CSS, dll -->
    </head>
@section('content')
<main class="main-content p-4 bg-light" id="mainContent">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-semibold text-dark m-0">👥 Kelola Akun Pengguna</h4>
        </div>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Notifikasi Error --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <strong>Terjadi kesalahan saat menginput data:</strong>
                </div>
                <ul class="mb-0 ps-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Filter Role yang Lebih Menarik --}}
        <div class="mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body py-3 px-4">
                    <form method="GET" action="{{ route('admin.kelola-akun') }}" class="row align-items-center g-3">
                        <div class="col-auto">
                            <label for="role" class="col-form-label fw-semibold">
                                <i class="bi bi-funnel-fill me-1"></i> Filter Role:
                            </label>
                        </div>
                        <div class="col-auto">
                            <select name="role" id="role" class="form-select" onchange="this.form.submit()">
                                <option value="">🔍 Semua</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>🛠️ Admin</option>
                                <option value="pelanggan" {{ request('role') === 'pelanggan' ? 'selected' : '' }}>👤 Pelanggan</option>
                            </select>
                        </div>

                        @if (request('role'))
                        <div class="col-auto">
                            <span class="badge bg-dark">
                                Menampilkan: {{ ucfirst(request('role')) }}
                                <a href="{{ route('admin.kelola-akun') }}" class="text-white ms-2 text-decoration-none">
                                    &times;
                                </a>
                            </span>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead style="background-color: #8B0000; color: white;">
                            <tr class="text-left">
                                <th style="width: 50px;">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th style="width: 220px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-dark text-capitalize me-1">{{ $role }}</span>
                                    @empty
                                        <span class="text-muted">-</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if ($user->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.kelola-akun.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                            ✏️ Edit
                                        </a>

                                        {{-- Toggle Status --}}
                                        <form method="POST" class="form-toggle-status"
                                            data-username="{{ $user->name }}"
                                            data-status="{{ $user->is_active ? 'nonaktifkan' : 'aktifkan' }}"
                                            action="{{ route('admin.kelola-akun.toggle-active', $user->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-secondary' : 'btn-success' }}">
                                                {{ $user->is_active ? '🚫 Nonaktifkan' : '✅ Aktifkan' }}
                                            </button>
                                        </form>

                                        {{-- Hapus --}}
                                        <form method="POST" class="form-delete"
                                            data-username="{{ $user->name }}"
                                            action="{{ route('admin.kelola-akun.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete">🗑️ Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada pengguna.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // DELETE
        document.querySelectorAll('.btn-delete').forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                const name = form.getAttribute('data-username');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: `Pengguna "${name}" akan dihapus secara permanen.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#8B0000',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // TOGGLE STATUS
        document.querySelectorAll('.form-toggle-status').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const username = form.getAttribute('data-username');
                const status = form.getAttribute('data-status');

                Swal.fire({
                    title: `Yakin ingin ${status} akun ini?`,
                    text: `Akun "${username}" akan di-${status}.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#8B0000',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: `Ya, ${status}`,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
