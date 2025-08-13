@extends('admin.components.app')

@section('title', 'Pembelian Varian Produk | Insulmart')

@section('content')
<style>
    :root {
        --color-merah-tua: #8B0000;
        --color-merah-hover: #a41515;
        --color-gradient: linear-gradient(90deg, #8B0000 0%, #a41515 100%);
        --color-gradient-hover: linear-gradient(90deg, #a41515 0%, #8B0000 100%);
        --color-maroon-light: #fbeaec;
    }
    
    .text-merah {
        color: var(--color-merah-tua) !important;
    }
    
    .btn-maroon {
        background: var(--color-gradient);
        color: #fff;
        border: none;
        border-radius: 2em;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-maroon:hover {
        background: var(--color-gradient-hover);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 0, 0, 0.2);
    }

    .btn-outline-maroon {
        color: var(--color-merah-tua);
        border: 2px solid var(--color-merah-tua);
        border-radius: 2em;
        padding: 0.5rem 1.2rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-maroon:hover {
        background: var(--color-gradient);
        color: #fff;
        border-color: transparent;
        transform: translateY(-2px);
    }
    
    .table-custom {
        background: #fff;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 18px 0 rgba(139,0,0,.08);
    }
    
    .table-custom thead {
        background: var(--color-maroon-light);
    }
    
    .table-custom th {
        font-weight: 600;
        color: var(--color-merah-tua);
        padding: 1rem;
    }
    
    .table-custom td {
        padding: 1rem;
        vertical-align: middle;
    }

    .table-hover > tbody > tr:hover {
        background-color: #fde4e4 !important;
        transition: .2s;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 2em;
        font-weight: 500;
    }

    .card-custom {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 18px 0 rgba(139,0,0,.08);
        overflow: hidden;
    }

    .alert-custom {
        border-radius: 1rem;
        border: none;
        padding: 1rem 1.5rem;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }
</style>

<main class="main-content p-4 bg-light" id="mainContent">
    <div class="mb-4 border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold text-merah mb-1" style="font-size:2rem;letter-spacing:.5px">
                    <i class="bi bi-cart-plus me-2"></i> Pembelian Varian Produk
                </h3>
                <p class="text-muted mb-0">Kelola semua pembelian varian produk untuk stok</p>
            </div>
            <a href="{{ route('pembelian.create') }}" class="btn btn-maroon d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle-fill"></i> Tambah Pembelian
            </a>
        </div>
    </div>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show alert-custom mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Varian</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal Beli</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelians as $index => $pembelian)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pembelian->varian->produk->nama_produk }}</td>
                            <td>{{ $pembelian->varian->nama_varian }}</td>
                            <td>{{ $pembelian->qty }}</td>
                            <td>Rp {{ number_format($pembelian->harga_satuan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $statusClass = [
                                        'draft' => 'secondary',
                                        'dipesan' => 'info',
                                        'dikirim' => 'primary',
                                        'diterima_sebagian' => 'warning',
                                        'selesai' => 'success',
                                        'dibatalkan' => 'danger',
                                        'dikembalikan_ke_supplier' => 'dark'
                                    ][$pembelian->status] ?? 'secondary';
                                    
                                    $statusLabel = str_replace('_', ' ', ucfirst($pembelian->status));
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td>{{ $pembelian->tanggal_beli ? $pembelian->tanggal_beli->format('d M Y') : '-' }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('pembelian.show', $pembelian->id) }}" 
                                       class="btn btn-action btn-info text-white"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('pembelian.edit', $pembelian->id) }}" 
                                       class="btn btn-action btn-warning text-white"
                                       title="Edit Pembelian">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-action btn-danger btn-delete"
                                            data-id="{{ $pembelian->id }}"
                                            title="Hapus Pembelian">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-inbox text-muted mb-3" style="font-size: 2rem;"></i>
                                    <h5 class="text-muted mb-3">Belum ada pembelian</h5>
                                    <a href="{{ route('pembelian.create') }}" class="btn btn-merah">
                                        <i class="bi bi-plus-circle me-2"></i> Tambah Pembelian
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const deleteForm = document.getElementById('delete-form');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pembelian akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteForm.setAttribute('action', `/admin/pembelian/${id}`);
                    deleteForm.submit();
                }
            });
        });
    });
});
</script>
@endpush
