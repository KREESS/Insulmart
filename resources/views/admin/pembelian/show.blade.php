@extends('admin.components.app')

@section('title', 'Detail Pembelian Varian Produk | Insulmart')

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

    .card-custom {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 18px 0 rgba(139,0,0,.08);
    }

    .badge-custom {
        padding: 0.5rem 1.2rem;
        border-radius: 2em;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .info-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
    }

    .info-value {
        color: #2d3338;
        font-weight: 500;
        font-size: 1.1rem;
    }

    .img-product {
        max-height: 200px;
        object-fit: contain;
        border-radius: 1rem;
    }

    .product-badge {
        background: var(--color-maroon-light);
        color: var(--color-merah-tua);
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 2em;
        display: inline-block;
        margin-top: 1rem;
    }

    .btn-po-gradient {
        display: inline-block;
        background: linear-gradient(135deg, #d61e1e, #8b0000);
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: transform .08s ease, opacity .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .btn-po-gradient:hover {
        opacity: 0.95;
        color: #fff;
        background: linear-gradient(135deg, #e62e2e, #a50000); /* sedikit lebih terang */
        box-shadow: 0 4px 12px rgba(214, 30, 30, 0.3);
    }

    .btn-po-gradient:active {
        transform: scale(.98);
    }
</style>

<main class="main-content p-4 bg-light" id="mainContent">
    <div class="mb-4 border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold text-merah mb-1" style="font-size:2rem;letter-spacing:.5px">
                    <i class="bi bi-eye me-2"></i> Detail Pembelian
                </h3>
                <p class="text-muted mb-0">Detail data pembelian varian produk</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pembelian.index') }}" class="btn btn-outline-maroon">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
                <a href="{{ route('pembelian.edit', $pembelian->id) }}" class="btn btn-maroon">
                    <i class="bi bi-pencil-fill me-2"></i> Edit
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-body p-4">
                    <h5 class="card-title text-merah mb-4">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Informasi Pembelian
                    </h5>
                    <a href="{{ route('pembelian.produk.downloadPo', $pembelian->id) }}"
                        class="btn btn-po-gradient mb-3">
                        <i class="bi bi-download me-1"></i> Download PO
                    </a>
                    <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <div class="info-label">Produk</div>
                            <div class="info-value">{{ $pembelian->varian->produk->nama_produk }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <div class="info-label">Varian</div>
                            <div class="info-value">{{ $pembelian->varian->tipe }}</div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Jumlah</h6>
                        <p class="mb-0 fw-bold">{{ $pembelian->qty }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Harga Satuan</h6>
                        <p class="mb-0 fw-bold">Rp {{ number_format($pembelian->harga_satuan, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Total Harga</h6>
                        <p class="mb-0">
                            <span class="badge bg-success fs-6">
                                Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Status</h6>
                        <p class="mb-0">
                            @php
                                $statusClass = [
                                    'pending' => 'warning',
                                    'selesai' => 'success',
                                    'dibatalkan' => 'danger'
                                ][$pembelian->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">
                                {{ ucfirst($pembelian->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Tanggal Pembelian</h6>
                        <p class="mb-0 fw-bold">{{ $pembelian->tanggal_beli->format('d M Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Dibuat Pada</h6>
                        <p class="mb-0 fw-bold">{{ $pembelian->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                @if($pembelian->catatan)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Catatan</h6>
                        <p class="mb-0">{{ $pembelian->catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-custom">
            <div class="card-body p-4">
                <h5 class="card-title text-merah mb-4">
                    <i class="bi bi-box-seam-fill me-2"></i>
                    Detail Produk
                </h5>

                <div class="text-center mb-4">
                    @if($pembelian->varian->produk->gambars->count() > 0)
                        <img src="{{ asset('storage/' . $pembelian->varian->produk->gambars->first()->path) }}" 
                             alt="{{ $pembelian->varian->produk->nama_produk }}"
                             class="img-fluid rounded mb-3"
                             style="max-height: 200px; object-fit: contain;">
                    @else
                        <div class="bg-light rounded p-4 mb-3">
                            <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <h6 class="text-muted mb-2">Jenis Produk</h6>
                    <p class="mb-0 fw-bold">{{ ucfirst($pembelian->varian->produk->jenis_produk) }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted mb-2">Varian</h6>
                    <p class="mb-0 fw-bold">{{ $pembelian->varian->nama_varian }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted mb-2">Stok Saat Ini</h6>
                    <p class="mb-0">
                        <span class="badge bg-info fs-6">
                            {{ $pembelian->varian->stok }} unit
                        </span>
                    </p>
                </div>

                <div>
                    <h6 class="text-muted mb-2">Harga Jual</h6>
                    <p class="mb-0">
                        <span class="badge bg-success fs-6">
                            Rp {{ number_format($pembelian->varian->harga, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
