<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pelanggan - Insulmart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('assets/img/insulmart_new1.png') }}" type="image/png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    /* === Navbar Modern === */
nav {
    background: linear-gradient(90deg, #8B0000, #a60000);
    padding: 0;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 9999;
}

.navbar {
    max-width: 1350px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1px 24px;
    position: relative;
}

.navbar-logo {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.logo-img {
    height: 85px;
    width: auto;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.logo-img:hover {
    transform: scale(1.05);
}

.navbar-menu {
    display: flex;
    gap: 20px;
}

.navbar-menu a {
    color: #fff;
    text-decoration: none;
    font-size: 1rem;
    font-weight: 500;
    padding: 8px 12px;
    border-radius: 6px;
    transition: all 0.25s ease;
}

.navbar-menu a:hover {
    background-color: rgba(255, 255, 255, 0.15);
    color: #ffe082;
}

nav.scrolled {
    background: rgba(139, 0, 0, 0.7); /* merah tua semi-transparan */
    backdrop-filter: blur(5px); /* efek blur elegan */
    transition: background 0s ease, backdrop-filter 0.3s ease;
}

/* === Navbar Icons & Auth Buttons === */
.navbar-icons {
    display: flex;
    align-items: center;
    gap: 12px;
}

.icon-link {
    color: #fff;
    font-size: 1.4rem;
    transition: color 0.3s;
}

.icon-link:hover {
    color: #ffe082;
}

.btn-auth {
    padding: 6px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    transition: background 0.3s, color 0.3s, border 0.3s;
    border: 1px solid transparent;
}

.btn-masuk {
    color: #fff;
    border: 1px solid #fff;
}

.btn-masuk:hover {
    background-color: #fff;
    color: #8B0000;
}

.btn-daftar {
    background-color: #ffe082;
    color: #8B0000;
    border: 1px solid #ffe082;
}

.btn-daftar:hover {
    background-color: #ffca28;
    color: #8B0000;
}

/* === Responsive: Letakkan Icons di Bawah saat Mobile === */
@media (max-width: 768px) {
    .navbar-icons {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 12px 20px;
        background: #8B0000;
        width: 100%;
    }

    .btn-auth {
        width: 100%;
        text-align: left;
        margin-top: 10px;
    }

    .icon-link {
        margin-bottom: 10px;
    }
}


/* === Toggle Button === */
.navbar-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.8rem;
    color: #fff;
    cursor: pointer;
}

/* === Responsive (Mobile) === */
@media (max-width: 768px) {
    .navbar {
        flex-direction: row;
        padding: 1px 1px;
    }

    .navbar-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 1;
    }

    .navbar-toggle {
        display: block;
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
    }

    .navbar-menu {
        display: none;
        flex-direction: column;
        align-items: start;
        background: #8B0000;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        padding: 12px 20px;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .navbar-menu.show {
        display: flex;
    }

    .navbar-menu a {
        width: 100%;
        padding: 15px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .navbar-menu a:last-child {
        border-bottom: none;
    }
}
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
  <div class="navbar">
    <a href="{{ url('/home') }}" class="navbar-logo">
      <img src="{{ asset('assets/img/insulmart_new_bg_new.png') }}" alt="Logo PT" class="logo-img">
    </a>

    <button class="navbar-toggle" id="navbar-toggle">
      <i class="bi bi-list"></i>
    </button>

    <div class="navbar-menu" id="navbar-menu">
      <a href="{{ url('/home') }}">Beranda</a>
      <a href="{{ url('/produk') }}">Produk</a>
      <a href="{{ url('/pesanan-saya') }}">Pesanan Saya</a>
      <a href="{{ url('/wishlist') }}">Wishlist</a>
      <a href="{{ url('/profil') }}">Profil</a>
    </div>

    <div class="navbar-icons">
      <a href="{{ url('/keranjang') }}" class="icon-link" title="Keranjang">
        <i class="bi bi-cart3"></i>
      </a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn-auth btn-masuk" type="submit">Logout</button>
      </form>
    </div>
  </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container" style="margin-top: 120px;">
  <h3 class="mb-4">Halo, {{ Auth::user()->name ?? 'Pelanggan' }} 👋</h3>

  <div class="row g-4">
    <div class="col-md-6 col-lg-4">
      <div class="card p-4 bg-white shadow-sm">
        <div class="d-flex align-items-center">
          <div class="icon text-danger fs-4 me-3">🛒</div>
          <div>
            <h5 class="card-title mb-1">Pesanan Aktif</h5>
            <h4 class="m-0">3</h4>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4">
      <div class="card p-4 bg-white shadow-sm">
        <div class="d-flex align-items-center">
          <div class="icon text-success fs-4 me-3">✅</div>
          <div>
            <h5 class="card-title mb-1">Pesanan Selesai</h5>
            <h4 class="m-0">12</h4>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4">
      <div class="card p-4 bg-white shadow-sm">
        <div class="d-flex align-items-center">
          <div class="icon text-warning fs-4 me-3">❤️</div>
          <div>
            <h5 class="card-title mb-1">Wishlist</h5>
            <h4 class="m-0">5 Produk</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-5">
    <h5>Riwayat Aktivitas</h5>
    <ul class="list-group mt-3">
      <li class="list-group-item">🛒 Kamu memesan <strong>Rockwool Premium 5cm</strong></li>
      <li class="list-group-item">💳 Pembayaran berhasil pada 2 Juli</li>
      <li class="list-group-item">📦 Produk <strong>Insulpipe</strong> dikirim</li>
    </ul>
  </div>
</div>

<!-- Script untuk Toggle -->
<script>
  document.getElementById('navbar-toggle').addEventListener('click', function () {
    document.getElementById('navbar-menu').classList.toggle('show');
  });
</script>

    @include('components.footer')

</body>
</html>
