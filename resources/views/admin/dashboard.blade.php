<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - E-Commerce</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- ✅ Favicon (Logo Tab Browser) -->
    <link rel="icon" href="{{ asset('assets/img/insulmart_new1.png') }}" type="image/png">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
        }

        .sidebar {
            height: 100vh;
            background-color: #8B0000;
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            width: 220px;
            padding-top: 60px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #a60000;
        }

        .main-content {
            margin-left: 220px;
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        .card-title {
            font-weight: bold;
        }

        .stat-icon {
            font-size: 30px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                height: auto;
                width: 100%;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="text-center mb-4">
        <h4 class="fw-bold">Admin Panel</h4>
    </div>
    <a href="#" class="active"><i class="bi bi-house-door-fill me-2"></i>Dashboard</a>
    <a href="#"><i class="bi bi-box-fill me-2"></i>Produk</a>
    <a href="#"><i class="bi bi-cart-fill me-2"></i>Pesanan</a>
    <a href="#"><i class="bi bi-people-fill me-2"></i>Pelanggan</a>
    <a href="#"><i class="bi bi-credit-card-fill me-2"></i>Pembayaran</a>
    <a href="#"><i class="bi bi-gear-fill me-2"></i>Pengaturan</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-sm btn-outline-light w-100 mt-3" type="submit">🚪 Logout</button>
    </form>
</div>

<!-- Main Content -->
<div class="main-content">
    <h3 class="mb-4">Selamat datang, Admin!</h3>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-4 bg-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Produk</h5>
                        <h3>125</h3>
                    </div>
                    <div class="stat-icon text-danger">📦</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 bg-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Pesanan</h5>
                        <h3>89</h3>
                    </div>
                    <div class="stat-icon text-warning">🛒</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 bg-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Pelanggan</h5>
                        <h3>342</h3>
                    </div>
                    <div class="stat-icon text-success">👥</div>
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
</div>

</body>
</html>
