<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar Produk</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

  <style>
    body {
      background-color: #f8f9fa;
    }
    .card-title {
      font-weight: 600;
      color: #343a40;
    }
    .card-text {
      font-size: 0.95rem;
    }
    .card-price {
      font-size: 1.1rem;
      color: #198754;
    }
    .btn-add {
      float: right;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0"><i class="bi bi-box-fill me-2"></i>Daftar Produk</h2>
      <a href="/produk/tambah" class="btn btn-success btn-add">
        <i class="bi bi-plus-circle me-1"></i>Tambah Produk
      </a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
      <!-- Produk A -->
      <div class="col">
        <div class="card h-100 shadow-sm border-0">
          <img src="assets/img/produk1.jpg" class="card-img-top" alt="Produk A">
          <div class="card-body">
            <h5 class="card-title">Produk A</h5>
            <p class="card-text">Deskripsi singkat produk A. Cocok untuk berbagai kebutuhan Anda.</p>
            <div class="card-price fw-bold">Rp120.000</div>
          </div>
          <div class="card-footer bg-white border-0 text-end">
            <a href="#" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Produk B -->
      <div class="col">
        <div class="card h-100 shadow-sm border-0">
          <img src="assets/img/produk2.jpg" class="card-img-top" alt="Produk B">
          <div class="card-body">
            <h5 class="card-title">Produk B</h5>
            <p class="card-text">Produk unggulan dengan kualitas terbaik dan harga bersaing.</p>
            <div class="card-price fw-bold">Rp95.000</div>
          </div>
          <div class="card-footer bg-white border-0 text-end">
            <a href="#" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Produk C -->
      <div class="col">
        <div class="card h-100 shadow-sm border-0">
          <img src="assets/img/produk3.jpg" class="card-img-top" alt="Produk C">
          <div class="card-body">
            <h5 class="card-title">Produk C</h5>
            <p class="card-text">Efisien dan praktis digunakan untuk berbagai aktivitas harian.</p>
            <div class="card-price fw-bold">Rp75.000</div>
          </div>
          <div class="card-footer bg-white border-0 text-end">
            <a href="#" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
