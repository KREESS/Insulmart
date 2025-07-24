@extends('components.layout-bootstrap')

@section('title', 'Alamat Pengiriman Saya | Insulmart')
    <head>
        <title>@yield('title', 'Alamat Pengiriman Saya | Insulmart')</title>
        <!-- Tag lain seperti meta, link CSS, dll -->
    </head>

@section('content')
<style>
  :root {
    --accent-start: #800000;
    --accent-end:   #990000;
    --light-bg:     #f8e5e5;
    --round:        1rem;
    --card-hover:   rgba(0,0,0,0.15);
  }
  @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');

  /* Tingkatkan padding-top agar tidak tertutup navbar */
  body { background: var(--light-bg); padding-top: 6rem; }
  .header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
  }
  .btn-maroon {
    background: var(--accent-start);
    color: #fff;
    border-radius: var(--round);
    padding: .5rem 1rem;
    transition: background .3s;
    white-space: nowrap;
  }
  .btn-maroon:hover { background: var(--accent-end); }

  .grid-address {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  @media(min-width:768px) { .grid-address { grid-template-columns: repeat(2,1fr); } }

  .card-addr {
    background: #fff;
    border-radius: var(--round);
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    position: relative;
    transition: transform .3s, box-shadow .3s;
  }
  .card-addr:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow: 0 8px 24px var(--card-hover);
  }

  .card-addr::before {
    content: '';
    position: absolute; top:0; left:0; right:0;
    height:4px;
    background: linear-gradient(90deg, var(--accent-start), var(--accent-end));
  }

  .card-header {
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: .75rem;
  }
  .card-header i {
    font-size: 1.5rem;
    color: var(--accent-start);
    background: rgba(128,0,0,0.1);
    border-radius: 50%; padding: .5rem;
  }
  .card-header h5 { margin:0; font-weight:600; color: #333; }

  .badge-default {
    position: absolute; top:2rem; right:11rem;
    background: var(--accent-start);
    color:#fff;
    padding:.25rem .75rem;
    border-radius: var(--round);
    font-size:.75rem;
    text-transform: uppercase;
  }

  .card-body { padding: .75rem 1.5rem; }
  .detail-line { display: flex; justify-content: space-between; font-size: .95rem; margin-bottom: .5rem; }
  .detail-line strong { color: var(--accent-start); }

  .card-footer {
    padding: .75rem 1.5rem 1.25rem;
    display: flex; gap: .5rem; justify-content: flex-end;
  }
  .card-footer .btn { flex:1; font-size:.85rem; border-radius: var(--round); transition: background .2s, color .2s; }
  .btn-edit { border: 1px solid var(--accent-start); color: var(--accent-start); }
  .btn-edit:hover { background: var(--accent-start); color: #fff; }
  .btn-delete { border: 1px solid #dc3545; color: #dc3545; }
  .btn-delete:hover { background: #dc3545; color:#fff; }
  .btn-setdef { background: var(--accent-start); color:#fff; border:none; }
  .btn-setdef:hover { background: var(--accent-end); }
  
  #btnScrollTop {
    position: fixed; bottom: 2rem; right: 2rem;
    display: none; z-index: 1000;
  }
  .navbar {
    padding: 0px 24px;
  }
</style>

<div class="container px-3 px-md-5 py-4 animate__animated animate__fadeIn fade-up">
  <div class="header-bar fade-up">
    <h2 class="text-maroon mb-0">Daftar Alamat Saya</h2>
    <a href="{{ route('alamat.create') }}" class="btn btn-maroon">
      <i class="bi bi-plus-circle me-1"></i>Tambah Alamat
    </a>
  </div>

  {{-- Notifikasi Sukses --}}
  @if(session('success'))
    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show shadow-sm" role="alert">
      <i class="bi bi-check-circle-fill me-2 fs-5"></i>
      <div>{{ session('success') }}</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
  @endif

  {{-- Notifikasi Error --}}
  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
      <div class="d-flex align-items-center mb-2">
        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
        <strong>Terjadi kesalahan saat menginput data:</strong>
      </div>
      <ul class="mb-0 ps-4">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
  @endif

  @if($alamat->isEmpty())
    <div class="alert alert-warning text-center py-4">
      <i class="bi bi-geo-alt-slash fs-2"></i>
      <p class="mb-0 mt-2">Belum ada alamat tersimpan.</p>
    </div>
  @else
    <div class="grid-address">
      @foreach($alamat as $a)
        <div class="card-addr animate__animated animate__zoomIn">
          @if($a->is_default)
            <div class="badge-default">Default</div>
          @endif

          <div class="card-header">
            <i class="bi bi-geo-alt-fill"></i>
            <h5>{{ $a->label ?? 'Alamat' }}</h5>
            <div class="ms-auto d-flex gap-2">
              <button class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Salin Alamat"
                      onclick="navigator.clipboard.writeText('{{ $a->alamat_lengkap }}')">
                <i class="bi bi-clipboard"></i>
              </button>
              <button class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Lihat Peta"
                      onclick="window.open('https://www.google.com/maps/search/'+encodeURIComponent('{{ $a->alamat_lengkap }}'), '_blank')">
                <i class="bi bi-map"></i>
              </button>
            </div>
          </div>

          <div class="card-body">
            <div class="detail-line"><span><strong>Provinsi</strong></span><span>{{ $a->province }}</span></div>
            <div class="detail-line"><span><strong>Kota</strong></span><span>{{ $a->regency }}</span></div>
            <div class="detail-line"><span><strong>Kecamatan</strong></span><span>{{ $a->district }}</span></div>
            <div class="detail-line"><span><strong>Desa</strong></span><span>{{ $a->village }}</span></div>
            <div class="detail-line"><span><strong>RT/RW</strong></span><span>{{ $a->rt }}/{{ $a->rw }}</span></div>
            <div class="detail-line"><span><strong>Kode Pos</strong></span><span>{{ $a->kode_pos }}</span></div>
            <div class="detail-line"><span><strong>Detail</strong></span><span>{{ Str::limit($a->alamat_lengkap, 50) }}</span></div>
          </div>

          <div class="card-footer">
            @unless($a->is_default)
              <form action="{{ route('alamat.default', $a->id) }}" method="POST">
                @csrf
                <button class="btn btn-setdef">
                  <i class="bi bi-check-circle me-1"></i>Jadikan Default
                </button>
              </form>
            @endunless

            <a href="{{ route('alamat.edit', $a->id) }}" class="btn btn-edit">
              <i class="bi bi-pencil-square me-1"></i>Edit
            </a>

            <form action="{{ route('alamat.destroy', $a->id) }}" method="POST" class="delete-address-form">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-delete">
                <i class="bi bi-trash me-1"></i>Hapus
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>

<button id="btnScrollTop" class="btn btn-maroon animate__animated animate__fadeIn"><i class="bi bi-arrow-up"></i></button>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.querySelectorAll('.delete-address-form').forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      Swal.fire({
        title: 'Yakin ingin menghapus alamat ini?',
        text: "Data akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#800000',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then(res => { if (res.isConfirmed) form.submit(); });
    });
  });

  const btnTop = document.getElementById('btnScrollTop');
  window.addEventListener('scroll', () => { btnTop.style.display = window.scrollY > 300 ? 'block' : 'none'; });
  btnTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
</script>
@endpush
@endsection
