<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
  <div class="container py-5">
    <h2 class="mb-4">Tambah Produk</h2>

    <form action="#" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="nama" class="form-label">Nama Produk</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
      </div>

      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
      </div>

      <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" required>
      </div>

      <div class="mb-3">
        <label for="gambar" class="form-label">Gambar Produk</label>
        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
