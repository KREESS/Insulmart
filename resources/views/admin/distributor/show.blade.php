@extends('admin.components.app')

<head>
    <title>@yield('title', 'Detail Distributor | Insulmart')</title>
</head>

@section('content')
<style>
  :root{
    --maroon: #8B0000;
    --maroon-2: #a41515;
    --maroon-light: #fbeaec;
    --gradient: linear-gradient(90deg, #8B0000 0%, #a41515 100%);
    --gradient-hover: linear-gradient(90deg, #a41515 0%, #8B0000 100%);
    --radius: 16px;
  }
  .text-maroon{ color: var(--maroon) !important; }
  .btn-maroon{
    background: var(--gradient); color:#fff; border:none; border-radius:2em;
    padding:.6rem 1.5rem; font-weight:600; transition:.2s;
  }
  .btn-maroon:hover{ background: var(--gradient-hover); transform:translateY(-2px); box-shadow:0 4px 12px rgba(139,0,0,.2); }
  .btn-outline-maroon{
    color:var(--maroon); border:2px solid var(--maroon); border-radius:2em; padding:.5rem 1.2rem; font-weight:600;
    background:#fff; transition:.2s;
  }
  .btn-outline-maroon:hover{ background:var(--gradient); color:#fff; border-color:transparent; transform:translateY(-2px); }
  .btn-action{
    width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius:10px;
  }
  .card-custom{
    background:#fff; border:none; border-radius:var(--radius); box-shadow:0 4px 18px rgba(139,0,0,.08);
  }
  .alert-custom{ border-radius: var(--radius); border:none; }
  .list-clean .list-group-item{ border:0; padding:.5rem 0; }
  .divider{ height:1px; background:#eee; margin:1rem 0; }
  .badge-dot{ width:.5rem; height:.5rem; display:inline-block; border-radius:50%; margin-right:.35rem; vertical-align:middle; }
</style>

<main class="main-content p-4 bg-light" id="mainContent">

  {{-- Header --}}
  <div class="mb-4 border-bottom pb-3 d-flex justify-content-between align-items-center">
    <div>
      <h3 class="fw-bold text-maroon mb-1" style="letter-spacing:.5px">
        <i class="bi bi-truck me-2"></i> Detail Distributor
      </h3>
      <p class="text-muted mb-0">Informasi lengkap pemasok / mitra distribusi</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('distributor.index') }}" class="btn btn-outline-maroon">
        <i class="bi bi-arrow-left me-1"></i> Kembali
      </a>
      <button type="button" class="btn btn-outline-maroon" onclick="window.print()">
        <i class="bi bi-printer me-1"></i> Cetak
      </button>
      <a href="{{ route('distributor.edit', $distributor->id) }}" class="btn btn-maroon">
        <i class="bi bi-pencil-square me-1"></i> Edit
      </a>
      <button type="button" class="btn btn-danger" id="btnDelete" data-id="{{ $distributor->id }}">
        <i class="bi bi-trash3 me-1"></i> Hapus
      </button>
    </div>
  </div>

  {{-- Notifikasi --}}
  @if(session('success'))
    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show alert-custom mb-4" role="alert">
      <i class="bi bi-check-circle-fill me-2 fs-5"></i>
      <div>{{ session('success') }}</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @php
    $isActive = (bool) ($distributor->is_active ?? false);
    $badge = $isActive
      ? '<span class="badge bg-success-subtle text-success border border-success-subtle"><span class="badge-dot bg-success"></span> Aktif</span>'
      : '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle"><span class="badge-dot bg-secondary"></span> Nonaktif</span>';

    // susun alamat singkat
    $alamatSingkat = collect([$distributor->village, $distributor->district, $distributor->regency])->filter()->implode(', ');
    $prov = $distributor->province ? ' - '.$distributor->province : '';
    $kp = $distributor->kode_pos ? ' ('.$distributor->kode_pos.')' : '';

    // url maps
    $mapsQuery = $distributor->coordinate && trim($distributor->coordinate) !== ''
      ? $distributor->coordinate
      : trim(trim(($distributor->alamat_lengkap ?? '').' '.$alamatSingkat.$prov.$kp));
    $mapsUrl = $mapsQuery ? 'https://www.google.com/maps?q='.urlencode($mapsQuery) : null;
  @endphp

  {{-- Ringkasan singkat --}}
  <div class="card-custom p-3 mb-3">
    <div class="row g-3">
      <div class="col-lg-8 d-flex align-items-center gap-3">
        <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
             style="width:54px;height:54px;background:var(--maroon-light);color:var(--maroon)">
          <i class="bi bi-building fs-4"></i>
        </div>
        <div>
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="fw-semibold fs-5">{{ $distributor->name_pt ?? '-' }}</span>
            {!! $badge !!}
          </div>
          <div class="text-muted small">
            <i class="bi bi-person-badge me-1"></i> PIC: <span class="fw-semibold">{{ $distributor->contact_person ?? '—' }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Konten 2 kolom --}}
  <div class="row g-3">

    {{-- Kiri: Kontak & Catatan --}}
    <div class="col-lg-5">
      <div class="card-custom p-3 mb-3">
        <h6 class="fw-semibold text-maroon mb-3"><i class="bi bi-person-lines-fill me-2"></i>Kontak</h6>
        <div class="list-group list-clean">
          <div class="list-group-item d-flex justify-content-between">
            <span class="text-muted">Nama PT</span>
            <span class="fw-semibold text-end">{{ $distributor->name_pt ?? '-' }}</span>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span class="text-muted">PIC</span>
            <span class="fw-semibold text-end">{{ $distributor->contact_person ?? '—' }}</span>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span class="text-muted"><i class="bi bi-telephone me-1"></i> Telepon</span>
            <span class="fw-semibold text-end">{{ $distributor->phone ?? '—' }}</span>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span class="text-muted"><i class="bi bi-envelope me-1"></i> Email</span>
            <span class="fw-semibold text-end">{{ $distributor->email ?? '—' }}</span>
          </div>
        </div>
      </div>

      <div class="card-custom p-3">
        <h6 class="fw-semibold text-maroon mb-2"><i class="bi bi-journal-text me-2"></i>Catatan</h6>
        <div class="small">{{ $distributor->notes ? nl2br(e($distributor->notes)) : '—' }}</div>
        <div class="divider"></div>
        <div class="muted small">
          Dibuat: {{ $distributor->created_at ? $distributor->created_at->format('d M Y H:i') : '-' }} <br>
          Diperbarui: {{ $distributor->updated_at ? $distributor->updated_at->format('d M Y H:i') : '-' }}
        </div>
      </div>
    </div>

    {{-- Kanan: Alamat --}}
    <div class="col-lg-7">
      <div class="card-custom p-3">
        <h6 class="fw-semibold text-maroon mb-3"><i class="bi bi-geo-alt me-2"></i>Alamat</h6>

        <div class="list-group list-clean">
          <div class="list-group-item d-flex justify-content-between">
            <span class="text-muted">Provinsi</span>
            <span class="fw-semibold text-end">{{ $distributor->province ?? '—' }}</span>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span class="text-muted">Kab/Kota</span>
            <span class="fw-semibold text-end">{{ $distributor->regency ?? '—' }}</span>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span class="text-muted">Kecamatan</span>
            <span class="fw-semibold text-end">{{ $distributor->district ?? '—' }}</span>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span class="text-muted">Kel/Desa</span>
            <span class="fw-semibold text-end">{{ $distributor->village ?? '—' }}</span>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span class="text-muted">RT / RW</span>
            <span class="fw-semibold text-end">
              {{ $distributor->rt ?? '—' }} / {{ $distributor->rw ?? '—' }}
            </span>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span class="text-muted">Kode Pos</span>
            <span class="fw-semibold text-end">{{ $distributor->kode_pos ?? '—' }}</span>
          </div>
          <div class="list-group-item">
            <div class="text-muted mb-1">Alamat Lengkap</div>
            <div class="fw-semibold">{{ $distributor->alamat_lengkap ?? '—' }}</div>
          </div>

          <div class="divider"></div>

          <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
              <div class="text-muted">Koordinat (Lat,Lng)</div>
              <div class="fw-semibold">{{ $distributor->coordinate ?? '—' }}</div>
            </div>
            @if($mapsUrl)
            <a class="btn btn-outline-maroon" href="{{ $mapsUrl }}" target="_blank" rel="noopener">
              <i class="bi bi-geo-alt-fill me-1"></i> Buka di Maps
            </a>
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- Form delete (hidden) --}}
  <form id="delete-form" action="{{ route('distributor.destroy', $distributor->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
  </form>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Konfirmasi hapus
  document.getElementById('btnDelete')?.addEventListener('click', function(){
    Swal.fire({
      title: 'Hapus distributor?',
      text: 'Data akan dihapus (soft delete).',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#8B0000',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then((res) => {
      if(res.isConfirmed){
        document.getElementById('delete-form').submit();
      }
    });
  });
</script>
@endpush
