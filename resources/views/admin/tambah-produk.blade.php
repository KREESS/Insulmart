@extends('admin.components.app')
    <head>
        <title>@yield('title', 'Tambah Produk Admin | Insulmart')</title>
        <!-- Tag lain seperti meta, link CSS, dll -->
    </head>
@section('content')
<style>
  .btn-merah {
    background-color: #8B0000;
    color: #fff;
    border-color: #8B0000;
  }

  .btn-merah:hover {
    background-color: #a41515;
    border-color: #a41515;
    color: #fff;
  }
</style>

<div class="main-content p-4">
  <div class="container">
    <h2 class="mb-4"><i class="bi bi-plus-circle me-2 text-success"></i>Tambah Produk Baru</h2>

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

    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
      @csrf

      {{-- INFO UTAMA PRODUK --}}
      <div class="row g-3">
        <div class="col-md-6">
          <label for="nama_produk" class="form-label">Nama Produk</label>
          <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Contoh: Rockwool" required>
        </div>

        <div class="col-md-6">
          <label for="jenis_produk" class="form-label">Jenis Produk</label>
          <select name="jenis_produk" id="jenis_produk" class="form-select" required onchange="toggleInputJenis(this.value)">
            <option disabled selected>Pilih jenis</option>
            <option value="rockwool">Rockwool</option>
            <option value="glasswool">Glasswool</option>
            <option value="aluminium_foil">Aluminium Foil</option>
            <option value="lainnya">+ Tambah Jenis Produk Baru</option>
          </select>

          <input type="text" id="inputJenisBaru" name="jenis_produk_baru" class="form-control mt-2 d-none" placeholder="Tulis jenis produk baru...">
        </div>

        <div class="col-12">
          <label for="deskripsi" class="form-label">Deskripsi Produk</label>
          <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" placeholder="Tulis deskripsi produk..."></textarea>
        </div>

        <div class="col-12 mb-3">
          <label for="gambar" class="form-label">Upload Gambar Produk</label>
          <input type="file" name="gambar[]" id="gambar" class="form-control" accept="image/*" multiple required>
          <small class="text-muted">Minimal 3 gambar. Format: JPG, PNG, JPEG.</small>
        </div>

        {{-- Tempat Preview Gambar --}}
        <div id="preview" class="d-flex flex-wrap gap-2 mt-3"></div>
      </div>

      <hr class="my-4">

      {{-- VARIAN PRODUK --}}
      <h5>Varian Produk</h5>
      <p class="text-muted">Masukkan kombinasi varian produk seperti ukuran, ketebalan, densitas, harga & stok.</p>

      <div id="varian-wrapper">
        <div class="row g-2 mb-3 varian-row">
          <div class="col-md-2">
            <input type="text" name="varian[0][tipe]" class="form-control" placeholder="Tipe (misal: S60/25)" required>
          </div>
          <div class="col-md-2">
            <input type="text" name="varian[0][ukuran]" class="form-control" placeholder="Ukuran" required>
          </div>
          <div class="col-md-2">
            <input type="number" name="varian[0][ketebalan]" class="form-control" placeholder="Ketebalan" required>
          </div>
          <div class="col-md-2">
            <input type="number" name="varian[0][densitas]" class="form-control" placeholder="Densitas" required>
          </div>
          <div class="col-md-3">
            <input type="number" name="varian[0][harga]" class="form-control" placeholder="Harga (Rp)" required>
          </div>
          <div class="col-md-2">
            <input type="number" name="varian[0][stok]" class="form-control" placeholder="Stok" required>
          </div>
          <div class="col-md-1 text-end">
            <button type="button" class="btn btn-danger btn-sm btn-remove-varian d-none"><i class="bi bi-x"></i></button>
          </div>
        </div>
      </div>

      <button type="button" class="btn btn-outline-success btn-sm" id="btn-add-varian">
        <i class="bi bi-plus-circle me-1"></i> Tambah Varian
      </button>

      <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>

        <button type="submit" class="btn btn-merah">
          <i class="bi bi-save me-1"></i> Simpan Produk
        </button>
      </div>
    </form>
  </div>
</div>
<br>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      const inputGambar = document.getElementById('gambar');
      const preview = document.getElementById('preview');

      if (!inputGambar || !preview) return;

      inputGambar.addEventListener('change', function (e) {
          preview.innerHTML = ''; // Kosongkan preview
          const files = e.target.files;
          if (!files.length) return;

          Array.from(files).forEach(file => {
              if (!file.type.startsWith('image/')) return;

              const reader = new FileReader();
              reader.onload = function (ev) {
                  const img = document.createElement('img');
                  img.src = ev.target.result;
                  img.className = 'img-thumbnail m-1';
                  img.style.maxWidth = '120px';
                  img.style.maxHeight = '120px';
                  img.style.objectFit = 'cover';
                  preview.appendChild(img);
              };
              reader.readAsDataURL(file);
          });
      });
  });
</script>


<script>
  function toggleInputJenis(value) {
    const inputBaru = document.getElementById('inputJenisBaru');
    if (value === 'lainnya') {
      inputBaru.classList.remove('d-none');
      inputBaru.required = true;
    } else {
      inputBaru.classList.add('d-none');
      inputBaru.required = false;
    }
  }
</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    let varianIndex = 1;
    const wrapper = document.getElementById('varian-wrapper');
    const addBtn = document.getElementById('btn-add-varian');

    addBtn.addEventListener('click', () => {
      const row = document.createElement('div');
      row.classList.add('row', 'g-2', 'mb-3', 'varian-row');
      row.innerHTML = `
        <div class="col-md-2"><input type="text" name="varian[${varianIndex}][tipe]" class="form-control" placeholder="Tipe (misal: S60/25)" required></div>
        <div class="col-md-2"><input type="text" name="varian[${varianIndex}][ukuran]" class="form-control" placeholder="Ukuran" required></div>
        <div class="col-md-2"><input type="number" name="varian[${varianIndex}][ketebalan]" class="form-control" placeholder="Ketebalan" required></div>
        <div class="col-md-2"><input type="number" name="varian[${varianIndex}][densitas]" class="form-control" placeholder="Densitas" required></div>
        <div class="col-md-3"><input type="number" name="varian[${varianIndex}][harga]" class="form-control" placeholder="Harga (Rp)" required></div>
        <div class="col-md-2"><input type="number" name="varian[${varianIndex}][stok]" class="form-control" placeholder="Stok" required></div>
        <div class="col-md-1 text-end">
          <button type="button" class="btn btn-danger btn-sm btn-remove-varian"><i class="bi bi-x"></i></button>
        </div>
      `;
      wrapper.appendChild(row);
      varianIndex++;
    });

    wrapper.addEventListener('click', function (e) {
      if (e.target.closest('.btn-remove-varian')) {
        e.target.closest('.varian-row').remove();
      }
    });
  });
</script>

@endsection
