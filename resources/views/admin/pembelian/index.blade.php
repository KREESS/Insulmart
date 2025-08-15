@extends('admin.components.app')

<head>
  <title>@yield('title', 'Pembelian Produk (Per PO) | Insulmart')</title>
</head>

@section('content')
<style>
  :root{
    --color-merah-tua:#8B0000; --color-merah-hover:#a41515;
    --color-gradient:linear-gradient(90deg,#8B0000 0%,#a41515 100%);
    --color-maroon-light:#fbeaec;
  }
  .text-merah{color:var(--color-merah-tua)!important}
  .btn-maroon{background:var(--color-gradient);color:#fff;border:none;border-radius:2em;padding:.6rem 1.5rem;font-weight:500;transition:.3s}
  .btn-maroon:hover{background:linear-gradient(90deg,#a41515 0%,#8B0000 100%);transform:translateY(-2px);color:#fff}
  .btn-outline-maroon{color:var(--color-merah-tua);border:2px solid var(--color-merah-tua);border-radius:2em;padding:.5rem 1.2rem;font-weight:500}
  .btn-outline-maroon:hover{background:var(--color-gradient);color:#fff;border-color:transparent;transform:translateY(-2px)}
  .card-custom{border-radius:1rem;border:none;box-shadow:0 4px 18px rgba(139,0,0,.08);overflow:hidden;background:#fff}
  .table-custom{background:#fff;border-radius:1rem;overflow:hidden;box-shadow:0 4px 18px rgba(139,0,0,.08)}
  .table-custom thead{background:var(--color-maroon-light)}
  .table-custom th{font-weight:600;color:var(--color-merah-tua);padding:1rem;white-space:nowrap}
  .table-custom td{padding:1rem;vertical-align:middle}
  .table-hover>tbody>tr:hover{background:#fde4e4!important;transition:.2s}
  .btn-action{width:34px;height:34px;padding:0;display:inline-flex;align-items:center;justify-content:center;border-radius:8px}
  .collapse-row{background:#fff}
  .inner-table thead th{background:#faf5f5}
  .badge{border-radius:2em}
</style>

<main class="main-content p-4 bg-light" id="mainContent">

  <div class="mb-4 border-bottom pb-3 d-flex justify-content-between align-items-center">
    <div>
      <h3 class="fw-bold text-merah mb-1" style="font-size:2rem;letter-spacing:.5px">
        <i class="bi bi-cart-plus me-2"></i> Pembelian (Dikelompokkan per PO)
      </h3>
      <p class="text-muted mb-0">Setiap baris mewakili 1 kode PO. Klik untuk lihat item di dalamnya.</p>
    </div>
    <a href="{{ route('pembelian.create') }}" class="btn btn-maroon d-flex align-items-center gap-2">
      <i class="bi bi-plus-circle-fill"></i> Tambah Pembelian
    </a>
  </div>

  {{-- Notifikasi --}}
  @if(session('success'))
    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show alert-custom mb-4" role="alert">
      <i class="bi bi-check-circle-fill me-2 fs-5"></i>
      <div>{{ session('success') }}</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card card-custom">
    <div class="table-responsive">
      <table class="table table-hover table-custom mb-0 align-middle">
        <thead>
          <tr>
            <th style="width:30%">PO Code & Distributor</th>
            <th style="width:15%">Jumlah Item</th>
            <th style="width:20%">Grand Total</th>
            <th style="width:20%">Rentang Tanggal</th>
            <th style="width:15%">Aksi</th>
          </tr>
        </thead>
        <tbody>
        @forelse($groups as $g)
          @php
            $slug = \Illuminate\Support\Str::slug($g->po_code, '-');
            $items = $itemsByPo[$g->po_code] ?? collect();
            $first = $g->first_date ? \Carbon\Carbon::parse($g->first_date)->format('d M Y') : '-';
            $last  = $g->last_date  ? \Carbon\Carbon::parse($g->last_date)->format('d M Y') : '-';
          @endphp

          {{-- Row grup PO --}}
          <tr class="group-row">
            <td>
              <button class="btn btn-outline-secondary btn-sm me-2 btnToggle" data-target="#items-{{ $slug }}">
                <i class="bi bi-caret-down-fill"></i>
              </button>
              <span class="fw-semibold">{{ $g->po_code }}</span>
              <div class="text-muted small mt-1">
                <i class="bi bi-building me-1"></i>{{ optional($g->distributor)->name_pt ?? '—' }}
                @if(optional($g->distributor)->contact_person)
                  <span class="ms-2"><i class="bi bi-person-badge me-1"></i>{{ $g->distributor->contact_person }}</span>
                @endif
              </div>
            </td>
            <td>
              <span class="badge bg-info-subtle text-info border border-info-subtle">
                {{ (int) $g->items }} item
              </span>
            </td>
            <td class="fw-semibold">Rp {{ number_format($g->grand_total, 0, ',', '.') }}</td>
            <td>
              <div>{{ $first }} @if($first !== $last) — {{ $last }} @endif</div>
            </td>
            <td>
              <div class="d-flex gap-1">
                {{-- Tambah item ke PO yang sama --}}
                <a href="{{ route('pembelian.create', ['po_code' => $g->po_code]) }}"
                   class="btn btn-action btn-success text-white" title="Tambah item ke PO ini">
                  <i class="bi bi-plus-lg"></i>
                </a>
                {{-- Download PO per kode --}}
                <a href="{{ route('pembelian.produk.downloadPo', $g->po_code) }}"
                   class="btn btn-action btn-primary text-white" title="Download PO">
                  <i class="bi bi-download"></i>
                </a>
              </div>
            </td>
          </tr>

          {{-- Row detail item (collapse) --}}
          <tr id="items-{{ $slug }}" class="collapse-row" style="display:none;">
            <td colspan="5">
              <div class="p-3 bg-light rounded">
                <div class="fw-semibold mb-2 text-merah">
                  <i class="bi bi-list-ul me-1"></i> Item dalam {{ $g->po_code }}
                </div>
                <div class="table-responsive">
                  <table class="table table-sm align-middle inner-table">
                    <thead>
                      <tr>
                        <th style="width:32%">Produk & Varian</th>
                        <th style="width:10%">Qty</th>
                        <th style="width:16%">Harga Satuan</th>
                        <th style="width:16%">Total</th>
                        <th style="width:12%">Status</th>
                        <th style="width:14%">Tanggal</th>
                        <th style="width:10%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($items as $p)
                        @php
                          $statusClass = [
                            'draft' => 'secondary',
                            'dipesan' => 'info',
                            'dikirim' => 'primary',
                            'diterima_sebagian' => 'warning',
                            'selesai' => 'success',
                            'dibatalkan' => 'danger',
                            'dikembalikan_ke_supplier' => 'dark'
                          ][$p->status] ?? 'secondary';
                        @endphp
                        <tr>
                          <td>
                            <div class="lh-sm">
                              <div class="fw-semibold">{{ data_get($p,'varian.produk.nama_produk','-') }}</div>
                              <div class="mt-1">
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">{{ data_get($p,'varian.tipe','-') }}</span>
                              </div>
                            </div>
                          </td>
                          <td>{{ (int) $p->qty }}</td>
                          <td>Rp {{ number_format($p->harga_satuan, 0, ',', '.') }}</td>
                          <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                          <td><span class="badge bg-{{ $statusClass }}">{{ str_replace('_',' ', ucfirst($p->status)) }}</span></td>
                          <td>{{ $p->tanggal_beli?->format('d M Y') ?? '-' }}</td>
                          <td>
                            <div class="d-flex gap-1">
                              <a href="{{ route('pembelian.show', $p->id) }}" class="btn btn-action btn-info text-white" title="Detail">
                                <i class="bi bi-eye-fill"></i>
                              </a>
                              <a href="{{ route('pembelian.edit', $p->id) }}" class="btn btn-action btn-warning text-white" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                              </a>
                              <button type="button" class="btn btn-action btn-danger btn-delete" data-id="{{ $p->id }}" title="Hapus item">
                                <i class="bi bi-trash-fill"></i>
                              </button>
                            </div>
                          </td>
                        </tr>
                      @empty
                        <tr><td colspan="7" class="text-muted">Tidak ada item.</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center py-4">
              <div class="d-flex flex-column align-items-center">
                <i class="bi bi-inbox text-muted mb-3" style="font-size: 2rem;"></i>
                <h5 class="text-muted mb-3">Belum ada pembelian</h5>
                <a href="{{ route('pembelian.create') }}" class="btn btn-maroon">
                  <i class="bi bi-plus-circle me-2"></i> Tambah Pembelian
                </a>
              </div>
            </td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if(method_exists($groups, 'links'))
      <div class="p-3">
        {{ $groups->withQueryString()->links() }}
      </div>
    @endif
  </div>

  {{-- Form hapus item (global, diisi dinamis) --}}
  <form id="delete-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
  </form>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Toggle detail items
  document.querySelectorAll('.btnToggle').forEach(btn => {
    btn.addEventListener('click', function(){
      const target = document.querySelector(this.dataset.target);
      if (!target) return;
      const isOpen = target.style.display !== 'none';
      target.style.display = isOpen ? 'none' : '';
      this.querySelector('i').classList.toggle('bi-caret-down-fill', isOpen);
      this.querySelector('i').classList.toggle('bi-caret-up-fill', !isOpen);
    });
  });

  // Hapus item
  const deleteForm = document.getElementById('delete-form');
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function(){
      const id = this.getAttribute('data-id');
      Swal.fire({
        title: 'Hapus item?',
        text: 'Item akan dihapus permanen dari PO ini.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
      }).then((r) => {
        if (r.isConfirmed) {
          deleteForm.setAttribute('action', `/admin/pembelian/${id}`);
          deleteForm.submit();
        }
      });
    });
  });
});
</script>
@endpush
