@extends('components.layout-bootstrap')

    <head>
        <title>@yield('title', 'Edit Alamat Pengiriman | Insulmart')</title>
    </head> 

    <style>
    :root {
        --maroon-50: #fdf2f2;
        --maroon-100: #fde8e8;
        --maroon-400: #cd5c5c;
        --maroon-600: #8b0000;
        --maroon-gradient: linear-gradient(60deg, #8b0000 0%, #660000 100%);
        --radius: 1rem;
        --transition: 0.3s;
        --nav-height: 4rem;
    }

    body {
        background-color: var(--maroon-50);
        padding-top: var(--nav-height);
    }

    .content-container {
        padding: 4rem 1.5rem;
    }
    @media (min-width: 768px) {
        .content-container {
        padding: 4rem 3rem;
        max-width: 1024px;
        margin: 0 auto;
        }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .card-custom {
        border: none;
        border-radius: var(--radius);
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.08);
        overflow: hidden;
        animation: fadeInUp 0.6s ease forwards;
        background-color: #fff;
        transition: transform var(--transition), box-shadow var(--transition);
    }
    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 1.5rem 2.5rem rgba(0,0,0,0.12);
    }
    .card-custom .card-body {
        padding: 2.5rem 2rem;
    }

    /* Adjusted header spacing and original font size */
    .card-header {
        background: var(--maroon-gradient);
        color: #fff !important;      /* ← pastikan ini */
        font-size: 1.5rem; /* revert font size */
        letter-spacing: 0.02em;
        padding: 1rem 2rem !important; /* increased vertical padding */
        text-align: center;
        border-bottom: 4px solid var(--maroon-600);
    }
    .card-header i.bi {
        margin-right: 0.75rem;
        font-size: 1.5rem; /* match font-size */
        vertical-align: middle;
    }

    .form-label {
        font-weight: 500;
        color: var(--maroon-600);
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .form-control {
        border-radius: calc(var(--radius)/2);
        border: 1px solid #ddd;
        transition: border-color var(--transition), box-shadow var(--transition);
    }
    .form-control:focus {
        border-color: var(--maroon-600);
        box-shadow: 0 0 0 0.2rem rgba(139,0,0,0.25);
    }

    hr.divider {
        border: 0;
        border-top: 2px dashed var(--maroon-100);
        margin: 2.5rem 0;
    }

    .btn-gradient {
        background-image: var(--maroon-gradient);
        color: #fff !important;
        border-radius: var(--radius);
        padding: .85rem 2.25rem;
        font-weight: 600;
        transition: transform var(--transition), box-shadow var(--transition);
    }
    .btn-gradient:hover {
        transform: scale(1.03);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,0.1);
        color: #fff;
    }

    .btn-outline-secondary {
        border-radius: var(--radius);
        padding: .85rem 2.25rem;
        transition: background var(--transition), color var(--transition);
    }
    .btn-outline-secondary:hover {
        background-color: var(--maroon-400);
        color: #fff;
        border-color: var(--maroon-400);
    }

    @media (max-width: 576px) {
        .sticky-actions {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        background: #fff;
        box-shadow: 0 -1rem 1.5rem rgba(0,0,0,0.05);
        display: flex;
        gap: 1rem;
        justify-content: center;
        z-index: 1000;
        }
        .sticky-actions .btn {
        flex: 1;
        }
    }
    .navbar {
        padding: 0px 24px !important;
    }
    </style>

    @section('content')
    <div class="content-container fade-up">
    <div class="row gy-5 gx-4 justify-content-center">

        {{-- Kartu Lokasi --}}
        <div class="col-xl-5 col-lg-6 fade-up">
        <div class="card-custom">
            <div class="card-header fade-up">
            <i class="bi bi-geo-alt-fill"></i> Lokasi Pengiriman
            </div>
            <div class="card-body fade-up">
            <div class="row gy-4">
                @foreach ([
                ['Provinsi',       $alamat->province],
                ['Kabupaten/Kota', $alamat->regency],
                ['Kecamatan',      $alamat->district],
                ['Desa/Kelurahan', $alamat->village],
                ] as $f)
                <div class="col-6">
                    <label class="form-label">{{ $f[0] }}</label>
                    <p class="form-control-plaintext">{{ $f[1] }}</p>
                    <input type="hidden"
                        name="{{ strtolower(str_replace('/', '_', $f[0])) }}"
                        value="{{ $f[1] }}">
                </div>
                @endforeach
            </div>
            </div>
        </div>
        </div>

        {{-- Kartu Form --}}
        <div class="col-xl-7 col-lg-6 fade-up">
        <div class="card-custom">
            <div class="card-header fade-up">
            <i class="bi bi-pencil-square"></i> Ubah Detail Alamat
            </div>
            <div class="card-body fade-up">
            <form action="{{ route('alamat.update', $alamat->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="row gy-4">
                {{-- RT --}}
                <div class="col-md-6">
                    <label for="rt" class="form-label">
                    <i class="bi bi-people"></i> RT
                    </label>
                    <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" name="rt" placeholder="RT" value="{{ old('rt',$alamat->rt) }}">
                    @error('rt')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                {{-- RW --}}
                <div class="col-md-6">
                    <label for="rw" class="form-label">
                    <i class="bi bi-people-fill"></i> RW
                    </label>
                    <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" name="rw" placeholder="RW" value="{{ old('rw',$alamat->rw) }}">
                    @error('rw')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                {{-- Kode Pos --}}
                <div class="col-12">
                    <label for="kode_pos" class="form-label">
                    <i class="bi bi-mailbox"></i> Kode Pos
                    </label>
                    <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" id="kode_pos" name="kode_pos" placeholder="Kode Pos" value="{{ old('kode_pos',$alamat->kode_pos) }}">
                    @error('kode_pos')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                {{-- Detail Alamat --}}
                <div class="col-12">
                    <label for="alamat_lengkap" class="form-label">
                    <i class="bi bi-journal-text"></i> Detail Alamat
                    </label>
                    <textarea class="form-control @error('alamat_lengkap') is-invalid @enderror" id="alamat_lengkap" name="alamat_lengkap" rows="4" placeholder="Detail Alamat">{{ old('alamat_lengkap',$alamat->alamat_lengkap) }}</textarea>
                    @error('alamat_lengkap')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                </div>

                <hr class="divider">

                {{-- Tombol Desktop --}}
                <div class="d-none d-sm-flex justify-content-end gap-3 mt-4">
                <a href="{{ route('alamat.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg me-1"></i> Batal</a>
                <button type="submit" class="btn btn-gradient"><i class="bi bi-save me-1"></i> Simpan</button>
                </div>

                {{-- Tombol Mobile Sticky --}}
                <div class="sticky-actions d-sm-none">
                <a href="{{ route('alamat.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-gradient">Simpan</button>
                </div>

            </form>
            </div>
        </div>
        </div>

    </div>
    </div>
@endsection
