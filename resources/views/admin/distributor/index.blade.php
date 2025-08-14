@extends('admin.components.app')

<head>
    <title>@yield('title', 'Kelola Distributor | Insulmart')</title>
</head>

@section('content')
<style>
  :root {
    --color-merah-tua: #8B0000;
    --color-merah-hover: #a41515;
    --color-gradient: linear-gradient(90deg, #8B0000 0%, #a41515 100%);
    --color-gradient-hover: linear-gradient(90deg, #a41515 0%, #8B0000 100%);
    --color-maroon-light: #fbeaec;
  }

  .text-merah { color: var(--color-merah-tua) !important; }

  .btn-maroon {
    background: var(--color-gradient);
    color: #fff;
    border: none;
    border-radius: 2em;
    padding: 0.6rem 1.5rem;
    font-weight: 500;
    transition: all .3s ease;
  }
  .btn-maroon:hover {
    background: var(--color-gradient-hover);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(139, 0, 0, 0.2);
  }

  .btn-outline-maroon {
    color: var(--color-merah-tua);
    border: 2px solid var(--color-merah-tua);
    border-radius: 2em;
    padding: 0.5rem 1.2rem;
    font-weight: 500;
    transition: all .3s ease;
    background: #fff;
  }
  .btn-outline-maroon:hover {
    background: var(--color-gradient);
    color: #fff;
    border-color: transparent;
    transform: translateY(-2px);
  }

  .card-custom {
    border-radius: 1rem;
    border: none;
    box-shadow: 0 4px 18px 0 rgba(139,0,0,.08);
    overflow: hidden;
    background: #fff;
  }

  .table-custom {
    background: #fff;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 18px 0 rgba(139,0,0,.08);
  }
  .table-custom thead { background: var(--color-maroon-light); }
  .table-custom th {
    font-weight: 600;
    color: var(--color-merah-tua);
    padding: 1rem;
    white-space: nowrap;
  }
  .table-custom td { padding: 1rem; vertical-align: middle; }
  .table-hover > tbody > tr:hover {
    background-color: #fde4e4 !important;
    transition: .2s;
  }

  .badge-dot {
    width: .5rem; height: .5rem; display:inline-block; border-radius:50%;
    margin-right: .35rem; vertical-align: middle;
  }
  .empty-state {
    border: 2px dashed #e9ecef; border-radius: 16px; padding: 32px;
    background: #fff;
  }
  .alert-custom { border-radius: 1rem; border: none; padding: 1rem 1.5rem; }

  .btn-action {
    width: 36px; height: 36px; padding: 0;
    display: inline-flex; align-items: center; justify-content: center;
    border-radius: 10px; transition: all .25s ease;
  }
  .btn-action:hover { transform: translateY(-2px); }

  .search-input::placeholder { color: #9aa0a6; }
</style>

<main class="main-content p-4 bg-light" id="mainContent">

  {{-- Header maroon --}}
  <div class="mb-4 border-bottom pb-3">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h3 class="fw-bold text-merah mb-1" style="font-size:2rem;letter-spacing:.5px">
          <i class="bi bi-building-gear me-2"></i> Kelola Distributor
        </h3>
        <p class="text-muted mb-0">Data pemasok untuk kebutuhan pembelian & pengisian gudang</p>
      </div>
      <button class="btn btn-maroon d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalCreate">
        <i class="bi bi-plus-circle-fill"></i> Tambah Distributor
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

  {{-- Toolbar: Search & Filter --}}
  <div class="card-custom mb-3">
    <div class="p-3">
      <div class="row g-2 align-items-center">
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" id="searchInput" class="form-control search-input" placeholder="Cari nama PT, PIC, telepon, email, atau alamat...">
          </div>
        </div>
        <div class="col-md-3">
          <select id="statusFilter" class="form-select">
            <option value="">Semua Status</option>
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
          </select>
        </div>
        <div class="col-md-3 text-md-end">
          <button class="btn btn-outline-maroon" id="btnExport" type="button">
            <i class="bi bi-download me-1"></i>Export
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- Tabel maroon --}}
  <div class="table-responsive">
    <table class="table table-hover table-custom mb-0" id="tableDistributor">
      <thead>
        <tr>
          <th style="width: 28%">Nama PT & PIC</th>
          <th style="width: 20%">Kontak</th>
          <th style="width: 34%">Alamat</th>
          <th style="width: 8%">Status</th>
          <th style="width: 12%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @php
          $collection = isset($distributors) ? $distributors : collect();
        @endphp

        @forelse($collection as $d)
          <tr data-status="{{ (int)($d->is_active) }}">
            <td>
              <div class="fw-semibold">{{ $d->name_pt ?? $d->name ?? '-' }}</div>
              <div class="text-muted small">
                <i class="bi bi-person-badge me-1"></i>{{ $d->contact_person ?: '—' }}
              </div>
            </td>
            <td>
              <div class="small">
                <i class="bi bi-telephone me-1"></i>{{ $d->phone ?: '—' }}
              </div>
              <div class="small">
                <i class="bi bi-envelope me-1"></i>{{ $d->email ?: '—' }}
              </div>
            </td>
            <td class="small">
              @php
                $alamatSingkat = collect([$d->village, $d->district, $d->regency])->filter()->implode(', ');
                $prov = $d->province ? ' - '.$d->province : '';
                $kp = $d->kode_pos ? ' ('.$d->kode_pos.')' : '';
              @endphp
              <div class="text-truncate" style="max-width: 460px;">
                <i class="bi bi-geo-alt me-1"></i>
                {{ $alamatSingkat ? $alamatSingkat.$prov.$kp : ($d->alamat_lengkap ?: '—') }}
              </div>
              @if(!empty($d->coordinate))
                <div class="text-muted">
                  <i class="bi bi-crosshair me-1"></i>{{ $d->coordinate }}
                </div>
              @endif
            </td>
            <td>
              @if($d->is_active)
                <span class="badge bg-success-subtle text-success border border-success-subtle">
                  <span class="badge-dot bg-success"></span>Aktif
                </span>
              @else
                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                  <span class="badge-dot bg-secondary"></span>Nonaktif
                </span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1">
                  {{-- SHOW / DETAIL --}}
                <a href="{{ route('distributor.show', $d->id) }}"
                class="btn btn-action btn-info text-white"
                title="Lihat Detail">
                <i class="bi bi-eye-fill"></i>
                </a>
                <a href="{{ route('distributor.edit', $d->id) }}"
                   class="btn btn-action btn-warning text-white" title="Edit">
                  <i class="bi bi-pencil-fill"></i>
                </a>
                <button type="button"
                        class="btn btn-action btn-danger btnDelete"
                        data-id="{{ $d->id }}"
                        data-name="{{ $d->name_pt ?? $d->name ?? 'Distributor' }}"
                        title="Hapus">
                  <i class="bi bi-trash-fill"></i>
                </button>
              </div>
              <form action="{{ route('distributor.destroy', $d->id) }}" method="POST" class="d-none" id="formDelete-{{ $d->id }}">
                @csrf
                @method('DELETE')
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center py-4">
              <div class="d-flex flex-column align-items-center">
                <i class="bi bi-inbox text-muted mb-3" style="font-size: 2rem;"></i>
                <h5 class="text-muted mb-2">Belum ada distributor</h5>
                <button class="btn btn-maroon d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalCreate">
                  <i class="bi bi-plus-circle"></i> Tambah Distributor
                </button>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination (jika pakai paginate) --}}
  @if(method_exists($collection, 'links'))
    <div class="mt-3">
      {{ $collection->withQueryString()->links() }}
    </div>
  @endif
