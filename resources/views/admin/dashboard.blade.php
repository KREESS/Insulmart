@extends('admin.components.app')

@section('content')

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
