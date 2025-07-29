@extends('components.layout')

@section('content')

    <br><br><br>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <header id="beranda" class="snap-section">
            <div class="slider-container">
                <div class="slider-slide slider-active" style="background-image: url('{{ asset('assets/img/landing/7.png') }}');"></div>
                <div class="slider-slide" style="background-image: url('{{ asset('assets/img/landing/8.png') }}');"></div>
                <div class="slider-slide" style="background-image: url('{{ asset('assets/img/landing/9.png') }}');"></div>
            </div>

            <div class="slider-content text-center">
                <div class="slider-inner">
                    <p class="welcome-text">Selamat Datang di INSULMART</p>
                    <h1 id="slider-title">TALI REJEKI</h1>
                    <p id="slider-desc">
                        BERDIRI SEJAK 2011. PT. TALI REJEKI DIPERCAYA SEBAGAI DISTRIBUTOR & AGEN UNTUK BERBAGAI PROJECT BESAR PEREDAM SUARA UNTUK RUANG KARAOKE, BALLROOM, DAN AKUSTIK DI SELURUH INDONESIA.
                    </p>
                    <a href="{{ url('/produk') }}" class="cta-btn" style="color: white;">Lihat Produk Kami</a>
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
                <h2 class="section-title">Proyek Kami</h2>

                <div class="slider-wrapper">
                    <div class="slider-track" id="sliderTrack">
                    <!-- JS will render items here -->
                    </div>
                </div>

                <div class="proyek-indikator" id="proyekDots"></div>
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
            @include('components.back-to-top')
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

    <script>
        const data = [
        ['done7 (3).png', 'Wika Palu PLTU'],
        ['done3 (1).png', 'Nikomas Gemilang'],
        ['done2 (1).png', 'PT Dohsung Indonesia'],
        ['done4 (1).png', 'PT DATA CENTRE'],
        ['done1 (1).png', 'PROYEK BAMBULOGY MENSION'],
        ['done6 (1).png', 'PROYEK PEREDAM GENSET'],
        ['done5 (1).png', 'PROYEK AINUL HAYAT SEJAHTERA'],
        ['done7 (1).png', 'PROYEK BANDARA DHOHO'],
        ];

        const track = document.getElementById('sliderTrack');
        const dotsContainer = document.getElementById('proyekDots');
        let currentIndex = 2;
        let startX = 0;
        let isDragging = false;

        function createItem([src, caption], isClone = false) {
        const item = document.createElement('div');
        item.className = 'slider-item';
        if (isClone) item.dataset.clone = true;

        const img = document.createElement('img');
        img.src = `assets/img/galeri/${src}`;
        img.alt = caption;

        const cap = document.createElement('div');
        cap.className = 'slider-caption';
        cap.innerHTML = `<p>${caption}</p>`;

        item.appendChild(img);
        item.appendChild(cap);
        return item;
        }

        function render() {
        const clonesBefore = data.slice(-2);
        const clonesAfter = data.slice(0, 2);

        [...clonesBefore, ...data, ...clonesAfter].forEach((item, i) => {
            const el = createItem(item, i < 2 || i >= data.length + 2);
            track.appendChild(el);
        });

        data.forEach((_, i) => {
            const dot = document.createElement('span');
            dot.addEventListener('click', () => goTo(i));
            dotsContainer.appendChild(dot);
        });
        }

        function goTo(index) {
        currentIndex = index + 2; // plus 2 karena ada clone sebelum
        update();
        }

        function update() {
        const items = document.querySelectorAll('.slider-item');
        const wrapper = document.querySelector('.slider-wrapper');
        if (!items.length) return;

        const activeItem = items[currentIndex];
        const wrapperRect = wrapper.getBoundingClientRect();
        const activeRect = activeItem.getBoundingClientRect();
        const offset = activeRect.left - wrapperRect.left;
        const diffToCenter = offset - (wrapperRect.width / 2 - activeRect.width / 2);

        const currentTransform = parseFloat(getComputedStyle(track).transform.split(',')[4]) || 0;
        const translate = currentTransform - diffToCenter;

        track.style.transform = `translateX(${translate}px)`;

        items.forEach(item => item.classList.remove('active'));
        if (items[currentIndex]) items[currentIndex].classList.add('active');

        const realIndex = (currentIndex - 2 + data.length) % data.length;
        dotsContainer.querySelectorAll('span').forEach((dot, i) => {
            dot.classList.toggle('active', i === realIndex);
        });
        }

        function loopFix() {
        if (currentIndex >= data.length + 2) {
            currentIndex = 2;
            track.style.transition = 'none';
            update();
            requestAnimationFrame(() => {
            track.style.transition = 'transform 0.5s ease';
            });
        } else if (currentIndex < 2) {
            currentIndex = data.length + (currentIndex - 2);
            track.style.transition = 'none';
            update();
            requestAnimationFrame(() => {
            track.style.transition = 'transform 0.5s ease';
            });
        }
        }

        function next() {
        currentIndex++;
        update();
        setTimeout(loopFix, 600);
        }

        function prev() {
        currentIndex--;
        update();
        setTimeout(loopFix, 600);
        }

        // Swipe
        track.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.clientX;
        });
        track.addEventListener('mouseup', (e) => {
        if (!isDragging) return;
        const diff = e.clientX - startX;
        if (diff > 50) prev();
        else if (diff < -50) next();
        isDragging = false;
        });
        track.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        });
        track.addEventListener('touchend', (e) => {
        const diff = e.changedTouches[0].clientX - startX;
        if (diff > 50) prev();
        else if (diff < -50) next();
        });

        // Init
        render();
        window.addEventListener('load', () => {
        update();
        window.addEventListener('resize', update);
        // Auto Slide setiap 3 detik
            let autoSlide = setInterval(() => {
            next();
            }, 3000);

            // Opsional: Hentikan saat user swipe/interaksi manual (biar ga bentrok)
            track.addEventListener('mousedown', pauseAutoSlide);
            track.addEventListener('mouseup', resumeAutoSlide);
            track.addEventListener('touchstart', pauseAutoSlide);
            track.addEventListener('touchend', resumeAutoSlide);

            function pauseAutoSlide() {
            clearInterval(autoSlide);
            }

            function resumeAutoSlide() {
            clearInterval(autoSlide);
            autoSlide = setInterval(() => {
                next();
            }, 3000);
            }

        });
    </script>





@endsection
