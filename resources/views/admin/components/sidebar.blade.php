<aside class="sidebar bg-merah-tua text-white p-3 shadow-sm" id="sidebar">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0">Admin Panel</h4>
    {{-- <button class="btn btn-sm btn-outline-light d-md-none" id="sidebarToggleClose">
      <i class="bi bi-x-lg"></i>
    </button> --}}
  </div>

  <ul class="nav flex-column" id="navLinks">
    <li class="nav-item mb-2">
      <a href="/admin/dashboard" class="nav-link text-white {{ request()->is('admin/dashboard') ? 'active fw-bold' : '' }}">
        <i class="bi bi-house-door-fill me-2"></i>Dashboard
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="/admin/produk" class="nav-link text-white {{ request()->is('admin/produk*') ? 'active fw-bold' : '' }}">
        <i class="bi bi-box-fill me-2"></i>Produk
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="#" class="nav-link text-white">
        <i class="bi bi-cart-fill me-2"></i>Pesanan
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="#" class="nav-link text-white">
        <i class="bi bi-people-fill me-2"></i>Pelanggan
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="#" class="nav-link text-white">
        <i class="bi bi-credit-card-fill me-2"></i>Pembayaran
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="#" class="nav-link text-white">
        <i class="bi bi-gear-fill me-2"></i>Pengaturan
      </a>
    </li>
    <li class="nav-item mt-3">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-outline-light w-100" type="submit">Logout</button>
      </form>
    </li>
  </ul>
</aside>
