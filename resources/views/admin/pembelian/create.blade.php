@extends('admin.components.app')

    <head>
        <title>@yield('title', 'Tambah Pembelian Produk | Insulmart')</title>
        <!-- Tag lain seperti meta, link CSS, dll -->
    </head>

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
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .btn-maroon:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--color-gradient-hover);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }
    
    .btn-maroon:hover {
        color: #fff;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 6px 15px rgba(139, 0, 0, 0.25);
    }
    
    .btn-maroon:hover:before {
        opacity: 1;
    }
    
    .btn-maroon:active {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(139, 0, 0, 0.2);
    }

    .btn-outline-maroon {
        color: var(--color-merah-tua);
        background: transparent;
        border: 2px solid var(--color-merah-tua);
        border-radius: 2em;
        padding: 0.5rem 1.2rem;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn-outline-maroon:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--color-gradient);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }

    .btn-outline-maroon:hover {
        color: #fff;
        border-color: transparent;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 6px 15px rgba(139, 0, 0, 0.2);
    }
    
    .btn-outline-maroon:hover:before {
        opacity: 1;
    }
    
    .btn-outline-maroon:active {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(139, 0, 0, 0.15);
    }

    /* Adding button focus states for accessibility */
    .btn-maroon:focus,
    .btn-outline-maroon:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.15);
    }

    .card-custom {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 18px 0 rgba(139,0,0,.08);
    }

    .form-control, .form-select {
        border-radius: 0.8rem;
        padding: 0.6rem 1rem;
        border-color: #dee2e6;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--color-merah-tua);
        box-shadow: 0 0 0 0.2rem rgba(139, 0, 0, 0.1);
    }

    .input-group .form-control {
        border-radius: 0 0.8rem 0.8rem 0;
    }

    .input-group-text {
        border-radius: 0.8rem 0 0 0.8rem;
        background: var(--color-maroon-light);
        border-color: #dee2e6;
        color: var(--color-merah-tua);
    }

    .form-label {
        color: var(--color-merah-tua);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .info-icon {
        color: var(--color-merah-tua);
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
</style>

<main class="main-content p-4 bg-light" id="mainContent">
    <div class="mb-4 border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold text-merah mb-1" style="font-size:2rem;letter-spacing:.5px">
                    <i class="bi bi-cart-plus me-2"></i> Tambah Pembelian
                </h3>
                <p class="text-muted mb-0">Tambah data pembelian varian produk baru</p>
            </div>
            <a href="{{ route('pembelian.index') }}" class="btn btn-outline-maroon">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

<div class="row">
    <div class="col-md-8">
        <div class="card card-custom">
            <div class="card-body p-4">
                <form action="{{ route('pembelian.store') }}" method="POST">
                    @csrf

                    {{-- KODE PO (opsional). Kalau datang dari query, kunci supaya konsisten --}}
                    <div class="mb-4">
                        <label for="po_code" class="form-label">Kode PO (opsional)</label>
                        <input type="text" name="po_code" id="po_code"
                                class="form-control @error('po_code') is-invalid @enderror"
                                value="{{ old('po_code', $activePoCode ?? '') }}"
                                {{ !empty($activePoCode) ? 'readonly' : '' }}
                                placeholder="Kosongkan untuk auto-generate">
                        @error('po_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if(!empty($activePoCode))
                            <small class="text-muted">Menambahkan item ke PO: <b>{{ $activePoCode }}</b></small>
                        @else
                            <small class="text-muted">Kosongkan bila ingin dibuat otomatis.</small>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="varian_id" class="form-label">Pilih Varian Produk</label>
                        <select name="varian_id" id="varian_id" class="form-select @error('varian_id') is-invalid @enderror">
                            <option value="">Pilih Varian</option>
                            @foreach($varians as $varian)
                                <option value="{{ $varian->id }}" {{ old('varian_id') == $varian->id ? 'selected' : '' }}>
                                    {{ $varian->produk->nama_produk }} - {{ $varian->tipe }} ⮕ {{ $varian->stok }}
                                </option>
                            @endforeach
                        </select>
                        @error('varian_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PILIH DISTRIBUTOR --}}
                    <div class="mb-4">
                        <label for="distributor_id" class="form-label">Pilih Distributor</label>
                        <select name="distributor_id" id="distributor_id"
                                class="form-select @error('distributor_id') is-invalid @enderror">
                            <option value="">Pilih Distributor</option>
                            @foreach(($distributors ?? collect()) as $dist)
                                <option value="{{ $dist->id }}" {{ old('distributor_id') == $dist->id ? 'selected' : '' }}>
                                    {{ $dist->name_pt }}
                                    @if($dist->contact_person) — {{ $dist->contact_person }} ⮕ {{ $dist->notes }} @endif
                                </option>
                            @endforeach
                        </select>
                        @error('distributor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Jika belum ada, tambahkan dulu di menu Kelola Distributor.</small>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="qty" class="form-label">Jumlah</label>
                            <input type="number" name="qty" id="qty" class="form-control @error('qty') is-invalid @enderror"
                                   value="{{ old('qty') }}" min="1" step="1">
                            <small class="text-muted">Masukkan harga dalam angka bulat</small>
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="harga_satuan" class="form-label">Harga Satuan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_satuan" id="harga_satuan" 
                                       class="form-control @error('harga_satuan') is-invalid @enderror"
                                       value="{{ old('harga_satuan') }}" min="0" step="1">
                            </div>
                            <small class="text-muted">Masukkan harga dalam angka bulat</small>
                            @error('harga_satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="tanggal_beli" class="form-label">Tanggal Pembelian</label>
                            <input type="date" name="tanggal_beli" id="tanggal_beli" 
                                   class="form-control @error('tanggal_beli') is-invalid @enderror"
                                   value="{{ old('tanggal_beli', date('Y-m-d')) }}">
                            @error('tanggal_beli')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="dipesan" {{ old('status') == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                                <option value="dikirim" {{ old('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="diterima_sebagian" {{ old('status') == 'diterima_sebagian' ? 'selected' : '' }}>Diterima Sebagian</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                <option value="dikembalikan_ke_supplier" {{ old('status') == 'dikembalikan_ke_supplier' ? 'selected' : '' }}>Dikembalikan ke Supplier</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea name="catatan" id="catatan" rows="3" 
                                  class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Total Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="total_harga" class="form-control" readonly>
                        </div>
                        <small class="text-muted">Total harga akan dihitung otomatis</small>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('pembelian.index') }}" class="btn btn-outline-maroon">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-maroon">
                            <i class="bi bi-check-circle me-2"></i>Simpan Pembelian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-custom">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-info-circle-fill info-icon"></i>
                    <h5 class="card-title text-merah">
                        Informasi Pembelian
                    </h5>
                </div>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check2-circle text-success me-2"></i>
                        Pilih varian produk yang akan dibeli
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check2-circle text-success me-2"></i>
                        Masukkan jumlah dan harga satuan
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check2-circle text-success me-2"></i>
                        Total harga akan dihitung otomatis
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check2-circle text-success me-2"></i>
                        Pilih status pembelian yang sesuai
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const qtyInput = document.getElementById('qty');
        const hargaInput = document.getElementById('harga_satuan');
        const totalInput = document.getElementById('total_harga');

        function hitungTotal() {
            const qty = parseInt(qtyInput.value) || 0;
            const harga = parseInt(hargaInput.value) || 0;
            const total = qty * harga;
            totalInput.value = total.toLocaleString('id-ID');
        }

        qtyInput.addEventListener('input', hitungTotal);
        hargaInput.addEventListener('input', hitungTotal);
    });
</script>
@endpush
