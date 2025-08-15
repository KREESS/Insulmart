@extends('admin.components.app')

<head>
    <title>@yield('title', 'Edit Distributor | Insulmart')</title>
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

  .card-custom{
    background:#fff; border:none; border-radius:var(--radius); box-shadow:0 4px 18px rgba(139,0,0,.08);
  }
  .alert-custom{ border-radius: var(--radius); border:none; }

  .form-control, .form-select{ border-radius: 12px; padding: .9rem 1rem; border: 1px solid #e9ecef; }
  .form-label{ font-weight: 600; color: var(--maroon); }
  .divider{ height:1px; background:#eee; margin:1rem 0 1.25rem; }
</style>

<main class="main-content p-4 bg-light" id="mainContent">

  {{-- Header --}}
  <div class="mb-4 border-bottom pb-3 d-flex justify-content-between align-items-center">
    <div>
      <h3 class="fw-bold text-maroon mb-1" style="letter-spacing:.5px">
        <i class="bi bi-truck me-2"></i> Edit Distributor
      </h3>
      <p class="text-muted mb-0">Ubah data pemasok / mitra distribusi</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('distributor.index') }}" class="btn btn-outline-maroon">
        <i class="bi bi-arrow-left me-1"></i> Kembali
      </a>
      <a href="{{ route('distributor.show', $distributor->id) }}" class="btn btn-outline-maroon">
        <i class="bi bi-eye me-1"></i> Lihat
      </a>
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

  {{-- Error validasi --}}
  @if ($errors->any())
    <div class="alert alert-danger alert-custom">
      <div class="fw-semibold mb-1">Periksa kembali input berikut:</div>
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card-custom p-3">
    <form action="{{ route('distributor.update', $distributor->id) }}" method="POST">
      @csrf
      @method('PUT')

      {{-- Bagian: Informasi Perusahaan --}}
      <div class="mb-3">
        <h6 class="mb-3 text-merah d-flex align-items-center">
          <i class="bi bi-building me-2"></i> Informasi Perusahaan
        </h6>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama PT <span class="text-danger">*</span></label>
            <input type="text" name="name_pt"
                  class="form-control @error('name_pt') is-invalid @enderror"
                  value="{{ old('name_pt', $distributor->name_pt) }}" required>
            @error('name_pt') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">NPWP</label>
            <input type="text" name="npwp"
                  class="form-control @error('npwp') is-invalid @enderror"
                  value="{{ old('npwp', $distributor->npwp) }}"
                  placeholder="12.345.678.9-012.345">
            @error('npwp') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>

      <hr class="my-4">

      {{-- Bagian: Kontak & Status --}}
      <div class="mb-3">
        <h6 class="mb-3 text-merah d-flex align-items-center">
          <i class="bi bi-person-lines-fill me-2"></i> Kontak & Status
        </h6>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">PIC / Contact Person</label>
            <input type="text" name="contact_person" class="form-control"
                  value="{{ old('contact_person', $distributor->contact_person) }}">
          </div>
          <div class="col-md-3">
            <label class="form-label">Telepon</label>
            <input type="text" name="phone" class="form-control"
                  value="{{ old('phone', $distributor->phone) }}">
          </div>
          <div class="col-md-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"
                  value="{{ old('email', $distributor->email) }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ (string)old('is_active', (int)$distributor->is_active) === '1' ? 'selected' : '' }}>Aktif</option>
              <option value="0" {{ (string)old('is_active', (int)$distributor->is_active) === '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
          </div>
        </div>
      </div>

      <hr class="my-4">

      {{-- Bagian: Alamat --}}
      <div class="mb-3">
        <h6 class="mb-3 text-merah d-flex align-items-center">
          <i class="bi bi-geo-alt-fill me-2"></i> Alamat
        </h6>

        <div class="row g-3">
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
            <input type="text" name="rt" class="form-control"
                  value="{{ old('rt', $distributor->rt) }}" placeholder="001">
          </div>
          <div class="col-md-2">
            <label class="form-label">RW</label>
            <input type="text" name="rw" class="form-control"
                  value="{{ old('rw', $distributor->rw) }}" placeholder="002">
          </div>
          <div class="col-md-3">
            <label class="form-label">Kode Pos</label>
            <input type="text" name="kode_pos" class="form-control"
                  value="{{ old('kode_pos', $distributor->kode_pos) }}" placeholder="12345">
          </div>
          <div class="col-md-5">
            <label class="form-label">Koordinat (Lat,Lng)</label>
            <input type="text" name="coordinate" class="form-control"
                  value="{{ old('coordinate', $distributor->coordinate) }}" placeholder="-6.2, 106.81">
          </div>

          <div class="col-12">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="alamat_lengkap" class="form-control" rows="2" placeholder="Nama jalan, nomor, patokan...">{{ old('alamat_lengkap', $distributor->alamat_lengkap) }}</textarea>
          </div>

          <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $distributor->notes) }}</textarea>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between pt-2">
        <a href="{{ route('distributor.index') }}" class="btn btn-outline-maroon">
          <i class="bi bi-x-circle me-1"></i> Batal
        </a>
        <button type="submit" class="btn btn-maroon">
          <i class="bi bi-save2 me-1"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</main>
