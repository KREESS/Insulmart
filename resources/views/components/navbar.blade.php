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
            <a href="{{ url('/katalog-produk') }}">Katalog</a>
            <a href="{{ url('/galeri') }}">Galeri</a>
            <a href="{{ url('/hubungi-kami') }}">Kontak</a>
        </div>

        <div class="navbar-icons">
            <a href="{{ url('/keranjang') }}" class="icon-link" title="Keranjang">
                <i class="bi bi-cart3"></i>
            </a>
            <a href="{{ route('login') }}" class="btn-auth btn-masuk">Masuk</a>
            <a href="{{ route('register') }}" class="btn-auth btn-daftar">Daftar</a>
        </div>
    </div>
</nav>
