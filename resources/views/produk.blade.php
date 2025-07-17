@extends('components.layout-bootstrap')

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

  .carousel-inner,
  .carousel-item {
    height: 100%;
    width: 100%;
  }

  .produk-img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    display: block;
    margin: auto;
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

{{-- Hero Banner Produk --}}
<section class="position-relative text-center text-white fade-up" style="
  height: 260px;
  background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)),
              url('{{ asset('assets/img/landing/7.png') }}') center center / cover no-repeat;">   <div class="position-relative h-100 d-flex flex-column justify-content-center align-items-center">
    <h2 class="fw-bold mb-1">Produk Rockwool Kami</h2>
    <p class="text-white-50 small mb-0">Insulasi cerdas untuk kenyamanan rumah & industri</p>
  </div>
</section>


<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5 fade-up">
      <h2 class="fw-bold text-merah">Produk Pilihan Kami</h2>
      <p class="text-muted">Eksplorasi koleksi produk unggulan terbaik kami dengan kualitas terjamin</p>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
      @forelse ($products as $product)
        <div class="col fade-up">
          <a href="{{ route('produk.detail', $product->slugified_nama) }}" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm rounded-4 overflow-hidden">

              {{-- Carousel Gambar --}}
              @if ($product->gambars->count() > 0)
              <div id="carouselProduk{{ $product->id }}" class="carousel slide produk-img-wrapper" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner h-100 w-100">
                  @foreach ($product->gambars as $index => $gambar)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                      <div class="d-flex justify-content-center align-items-center h-100">
                        <img src="{{ asset('storage/' . $gambar->path) }}"
                             class="produk-img"
                             alt="Gambar {{ $index + 1 }}">
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
              @else
              <div class="produk-img-wrapper d-flex justify-content-center align-items-center">
                <img src="{{ asset('assets/img/no-img-ava.jpg') }}"
                     class="produk-img"
                     alt="{{ $product->nama_produk }}">
              </div>
              @endif

                {{-- Konten --}}
                <div class="card-body d-flex flex-column">
                <h5 class="card-title text-merah mb-2">{{ $product->nama_produk }}</h5>

                <p class="card-text text-muted small flex-grow-1">
                    {{ \Illuminate\Support\Str::limit($product->deskripsi, 80) }}
                </p>

                @php
                    $hargaMin = $product->varians->min('harga');
                    $hargaMax = $product->varians->max('harga');
                @endphp

                <div class="mt-auto">
                    <p class="text-dark fw-semibold mb-1">Harga:</p>
                    <p class="fw-bold text-danger fs-5 mb-0">
                    @if ($hargaMin === $hargaMax)
                        Rp{{ number_format($hargaMin, 0, ',', '.') }}
                    @else
                        Rp{{ number_format($hargaMin, 0, ',', '.') }}
                        <span class="text-muted">–</span>
                        Rp{{ number_format($hargaMax, 0, ',', '.') }}
                    @endif
                    </p>
                </div>
                </div>

            </div>
          </a>
        </div>
      @empty
        <div class="col-12 text-center">
          <h5 class="text-muted">Tidak ada produk tersedia.</h5>
        </div>
      @endforelse
    </div>
  </div>
</section>

{{-- Bootstrap JS Carousel --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
