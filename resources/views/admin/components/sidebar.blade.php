<aside class="sidebar bg-merah-tua text-white p-3 shadow-sm" id="sidebar">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0">Admin Panel</h4>
  </div>

  <ul class="nav flex-column" id="navLinks">
    <li class="nav-item mb-2">
      <a href="/admin/dashboard"
        class="nav-link text-white d-flex align-items-center w-100 {{ request()->is('admin/dashboard') ? 'active fw-bold' : '' }}">
        <span class="d-inline-flex align-items-center text-truncate">
          <i class="bi bi-house-door-fill me-2"></i>
          <span class="text-truncate">Dashboard</span>
        </span>
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="/admin/pembelian"
        class="nav-link text-white d-flex align-items-center w-100 {{ request()->is('admin/pembelian*') ? 'active fw-bold' : '' }}">
        <span class="d-inline-flex align-items-center text-truncate">
          <i class="bi bi-receipt me-2"></i>
          <span class="text-truncate">Pembelian Produk</span>
        </span>
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="/admin/distributor"
        class="nav-link text-white d-flex align-items-center w-100 {{ request()->is('admin/distributor*') ? 'active fw-bold' : '' }}">
        <span class="d-inline-flex align-items-center text-truncate">
          <i class="bi bi-shop me-2"></i>
          <span class="text-truncate">Kelola Pemasok</span>
        </span>
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="/admin/produk"
        class="nav-link text-white d-flex align-items-center w-100 {{ request()->is('admin/produk*') ? 'active fw-bold' : '' }}">
        <span class="d-inline-flex align-items-center text-truncate">
          <i class="bi bi-box-seam-fill me-2"></i>
          <span class="text-truncate">Kelola Produk</span>
        </span>
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="/admin/pesanan"
        class="nav-link text-white d-flex align-items-center w-100 {{ request()->is('admin/pesanan*') ? 'active fw-bold' : '' }}">
        <span class="d-inline-flex align-items-center text-truncate">
          <i class="bi bi-cart-fill me-2"></i>
          <span class="text-truncate">Pesanan</span>
        </span>
        @if(isset($waitingOrdersCount) && $waitingOrdersCount > 0)
          <span class="badge bg-warning text-dark fw-bold rounded-pill px-2 py-1 small ms-auto">{{ $waitingOrdersCount }}</span>
        @endif
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="/admin/armada"
        class="nav-link text-white d-flex align-items-center w-100 {{ request()->is('admin/armada*') ? 'active fw-bold' : '' }}">
        <span class="d-inline-flex align-items-center text-truncate">
          <i class="bi bi-truck me-2"></i>
          <span class="text-truncate">Armada Pengiriman</span>
        </span>
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="/admin/pengguna"
        class="nav-link text-white d-flex align-items-center w-100 {{ request()->is('admin/pengguna*') ? 'active fw-bold' : '' }}">
        <span class="d-inline-flex align-items-center text-truncate">
          <i class="bi bi-people-fill me-2"></i>
          <span class="text-truncate">Kelola Pengguna</span>
        </span>
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="/admin/chat"
        class="nav-link text-white d-flex align-items-center w-100 {{ request()->is('admin/chat*') ? 'active fw-bold' : '' }}">
        <span class="d-inline-flex align-items-center text-truncate">
          <i class="bi bi-chat-left-text me-2"></i>
          <span class="text-truncate">Layanan Chat</span>
        </span>
        @if(isset($unreadCount) && $unreadCount > 0)
          <span class="badge bg-warning text-dark fw-bold rounded-pill px-2 py-1 small ms-auto">{{ $unreadCount }}</span>
        @endif
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
