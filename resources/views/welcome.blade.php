@extends('components.layout')

@section('content')
<br>
<br>
<br>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <header id="beranda" class="snap-section">
        <div class="slider-container">
            <div class="slider-slide slider-active" style="background-image: url('{{ asset('assets/img/landing_page (4)1.png') }}');"></div>
            <div class="slider-slide" style="background-image: url('{{ asset('assets/img/landing (7)1.png') }}');"></div>
            <div class="slider-slide" style="background-image: url('{{ asset('assets/img/landing (2)1.png') }}');"></div>
        </div>

        <div class="slider-content text-center">
            <div class="slider-inner">
                <p class="welcome-text">Selamat Datang di INSULMART</p>
                <h1 id="slider-title">TALI REJEKI</h1>
                <p id="slider-desc">
                    BERDIRI SEJAK 2011. PT. TALI REJEKI DIPERCAYA SEBAGAI DISTRIBUTOR & AGEN UNTUK BERBAGAI PROJECT BESAR PEREDAM SUARA UNTUK RUANG KARAOKE, BALLROOM, DAN AKUSTIK DI SELURUH INDONESIA.
                </p>
                <a href="produk.html" class="cta-btn" style="color: white;">Lihat Produk Kami</a>
            </div>
        </div>

    </header>

    <!-- Bagian Bawah Edit -->
    <!-- sama -->
    <div class="container">
    <!-- Kenapa Harus Tali Rejeki -->
        <section id="profile" class="snap-section fade-up">
            <h2 class="section-title">Kenapa Harus Belanja di Insulmart?</h2>
            <div class="keunggulan-wrapper">
                <div class="keunggulan-card fade-up">
                    <b>Spesialis Rockwool & Insulasi:</b> Insulmart fokus menyediakan berbagai jenis rockwool, dan material peredam suara/insulasi terbaik untuk kebutuhan industri dan proyek konstruksi.
                </div>
                <div class="keunggulan-card fade-up">
                    <b>Belanja Mudah & Aman:</b> Proses pembelian cepat, aman, dan praktis. Bisa cek stok dan harga secara real-time.
                </div>
                <div class="keunggulan-card fade-up">
                    <b>Harga Grosir & Diskon Proyek:</b> Dapatkan harga lebih hemat untuk pembelian dalam jumlah besar, cocok untuk kebutuhan proyek dan tender.
                </div>
                <div class="keunggulan-card fade-up">
                    <b>Pengiriman Seluruh Indonesia:</b> Layanan ekspedisi ke seluruh wilayah Indonesia dengan dukungan pengemasan aman dan estimasi pengiriman cepat.
                </div>
                <div class="keunggulan-card fade-up">
                    <b>Produk Dijamin Asli:</b> Semua produk dijamin 100% original, berkualitas tinggi, dan sesuai spesifikasi pabrikan.
                </div>
                <div class="keunggulan-card fade-up">
                    <b>Layanan Konsultasi:</b> Tim Insulmart siap membantu memberikan rekomendasi produk dan solusi insulasi yang sesuai kebutuhan proyek Anda.
                </div>
            </div>
        </section>

        <!-- Produk Unggulan -->
        <section id="produk" class="fade-up bg-light py-5">
            <h2 class="section-title">Produk Unggulan</h2>

            <div class="produk-scroll-wrapper">
                @forelse ($produks as $produk)
                <a href="{{ route('produk.detail', $produk->slugified_nama) }}" class="produk-link">
                    <div class="produk-card">
                        {{-- Carousel Gambar Produk --}}
                        @if ($produk->gambars->count() > 0)
                        <div id="carouselProduk{{ $produk->id }}" class="carousel slide produk-img-wrapper" data-bs-ride="carousel" data-bs-interval="3000">
                            <div class="carousel-inner">
                                @foreach ($produk->gambars as $index => $gambar)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $gambar->path) }}" class="d-block w-100 produk-img" alt="Gambar {{ $index + 1 }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="produk-img-wrapper">
                            <img src="{{ asset('assets/img/no-image.png') }}" class="produk-img d-block w-100" alt="{{ $produk->nama_produk }}">
                        </div>
                        @endif

                        <div class="produk-body">
                            <h5 class="produk-nama">{{ $produk->nama_produk }}</h5>
                            <p class="text-muted small mb-1">
                                <i class="bi bi-tag-fill me-1 text-danger"></i>{{ ucfirst($produk->jenis_produk) }}
                            </p>

                            @php
                                $min = $produk->varians->min('harga');
                                $max = $produk->varians->max('harga');
                            @endphp
                            <p class="text-success mb-1 fw-bold">
                                Rp{{ number_format($min, 0, ',', '.') }}
                                @if ($min != $max)
                                ~ Rp{{ number_format($max, 0, ',', '.') }}
                                @endif
                            </p>

                            <p class="produk-deskripsi">{!! \Illuminate\Support\Str::limit($produk->deskripsi, 80) !!}</p>
                        </div>
                    </div>
                </a>
                @empty
                <p class="text-muted">Belum ada produk tersedia.</p>
                @endforelse
            </div>
        </section>

        <!-- Testimoni -->
        <section id="testimoni" class="snap-section fade-up">
            <h2 class="section-title">Apa Kata Mereka?</h2>
            <div class="testimoni-wrapper">

                <div class="testimoni-card fade-up">
                <div class="testimoni-header">
                    <img src="https://i.pravatar.cc/80?img=12" alt="Foto Dedi">
                    <div>
                    <h5>Dedi Pratama</h5>
                    <span class="bintang">★★★★★</span>
                    <p class="kota">Jakarta - Pemilik Studio</p>
                    </div>
                </div>
                <p>"Barang cepat sampai dan kualitas rockwool-nya mantap! Studio jadi lebih kedap suara. Recommended!"</p>
                </div>

                <div class="testimoni-card fade-up">
                <div class="testimoni-header">
                    <img src="https://i.pravatar.cc/80?img=16" alt="Foto Lusi">
                    <div>
                    <h5>Lusi Andriani</h5>
                    <span class="bintang">★★★★☆</span>
                    <p class="kota">Surabaya - Kontraktor Hotel</p>
                    </div>
                </div>
                <p>"Layanan cepat dan komunikatif. Order dalam jumlah besar untuk ballroom hotel selesai tepat waktu."</p>
                </div>

                <div class="testimoni-card fade-up">
                <div class="testimoni-header">
                    <img src="https://i.pravatar.cc/80?img=25" alt="Foto Arif">
                    <div>
                    <h5>Arif Maulana</h5>
                    <span class="bintang">★★★★★</span>
                    <p class="kota">Bandung - Developer Rumah</p>
                    </div>
                </div>
                <p>"Website-nya mudah dipakai dan langsung dapat invoice. Cocok buat yang sering belanja material insulasi."</p>
                </div>

                <div class="testimoni-card fade-up">
                <div class="testimoni-header">
                    <img src="https://i.pravatar.cc/80?img=35" alt="Foto Yuli">
                    <div>
                    <h5>Yuli Hartini</h5>
                    <span class="bintang">★★★★☆</span>
                    <p class="kota">Yogyakarta - Arsitek Interior</p>
                    </div>
                </div>
                <p>"Produk original dan pengemasan rapi. Klien saya puas karena suara ruangannya lebih terkontrol."</p>
                </div>

                <div class="testimoni-card fade-up">
                <div class="testimoni-header">
                    <img src="https://i.pravatar.cc/80?img=7" alt="Foto Fajar">
                    <div>
                    <h5>Fajar Nugroho</h5>
                    <span class="bintang">★★★★★</span>
                    <p class="kota">Tangerang - Pelanggan Tetap</p>
                    </div>
                </div>
                <p>"Udah 3x order di Insulmart, semuanya lancar. Barang cepat sampai dan harga paling oke."</p>
                </div>

                <div class="testimoni-card fade-up">
                <div class="testimoni-header">
                    <img src="https://i.pravatar.cc/80?img=22" alt="Foto Melati">
                    <div>
                    <h5>Melati Saraswati</h5>
                    <span class="bintang">★★★★★</span>
                    <p class="kota">Semarang - Pengusaha Event</p>
                    </div>
                </div>
                <p>"Kebutuhan insulasi buat event hall selalu saya percayakan ke Insulmart. Servisnya cepat, barangnya top!"</p>
                </div>

            </div>
        </section>

        <!-- Proyek Kami -->
        <section id="brand" class="snap-section proyek-section-unik fade-up">
            <h2 class="section-title" id="proyek">Proyek Kami</h2>

            <div class="proyek-slider-container">
                <div class="proyek-slider-track">
                <div class="proyek-slide active">
                    <img src="{{ asset('assets/img/wikapalu.jpg') }}" alt="Proyek 1">
                    <div class="proyek-caption"><p>Wika Palu PLTU</p></div>
                </div>
                <div class="proyek-slide">
                    <img src="{{ asset('assets/img/nikomas.jpg') }}" alt="Proyek 2">
                    <div class="proyek-caption"><p>Nikomas Gemilang</p></div>
                </div>
                <div class="proyek-slide">
                    <img src="{{ asset('assets/img/dohsung.jpg') }}" alt="Proyek 3">
                    <div class="proyek-caption"><p>PT Dohsung Indonesia</p></div>
                </div>
                <div class="proyek-slide">
                    <img src="{{ asset('assets/img/13.png') }}" alt="Proyek 4">
                    <div class="proyek-caption"><p>PT DATA CENTRE</p></div>
                </div>
                <div class="proyek-slide">
                    <img src="{{ asset('assets/img/11.png') }}" alt="Proyek 5">
                    <div class="proyek-caption"><p>PROYEK BAMBULOGY MENSION</p></div>
                </div>
                <div class="proyek-slide">
                    <img src="{{ asset('assets/img/6.png') }}" alt="Proyek 6">
                    <div class="proyek-caption"><p>PROYEK PEREDAM GENSET</p></div>
                </div>
                <div class="proyek-slide">
                    <img src="{{ asset('assets/img/3.png') }}" alt="Proyek 7">
                    <div class="proyek-caption"><p>PROYEK AINUL HAYAT SEJAHTERA</p></div>
                </div>
                <div class="proyek-slide">
                    <img src="{{ asset('assets/img/b.jpg') }}" alt="Proyek 8">
                    <div class="proyek-caption"><p>PROYEK BANDARA DHOHO</p></div>
                </div>

                <!-- Tombol Navigasi -->
                <button class="proyek-nav proyek-prev" onclick="moveProyekSlide(-1)">&#10094;</button>
                <button class="proyek-nav proyek-next" onclick="moveProyekSlide(1)">&#10095;</button>
                </div> <!-- penutup .proyek-slider-track -->
            </div> <!-- penutup .proyek-slider-container -->

            <!-- DOTS harus DI SINI -->
            <div class="proyek-dots">
                <span class="proyek-dot active" onclick="goToProyekSlide(0)"></span>
                <span class="proyek-dot" onclick="goToProyekSlide(1)"></span>
                <span class="proyek-dot" onclick="goToProyekSlide(2)"></span>
                <span class="proyek-dot" onclick="goToProyekSlide(3)"></span>
                <span class="proyek-dot" onclick="goToProyekSlide(4)"></span>
                <span class="proyek-dot" onclick="goToProyekSlide(5)"></span>
                <span class="proyek-dot" onclick="goToProyekSlide(6)"></span>
                <span class="proyek-dot" onclick="goToProyekSlide(7)"></span>
            </div>
        </section>

        <!-- Our Brand -->
        <section id="brand" class="snap-section brand-slider-section fade-up">
        <h2 class="section-title">Our Brand</h2>
        <div class="brand-slider-wrapper">
            <div class="brand-slider-track">
            <!-- ulang 8 logo -->
            <div class="brand-logo"><img src="assets/img/Nichias_Tombo.jpg" alt="Nichias Tombo"></div>
            <div class="brand-logo"><img src="assets/img/Ecowool.jpg" alt="Ecowool"></div>
            <div class="brand-logo"><img src="assets/img/Tilement_Spindlepin.jpg" alt="Tilement Spindlepin"></div>
            <div class="brand-logo"><img src="assets/img/Firerock.jpg" alt="Firerock"></div>
            <div class="brand-logo"><img src="assets/img/Rockwool.jpg" alt="Rockwool"></div>
            <div class="brand-logo"><img src="assets/img/Polyfoil_Aluminium.jpg" alt="Polyfoil Aluminium"></div>
            <div class="brand-logo"><img src="assets/img/ABR_Mineral_Wool.jpg" alt="ABR Mineral Wool"></div>
            <div class="brand-logo"><img src="assets/img/Belver_Spindle_Pin.jpg" alt="Belver Spindle Pin"></div>

            <!-- duplikasi untuk loop mulus -->
            <div class="brand-logo"><img src="assets/img/Nichias_Tombo.jpg" alt="Nichias Tombo"></div>
            <div class="brand-logo"><img src="assets/img/Ecowool.jpg" alt="Ecowool"></div>
            <div class="brand-logo"><img src="assets/img/Tilement_Spindlepin.jpg" alt="Tilement Spindlepin"></div>
            <div class="brand-logo"><img src="assets/img/Firerock.jpg" alt="Firerock"></div>
            <div class="brand-logo"><img src="assets/img/Rockwool.jpg" alt="Rockwool"></div>
            <div class="brand-logo"><img src="assets/img/Polyfoil_Aluminium.jpg" alt="Polyfoil Aluminium"></div>
            <div class="brand-logo"><img src="assets/img/ABR_Mineral_Wool.jpg" alt="ABR Mineral Wool"></div>
            <div class="brand-logo"><img src="assets/img/Belver_Spindle_Pin.jpg" alt="Belver Spindle Pin"></div>
            </div>
        </div>
        </section>

    @include('live-chat')
    </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
<style>
.produk-link {
  text-decoration: none !important;
  color: inherit; /* Ikuti warna default anaknya */
  display: block;
}

.produk-link:hover {
  text-decoration: none !important;
  color: inherit;
}
</style>

<script>
  let proyekCurrentIndex = 0;
  const proyekSlides = document.querySelectorAll('.proyek-slide');
  const proyekDots = document.querySelectorAll('.proyek-dot');
  let proyekInterval;

  function showProyekSlide(index) {
    proyekSlides.forEach((slide, i) => {
      slide.classList.remove('active');
      proyekDots[i].classList.remove('active');
    });

    proyekSlides[index].classList.add('active');
    proyekDots[index].classList.add('active');
    proyekCurrentIndex = index;
  }

  function moveProyekSlide(step) {
    const nextIndex = (proyekCurrentIndex + step + proyekSlides.length) % proyekSlides.length;
    showProyekSlide(nextIndex);
    resetProyekAutoSlide();
  }

  function goToProyekSlide(index) {
    if (index !== proyekCurrentIndex) {
      showProyekSlide(index);
      resetProyekAutoSlide();
    }
  }

  function startProyekAutoSlide() {
    proyekInterval = setInterval(() => {
      moveProyekSlide(1);
    }, 5000);
  }

  function resetProyekAutoSlide() {
    clearInterval(proyekInterval);
    startProyekAutoSlide();
  }

  document.addEventListener('DOMContentLoaded', () => {
    showProyekSlide(proyekCurrentIndex);
    startProyekAutoSlide();
  });
</script>
@endsection

