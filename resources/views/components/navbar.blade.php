<nav>
    <div class="navbar">
        <a href="{{ url('/') }}" class="navbar-logo">
            <img src="{{ asset('assets/img/insulmart_new_bg_new.png') }}" alt="Logo PT" class="logo-img">
        </a>

        <button class="navbar-toggle" id="navbar-toggle">
            <i class="bi bi-list"></i>
        </button>

        <div class="navbar-menu" id="navbar-menu">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
            <a href="{{ url('/produk') }}" class="{{ request()->is('produk') ? 'active' : '' }}">Produk Kami</a>
            <a href="{{ url('/katalog-produk') }}" class="{{ request()->is('katalog-produk') ? 'active' : '' }}">Katalog</a>
            <a href="{{ url('/galeri') }}" class="{{ request()->is('galeri') ? 'active' : '' }}">Galeri</a>
            <a href="{{ url('/hubungi-kami') }}" class="{{ request()->is('hubungi-kami') ? 'active' : '' }}">Kontak</a>
        </div>

        <div class="navbar-icons">
            <a href="{{ url('/keranjang') }}" class="icon-link" title="Keranjang">
                <i class="bi bi-cart3"></i>
            </a>

            @auth
                @if (auth()->user()->hasRole('admin'))
                    <a href="{{ url('/admin/dashboard') }}" class="btn-auth btn-masuk">Dashboard</a>
                @elseif (auth()->user()->hasRole('pelanggan'))
                    <a href="{{ url('/pelanggan/dashboard') }}" class="btn-auth btn-masuk">Dashboard</a>
                @else
                    <a href="#" class="btn-auth btn-masuk">Akun</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-auth btn-masuk">Masuk</a>
                <a href="{{ route('register') }}" class="btn-auth btn-daftar">Daftar</a>
            @endauth
        </div>
    </div>
</nav>