@endsection

@push('scripts')
<script>
  // === Wilayah dari JSON (prefill nilai lama) ===
  document.addEventListener('DOMContentLoaded', async () => {
    const $ = id => document.getElementById(id);
    const reset = (el, label) => { el.innerHTML = `<option value="">Pilih ${label}…</option>`; el.disabled = true; };
    const fillBy = (el, list, parentKey, parentVal, label) => {
      reset(el, label);
      list.filter(i => String(i[parentKey]) === String(parentVal))
          .forEach(i => el.add(new Option(i.name, i.name)));
      el.disabled = false;
    };
    const findIdByName = (list, name) => (list.find(x => x.name === name) || {}).id;

    // Preset nilai (old() -> model)
    const preset = {
      province: @json(old('province', $distributor->province)),
      regency:  @json(old('regency',  $distributor->regency)),
      district: @json(old('district', $distributor->district)),
      village:  @json(old('village',  $distributor->village)),
    };

    // Hidden name setter (kalau backend pakai *_name)
    const setHiddenName = (selectEl, hiddenId) => {
      const text = selectEl.options[selectEl.selectedIndex]?.text || '';
      document.getElementById(hiddenId).value = text;
    };

    // Load datasets
    let PROV=[], REGENCY=[], DISTRICT=[], VILLAGE=[];
    try{
      const [p, r, d, v] = await Promise.all([
        fetch('/data/provinces.json').then(res => res.json()),
        fetch('/data/regencies.json').then(res => res.json()),
        fetch('/data/districts.json').then(res => res.json()),
        fetch('/data/villages.json').then(res => res.json()),
      ]);
      PROV=p; REGENCY=r; DISTRICT=d; VILLAGE=v;
    }catch(e){
      console.error(e);
      return;
    }

    // Hydrate provinsi
    reset($('province'), 'Provinsi');
    PROV.forEach(p => $('province').add(new Option(p.name, p.name)));
    $('province').disabled = false;

    // Prefill bertingkat
    if(preset.province){
      $('province').value = preset.province;
      setHiddenName($('province'), 'province_name');
      const pid = findIdByName(PROV, preset.province);
      if(pid){
        fillBy($('regency'), REGENCY, 'province_id', pid, 'Kabupaten/Kota');
        if(preset.regency){
          $('regency').value = preset.regency;
          setHiddenName($('regency'), 'regency_name');
          const rid = findIdByName(REGENCY, preset.regency);
          if(rid){
            fillBy($('district'), DISTRICT, 'regency_id', rid, 'Kecamatan');
            if(preset.district){
              $('district').value = preset.district;
              setHiddenName($('district'), 'district_name');
              const did = findIdByName(DISTRICT, preset.district);
              if(did){
                fillBy($('village'), VILLAGE, 'district_id', did, 'Desa/Kelurahan');
                if(preset.village){
                  $('village').value = preset.village;
                  setHiddenName($('village'), 'village_name');
                }
              }
            }
          }
        }
      }
    }

    // Event changes
    $('province')?.addEventListener('change', () => {
      setHiddenName($('province'), 'province_name');
      reset($('regency'), 'Kabupaten/Kota');
      reset($('district'), 'Kecamatan');
      reset($('village'), 'Desa/Kelurahan');
      const pid = findIdByName(PROV, $('province').value);
      if(pid) fillBy($('regency'), REGENCY, 'province_id', pid, 'Kabupaten/Kota');
    });

    $('regency')?.addEventListener('change', () => {
      setHiddenName($('regency'), 'regency_name');
      reset($('district'), 'Kecamatan');
      reset($('village'), 'Desa/Kelurahan');
      const rid = findIdByName(REGENCY, $('regency').value);
      if(rid) fillBy($('district'), DISTRICT, 'regency_id', rid, 'Kecamatan');
    });

    $('district')?.addEventListener('change', () => {
      setHiddenName($('district'), 'district_name');
      reset($('village'), 'Desa/Kelurahan');
      const did = findIdByName(DISTRICT, $('district').value);
      if(did) fillBy($('village'), VILLAGE, 'district_id', did, 'Desa/Kelurahan');
    });

    $('village')?.addEventListener('change', () => {
      setHiddenName($('village'), 'village_name');
    });
  });
</script>
@endpush
