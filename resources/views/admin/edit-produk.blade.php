@extends('admin.components.app')

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
    height: 100%; /* agar tingginya konsisten */
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

  .btn-hapus-gambar button {
    padding: 3px 7px;
    font-size: 0.75rem;
  }
</style>


<div class="main-content p-4">
  <div class="container">
    <h2 class="mb-4"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Produk</h2>

    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
      @csrf
      @method('PUT')

      {{-- INFO UTAMA PRODUK --}}
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
          <input type="text" id="inputJenisBaru" name="jenis_produk_baru" class="form-control mt-2 d-none" placeholder="Tulis jenis produk baru...">
        </div>

        <div class="col-12">
          <label for="deskripsi" class="form-label">Deskripsi Produk</label>
          <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
        </div>

        {{-- INPUT GAMBAR BARU --}}
        <div class="col-12">
          <label for="gambar" class="form-label">Upload Gambar Baru (Opsional)</label>
          <input type="file" name="gambar[]" id="gambar" class="form-control" accept="image/*" multiple>
          <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar. Minimal 3 gambar jika upload baru.</small>
        </div>

        {{-- GAMBAR SAAT INI --}}
        <div class="col-12 mt-4">
          <label class="form-label fw-semibold">Gambar Saat Ini:</label>
          <div class="row">
            @forelse ($produk->gambars as $gambar)
              <div class="col-md-3 mb-3">
                <div class="gambar-wrapper">
                  <img src="{{ asset('storage/' . $gambar->path) }}" alt="Gambar Produk" class="img-fluid rounded" style="max-height: 150px; object-fit: contain;">
                  <form action="{{ route('produk.gambar.destroy', $gambar->id) }}" method="POST" class="btn-hapus-gambar">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm rounded-circle" onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </form>
                </div>
            </div>
            @empty
              <p class="text-muted">Belum ada gambar yang diunggah.</p>
            @endforelse
          </div>
        </div>
      </div>

      <hr class="my-4">

      {{-- VARIAN PRODUK --}}
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
          <div class="col-md-1 text-end"><button type="button" class="btn btn-danger btn-sm btn-remove-varian"><i class="bi bi-x"></i></button></div>
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
  </div>
</div>
<br>

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
      <div class="col-md-3"><input type="number" name="varian[${varianIndex}][harga]" class="form-control" placeholder="Harga" required></div>
      <div class="col-md-2"><input type="number" name="varian[${varianIndex}][stok]" class="form-control" placeholder="Stok" required></div>
      <div class="col-md-1 text-end"><button type="button" class="btn btn-danger btn-sm btn-remove-varian"><i class="bi bi-x"></i></button></div>
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
