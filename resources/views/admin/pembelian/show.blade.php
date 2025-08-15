@extends('admin.components.app')

    <head>
        <title>@yield('title', 'Detail Pembelian Varian Produk | Insulmart')</title>
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

    /* PAKSA full-bleed: hilangkan padding kiri/kanan area main */
    #mainContent { padding-left: 0 !important; padding-right: 0 !important; }

    .text-merah { color: var(--color-merah-tua) !important; }
    .btn-maroon {
        background: var(--color-gradient); color: #fff; border: none; border-radius: 2em;
        padding: 0.6rem 1.5rem; font-weight: 500; transition: all 0.3s ease;
    }
    .btn-maroon:hover {
        background: var(--color-gradient-hover); color: #fff;
        transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139, 0, 0, 0.2);
    }
    .btn-outline-maroon {
        color: var(--color-merah-tua); border: 2px solid var(--color-merah-tua);
        border-radius: 2em; padding: 0.5rem 1.2rem; font-weight: 500; transition: all 0.3s ease;
    }
    .btn-outline-maroon:hover {
        background: var(--color-gradient); color: #fff; border-color: transparent;
        transform: translateY(-2px);
    }

    .card-custom { border-radius: 1rem; border: none; box-shadow: 0 4px 18px rgba(139,0,0,.08); }
    .badge-custom { padding: 0.5rem 1.2rem; border-radius: 2em; font-weight: 500; font-size: 0.9rem; }

    .info-label { color: #6c757d; font-size: 0.9rem; margin-bottom: 0.3rem; }
    .info-value { color: #2d3338; font-weight: 500; font-size: 1.1rem; }

    .img-product { max-height: 200px; object-fit: contain; border-radius: 1rem; }
    .product-badge {
        background: var(--color-maroon-light); color: var(--color-merah-tua);
        font-weight: 500; padding: 0.5rem 1rem; border-radius: 2em; display: inline-block; margin-top: 1rem;
    }

    .btn-po-gradient {
        display: inline-block; background: linear-gradient(135deg, #d61e1e, #8b0000);
        color: #fff; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 500;
        transition: transform .08s ease, opacity .2s ease, box-shadow .2s ease, background .2s ease;
    }
    .btn-po-gradient:hover {
        opacity: 0.95; color: #fff; background: linear-gradient(135deg, #e62e2e, #a50000);
        box-shadow: 0 4px 12px rgba(214, 30, 30, 0.3);
    }
    .btn-po-gradient:active { transform: scale(.98); }
</style>

<main class="main-content bg-light" id="mainContent">
  {{-- full-bleed container --}}
  <div class="container-fluid px-0">
    {{-- Header: juga full-bleed --}}
    <div class="mb-4 border-bottom pb-3 px-3 px-md-4">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
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

    {{-- Row full-bleed (tanpa margin kiri/kanan) --}}
    <div class="row mx-0 g-3 g-xl-4">
      {{-- KIRI: Informasi Pembelian --}}
      <div class="col-12 col-xl-8">
        <div class="card card-custom h-100">
          <div class="card-body p-4">
            <h5 class="card-title text-merah mb-4">
              <i class="bi bi-info-circle-fill me-2"></i> Informasi Pembelian
            </h5>

            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
              <div class="d-flex align-items-start gap-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:var(--color-maroon-light);color:var(--color-merah-tua)">
                  <i class="bi bi-box-seam fs-5"></i>
                </div>
                <div>
                  <div class="fw-semibold" style="font-size:1.1rem">
                    {{ data_get($pembelian, 'varian.produk.nama_produk', '-') }}
                  </div>
                  <div class="text-muted small">
                    {{ data_get($pembelian, 'varian.tipe', '-') }}
                  </div>
                  {{-- <a href="{{ route('pembelian.produk.downloadPo', $pembelian->id) }}" class="btn btn-po-gradient mt-2">
                    <i class="bi bi-download me-1"></i> Download PO
                  </a> --}}
                </div>
              </div>

              <div class="text-end">
                @php
                  $statusClass = [
                    'pending' => 'warning',
                    'selesai' => 'success',
                    'dibatalkan' => 'danger'
                  ][$pembelian->status] ?? 'secondary';
                @endphp
                <div class="mb-2">
                  <span class="badge bg-{{ $statusClass }}">{{ ucfirst($pembelian->status) }}</span>
                </div>
                <div class="small text-muted">Total Harga</div>
                <div class="fw-bold fs-4 text-merah">
                  Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}
                </div>
              </div>
            </div>

            <hr class="my-3">

            <div class="row g-3">
              <div class="col-6 col-md-3">
                <div class="info-label">Jumlah</div>
                <div class="info-value">{{ $pembelian->qty }}</div>
              </div>
              <div class="col-6 col-md-3">
                <div class="info-label">Harga Satuan</div>
                <div class="info-value">Rp {{ number_format($pembelian->harga_satuan, 0, ',', '.') }}</div>
              </div>
              <div class="col-6 col-md-3">
                <div class="info-label">Tanggal Pembelian</div>
                <div class="info-value">{{ optional($pembelian->tanggal_beli)->format('d M Y') ?: '-' }}</div>
              </div>
              <div class="col-6 col-md-3">
                <div class="info-label">Dibuat Pada</div>
                <div class="info-value">{{ optional($pembelian->created_at)->format('d M Y H:i') ?: '-' }}</div>
              </div>
            </div>

            @if($pembelian->catatan)
              <hr class="my-3">
              <div>
                <div class="info-label">Catatan</div>
                <div class="fw-medium">{{ $pembelian->catatan }}</div>
              </div>
            @endif
          </div>
        </div>
      </div>

      {{-- KANAN: Detail Distributor + Detail Produk (stack) --}}
      <div class="col-12 col-xl-4 d-flex flex-column gap-3">

        {{-- DETAIL PRODUK --}}
        <div class="card card-custom">
          <div class="card-body p-4">
            <h5 class="card-title text-merah mb-4">
              <i class="bi bi-box-seam-fill me-2"></i> Detail Produk
            </h5>

            <div class="text-center mb-4">
              @if(optional($pembelian->varian->produk)->gambars && $pembelian->varian->produk->gambars->count() > 0)
                <img src="{{ asset('storage/' . $pembelian->varian->produk->gambars->first()->path) }}"
                     alt="{{ $pembelian->varian->produk->nama_produk }}"
                     class="img-fluid rounded"
                     style="max-height: 200px; object-fit: contain;">
              @else
                <div class="bg-light rounded p-4">
                  <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                </div>
              @endif
            </div>

            <div class="mb-2">
              <div class="info-label">Jenis Produk</div>
              <div class="info-value">{{ ucfirst(data_get($pembelian, 'varian.produk.jenis_produk', '-')) }}</div>
            </div>

            <div class="mb-2">
              <div class="info-label">Varian</div>
              <div class="info-value">
                {{ data_get($pembelian, 'varian.nama_varian', data_get($pembelian, 'varian.tipe', '-')) }}
              </div>
            </div>

            <div class="mb-2">
              <div class="info-label">Stok Saat Ini</div>
              <div class="info-value">{{ number_format(data_get($pembelian, 'varian.stok', 0), 0, ',', '.') }} unit</div>
            </div>

            <div>
              <div class="info-label">Harga Jual</div>
              <div class="info-value">Rp {{ number_format(data_get($pembelian, 'varian.harga', 0), 0, ',', '.') }}</div>
            </div>
          </div>
        </div>

        {{-- DETAIL DISTRIBUTOR --}}
        <div class="card card-custom">
          <div class="card-body p-4">
            <h5 class="card-title text-merah mb-4">
              <i class="bi bi-building me-2"></i> Detail Distributor
            </h5>

            @if($pembelian->distributor)
              @php
                $d = $pembelian->distributor;
                $alamatSingkat = collect([$d->village, $d->district, $d->regency])->filter()->implode(', ');
                $prov = $d->province ? ' - '.$d->province : '';
                $kp   = $d->kode_pos ? ' ('.$d->kode_pos.')' : '';
                $mapsQuery = $d->coordinate && trim($d->coordinate) !== ''
                    ? $d->coordinate
                    : trim(($d->alamat_lengkap ?? '').' '.$alamatSingkat.$prov.$kp);
              @endphp

              <div class="mb-3">
                <div class="info-label">Nama PT</div>
                <div class="info-value">{{ $d->name_pt ?? '-' }}</div>
              </div>

              <div class="row">
                <div class="col-6 mb-3">
                  <div class="info-label">PIC</div>
                  <div class="info-value">{{ $d->contact_person ?? '—' }}</div>
                </div>
                <div class="col-6 mb-3">
                  <div class="info-label">Telepon</div>
                  <div class="info-value">{{ $d->phone ?? '—' }}</div>
                </div>
              </div>

              <div class="mb-3">
                <div class="info-label">NPWP</div>
                <div class="info-value">{{ $d->npwp ?? '-' }}</div>
              </div>

              <div class="mb-3">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $d->email ?? '—' }}</div>
              </div>

              <div class="mb-3">
                <div class="info-label">Alamat</div>
                <div class="info-value">
                  {{ $alamatSingkat ? $alamatSingkat.$prov.$kp : ($d->alamat_lengkap ?? '—') }}
                </div>
              </div>

              <div class="mb-3">
                <div class="info-label">Catatan</div>
                <div class="info-value">{{ $d->notes ?? '—' }}</div>
              </div>

              <div class="d-flex gap-2 flex-wrap">
                @if(!empty($mapsQuery))
                  <a href="https://www.google.com/maps?q={{ urlencode($mapsQuery) }}"
                     target="_blank" rel="noopener"
                     class="btn btn-outline-maroon">
                    <i class="bi bi-geo-alt me-1"></i> Buka di Maps
                  </a>
                @endif
                <a href="{{ route('distributor.show', $d->id) }}" class="btn btn-maroon">
                  <i class="bi bi-eye me-1"></i> Lihat Distributor
                </a>
              </div>
            @else
              <div class="text-muted">Distributor tidak tersedia pada transaksi ini.</div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div> {{-- /container-fluid --}}
</main>
@endsection