</main>

{{-- Modal Create: pakai SELECT bertingkat dari JSON --}}
<div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <form class="modal-content" action="{{ route('distributor.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title text-merah"><i class="bi bi-plus-circle-fill me-2"></i>Tambah Distributor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama PT <span class="text-danger">*</span></label>
            <input type="text" name="name_pt" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">PIC / Contact Person</label>
            <input type="text" name="contact_person" class="form-control">
          </div>

          <div class="col-md-4">
            <label class="form-label">Telepon</label>
            <input type="text" name="phone" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-select">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
          </div>

          {{-- Ganti input text -> SELECT bertingkat --}}
          <div class="col-md-6">
            <label class="form-label">Provinsi</label>
            <select id="province" name="province" class="form-select" disabled>
              <option value="">Pilih Provinsi…</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Kab/Kota</label>
            <select id="regency" name="regency" class="form-select" disabled>
              <option value="">Pilih Kabupaten/Kota…</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Kecamatan</label>
            <select id="district" name="district" class="form-select" disabled>
              <option value="">Pilih Kecamatan…</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Kel/Desa</label>
            <select id="village" name="village" class="form-select" disabled>
              <option value="">Pilih Desa/Kelurahan…</option>
            </select>
          </div>

          <div class="col-md-2">
            <label class="form-label">RT</label>
            <input type="text" name="rt" class="form-control" placeholder="001">
          </div>
          <div class="col-md-2">
            <label class="form-label">RW</label>
            <input type="text" name="rw" class="form-control" placeholder="002">
          </div>
          <div class="col-md-3">
            <label class="form-label">Kode Pos</label>
            <input type="text" name="kode_pos" class="form-control" placeholder="12345">
          </div>
          <div class="col-md-5">
            <label class="form-label">Koordinat (Lat,Lng)</label>
            <input type="text" name="coordinate" class="form-control" placeholder="-6.2, 106.81">
          </div>

          <div class="col-12">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="alamat_lengkap" class="form-control" rows="2" placeholder="Nama jalan, nomor, patokan..."></textarea>
          </div>
          <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="2"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-maroon" type="button" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-maroon" type="submit">
          <i class="bi bi-save2 me-1"></i>Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // ======= FILTER TABEL =======
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const tbody = document.getElementById('tableDistributor')?.querySelector('tbody');

    function normalize(str){ return (str || '').toString().toLowerCase(); }
    function applyFilter(){
        if (!tbody) return;
        const q = normalize(searchInput?.value);
        const s = statusFilter?.value; // "" | "1" | "0"
        [...tbody.rows].forEach(tr => {
        const text = normalize(tr.innerText);
        const status = tr.getAttribute('data-status');
        const passText = !q || text.includes(q);
        const passStatus = !s || s === status;
        tr.style.display = (passText && passStatus) ? "" : "none";
        });
    }
    searchInput?.addEventListener('input', applyFilter);
    statusFilter?.addEventListener('change', applyFilter);

    // ======= HAPUS DATA (SweetAlert) =======
    document.querySelectorAll('.btnDelete').forEach(btn => {
        btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const name = btn.getAttribute('data-name') || 'Distributor';
        Swal.fire({
            title: 'Hapus data?',
            html: `Data <b>${name}</b> akan dihapus.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#8B0000',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((res) => {
            if (res.isConfirmed) {
            document.getElementById('formDelete-' + id).submit();
            }
        });
        });
    });

    document.getElementById('btnExport')?.addEventListener('click', () => {
        Swal.fire({
        icon: 'info',
        title: 'Export Data',
        text: 'Hubungkan tombol ini ke route export (CSV/Excel) sesuai kebutuhan.',
        confirmButtonText: 'OK',
        confirmButtonColor: '#8B0000'
        });
    });

    // ======= SELECT BERtingkat dari JSON (Prov -> Kab/Kota -> Kec -> Desa) =======
    (function initWilayahSelector() {
        const modal = document.getElementById('modalCreate');

        // Cache datasets supaya fetch sekali
        let PROV=[], REGENCY=[], DISTRICT=[], VILLAGE=[];
        let loaded = false;

        const $ = (id) => document.getElementById(id);
        const reset = (el, label) => {
        el.innerHTML = `<option value="">Pilih ${label}…</option>`;
        el.disabled = true;
        };
        const fillBy = (el, list, parentKey, parentVal, label) => {
        reset(el, label);
        list
            .filter(item => String(item[parentKey]) === String(parentVal))
            .forEach(item => el.add(new Option(item.name, item.name)));
        el.disabled = false;
        };
        const hydrateProvinsi = () => {
        const provSel = $('province');
        reset(provSel, 'Provinsi');
        PROV.forEach(p => provSel.add(new Option(p.name, p.name)));
        provSel.disabled = false;
        };
        const findIdByName = (list, name) => {
        return (list.find(x => x.name === name) || {}).id;
        };

        async function ensureDataLoaded() {
        if (loaded) return;
        try {
            const [p, r, d, v] = await Promise.all([
            fetch('/data/provinces.json').then(res => res.json()),
            fetch('/data/regencies.json').then(res => res.json()),
            fetch('/data/districts.json').then(res => res.json()),
            fetch('/data/villages.json').then(res => res.json()),
            ]);
            PROV = p; REGENCY = r; DISTRICT = d; VILLAGE = v;
            loaded = true;
        } catch (e) {
            console.error('Gagal memuat data wilayah:', e);
            Swal.fire({
            icon: 'error',
            title: 'Gagal memuat wilayah',
            text: 'Pastikan file JSON tersedia di /public/data/*.json',
            confirmButtonColor: '#8B0000'
            });
        }
        }

        function resetFormWilayah() {
        const prov = $('province'), reg = $('regency'), dis = $('district'), vil = $('village');
        reset(prov, 'Provinsi');
        reset(reg, 'Kabupaten/Kota');
        reset(dis, 'Kecamatan');
        reset(vil, 'Desa/Kelurahan');
        }

        modal?.addEventListener('show.bs.modal', async () => {
        // Reset setiap kali modal dibuka
        resetFormWilayah();
        await ensureDataLoaded();
        if (loaded) hydrateProvinsi();
        });

        $('province')?.addEventListener('change', () => {
        const provName = $('province').value;
        reset($('regency'), 'Kabupaten/Kota');
        reset($('district'), 'Kecamatan');
        reset($('village'), 'Desa/Kelurahan');
        if (!provName) return;
        const pid = findIdByName(PROV, provName);
        fillBy($('regency'), REGENCY, 'province_id', pid, 'Kabupaten/Kota');
        });

        $('regency')?.addEventListener('change', () => {
        const regName = $('regency').value;
        reset($('district'), 'Kecamatan');
        reset($('village'), 'Desa/Kelurahan');
        if (!regName) return;
        const rid = findIdByName(REGENCY, regName);
        fillBy($('district'), DISTRICT, 'regency_id', rid, 'Kecamatan');
        });

        $('district')?.addEventListener('change', () => {
        const disName = $('district').value;
        reset($('village'), 'Desa/Kelurahan');
        if (!disName) return;
        const did = findIdByName(DISTRICT, disName);
        fillBy($('village'), VILLAGE, 'district_id', did, 'Desa/Kelurahan');
        });
    })();
    </script>
@endpush
