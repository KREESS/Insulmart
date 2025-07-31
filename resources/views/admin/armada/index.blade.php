@extends('admin.components.app')

@section('title', 'Kelola Armada Pengiriman')

@section('content')
    <style>
        :root {
            --maroon: #800000;
            --maroon-light: #a94442;
            --maroon-gradient: linear-gradient(135deg, #800000, #a94442);
            --gray-light: #f9f9f9;
            --hover-light: #fff6f6;
            --shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        .title-bar {
            background: var(--maroon-gradient);
            color: white;
            padding: 20px 30px;
            border-radius: 18px;
            margin-bottom: 30px;
            box-shadow: 0 8px 24px rgba(128, 0, 0, 0.25);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .title-bar h4 {
            margin: 0;
            font-weight: 800;
            letter-spacing: 0.6px;
        }

        .btn-add {
            background: linear-gradient(135deg, #800000, #c62828);
            color: #fff;
            font-weight: 600;
            padding: 8px 20px;
            border: none;
            border-radius: 10px;
            transition: 0.3s ease;
            box-shadow: 0 4px 10px rgba(128, 0, 0, 0.3);
        }

        .btn-add:hover {
            background: linear-gradient(135deg, #a94442, #800000);
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(128, 0, 0, 0.4);
        }

        .table-wrapper {
            background: #fff;
            padding: 28px;
            border-radius: 18px;
            box-shadow: var(--shadow);
            position: relative;
        }

        .table-custom th {
            background: var(--maroon);
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            text-align: center;
        }

        .table-custom td, .table-custom th {
            vertical-align: middle;
            text-align: center;
        }

        .table-custom tr:hover {
            background: var(--hover-light);
            transform: scale(1.005);
            transition: all 0.2s ease-in-out;
        }

        .badge-pack, .tarif-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 10px;
            font-size: 0.85rem;
            box-shadow: inset 0 0 4px rgba(0, 0, 0, 0.06);
        }

        .badge-pack {
            background: #e57373;
            color: white;
        }

        .tarif-tag {
            background: #ffebee;
            color: #c62828;
        }

        .tarif-tag i {
            font-size: 1rem;
        }

        .action-btns .btn {
            margin-right: 4px;
            transition: 0.15s ease-in;
            border-radius: 6px;
        }

        .action-btns .btn:hover {
            transform: scale(1.12);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f9a825, #ffb300);
            color: white;
            font-weight: 600;
            border: none;
            transition: 0.25s ease-in-out;
            box-shadow: 0 3px 8px rgba(255, 193, 7, 0.35);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #ffb300, #f57f17);
            transform: scale(1.08);
        }

        .btn-danger {
            background: linear-gradient(135deg, #d32f2f, #b71c1c);
            color: white;
            font-weight: 600;
            border: none;
            transition: 0.25s ease-in-out;
            box-shadow: 0 3px 8px rgba(244, 67, 54, 0.35);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #b71c1c, #d32f2f);
            transform: scale(1.08);
        }

        .table-footer {
            font-size: 0.85rem;
            margin-top: 14px;
            color: #999;
        }

        .no-data {
            text-align: center;
            padding: 48px 16px;
            color: #999;
            font-size: 1rem;
        }

        .no-data i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            color: #d4cfcf;
        }

        .floating-icon {
            position: absolute;
            top: -20px;
            right: -20px;
            background: var(--maroon);
            color: white;
            padding: 8px 12px;
            border-radius: 50px;
            font-size: 1.2rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .search-bar .input-group {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .search-bar .form-control {
            border: 1px solid #ccc;
            border-left: none;
            background: #fff;
            font-size: 0.95rem;
            padding: 10px 14px;
            transition: 0.3s;
        }

        .search-bar .form-control:focus {
            box-shadow: none;
            border-color: #800000;
        }

        .search-bar .input-group-text {
            background: #fff;
            border: 1px solid #ccc;
            border-right: none;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .title-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
            }

            .btn-add {
                width: 100%;
                text-align: center;
                padding: 10px 20px;
            }

            .search-bar .input-group {
                flex-direction: row;
                width: 100% !important;
            }

            .search-bar {
                justify-content: center !important;
                margin-top: 1rem;
            }

            .search-bar .form-control {
                font-size: 0.9rem;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            .table-custom th,
            .table-custom td {
                white-space: nowrap;
            }

            .action-btns .btn {
                margin-bottom: 6px;
            }
        }

        @media (max-width: 576px) {
            .title-bar h4 {
                font-size: 1.15rem;
            }

            .table-footer {
                font-size: 0.75rem;
            }

            .floating-icon {
                top: -10px;
                right: -10px;
                font-size: 1rem;
                padding: 6px 10px;
            }

            .badge-pack,
            .tarif-tag {
                font-size: 0.75rem;
                padding: 4px 8px;
            }

            .search-bar .input-group {
                max-width: 100% !important;
            }

            .search-bar .input-group-text {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
    </style>

    <main id="mainContent" class="main-content p-4 bg-light">
        <div class="title-bar">
            <h4><i class="bi bi-truck me-2"></i>Kelola Armada Pengiriman</h4>
            <a href="{{ route('admin.armada-create') }}" class="btn btn-add" title="Tambah Armada Baru">
                <i class="bi bi-plus-circle me-1"></i>Tambah Armada
            </a>
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

        <div class="table-wrapper position-relative">
            <div class="floating-icon">
                <i class="bi bi-truck-front-fill"></i>
            </div>

            <div class="search-bar mb-4 d-flex justify-content-end align-items-center">
                <div class="input-group w-100 w-md-25" style="max-width: 300px;">
                    <span class="input-group-text bg-white border-end-0 px-3">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" onkeyup="filterTable()" class="form-control border-start-0" placeholder="Cari armada..." aria-label="Cari Armada">
                </div>
            </div>

            @if($armadas->count())
            <table class="table table-bordered table-striped table-custom">
                <thead>
                    <tr>
                        <th>Nama Armada</th>
                        <th>Kapasitas</th>
                        <th>Tarif per KM</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($armadas as $armada)
                        <tr>
                            <td><strong><i class="bi bi-truck text-secondary me-1"></i>{{ $armada->nama }}</strong></td>
                            <td><span class="badge-pack"><i class="bi bi-box"></i> {{ $armada->kapasitas_pack }} bal</span></td>
                            <td><span class="tarif-tag"><i class="bi bi-cash-coin"></i> Rp{{ number_format($armada->tarif_per_km, 0, ',', '.') }}</span></td>
                            <td class="action-btns">
                                <a href="{{ route('admin.armada-edit', $armada->id) }}" class="btn btn-sm btn-warning" title="Edit Armada">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button onclick="confirmDelete('{{ route('admin.armada-delete', $armada->id) }}')" class="btn btn-sm btn-danger" title="Hapus Armada">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="table-footer">
                Total Armada: {{ $armadas->count() }}
            </div>
            @else
            <div class="no-data">
                <i class="bi bi-truck-flatbed"></i>
                Belum ada data armada yang tersedia.
            </div>
            @endif
        </div>
    </main>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(url) {
                Swal.fire({
                    title: 'Hapus Armada?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#800000',
                    cancelButtonColor: '#999',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;

                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';

                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';

                        form.appendChild(csrf);
                        form.appendChild(method);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

            function filterTable() {
                const input = document.getElementById("searchInput");
                const filter = input.value.toLowerCase();
                const rows = document.querySelectorAll(".table-custom tbody tr");

                rows.forEach(row => {
                    let match = false;
                    const cells = row.querySelectorAll("td");

                    // Cek semua kolom kecuali aksi (kolom terakhir)
                    for (let i = 0; i < cells.length - 1; i++) {
                        if (cells[i].innerText.toLowerCase().includes(filter)) {
                            match = true;
                            break;
                        }
                    }

                    row.style.display = match ? "" : "none";
                });
            }
        </script>
    @endpush
@endsection
