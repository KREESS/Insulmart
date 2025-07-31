@extends('admin.components.app')
<title>@yield('title', 'Kelola Pengguna Admin | Insulmart')</title>

@section('content')
    <style>
        :root {
        --maroon-dark: #7c1020;
        --maroon-mid: #a94442;
        --maroon-light: #ffe6eb;
        --gradient-maroon: linear-gradient(87deg, #8B0000 10%, #a94442 90%);
        --gradient-btn: linear-gradient(135deg, #8B0000, #a94442 90%);
        --shadow: 0 8px 32px rgba(140,0,0,0.09), 0 1.5px 3px rgba(100,0,0,0.02);
        --radius: 18px;
        }

        /* Main card effect */
        .card.shadow-gradient {
        background: #fff;
        box-shadow: var(--shadow);
        border: none;
        border-radius: var(--radius);
        overflow: hidden;
        }
        .table-user th {
        background: var(--gradient-maroon) !important;
        color: #fff !important;
        border: none !important;
        font-weight: 700;
        font-size: 1.08em;
        letter-spacing: .02em;
        }
        .table-user td {
        background: #fff;
        border-top: none;
        vertical-align: middle;
        padding: .75rem .7rem;
        }
        .table-user tr {
        transition: box-shadow .16s, transform .16s;
        }
        .table-user tbody tr:hover {
        background: #fff6f7;
        box-shadow: 0 4px 18px 0 #ffe6eb44;
        transform: scale(1.011);
        }
        .table-user .user-name {
        font-weight: 700;
        color: #8B0000;
        font-size: 1.05em;
        }
        .table-user .user-email { color: #a94442; font-size: .97em; }
        .table-user .phone-block {
        color: #8B0000;
        background: #ffe6eb;
        padding: .39em .9em;
        border-radius: 10px;
        font-weight: 600;
        font-size: .98em;
        letter-spacing: .03em;
        box-shadow: 0 1px 3px #fae2e2;
        min-width: 90px;
        display: inline-block;
        }
        .table-user .address-block {
        background: #fff7fa;
        border-left: 4px solid #a94442;
        border-radius: 10px;
        padding: .48em 1em .48em 1em;
        margin: 0;
        font-size: .97em;
        line-height: 1.48;
        box-shadow: 0 1.5px 5px #ffe6eb66;
        min-width: 180px; max-width: 330px;
        display: inline-block;
        word-break: break-word;
        }
        .table-user .address-title {
        color: #8B0000;
        font-weight: 600;
        font-size: 1em;
        }
        .table-user .address-info { color: #9b7979; font-size: .94em; }
        .table-user .status-badge {
        font-size: .95em;
        padding: .43em 1.18em;
        border-radius: 8px;
        font-weight: 700;
        letter-spacing: .01em;
        border: none;
        }
        .table-user .role-badge {
        background: #fff0f0;
        color: #8B0000;
        margin-right: .18em;
        padding: .32em .9em;
        border-radius: 7px;
        font-weight: 500;
        font-size: .97em;
        border: 1px solid #fae3e3;
        }
        .table-user .no-users-row {
        font-size: 1.10em;
        color: #a94442;
        background: #fff5f6;
        border-bottom: 2px solid #fff0f3;
        }

        .action-btns .btn-action-circle {
        width: 35px; height: 35px;
        padding: 0;
        display: inline-flex !important;
        align-items: center; justify-content: center;
        border-radius: 50%;
        font-size: 1.19em;
        transition: box-shadow .18s, transform .18s;
        background: var(--gradient-btn);
        color: #fff;
        border: none;
        box-shadow: 0 1.5px 4px #f9e2e2;
        }
        .action-btns .btn-action-circle.btn-warning { background: linear-gradient(135deg,#ffd966,#ffb74d); color: #8B0000;}
        .action-btns .btn-action-circle.btn-danger { background: linear-gradient(135deg,#ff758c,#ff7eb3); color: #fff;}
        .action-btns .btn-action-circle.btn-success { background: linear-gradient(135deg,#71e179,#26a564);}
        .action-btns .btn-action-circle.btn-secondary { background: linear-gradient(135deg,#dfdfdf,#c0c0c0); color:#7c1020;}
        .action-btns .btn-action-circle:hover {
        filter: brightness(1.10);
        transform: scale(1.10) rotate(-6deg);
        box-shadow: 0 3px 18px #fae1e1;
        }
        .action-btns .btn-action-circle:active {
        filter: brightness(0.98);
        transform: scale(0.97);
        }

        /* Search box gradient + shadow */
        .search-container input {
        background: #fffaf7;
        border: none;
        box-shadow: 0 2px 12px #ffeaea33;
        transition: border-color .2s;
        }
        .search-container input:focus {
        border-color: #a94442 !important;
        box-shadow: 0 2px 18px #a9444222;
        }
        #clearSearch {
        background: none;
        border: none;
        color: #a94442;
        font-size: 1.15em;
        }
        #clearSearch:hover { color: #8B0000; }

        .badge.bg-success { background: linear-gradient(87deg, #a5f3bc, #58bb61) !important; color:#144416 !important;}
        .badge.bg-secondary { background: #c4bdbd !important; color:#5c4343 !important;}
        .badge.bg-dark { background: var(--gradient-maroon)!important; color: #fff !important; border:none; }

        @media (max-width:1200px) {
        .table-user .address-block { max-width:160px; }
        }
        @media (max-width:900px) {
        .table-user th, .table-user td { font-size: .92em;}
        .table-user .address-block { max-width:100px; padding:.25em .3em; font-size:.91em;}
        .table-user .phone-block { min-width:55px; font-size:.92em; padding:.18em .28em;}
        .table-user .user-name{font-size:.95em;}
        }
        @media (max-width:768px) {
        .table-responsive { overflow-x: auto; }
        .table-user th, .table-user td { padding:.53em .34em;}
        .table-user .address-block {max-width:90px;}
        }
        @media (max-width:576px) {
        .table-user th, .table-user td { font-size: .88em;}
        .table-user .address-block {max-width:60px;font-size:.87em;padding:.14em .12em;}
        .table-user .user-name{font-size:.93em;}
        .table-user .status-badge, .table-user .role-badge { font-size:.89em;}
        }
    </style>

    <main class="main-content p-3 bg-light min-vh-100" id="mainContent">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold text-dark m-0" style="letter-spacing:.02em;">
                    <i class="bi bi-people-fill me-2" style="color:#8B0000;background:linear-gradient(135deg,#ffe6eb 60%,#fcd8e6);border-radius:12px;padding:7px 12px 7px 10px;"></i>
                    Kelola Akun Pengguna
                </h4>
            </div>

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show shadow-sm" role="alert" style="border-radius:14px;background:linear-gradient(93deg,#fbe9e7 50%,#e3e1fc 100%);">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            {{-- Notifikasi Error --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius:14px;">
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
                <div class="card shadow-gradient border-0">
                    <div class="card-body py-3 px-4">
                        <form method="GET" action="{{ route('admin.kelola-akun') }}" class="row align-items-center g-3">
                            <div class="col-auto">
                                <label for="role" class="col-form-label fw-semibold">
                                    <i class="bi bi-funnel-fill me-1"></i> Filter Role:
                                </label>
                            </div>
                            <div class="col-auto">
                                <select name="role" id="role" class="form-select" onchange="this.form.submit()" style="border-radius:9px;">
                                    <option value="">🔍 Semua</option>
                                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>🛠️ Admin</option>
                                    <option value="pelanggan" {{ request('role') === 'pelanggan' ? 'selected' : '' }}>👤 Pelanggan</option>
                                </select>
                            </div>
                            @if (request('role'))
                            <div class="col-auto">
                                <span class="badge bg-dark shadow-sm">
                                    Menampilkan: {{ ucfirst(request('role')) }}
                                    <a href="{{ route('admin.kelola-akun') }}" class="text-white ms-2 text-decoration-none" style="font-size:1.09em;">&times;</a>
                                </span>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow-gradient border-0 rounded-4">
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
                                    style="border-radius: 2rem; background: #fff7fa;"
                                    autocomplete="off"
                                >
                                <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2 py-1 px-2" id="clearSearch" style="z-index:4;display:none;">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>

                        <table class="table table-striped table-hover table-user mb-0 align-middle" id="userTable">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">No</th>
                                    <th>Nama</th>
                                    <th>Perusahaan</th>
                                    <th>NPWP</th>
                                    <th>Email</th>
                                    <th>Nomor Hp</th>
                                    <th>Alamat</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th style="width: 135px;">Aksi</th>
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
                                        <span class="user-perusahaan">
                                            <i class="bi bi-building me-1 text-maroon"></i>{{ $user->perusahaan }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="user-NPWP">
                                            <i class="bi bi-card-text me-1 text-maroon"></i>{{ $user->npwp }}
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
                                    <td colspan="10" class="text-center no-users-row py-4">
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