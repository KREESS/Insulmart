@extends('admin.components.app')
    <head>
        <title>@yield('title', 'Edit Produk Admin | Insulmart')</title>
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
  .gambar-wrapper {
    position: relative;
    background-color: #f8f9fa;
    padding: 5px;
    border-radius: 6px;
    border: 1px solid #dee2e6;
    height: 100%;
  }
  .gambar-wrapper img {
    width: 100%;
    height: 150px;
    object-fit: contain;
    border-radius: 5px;
  }
  .btn-hapus-gambar {
    position: absolute;
    top: 6px;
    right: 6px;
    z-index: 10;
  }
</style>
<main class="main-content p-4 bg-light" id="mainContent">
  <div class="container">
    <h2 class="mb-4"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Produk</h2>

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

    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
      @csrf
      @method('PUT')

      <div class="row g-3">
        <div class="col-md-6">
          <label for="nama_produk" class="form-label">Nama Produk</label>
          <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
        </div>

        <div class="col-md-6">
          <label for="jenis_produk" class="form-label">Jenis Produk</label>
          <select name="jenis_produk" id="jenis_produk" class="form-select" onchange="toggleInputJenis(this.value)" required>
            <option disabled>Pilih jenis</option>
            <option value="rockwool" {{ $produk->jenis_produk == 'rockwool' ? 'selected' : '' }}>Rockwool</option>
            <option value="glasswool" {{ $produk->jenis_produk == 'glasswool' ? 'selected' : '' }}>Glasswool</option>
            <option value="aluminium_foil" {{ $produk->jenis_produk == 'aluminium_foil' ? 'selected' : '' }}>Aluminium Foil</option>
            <option value="lainnya">+ Tambah Jenis Produk Baru</option>
          </select>
          <input type="text" id="inputJenisBaru" name="jenis_produk_baru" class="form-control mt-2 {{ old('jenis_produk') == 'lainnya' ? '' : 'd-none' }}" placeholder="Tulis jenis produk baru..." value="{{ old('jenis_produk_baru') }}">
        </div>

        <div class="col-12">
          <label for="deskripsi" class="form-label">Deskripsi Produk</label>
          <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
        </div>

        <div class="col-12">
          <label for="gambar" class="form-label">Upload Gambar Baru (Opsional)</label>
          <input type="file" name="gambar[]" id="gambar" class="form-control" accept="image/*" multiple>
          <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar. Minimal 3 gambar jika upload baru.</small>

          <div id="preview-gambar" class="row mt-3"></div>
        </div>

        <div class="col-12 mt-4">
          <label class="form-label fw-semibold">Gambar Saat Ini:</label>
          <div class="row">
            @forelse ($produk->gambars as $gambar)
              <div class="col-md-3 mb-3">
                <div class="gambar-wrapper">
                  <img 
                      src="{{ 
                          $gambar->path && file_exists(public_path('storage/' . $gambar->path)) 
                              ? asset('storage/' . $gambar->path) 
                              : asset('images/no-image.png') 
                      }}" 
                      alt="Gambar Produk" 
                      class="img-fluid rounded">
                  <button
                    type="button"
                    class="btn btn-danger btn-sm rounded-circle btn-delete-gambar"
                    data-id="{{ $gambar->id }}"
                  >
                    <i class="bi bi-trash-fill"></i>
                  </button>
                </div>
              </div>
            @empty
              <p class="text-muted">Belum ada gambar yang diunggah.</p>
            @endforelse
          </div>
        </div>
      </div>

      <hr class="my-4">

      <h5>Varian Produk</h5>
      <p class="text-muted">Perbarui kombinasi varian produk seperti ukuran, ketebalan, densitas, harga & stok.</p>

      <div id="varian-wrapper">
        @foreach($produk->varians as $i => $varian)
        <div class="row g-2 mb-3 varian-row">
          <div class="col-md-2"><input type="text" name="varian[{{ $i }}][tipe]" class="form-control" value="{{ $varian->tipe }}" required></div>
          <div class="col-md-2"><input type="text" name="varian[{{ $i }}][ukuran]" class="form-control" value="{{ $varian->ukuran }}" required></div>
          <div class="col-md-2"><input type="number" name="varian[{{ $i }}][ketebalan]" class="form-control" value="{{ $varian->ketebalan }}" required></div>
          <div class="col-md-2"><input type="number" name="varian[{{ $i }}][densitas]" class="form-control" value="{{ $varian->densitas }}" required></div>
          <div class="col-md-3"><input type="number" name="varian[{{ $i }}][harga]" class="form-control" value="{{ $varian->harga }}" required></div>
          <div class="col-md-2"><input type="number" name="varian[{{ $i }}][stok]" class="form-control" value="{{ $varian->stok }}" required></div>
          <div class="col-md-2"><input type="text" name="varian[{{ $i }}][ketersediaan]" class="form-control" value="{{ $varian->status_ketersediaan }}" required></div>
          <div class="col-md-1 text-end"><button type="button" class="btn btn-danger btn-sm btn-remove-varian"><i class="bi bi-x"></i></button></div>
                <input type="hidden" name="varian[{{$i}}][id]" value="{{ $varian->id }}">
        </div>
        @endforeach
      </div>

      <button type="button" class="btn btn-outline-success btn-sm" id="btn-add-varian">
        <i class="bi bi-plus-circle me-1"></i> Tambah Varian
      </button>

      <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <button type="submit" class="btn btn-merah"><i class="bi bi-save me-1"></i> Update Produk</button>
      </div>
    </form>
    <form id="form-delete-gambar" method="POST" style="display: none;">
      @csrf
      @method('DELETE')
    </form>
  </div>
