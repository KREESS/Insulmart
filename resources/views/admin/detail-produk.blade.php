@extends('admin.components.app')

<head>
    <title>{{ $produk->nama_produk }} Insulasi | Insulmart</title>
    <!-- Tag lain seperti meta, link CSS, dll -->
    <style>
        :root {
            --color-merah-tua: #8B0000;
            --color-merah-hover: #a41515;
            --color-gradient: linear-gradient(90deg, #8B0000 0%, #a41515 100%);
            --color-gradient-hover: linear-gradient(90deg, #a41515 0%, #8B0000 100%);
            --color-maroon-light: #fbeaec;
        }
        body, .bg-light {
            background: var(--color-maroon-light) !important;
        }
        .text-merah {
            color: var(--color-merah-tua) !important;
        }
        .badge-maroon {
            background: var(--color-gradient);
            color: #fff;
        }
        .btn-maroon {
            background: var(--color-gradient);
            color: #fff;
            border: none;
            border-radius: 2em;
        }
        .btn-maroon:hover, .btn-maroon:focus {
            background: var(--color-gradient-hover);
            color: #fff;
        }
        .stat-card {
            border-radius: 1.1rem;
            box-shadow: 0 4px 18px 0 rgba(139,0,0,.08);
            background: #fff;
            padding: 1.2rem 1.7rem;
        }
        .progress-bar-maroon {
            background: var(--color-gradient);
        }
        .table thead {
            background: var(--color-maroon-light);
        }
        .table-hover > tbody > tr:hover {
            background-color: #fde4e4 !important;
            transition: .2s;
        }
    </style>
</head>

@section('content')

<main class="main-content p-4 bg-light" id="mainContent">
    <div class="mb-4 border-bottom pb-2">
        <h3 class="fw-bold mb-1 text-merah" style="font-size:2rem;letter-spacing:.5px">
            <i class="bi bi-eye me-2"></i> Detail Produk
        </h3>
        <p class="text-muted">Informasi lengkap tentang produk <strong>{{ $produk->nama_produk }}</strong> beserta semua variannya.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="row g-0">
            {{-- Sidebar gambar produk --}}
            <div class="col-md-5 p-4 bg-white border-end">
                @if($produk->gambars->count())
                    <div id="carouselProduk" class="carousel slide mb-3" data-bs-ride="carousel">
                        <div class="carousel-inner rounded shadow-sm">
                            @foreach($produk->gambars as $index => $gambar)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ $gambar->path && file_exists(public_path($gambar->path)) ? asset($gambar->path) : asset('images/no-image.png') }}"
                                        class="d-block w-100"
                                        style="max-height: 260px; object-fit: contain;"
                                        alt="Gambar {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduk" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Sebelumnya</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselProduk" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Berikutnya</span>
                        </button>
                    </div>
                @else
                    <p class="text-muted text-center">Tidak ada gambar tersedia.</p>
                @endif

                <span class="badge rounded-pill px-3 py-2 badge-maroon fw-semibold mt-2 d-inline-block shadow-sm" style="font-size:1.1rem">
                    <i class="bi bi-archive"></i> {{ ucfirst($produk->jenis_produk) }}
                </span>

                <div class="mt-4">
                    <div class="stat-card mb-2">
                        <div class="mb-1 text-muted small">
                            <i class="bi bi-calendar"></i> Dibuat: {{ $produk->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Konten utama --}}
            <div class="col-md-7 p-4">
                <div class="mb-3 d-flex flex-wrap align-items-center gap-2">
                    <h4 class="text-merah fw-bold mb-0" style="font-size:1.4rem">{{ $produk->nama_produk }}</h4>
                </div>
                <div class="mb-2" style="white-space: pre-line;">
                    <strong>Deskripsi:</strong><br>{!! $produk->deskripsi !!}
                </div>
                
                @php
                    $min = $produk->varians->min('harga');
                    $max = $produk->varians->max('harga');
                    $stokTotal = $produk->varians->sum('stok');
                @endphp

                <div class="row g-2 mb-3">
                    <div class="col-md-auto">
                        <span class="badge bg-success-subtle text-success px-3 py-2">
                            <i class="bi bi-cash-coin"></i> Harga Min:
                            <b>Rp{{ number_format($min,0,',','.') }}</b>
                        </span>
                    </div>
                    <div class="col-md-auto">
                        <span class="badge bg-danger-subtle text-danger px-3 py-2">
                            <i class="bi bi-cash-coin"></i> Harga Max:
                            <b>Rp{{ number_format($max,0,',','.') }}</b>
                        </span>
                    </div>
                    <div class="col-md-auto">
                        <span class="badge badge-maroon px-3 py-2">
                            <i class="bi bi-collection"></i> Total Varian: <b>{{ $produk->varians->count() }}</b>
                        </span>
                    </div>
                    <div class="col-md-auto">
                        <span class="badge bg-warning-subtle text-warning px-3 py-2">
                            <i class="bi bi-box-seam"></i> Total Stok: <b>{{ $stokTotal }}</b>
                        </span>
                    </div>
                </div>

                {{-- Progress bar stok --}}
                @php
                    $stokMax = $stokTotal > 0 ? $stokTotal : 1;
                @endphp
                <div class="progress mb-4" style="height:18px; border-radius:20px;">
                    <div class="progress-bar progress-bar-maroon"
                         style="width:{{ min(100,($stokTotal/$stokMax)*100) }}%;font-weight:600;">
                        {{ $stokTotal }} pcs
                    </div>
                </div>

                {{-- Tabel Livewire varian produk --}}
                <h5 class="mb-3 text-dark mt-4">
                    <i class="bi bi-list-ul me-1"></i> Daftar Varian
                </h5>
                @livewire('produk-varian-table', ['produkId' => $produk->id])

                <a href="{{ route('produk.index') }}" class="btn btn-maroon mt-4 shadow-sm">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Produk
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
