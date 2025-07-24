@extends('admin.components.app')
    <head>
        <title>@yield('title', 'Produk Admin | Insulmart')</title>
        <!-- Tag lain seperti meta, link CSS, dll -->
    </head>
@section('content')

<style>
  :root {
    --color-merah-tua: #8B0000;
    --color-merah-hover: #a41515;
    --color-text: #ffffff;
  }

  .btn-merah {
    background-color: var(--color-merah-tua);
    border-color: var(--color-merah-tua);
    color: var(--color-text);
  }

  .btn-merah:hover {
    background-color: var(--color-merah-hover);
    border-color: var(--color-merah-hover);
    color: var(--color-text);
  }

  .btn-outline-merah {
    color: var(--color-merah-tua);
    border-color: var(--color-merah-tua);
  }

  .btn-outline-merah:hover {
    background-color: var(--color-merah-tua);
    color: var(--color-text);
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
  background-color: #fff;
  height: 200px;
  border-bottom: 1px solid #eee;
  overflow: hidden;
  position: relative;
}

.carousel-inner,
.carousel-item {
  height: 100%;
  width: 100%;
}

.carousel-item > div {
  height: 100%;
  width: 100%;
}

.produk-img {
  max-height: 100%;
  max-width: 100%;
  object-fit: contain;
  display: block;
}



</style>

<main class="main-content p-4 bg-light" id="mainContent">

  <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <div>
      <h3 class="mb-1 fw-bold text-merah d-flex align-items-center">
        📦 Daftar Produk
      </h3>
      <p class="text-muted small mb-0">Kelola semua produk yang tersedia di toko Anda dengan mudah.</p>
    </div>
    <a href="{{ route('produk.create') }}" class="btn btn-merah d-flex align-items-center gap-2 shadow-sm">
      <i class="bi bi-plus-circle"></i> Tambah Produk
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

  {{-- Daftar Produk --}}
  <div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse ($produks as $produk)
    <div class="col">
      <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden bg-white">
        @if ($produk->gambars->count() > 0)
          <div id="carouselProduk{{ $produk->id }}" class="carousel slide produk-img-wrapper" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner h-100 w-100">
              @foreach ($produk->gambars as $index => $gambar)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                  <div class="d-flex justify-content-center align-items-center h-100 w-100">
                    <img src="{{ asset('storage/' . $gambar->path) }}"
                        class="produk-img d-block"
                        alt="Gambar {{ $index + 1 }}">
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @else
          <div class="produk-img-wrapper">
            <img src="{{ asset('storage/' . $produk->gambar) }}" class="produk-img" alt="{{ $produk->nama_produk }}">
          </div>
        @endif


        <div class="card-body">
          <h5 class="card-title text-merah">{{ $produk->nama_produk }}</h5>
          <p class="text-muted mb-1"><i class="bi bi-tag me-1"></i>{{ ucfirst($produk->jenis_produk) }}</p>
          <p class="small text-secondary">{{ \Illuminate\Support\Str::limit($produk->deskripsi, 80) }}</p>

          @php
              $hargaMin = $produk->varians->min('harga');
              $hargaMax = $produk->varians->max('harga');
          @endphp

          <hr class="my-2">
          <p class="fw-bold mb-1 text-dark">Harga:</p>
          <p class="text-success fw-semibold mb-0">
            Rp{{ number_format($hargaMin, 0, ',', '.') }}
            @if($hargaMax !== $hargaMin)
              ~ Rp{{ number_format($hargaMax, 0, ',', '.') }}
            @endif
          </p>
        </div>

        <div class="card-footer bg-white border-0 d-flex justify-content-between px-3 pb-3">
          <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-outline-merah btn-sm px-3">
            <i class="bi bi-eye"></i> Lihat
          </a>
          <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-pencil-square"></i> Edit
          </a>
          <button type="button"
                  class="btn btn-outline-danger btn-sm px-3 btn-delete-produk"
                  data-id="{{ $produk->id }}">
            <i class="bi bi-trash3-fill"></i> Hapus
          </button>
        </div>
      </div>
    </div>
    @empty
    <div class="col-12 text-center">
      <h5 class="text-muted">Belum ada produk yang ditambahkan.</h5>
    </div>
    @endforelse
  </div>
  <form id="form-delete-produk" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
  </form>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const buttons = document.querySelectorAll('.btn-delete-produk');
  const formDelete = document.getElementById('form-delete-produk');

  buttons.forEach(button => {
    button.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      Swal.fire({
        title: 'Yakin ingin menghapus produk ini?',
        text: "Data yang dihapus tidak dapat dikembalikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          formDelete.setAttribute('action', `/admin/produk/${id}`);
          formDelete.submit();
        }
      });
    });
  });
});
</script>

@endsection