</main>
<br>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-delete-gambar').forEach(button => {
      button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        Swal.fire({
          title: 'Yakin ingin menghapus gambar ini?',
          text: "Tindakan ini tidak dapat dibatalkan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            const form = document.getElementById('form-delete-gambar');
            form.setAttribute('action', `/admin/produk/gambar/${id}`);
            form.submit();
          }
        });
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

document.getElementById('gambar').addEventListener('change', function (event) {
  const previewContainer = document.getElementById('preview-gambar');
  previewContainer.innerHTML = '';
  Array.from(event.target.files).forEach(file => {
    const reader = new FileReader();
    reader.onload = function (e) {
      const col = document.createElement('div');
      col.className = 'col-md-3 mb-2';
      col.innerHTML = `
        <div class="gambar-wrapper">
          <img src="${e.target.result}" class="img-fluid" />
        </div>
      `;
      previewContainer.appendChild(col);
    };
    reader.readAsDataURL(file);
  });
});

document.addEventListener('DOMContentLoaded', function () {
  let varianIndex = {{ count($produk->varians) }};
  const wrapper = document.getElementById('varian-wrapper');
  const addBtn = document.getElementById('btn-add-varian');

  addBtn.addEventListener('click', () => {
    const row = document.createElement('div');
    row.classList.add('row', 'g-2', 'mb-3', 'varian-row');
    row.innerHTML = `
      <div class="col-md-2"><input type="text" name="varian[${varianIndex}][tipe]" class="form-control" placeholder="Tipe" required></div>
      <div class="col-md-2"><input type="text" name="varian[${varianIndex}][ukuran]" class="form-control" placeholder="Ukuran" required></div>
      <div class="col-md-2"><input type="number" name="varian[${varianIndex}][ketebalan]" class="form-control" placeholder="Ketebalan" required></div>
      <div class="col-md-2"><input type="number" name="varian[${varianIndex}][densitas]" class="form-control" placeholder="Densitas" required></div>
      <div class="col-md-3"><input type="number" name="varian[${varianIndex}][harga]" class="form-control" placeholder="Harga (Rp)" required></div>
      <div class="col-md-2"><input type="number" name="varian[${varianIndex}][stok]" class="form-control" placeholder="Stok (Ball)" required></div>
      <div class="col-md-2"><input type="text" name="varian[${varianIndex}][ketersediaan]" class="form-control" placeholder="Ketersediaan (ready)" required></div>
      <div class="col-md-1 text-end"><button type="button" class="btn btn-danger btn-sm btn-remove-varian"><i class="bi bi-x"></i></button></div>
    `;
    wrapper.appendChild(row);
    varianIndex++;
  });

  wrapper.addEventListener('click', function (e) {
    const button = e.target.closest('button.btn-remove-varian');
    if (button) {
      const row = button.closest('.varian-row');
      if (row) row.remove();
    }
  });
});
</script>
@endsection
