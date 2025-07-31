@extends('components.layout-bootstrap')

<head>
    <title>@yield('title', 'About & Hubungi Kami Insulasi | Insulmart')</title>
    <!-- Tag lain seperti meta, link CSS, dll -->
</head>

@section('content')
  <style>
    :root {
      --color-merah-tua: #8B0000;
    }

    .text-merah {
      color: var(--color-merah-tua);
    }

    .kontak-section {
      padding: 4rem 0;
      background-color: #f9f9f9;
    }

    .kontak-box {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
      padding: 2rem;
    }

    .kontak-title {
      font-size: 2rem;
      font-weight: bold;
      color: var(--color-merah-tua);
    }

    .kontak-desc {
      font-size: 1rem;
      line-height: 1.7;
      color: #444;
    }

    .info-icon {
      width: 40px;
      height: 40px;
      background-color: var(--color-merah-tua);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 1rem;
      flex-shrink: 0;
    }

    .info-item {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
    }

    .form-control,
    .btn {
      border-radius: 8px;
    }

    .btn-merah {
      background-color: var(--color-merah-tua);
      color: white;
    }

    .btn-merah:hover {
      background-color: #a00000;
    }

    @media (max-width: 768px) {
      .kontak-flex {
        flex-direction: column !important;
      }

      .kontak-title {
        font-size: 1.5rem;
        margin-bottom: 1rem;
      }
    }
    .navbar {
      padding: 0px 24px;
    }
  </style>
  {{-- Hero --}}
  <section class="position-relative text-center text-white fade-up" style="
    height: 260px;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)),
                url('{{ asset('assets/img/landing/7.png') }}') center center / cover no-repeat;">
    <div class="position-relative h-100 d-flex flex-column justify-content-center align-items-center">
      <h2 class="fw-bold mb-1">Tentang & Kontak Kami</h2>
      <p class="text-white-50 small mb-0">
        Kenali lebih dekat Insulmart — platform penyedia insulasi terpercaya di bawah naungan PT Tali Rejeki. Hubungi kami untuk kebutuhan Anda.
      </p>
    </div>
  </section>

  <section class="kontak-section">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold text-merah">Tentang Kami & Hubungi Kami</h2>
        <p class="text-muted">Kenali lebih dekat Insulmart dan bagaimana kami dapat membantu kebutuhan insulasi Anda.</p>
      </div>

      <div class="row g-5 kontak-flex">

        {{-- ABOUT SECTION --}}
          <div class="col-md-6">
          <div class="kontak-box h-100">
              <h3 class="kontak-title mb-3">
              Tentang <span class="text-merah">Insulmart</span>
              </h3>

              <p class="kontak-desc mb-3">
              <strong>Insulmart</strong> adalah platform penyedia solusi insulasi terpercaya di Indonesia, yang menghadirkan berbagai pilihan material insulasi berkualitas tinggi seperti <strong>rockwool</strong>, dan produk insulasi lainnya.
              </p>

              <p class="kontak-desc mb-3">
              Kami melayani kebutuhan insulasi untuk berbagai sektor — mulai dari industri, gedung komersial, rumah tinggal, hingga proyek-proyek besar yang membutuhkan sistem peredaman panas, suara, dan getaran yang optimal.
              </p>

              <div class="bg-light p-3 rounded shadow-sm mt-4 border-start border-4 border-danger">
              <p class="mb-1 text-muted small">Didukung oleh:</p>
              <h5 class="m-0 fw-bold text-merah">PT Tali Rejeki</h5>
              <p class="mb-0 text-muted small">
                  Berdiri sejak <strong>2011</strong>, PT Tali Rejeki telah menjadi <strong>distributor resmi berbagai produk insulasi</strong> untuk proyek-proyek nasional di seluruh Indonesia.
              </p>
              </div>
          </div>
          </div>

        {{-- KONTAK SECTION --}}
        <div class="col-md-6">
          <div class="kontak-box h-100">
            <h3 class="kontak-title mb-4">Hubungi <span class="text-merah">Kami</span></h3>

            <div class="d-flex flex-column gap-3 mb-4">
              <div class="info-item">
                <div class="info-icon"><i class="bi bi-geo-alt-fill fs-5"></i></div>
                <div>
                  <div class="fw-semibold">Alamat</div>
                  <div class="text-muted small">
                    Jl. Raya Tarumajaya No. 11, RT 001 RW 029, Dusun III, Desa Setia Asih, Kec. Tarumajaya, Kab. Bekasi 17215
                  </div>
                </div>
              </div>

              <div class="info-item">
                <div class="info-icon"><i class="bi bi-telephone-fill fs-5"></i></div>
                <div>
                  <div class="fw-semibold">Telepon</div>
                  <div class="text-muted small">021-29470622 | 021-22889956</div>
                </div>
              </div>

              <div class="info-item">
                <div class="info-icon"><i class="bi bi-envelope-fill fs-5"></i></div>
                <div>
                  <div class="fw-semibold">Email</div>
                  <div class="text-muted small">talirejeki@gmail.com</div>
                </div>
              </div>
            </div>

            {{-- <form class="mt-2">
              <div class="mb-3">
                <input type="text" class="form-control" placeholder="Nama Anda" required>
              </div>
              <div class="mb-3">
                <input type="email" class="form-control" placeholder="Email Anda" required>
              </div>
              <div class="mb-3">
                <textarea class="form-control" rows="4" placeholder="Pesan Anda..." required></textarea>
              </div>
              <button type="submit" class="btn btn-merah w-100 fw-semibold">
                <i class="bi bi-send-fill me-2"></i> Kirim Pesan
              </button>
            </form> --}}
          </div>
        </div>

      </div>
    </div>
  </section>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  @include('components.back-to-top')
@endsection
