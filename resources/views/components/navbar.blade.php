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
            <a href="{{ url('/produk') }}" class="{{ Str::startsWith(Route::currentRouteName(), 'produk.') ? 'active' : '' }}">Produk</a>
            <a href="{{ url('/katalog-produk') }}" class="{{ request()->is('katalog-produk') ? 'active' : '' }}">Katalog</a>
            <a href="{{ url('/galeri') }}" class="{{ request()->is('galeri') ? 'active' : '' }}">Galeri</a>
            <a href="{{ url('/hubungi-kami') }}" class="{{ request()->is('hubungi-kami') ? 'active' : '' }}">Kontak</a>

            @auth
            <a href="{{ route('pemesanan.index') }}"
                class="{{ request()->is('pesanan*') ? 'active' : '' }}"
                style="display:flex; align-items:center; gap:4px; color: white; position: relative;">
                Pesanan
                <span class="order-count"
                    style="position: absolute; top: -5px; right: -5px; background-color: red; color: white; border-radius: 50%; padding: 4px 5px; font-size: 0.7rem; font-weight: bold;">
                    {{ auth()->check()
                        ? auth()->user()
                            ->pemesanan()
                            ->whereIn('status_pemesanan', ['menunggu', 'diproses'])
                            ->count()
                        : 0 }}
                </span>
            </a>

                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}"
                id="navbarCartIcon"
                class="cart-icon {{ request()->routeIs('cart.index') ? 'active' : '' }}"
                style="color: white; display: flex; align-items: center; gap: 4px; position: relative;">
                    <i class="bi bi-cart-fill" style="font-size: 1.2rem;"></i>
                    <span class="cart-count" style="position: absolute; top: -5px; right: -5px; background-color: red; color: white; border-radius: 50%; padding: 3px 7px; font-size: 0.7rem; font-weight: bold;">
                        {{ auth()->check() && auth()->user()->cart ? auth()->user()->cart->items->count() : 0 }}
                    </span>
                </a>
            @endauth

            @auth
                <div class="dropdown user-dropdown" id="userDropdown">
                    <button class="dropdown-toggle-button" type="button"
                            onclick="toggleDropdown()"
                            style="background: none; border: none; display: flex; align-items: center; cursor: pointer;">
                            <img 
                                src="{{ 
                                    auth()->user()->profile_photo_path && file_exists(public_path(auth()->user()->profile_photo_path)) 
                                        ? asset(auth()->user()->profile_photo_path) 
                                        : asset('images/default-user.png') 
                                }}"
                                alt="Foto Profil"
                                class="profile-pic"
                                style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #ccc; margin-right: 8px;"
                            >
                        <span style="color: white; font-weight: bold; display: flex; align-items: center; gap: 5px;">
                            {{ auth()->user()->name }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="white" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 5.646a.5.5 0 0 1 .708 0L8 11.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </span>
                    </button>

                    <div class="dropdown-menu" style="display: none; position: absolute; right: 0; background: white; border: 1px solid #ddd; box-shadow: 0 2px 8px rgba(0,0,0,0.1); min-width: 180px; z-index: 999;">
                        @if (auth()->user()->hasRole('admin'))
                            <a class="dropdown-item" href="{{ url('/admin/dashboard') }}" style="display:block; padding: 10px 15px; color: #333; text-decoration: none;">Dashboard Admin</a>
                        @elseif (auth()->user()->hasRole('pelanggan'))
                        @endif
                        <a class="dropdown-item" href="{{ route('profile') }}" style="display:block; padding: 10px 15px; color: #333; text-decoration: none;">Profile Saya</a>
                        <a class="dropdown-item" href="{{ route('alamat.index') }}" style="display:block; padding: 10px 15px; color: #333; text-decoration: none;">Alamat</a>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            style="display:block; padding: 10px 15px; color: red; text-decoration: none;">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-auth btn-masuk">Masuk</a>
                <a href="{{ route('register') }}" class="btn-auth btn-daftar">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleDropdown() {
        document.getElementById("userDropdown").classList.toggle("show");
        const dropdownMenu = document.querySelector("#userDropdown .dropdown-menu");
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    }

    // Klik di luar untuk menutup dropdown
    window.addEventListener('click', function (e) {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            dropdown.classList.remove('show');
            const menu = dropdown.querySelector('.dropdown-menu');
            if (menu) menu.style.display = 'none';
        }
    });
</script>
