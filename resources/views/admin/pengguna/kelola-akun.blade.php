@extends('admin.components.app')
<title>@yield('title', 'Kelola Pengguna Admin | Insulmart')</title>

@section('content')
<style>
    .table-user th, .table-user td {
        vertical-align: middle;
        padding: 0.6rem 0.6rem;
        font-size: 0.97em;
        /* Responsive min width on key columns */
        min-width: 80px;
    }
    .table-user .user-name {
        font-weight: 600;
        color: #800000;
        font-size: 1.02em;
        letter-spacing: .01em;
    }
    .table-user .user-email {
        font-size: 0.95em;
        color: #444;
    }
    .table-user .address-block {
        background: #faf7f7;
        border-left: 4px solid #8B0000;
        border-radius: 8px;
        padding: 0.45rem 0.9rem 0.45rem 0.9rem;
        margin: 0;
        font-size: 0.96em;
        line-height: 1.45;
        box-shadow: 0 1px 2px 0 #ececec;
        min-width: 220px;
        max-width: 340px;
        display: inline-block;
        word-break: break-word;
    }
    .table-user .address-title {
        color: #6c3c3c;
        font-weight: 500;
        font-size: 1em;
        margin-bottom: 2px;
    }
    .table-user .address-info {
        color: #8a8582;
        font-size: 0.93em;
    }
    .table-user .phone-block {
        color: #800000;
        background: #f9ecec;
        padding: 0.32em 0.7em;
        border-radius: 7px;
        font-weight: 500;
        font-size: 0.97em;
        display: inline-block;
        min-width: 110px;
    }
    .table-user .status-badge {
        font-size: 0.93em;
        padding: 0.38em 0.98em;
        border-radius: 6px;
        font-weight: 600;
    }
    .table-user .role-badge {
        font-size: 0.96em;
        background: #ece2e2;
        color: #8B0000;
        margin-right: 0.3em;
        padding: 0.3em 0.7em;
        border-radius: 6px;
        font-weight: 500;
    }
    .table-user .action-btns .btn {
        min-width: 36px;
        padding: 0.32em 0.65em;
        font-size: 1em;
    }
    .table-user .no-users-row {
        font-size: 1.07em;
        color: #999;
        background: #fcf6f6;
    }
    .btn-action-circle {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.13em;
    }
    @media (max-width: 576px) {
        .btn-action-circle {
            width: 28px;
            height: 28px;
            font-size: 1em;
        }
    }
    @media (max-width: 1200px) {
        .table-user .address-block {
            max-width: 220px;
        }
    }
    @media (max-width: 900px) {
        .table-user td, .table-user th {
            font-size: 0.92em;
        }
        .table-user .address-block {
            max-width: 140px;
            padding: 0.33rem 0.5rem;
            font-size: 0.92em;
        }
        .table-user .phone-block {
            min-width: 70px;
            font-size: 0.93em;
            padding: 0.22em 0.4em;
        }
    }
    @media (max-width: 576px) {
        .table-user .address-block {
            max-width: 110px;
            font-size: 0.87em;
            padding: 0.21rem 0.2rem;
        }
        .table-user .user-name { font-size: 0.97em;}
        .table-user .status-badge, .table-user .role-badge { font-size: 0.91em;}
    }
</style>

<main class="main-content p-3 bg-light" id="mainContent">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-semibold text-dark m-0"><i class="bi bi-people-fill me-2 text-maroon"></i> Kelola Akun Pengguna</h4>
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

        {{-- Filter Role --}}
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
                    <div class="d-flex justify-content-end mb-3 mt-3 p-3">
                        <div class="search-container position-relative" style="max-width:340px; width:100%;">
                            <span class="position-absolute top-50 translate-middle-y ms-3 text-muted" style="z-index:3;">
                                <i class="bi bi-search"></i>
                            </span>
                            <input
                                type="text"
                                id="searchInput"
                                class="form-control ps-5 shadow-sm search-glow"
                                placeholder="Cari nama, email, hp, alamat, dst..."
                                style="border-radius: 2rem; background: #faf7f7;"
                                autocomplete="off"
                            >
                            <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2 py-1 px-2 d-none" id="clearSearch" style="z-index:4;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>

                    <table class="table table-striped table-hover table-user mb-0 align-middle" id="userTable">
                        <thead style="background-color: #8B0000; color: white;">
                            <tr class="text-left">
                                <th style="width: 40px;">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Nomor Hp</th>
                                <th>Alamat</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <span class="user-name">
                                        <i class="bi bi-person-badge me-1 text-maroon"></i>{{ $user->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="user-email">
                                        <i class="bi bi-envelope-fill me-1 text-secondary"></i>{{ $user->email }}
                                    </span>
                                </td>
                                <td>
                                    <span class="phone-block">
                                        <i class="bi bi-telephone-fill me-1"></i>
                                        {{ $user->nomor_telepon ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @php $alamat = $user->alamatPenggunas->first(); @endphp
                                    @if($alamat)
                                        <div class="address-block">
                                            <span class="address-title">
                                                <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                                                {{ $alamat->alamat_lengkap }}
                                            </span>
                                            <div class="address-info">
                                                {{ $alamat->village }},
                                                Kec. {{ $alamat->district }},
                                                {{ $alamat->regency }},
                                                Prov. {{ $alamat->province }},
                                                {{ $alamat->kode_pos }}
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge role-badge">{{ ucfirst($role) }}</span>
                                    @empty
                                        <span class="text-muted">-</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if ($user->is_active)
                                        <span class="badge status-badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge status-badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center action-btns">
                                    <div class="d-flex justify-content-center align-items-center gap-2 flex-nowrap">
                                        <a href="{{ route('admin.kelola-akun.edit', $user->id) }}" 
                                        class="btn btn-warning btn-sm btn-action-circle" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form method="POST" class="form-toggle-status d-inline"
                                            data-username="{{ $user->name }}"
                                            data-status="{{ $user->is_active ? 'nonaktifkan' : 'aktifkan' }}"
                                            action="{{ route('admin.kelola-akun.toggle-active', $user->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                class="btn btn-sm btn-action-circle {{ $user->is_active ? 'btn-secondary' : 'btn-success' }}" 
                                                title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="bi {{ $user->is_active ? 'bi-person-x-fill' : 'bi-person-check-fill' }}"></i>
                                            </button>
                                        </form>
                                        <form method="POST" class="form-delete d-inline"
                                            data-username="{{ $user->name }}"
                                            action="{{ route('admin.kelola-akun.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-action-circle btn-delete" title="Hapus">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center no-users-row py-4">
                                    <i class="bi bi-emoji-frown text-maroon fs-4 me-2"></i>
                                    Belum ada pengguna.
                                </td>
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
    document.getElementById('searchInput').addEventListener('input', function() {
        let searchVal = this.value.toLowerCase();
        document.querySelectorAll('#userTable tbody tr').forEach(function(row) {
            let rowText = '';
            // gabungkan semua cell text dalam 1 string
            row.querySelectorAll('td').forEach(function(cell) {
                rowText += (cell.textContent + ' ').toLowerCase();
            });
            // cek apakah row mengandung searchVal
            if (rowText.includes(searchVal)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

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