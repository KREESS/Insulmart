<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - E-Commerce</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
        --color-merah: #8B0000;
        --color-merah-tua: #6a0000;
        }

        body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
        width: 250px;
        background-color: var(--color-merah);
        min-height: 100vh;
        color: #fff;
        transition: all 0.3s ease;
        position: fixed;
        z-index: 1050;
        }

        .sidebar.collapsed {
        margin-left: -250px;
        }

        .main-content {
        margin-left: 250px;
        transition: all 0.3s ease;
        }

        .main-content.expanded {
        margin-left: 0;
        }

        .nav-link {
        color: #fff;
        }

        .nav-link:hover,
        .nav-link.active {
        background-color: var(--color-merah-tua);
        border-radius: 4px;
        }

        @media (max-width: 768px) {
        .sidebar {
            position: absolute;
        }

        .main-content {
            margin-left: 0;
        }
        }

        .navbar-custom {
        background-color: var(--color-merah);
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .btn,
        .navbar-custom .navbar-toggler-icon {
        color: #fff;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark navbar-custom sticky-top d-flex justify-content-between">
  <div class="container-fluid">
    <button class="btn text-white me-3" id="toggleSidebar">
      <i class="bi bi-list fs-3"></i>
    </button>
    <span class="navbar-brand fw-bold">Dashboard Admin</span>
  </div>
</nav>

<!-- Sidebar -->
<aside class="sidebar p-3" id="sidebar">
  <h4 class="text-center mb-4 fw-bold">Admin Panel</h4>
  <ul class="nav flex-column" id="navLinks">
    <li class="nav-item mb-2">
      <a href="#" class="nav-link active"><i class="bi bi-house-door-fill me-2"></i>Dashboard</a>
    </li>
    <li class="nav-item mb-2">
      <a href="/produk" class="nav-link"><i class="bi bi-box-fill me-2"></i>Produk</a>
    </li>
    <li class="nav-item mb-2">
      <a href="#" class="nav-link"><i class="bi bi-cart-fill me-2"></i>Pesanan</a>
    </li>
    <li class="nav-item mb-2">
      <a href="#" class="nav-link"><i class="bi bi-people-fill me-2"></i>Pelanggan</a>
    </li>
    <li class="nav-item mb-2">
      <a href="#" class="nav-link"><i class="bi bi-credit-card-fill me-2"></i>Pembayaran</a>
    </li>
    <li class="nav-item mb-2">
      <a href="#" class="nav-link"><i class="bi bi-gear-fill me-2"></i>Pengaturan</a>
    </li>
    <li class="nav-item mt-3">
      <form method="POST" action="#">
        <button class="btn btn-outline-light w-100" type="submit">🚪 Logout</button>
      </form>
    </li>
  </ul>
</aside>

<!-- Main Content -->
<main class="main-content p-4 bg-light" id="mainContent">
  <h3 class="mb-4">Selamat datang, Admin!</h3>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title">Total Produk</h5>
            <h3 class="card-text">125</h3>
          </div>
          <div class="fs-2 text-danger">📦</div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title">Total Pesanan</h5>
            <h3 class="card-text">89</h3>
          </div>
          <div class="fs-2 text-warning">🛒</div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title">Total Pelanggan</h5>
            <h3 class="card-text">342</h3>
          </div>
          <div class="fs-2 text-success">👥</div>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-5">
    <h5>Aktivitas Terbaru</h5>
    <ul class="list-group mt-3">
      <li class="list-group-item">🛒 Pesanan baru oleh <strong>Putra</strong></li>
      <li class="list-group-item">📦 Produk "Rockwool 100cm" ditambahkan</li>
      <li class="list-group-item">💳 Pembayaran dikonfirmasi oleh <strong>Siti</strong></li>
    </ul>
  </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const navLinks = document.querySelectorAll('#navLinks .nav-link');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    });

    navLinks.forEach(link => {
        link.addEventListener('click', function () {
        navLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        });
    });
</script>
</body>
</html>
