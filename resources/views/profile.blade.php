@extends('components.layout-bootstrap')

@section('content')
  <style>
    body {
      scroll-padding-top: 100px;
    }

    :root {
      --color-merah-tua: #8B0000;
      --color-merah-hover: #a00000;
    }

    .text-merah {
      color: var(--color-merah-tua);
    }

    .btn-merah {
      background-color: var(--color-merah-tua);
      color: #fff;
      border: none;
    }

    .btn-merah:hover {
      background-color: var(--color-merah-hover);
      color: #fff;
    }

    .btn-kembali {
      background-color: transparent;
      border: none;
      color: var(--color-merah-tua);
      font-weight: 500;
    }

    .btn-kembali:hover {
      text-decoration: underline;
      color: var(--color-merah-hover);
    }

    .profile-card {
      background-color: #fff;
      padding: 32px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    }

    .form-control {
      border-radius: 8px;
    }

    label {
      font-weight: 500;
      margin-bottom: 6px;
    }

    .form-section-title {
      font-size: 18px;
      font-weight: bold;
      color: var(--color-merah-tua);
      border-bottom: 2px solid #ddd;
      padding-bottom: 8px;
      margin-bottom: 20px;
    }

    .rounded-photo {
      border-radius: 12px;
      border: 3px solid #eee;
      margin-bottom: 12px;
    }

    .section-profile {
      padding-top: 150px;
      padding-bottom: 60px;
    }
      .navbar {
          padding: 0px 24px;
      }
  </style>

  <div class="section-profile container fade-up">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="mb-3">
          <a href="{{ url('/') }}" class="btn btn-kembali">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
        </div>

        <div class="profile-card">
          <h4 class="text-merah fw-bold mb-4">👤 Profil Saya</h4>

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

          <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-section-title">Informasi Akun</div>

            <div class="mb-3 text-center">
                @if ($user->profile_photo_path && file_exists(public_path($user->profile_photo_path)))
                    <img src="{{ asset($user->profile_photo_path) }}" width="120" class="rounded-photo shadow">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=8B0000&color=fff&size=120" width="120" class="rounded-photo shadow">
                @endif
                <input type="file" name="profile_photo" class="form-control mt-2">
            </div>

            <div class="mb-3">
              <label>Nama Lengkap</label>
              <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            </div>

            <div class="form-section-title mt-4">Informasi Perusahaan</div>

            <div class="mb-3">
              <label>Nama Perusahaan</label>
              <input type="text" name="perusahaan" value="{{ old('perusahaan', $user->perusahaan) }}" class="form-control">
            </div>

            <div class="mb-3">
              <label>NPWP</label>
              <input type="text" name="npwp" value="{{ old('npwp', $user->npwp) }}" class="form-control">
            </div>

            <div class="mb-3">
              <label>Nomor Telepon</label>
              <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}" class="form-control">
            </div>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-merah py-2 fw-semibold">
                Simpan Perubahan
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
