@extends('components.layout-bootstrap')

<head>
    <title>@yield('title', 'Galeri Proyek Kami Insulasi | Insulmart')</title>
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

    .proyek-section {
      padding: 4rem 0;
    }

    .proyek-item {
      margin-bottom: 4rem;
      transition: transform 0.4s ease-in-out, box-shadow 0.4s ease-in-out;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
      border-radius: 16px;
      background-color: #fff;
      padding: 2rem;
      opacity: 0;
      transform: translateY(40px);
      animation: fadeInUp 0.8s ease forwards;
    }

    .proyek-item:nth-child(1) { animation-delay: 0.1s; }
    .proyek-item:nth-child(2) { animation-delay: 0.2s; }
    .proyek-item:nth-child(3) { animation-delay: 0.3s; }
    .proyek-item:nth-child(4) { animation-delay: 0.4s; }
    .proyek-item:nth-child(5) { animation-delay: 0.5s; }
    .proyek-item:nth-child(6) { animation-delay: 0.6s; }
    .proyek-item:nth-child(7) { animation-delay: 0.7s; }
    .proyek-item:nth-child(8) { animation-delay: 0.8s; }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .carousel {
      border-radius: 16px;
      overflow: hidden;
    }

    .carousel-inner {
      width: 100%;
      height: 100%;
    }

    .carousel-inner img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      background-color: #f8f8f8;
      padding: 1rem;
      border-radius: 12px;
      transition: transform 0.3s ease-in-out;
    }

    .carousel-item:hover img {
      transform: scale(1.02);
    }

    .carousel-indicators [data-bs-target] {
      background-color: var(--color-merah-tua);
      width: 10px;
      height: 10px;
      border-radius: 50%;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      background-color: transparent;
      width: 4rem;
      height: 4rem;
      background-size: 80% 80%;
      background-repeat: no-repeat;
      background-position: center;
    }

    .carousel-control-prev-icon {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%238B0000' viewBox='0 0 16 16'%3E%3Cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L6.707 7l4.647 4.646a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708 0z'/%3E%3C/svg%3E");
    }

    .carousel-control-next-icon {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%238B0000' viewBox='0 0 16 16'%3E%3Cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l5 5a.5.5 0 0 1 0 .708l-5 5a.5.5 0 0 1-.708-.708L9.293 7 4.646 2.354a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
    }

    .proyek-title {
      font-size: 1.8rem;
      font-weight: bold;
      color: var(--color-merah-tua);
    }

    .proyek-desc {
      font-size: 1rem;
      line-height: 1.7;
      color: #444;
      margin-top: 1rem;
    }

    @media (max-width: 768px) {
      .proyek-flex {
        flex-direction: column !important;
      }

      .proyek-title {
        font-size: 1.5rem;
        margin-top: 1.25rem;
      }

      .carousel-inner img {
        height: auto;
        object-fit: contain;
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
      <h2 class="fw-bold mb-1">Galeri Proyek Kami</h2>
      <p class="text-white-50 small mb-0">Dokumentasi proyek-proyek yang telah kami kerjakan</p>
    </div>
  </section>

  {{-- Galeri --}}
  <section class="proyek-section bg-light">
    <div class="container">
      <div class="text-center mb-5 fade-up">
        <h2 class="fw-bold text-merah">Dokumentasi Proyek</h2>
        <p class="text-muted">Beberapa proyek terbaik yang telah menggunakan layanan & produk kami.</p>
      </div>

      @php
        $galeriProyek = [
          [
            'title' => 'Proyek Bambulogy Mansion',
            'desc' => 'PROYEK BAMBULOGY MENSION (Jakasampurna - Bekasi) — Supply kebutuhan: Material insulasi dinding meliputi rockwool density 40 dan juga plafon.',
            'images' => ['galeri/done1 (1).png', 'galeri/done1 (2).png']
          ],
          [
            'title' => 'PT Dohsung Indonesia',
            'desc' => 'PROYEK PT DONGSUH INDONESIA (Serang - Banten) — Supply kebutuhan: Material insulasi boiler meliputi rockwool pipa cover tombo, rockwool wired blanket, dan plat aluminium jacketing.',
            'images' => ['galeri/done2 (1).png', 'galeri/done2 (2).png']
          ],
          [
            'title' => 'PT Nikomas Gemilang',
            'desc' => 'PROYEK PT NIKOMAS GEMILANG (Serang) — Supply kebutuhan: Material insulasi atap meliputi aluminium bubble foil dan roofmesh 3315.',
            'images' => ['galeri/done3 (1).png', 'galeri/done3 (2).png']
          ],
          [
            'title' => 'PT Data Centre',
            'desc' => 'PROYEK PT DATA CENTRE (Cikarang) — Supply kebutuhan: Material insulasi ruang genset meliputi rockwool tombo, kawat loket, dan juga spindle pin.',
            'images' => ['galeri/done4 (1).png', 'galeri/done4 (2).png']
          ],
          [
            'title' => 'Proyek Ainul Hayat Sejahtera',
            'desc' => 'PROYEK AINUL HAYAT SEJAHTERA — Supply kebutuhan: Material insulasi boiler meliputi rockwool pipa cover tombo, rockwool wired blanket, dan plat aluminium jacketing.',
            'images' => ['galeri/done5 (1).png', 'galeri/done5 (2).png']
          ],
          [
            'title' => 'Proyek Bandara Dhoho',
            'desc' => 'PROYEK BANDARA DHOHO — Supply kebutuhan: Aluminium coil.',
            'images' => ['galeri/done7 (1).png', 'galeri/done7 (2).png']
          ],
          [
            'title' => 'Proyek Peredam Genset',
            'desc' => 'PROJECT PEREDAM GENSET — Instalasi sistem peredaman suara untuk mesin genset pada area komersial dan pabrik.',
            'images' => ['galeri/done6 (1).png', 'galeri/done6 (2).png']
          ],
          [
            'title' => 'Wika Palu PLTU',
            'desc' => 'PROYEK WIKA PALU PLTU — Pemasangan insulasi termal di proyek Pembangkit Listrik Tenaga Uap (PLTU) Palu oleh WIKA.',
            'images' => ['galeri/done7 (3).png', 'galeri/done7 (4).png']
          ],
        ];
      @endphp

      @foreach ($galeriProyek as $index => $proyek)
        <div class="proyek-item row proyek-flex {{ $index % 2 == 1 ? 'flex-row-reverse' : '' }} align-items-center">
          <div class="col-md-6 mb-3 mb-md-0 fade-up">
          <div id="carouselProyek{{ $index }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
              <div class="carousel-inner">
                @foreach ($proyek['images'] as $imgIndex => $img)
                  <div class="carousel-item {{ $imgIndex === 0 ? 'active' : '' }}">
                    <img src="{{ asset('assets/img/' . $img) }}" alt="{{ $proyek['title'] }} {{ $imgIndex + 1 }}">
                  </div>
                @endforeach
              </div>
              @if (count($proyek['images']) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselProyek{{ $index }}" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselProyek{{ $index }}" data-bs-slide="next">
                  <span class="carousel-control-next-icon"></span>
                </button>
                <div class="carousel-indicators mt-2">
                  @foreach ($proyek['images'] as $imgIndex => $img)
                    <button type="button" data-bs-target="#carouselProyek{{ $index }}" data-bs-slide-to="{{ $imgIndex }}" class="{{ $imgIndex === 0 ? 'active' : '' }}" aria-label="Slide {{ $imgIndex + 1 }}"></button>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-6 fade-up">
            <h4 class="proyek-title">{{ $proyek['title'] }}</h4>
            <p class="proyek-desc">{{ $proyek['desc'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
