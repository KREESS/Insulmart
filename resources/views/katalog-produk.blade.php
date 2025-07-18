@extends('components.layout-bootstrap')

<head>
    <title>@yield('title', 'Katalog Produk Insulasi | Insulmart')</title>
    <!-- Tag lain seperti meta, link CSS, dll -->
</head>

@section('content')
  <style>
    :root {
      --color-merah-tua: #8B0000;
    }

    .text-merah {
      color: var(--color-merah-tua);
    }

    .card {
      transition: all 0.3s ease-in-out;
    }

    .card:hover {
      transform: translateY(-5px) scale(1.01);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
    }

    .produk-img-wrapper {
      height: 220px;
      background-color: #fff;
      overflow: hidden;
      border-bottom: 1px solid #eee;
      position: relative;
    }

    .produk-img {
      max-height: 100%;
      max-width: 100%;
      object-fit: contain;
      display: block;
      margin: auto;
    }

    .btn-katalog {
      background-color: var(--color-merah-tua);
      color: white;
      padding: 8px 16px;
      border-radius: 0.5rem;
      border: none;
      font-size: 0.875rem;
      transition: background-color 0.3s ease;
    }

    .btn-katalog:hover {
      background-color: #a41515;
      color: white;
    }

    @media (max-width: 576px) {
      .produk-img-wrapper {
        height: 180px;
      }
    }
        .navbar {
          padding: 0px 24px;
      }
  </style>

  {{-- Hero Section --}}
  <section class="position-relative text-center text-white fade-up" style="
    height: 260px;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)),
                url('{{ asset('assets/img/landing/7.png') }}') center center / cover no-repeat;">  
    <div class="position-relative h-100 d-flex flex-column justify-content-center align-items-center">
      <h2 class="fw-bold mb-1">Katalog Produk Insulasi</h2>
      <p class="text-white-50 small mb-0">Unduh katalog produk sesuai kebutuhan Anda</p>
    </div>
  </section>

  {{-- Section Katalog --}}
  <section class="py-5 bg-light">
    <div class="container">
      <div class="text-center mb-5 fade-up">
        <h2 class="fw-bold text-merah">Katalog Produk</h2>
        <p class="text-muted">Klik tombol untuk mengunduh katalog produk Rockwool pilihan kami</p>
      </div>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @forelse ($produks as $product)
          @php
              $gambars = $product->gambars;
              $nama = $product->nama_produk;
              $slug = \Illuminate\Support\Str::slug($nama);

              $pdfRelativePath = "assets/img/New folder/{$slug}.pdf"; // relatif ke public
              $pdfFullPath = public_path($pdfRelativePath);
              $pdfUrl = asset($pdfRelativePath);
              $hasPdf = file_exists($pdfFullPath);
          @endphp

          <div class="col fade-up">
            <div class="card h-100 shadow-sm rounded-4 overflow-hidden">
              {{-- Gambar --}}
              @if ($gambars->count())
                <div id="carouselKatalog{{ $product->id }}" class="carousel slide produk-img-wrapper" data-bs-ride="carousel" data-bs-interval="3000">
                  <div class="carousel-inner h-100 w-100">
                    @foreach ($gambars as $index => $gambar)
                      <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                        <div class="d-flex justify-content-center align-items-center h-100">
                          <img src="{{ asset('storage/' . $gambar->path) }}"
                              class="produk-img"
                              alt="{{ $nama }} {{ $index + 1 }}">
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              @else
                <div class="produk-img-wrapper d-flex justify-content-center align-items-center">
                  <img src="{{ asset('assets/img/no-img-ava.jpg') }}"
                      class="produk-img"
                      alt="{{ $nama }}">
                </div>
              @endif

              {{-- Info dan tombol --}}
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-merah mb-2">{{ strtoupper($nama) }}</h5>
                <p class="card-text text-muted small flex-grow-1">Klik tombol di bawah untuk mengunduh katalog produk ini.</p>
                <div class="mt-auto">
                  @if ($hasPdf)
                    <a href="{{ $pdfUrl }}" target="_blank" class="btn btn-katalog w-100">
                      <i class="bi bi-download me-1"></i> Download Katalog {{ strtoupper($nama) }}
                    </a>
                  @else
                    <button class="btn btn-secondary w-100" disabled>
                      <i class="bi bi-file-earmark-x me-1"></i> Katalog Belum Tersedia
                    </button>
                  @endif
                </div>
              </div>
            </div>
          </div>

        @empty
          <div class="col-12 text-center">
            <h5 class="text-muted">Belum ada data produk tersedia.</h5>
          </div>
        @endforelse
      </div>

    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
