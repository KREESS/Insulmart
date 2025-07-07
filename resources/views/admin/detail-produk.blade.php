@extends('admin.components.app')

@section('content')

<style>
:root {
  --color-merah-tua: #8B0000;
  --color-merah-hover: #a41515;
}

/* Warna dasar tombol carousel */
.carousel-control-prev-icon,
.carousel-control-next-icon {
  background-color: var(--color-merah-tua);
  border-radius: 50%;
  background-size: 60% 60%;
  padding: 10px;
  mask-image: none;
  -webkit-mask-image: none;
}

/* Hover tidak putih, tetap pakai tema */
.carousel-control-prev:hover .carousel-control-prev-icon,
.carousel-control-next:hover .carousel-control-next-icon {
  background-color: var(--color-merah-hover);
}

/* Ubah ikon default ke bentuk panah agar lebih modern */
.carousel-control-prev-icon {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3E%3C/svg%3E");
}

.carousel-control-next-icon {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
}

</style>

<main class="main-content p-4 bg-light" id="mainContent">
  <div class="mb-4 border-bottom pb-2">
    <h3 class="text-merah fw-bold mb-1">
      <i class="bi bi-eye me-2"></i> Detail Produk
    </h3>
    <p class="text-muted">Informasi lengkap tentang produk <strong>{{ $produk->nama_produk }}</strong> beserta semua variannya.</p>
  </div>

  <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
    <div class="row g-0">
      <div class="col-md-5 p-4 bg-white border-end">
        {{-- Carousel Gambar --}}
        @if($produk->gambars->count())
        <div id="carouselProduk" class="carousel slide mb-3" data-bs-ride="carousel">
          <div class="carousel-inner rounded shadow-sm">
            @foreach($produk->gambars as $index => $gambar)
              <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $gambar->path) }}"
                     class="d-block w-100" style="max-height: 260px; object-fit: contain;"
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

        <span class="badge rounded-pill px-3 py-2 bg-danger-subtle text-danger fw-semibold mt-2 d-inline-block">
          {{ ucfirst($produk->jenis_produk) }}
        </span>
      </div>

      <div class="col-md-7 p-4">
        <h4 class="text-merah fw-bold">{{ $produk->nama_produk }}</h4>
        <p class="mb-3" style="white-space: pre-line;"><strong>Deskripsi:</strong><br>{{ $produk->deskripsi }}</p>

        @php
          $min = $produk->varians->min('harga');
          $max = $produk->varians->max('harga');
        @endphp

        <p class="mb-3"><strong>Harga Global:</strong>
          <span class="text-success fw-bold">
            Rp{{ number_format($min, 0, ',', '.') }}
            @if($max !== $min)
              ~ Rp{{ number_format($max, 0, ',', '.') }}
            @endif
          </span>
        </p>

        @if($produk->varians->count() > 0)
        <div class="table-responsive mt-4">
          <h5 class="mb-3 text-dark"><i class="bi bi-list-ul me-1"></i> Daftar Varian</h5>
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
              <tr>
                <th>Tipe</th>
                <th>Ukuran</th>
                <th>Ketebalan (mm)</th>
                <th>Densitas (kg/m³)</th>
                <th>Harga</th>
                <th>Stok</th>
              </tr>
            </thead>
            <tbody>
              @foreach($produk->varians as $varian)
              <tr>
                <td>{{ $varian->tipe }}</td>
                <td>{{ $varian->ukuran }}</td>
                <td class="text-center">{{ $varian->ketebalan }}</td>
                <td class="text-center">{{ $varian->densitas }}</td>
                <td class="text-success fw-semibold">Rp{{ number_format($varian->harga, 0, ',', '.') }}</td>
                <td class="text-center">{{ $varian->stok }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
          <p class="text-muted">Tidak ada varian yang tersedia untuk produk ini.</p>
        @endif

        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary mt-4">
          <i class="bi bi-arrow-left"></i> Kembali ke Daftar Produk
        </a>
      </div>
    </div>
  </div>
</main>
@endsection
