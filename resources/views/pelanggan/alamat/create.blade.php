@extends('components.layout-bootstrap')

<head>
    <title>@yield('title', 'Tambah Alamat Pengiriman | Insulmart')</title>
</head>

@section('content')
<style>
  :root {
    --maroon-dark: #800000;
    --maroon-hover: #990000;
    --maroon-light: #f8ecec;
    --border-radius: 12px;
  }
  .page-wrapper {
    padding-top: 8rem;
    padding-bottom: 4rem;
    background: var(--maroon-light);
  }
  .card-address {
    background: #fff;
    border-radius: var(--border-radius);
    padding: 2rem;
    max-width: 600px;
    margin: 0 auto;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    transition: transform 0.2s;
  }
  .card-address:hover { transform: translateY(-4px); }
  h2.text-maroon {
    color: var(--maroon-dark);
    font-weight: 600;
    margin-bottom: 1.5rem;
    position: relative;
  }
  h2.text-maroon::after {
    content: '';
    position: absolute;
    bottom: -0.5rem;
    left: 0;
    width: 50px;
    height: 3px;
    background: var(--maroon-dark);
    border-radius: 2px;
  }
  label.text-maroon { color: var(--maroon-dark) !important; font-weight: 500; }
  .form-select, .form-control {
    border-radius: var(--border-radius);
    padding: 1rem;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
    border: none;
  }
  .form-select:disabled { background-color: #e9ecef; }
  .btn-maroon {
    background: var(--maroon-dark);
    color: #fff;
    border: none;
    border-radius: var(--border-radius);
    font-weight: 600;
    padding: 10px 24px;
    font-size: 1rem;
    letter-spacing: .02em;
    transition: background .15s, transform .15s;
  }
  .btn-maroon:hover { background: var(--maroon-hover); transform: translateY(-2px); }
  .btn-cancel {
    background: #6c757d;
    color: #fff;
    border: none;
    border-radius: var(--border-radius);
    padding: 10px 24px;
    transition: background .15s, transform .15s;
  }
  .btn-cancel:hover { background: #5a6268; transform: translateY(-2px); }
  .navbar {
    padding: 0px 24px;
  }
</style>

<div class="page-wrapper">
  <div class="card-address fade-up">
    <h2 class="text-maroon fade-up">Tambah Alamat Baru</h2>
    <form action="{{ route('alamat.store') }}" method="POST">
      @csrf

      {{-- Provinsi --}}
      <div class="mb-4 fade-up">
        <label class="form-label text-maroon">Provinsi *</label>
        <select id="province" name="province" class="form-select" required>
          <option value="">Pilih Provinsi…</option>
        </select>
      </div>

      {{-- Kabupaten/Kota --}}
      <div class="mb-4 fade-up">
        <label class="form-label text-maroon">Kabupaten/Kota *</label>
        <select id="regency" name="regency" class="form-select" disabled required>
          <option value="">Pilih Kabupaten/Kota…</option>
        </select>
      </div>

      {{-- Kecamatan --}}
      <div class="mb-4 fade-up">
        <label class="form-label text-maroon">Kecamatan *</label>
        <select id="district" name="district" class="form-select" disabled required>
          <option value="">Pilih Kecamatan…</option>
        </select>
      </div>

      {{-- Desa/Kelurahan --}}
      <div class="mb-4 fade-up">
        <label class="form-label text-maroon">Desa/Kelurahan *</label>
        <select id="village" name="village" class="form-select" disabled required>
          <option value="">Pilih Desa/Kelurahan…</option>
        </select>
      </div>

      {{-- RT & RW --}}
      <div class="row g-3 mb-4 fade-up">
        <div class="col-md-6">
          <label class="form-label text-maroon">RT *</label>
          <input type="text" name="rt" class="form-control" placeholder="001" required>
        </div>
        <div class="col-md-6">
          <label class="form-label text-maroon">RW *</label>
          <input type="text" name="rw" class="form-control" placeholder="002" required>
        </div>
      </div>

      {{-- Kode Pos --}}
      <div class="mb-4 fade-up">
        <label class="form-label text-maroon">Kode Pos *</label>
        <input type="text" name="kode_pos" class="form-control" placeholder="12345" required>
      </div>

      {{-- Alamat Lengkap --}}
      <div class="mb-4 fade-up">
        <label class="form-label text-maroon">Alamat Lengkap *</label>
        <textarea name="alamat_lengkap" class="form-control" rows="3" required></textarea>
      </div>

      {{-- Koordinat --}}
      <div class="mb-4 fade-up">
        <label class="form-label text-maroon">Koordinat (Latitude,Longitude) *</label>
        <input type="text" name="koordinat" class="form-control" placeholder="-6.2,106.8" required>
      </div>

      <div class="d-flex justify-content-between fade-up">
        <a href="{{ route('alamat.index') }}" class="btn btn-cancel">Batal</a>
        <button type="submit" class="btn btn-maroon">Simpan Alamat</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', async () => {
  const sel = id => document.getElementById(id);
  const reset = (el,label) => {
    el.innerHTML = `<option value="">Pilih ${label}…</option>`;
    el.disabled = true;
  };
  const fill  = (el,list,parentKey,parentVal,label) => {
    reset(el,label);
    list
      .filter(i => i[parentKey] == parentVal)
      .forEach(i => el.add(new Option(i.name, i.name)));
    el.disabled = false;
  };

  const [provs, regs, dists, vills] = await Promise.all([
    fetch('/data/provinces.json').then(r => r.json()),
    fetch('/data/regencies.json').then(r => r.json()),
    fetch('/data/districts.json').then(r => r.json()),
    fetch('/data/villages.json').then(r => r.json()),
  ]);

  // isi provinsi
  provs.forEach(p => sel('province').add(new Option(p.name, p.name)));
  sel('province').disabled = false;

  sel('province').onchange = () => {
    reset(sel('regency'), 'Kabupaten/Kota');
    reset(sel('district'), 'Kecamatan');
    reset(sel('village'), 'Desa/Kelurahan');
    if (!sel('province').value) return;
    // cari province.id dari nama
    const pid = provs.find(x=>x.name===sel('province').value).id;
    fill(sel('regency'), regs, 'province_id', pid, 'Kabupaten/Kota');
  };

  sel('regency').onchange = () => {
    reset(sel('district'), 'Kecamatan');
    reset(sel('village'), 'Desa/Kelurahan');
    if (!sel('regency').value) return;
    const rid = regs.find(x=>x.name===sel('regency').value).id;
    fill(sel('district'), dists, 'regency_id', rid, 'Kecamatan');
  };

  sel('district').onchange = () => {
    reset(sel('village'), 'Desa/Kelurahan');
    if (!sel('district').value) return;
    const did = dists.find(x=>x.name===sel('district').value).id;
    fill(sel('village'), vills, 'district_id', did, 'Desa/Kelurahan');
  };
});
</script>
@endpush