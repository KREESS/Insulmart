@extends('components.layout-bootstrap')

    <head>
        <title>@yield('title', 'Pesanan Saya | Insulmart')</title>
        <!-- Tag lain seperti meta, link CSS, dll -->
    </head>
@section('content')
    <style>
    :root {
        --color-maroon: #8B0000;
        --color-maroon-light: #f8e5e5;
        --color-maroon-hover: #e22d2dff;
        --radius: 0.75rem;
        --shadow-light: rgba(0,0,0,0.1);
    }
    .page-container { margin-top: 8rem; margin-bottom: 8rem; }
    h3.text-maroon {
        font-size: 2rem;
        border-bottom: 3px solid var(--color-maroon);
        padding-bottom: 0.5rem;
    }

    /* Nav-pills maroon */
    .nav-pills .nav-link {
        color: #fff;
        background-color: var(--color-maroon);
        margin-right: .5rem;
        border-radius: var(--radius);
        transition: background-color .3s, transform .2s;
    }
    .nav-pills .nav-link:hover {
        background-color: var(--color-maroon-hover);
        transform: translateY(-2px);
    }
    .nav-pills .nav-link.active {
        background-color: var(--color-maroon-hover);
    }

    .btn-maroon {
        background-color: var(--color-maroon);
        color: #fff;
        font-weight: 600;
        border-radius: var(--radius);
        padding: 6px 16px;
        transition: background-color .3s;
    }
    .btn-maroon:hover { background-color: var(--color-maroon-hover); }

    .search-bar {
        max-width: 300px;
        border-radius: var(--radius);
    }

    /* Order card etc – unchanged from before */
    .order-card {
        border-radius: var(--radius);
        box-shadow: 0 2px 8px var(--shadow-light);
        transition: transform .2s, box-shadow .2s;
    }
    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 16px var(--shadow-light);
    }
    .badge-status { font-size: .85rem; padding: 6px 12px; border-radius: 20px; }
    .badge-menunggu   { background-color: #fff3cd; color: #856404; }
    .badge-diproses   { background-color: #d1ecf1; color: #0c5460; }
    .badge-selesai    { background-color: #d4edda; color: #155724; }
    .badge-dibatalkan { background-color: #f8d7da; color: #721c24; }
    .navbar { padding: 0 24px; }

    @media (max-width: 767.98px) {
        .order-card .row.g-3 {
            flex-direction: column !important;
        }
        .order-card .col-md-6.col-12 {
            max-width: 100% !important;
            flex: 0 0 100%;
        }
        .order-card .d-flex.flex-wrap.gap-2 {
            gap: 0.3rem 0.9rem !important;
            flex-wrap: wrap !important;
        }
            .fade-up, .fade-up.show {
        opacity: 1 !important;
        transform: none !important;
        transition: none !important;
        animation: none !important;
    }
    }
    @media (max-width: 576px) {
        .order-card .d-flex.flex-wrap.gap-2 {
            overflow-x: auto;
            flex-wrap: nowrap;
        }
            .fade-up, .fade-up.show {
        opacity: 1 !important;
        transform: none !important;
        transition: none !important;
        animation: none !important;
    }
    }


    </style>

    {{-- Hero --}}
    <section class="position-relative text-center text-white mb-5 fade-up" style="
        height: 200px;
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)),
                    url('{{ asset('assets/img/landing/7.png') }}') center/cover no-repeat;">
        <div class="h-100 d-flex flex-column justify-content-center align-items-center">
            <h2 class="fw-bold">Pesanan Saya</h2>
            <p class="text-white-50 small mb-0">Lihat riwayat pesanan dan status pembayaran Anda</p>
        </div>
    </section>

    <div class="container page-container fade-up">
    <h3 class="text-maroon fw-bold mb-4"><i class="bi bi-list-check me-2"></i>Pesanan Saya</h3>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabs + Search inline --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap fade-up">
        <ul class="nav nav-pills">
        <li class="nav-item"><a href="#" class="nav-link active status-filter" data-status="all">All</a></li>
        <li class="nav-item"><a href="#" class="nav-link status-filter" data-status="menunggu">Menunggu</a></li>
        <li class="nav-item"><a href="#" class="nav-link status-filter" data-status="diproses">Diproses</a></li>
        <li class="nav-item"><a href="#" class="nav-link status-filter" data-status="selesai">Selesai</a></li>
        <li class="nav-item"><a href="#" class="nav-link status-filter" data-status="dibatalkan">Dibatalkan</a></li>
        </ul>
        <input type="text" id="searchOrder" class="form-control search-bar" placeholder="Cari no. pemesanan...">
    </div>

    <div class="row fade-up">
        @forelse($listPemesanan as $pesanan)
        @php
            $terminCount = str_starts_with($pesanan->metode_pembayaran, 'termin')
            ? (int) filter_var($pesanan->metode_pembayaran, FILTER_SANITIZE_NUMBER_INT)
            : 1;
            $payMap = $pesanan->pembayaran->keyBy('termin_ke');
            $status = $pesanan->status_pemesanan;
            $statusClass = match($status) {
            'selesai'    => 'badge-selesai',
            'diproses'   => 'badge-diproses',
            'dibatalkan' => 'badge-dibatalkan',
            default      => 'badge-menunggu',
            };
        @endphp

        <div class="col-md-6 mb-4 order-card-container fade-up"
            data-status="{{ $status }}"
            data-code="{{ strtolower($pesanan->kode_pemesanan) }}">
            <div class="card order-card h-100 p-3">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                <h5 class="mb-1 fw-semibold text-maroon order-code">{{ $pesanan->kode_pemesanan }}</h5>
                <small class="text-muted">{{ $pesanan->created_at->translatedFormat('d F Y, H:i:s') }}</small>
                </div>
                <span class="badge badge-status {{ $statusClass }}">
                {{ ucfirst($status) }}
                </span>
            </div>

            <div class="row g-3 mb-3 fade-up">
                {{-- Pembayaran --}}
                <div class="col-6">
                <h6 class="text-maroon mb-2">Pembayaran</h6>
                @for($t=1; $t<=$terminCount; $t++)
                    @php $p = $payMap->get($t); @endphp
                    <div class="mb-2 small">
                    <strong>Termin {{ $t }}:</strong><br>
                    @if($p && $p->bukti_transfer)
                        <span>{{ \Carbon\Carbon::parse($p->tanggal_pembayaran)->format('d M Y, H:i') }}</span><br>
                        @php
                        $v = $p->status_verifikasi;
                        $c = match($v) {
                            'diterima' => 'bg-success',
                            'ditolak'  => 'bg-danger',
                            default    => 'bg-primary',
                        };
                        @endphp
                        <span class="badge {{ $c }} mt-1">{{ ucfirst($v) }}</span>
                    @else
                        <span class="badge bg-warning text-dark">Belum bayar</span>
                    @endif
                    </div>
                @endfor
                </div>

                {{-- Produk --}}
                <div class="col-6">
                <h6 class="text-maroon mb-2">Produk</h6>
                @forelse($pesanan->detailPemesanan as $item)
                    <div class="mb-2 d-flex align-items-center small">
                    @php $img = $item->varianProduk->produk->gambars->first(); @endphp
                    @if($img)
                        <img src="{{ asset('storage/'.$img->path) }}" alt=""
                            class="me-2" style="width:40px; height:40px; object-fit:cover; border-radius:4px;">
                    @else
                        <span class="me-2" style="width:40px; height:40px; display:inline-block;
                            background:#f0f0f0; border-radius:4px;"></span>
                    @endif
                    {{ $item->varianProduk->tipe ?? '–' }}&nbsp;×&nbsp;<strong>{{ $item->kuantitas }}</strong>
                    </div>
                @empty
                    <div class="text-muted small">–</div>
                @endforelse
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center fade-up">
                <div class="fw-semibold">Total:</div>
                <div class="fw-bold fs-5 text-maroon">
                Rp{{ number_format($pesanan->total_harga,0,',','.') }}
                </div>
            </div>

            <div class="mt-3 text-end fade-up">
                <a href="{{ route('pemesanan.pembayaran',['pemesanan_id'=>$pesanan->id]) }}"
                class="btn btn-maroon btn-sm me-2">
                <i class="bi bi-wallet2 me-1"></i> Lihat/Upload
                </a>
                <a href="{{ route('pemesanan.detail',['pemesanan_id'=>$pesanan->id]) }}"
                class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-info-circle me-1"></i> Detail
                </a>
            </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted">Belum ada data pesanan.</div>
        @endforelse
    </div>
    </div>

    <script>
    function applyFilters() {
        const tab   = document.querySelector('.status-filter.active').dataset.status;
        const query = document.getElementById('searchOrder').value.toLowerCase();
        document.querySelectorAll('.order-card-container').forEach(el => {
        const status   = el.dataset.status;
        const code     = el.dataset.code;
        const okTab    = tab === 'all'
            ? ['menunggu','diproses'].includes(status)
            : status === tab;
        const okSearch = code.includes(query);
        el.style.display = (okTab && okSearch) ? 'block' : 'none';
        });
    }

    document.querySelectorAll('.status-filter').forEach(a => {
        a.addEventListener('click', e => {
        e.preventDefault();
        document.querySelectorAll('.status-filter').forEach(x=>x.classList.remove('active'));
        a.classList.add('active');
        applyFilters();
        });
    });

    document.getElementById('searchOrder').addEventListener('input', applyFilters);
    applyFilters();
    </script>
@endsection
