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