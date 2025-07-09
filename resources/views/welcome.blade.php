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
    {{-- <br>
    <br>
    <br> --}}

    <!-- Bagian Bawah Edit -->
    <!-- sama -->
    <div class="container">
    <!-- Kenapa Harus Tali Rejeki -->
        <section id="profile" class="snap-section fade-up">
            <h2 class="section-title">Kenapa Harus Belanja di Insulmart?</h2>
            <div class="keunggulan-wrapper">
                <div class="keunggulan-card fade-up">
                    <b>Spesialis Rockwool & Insulasi:</b> Insulmart fokus menyediakan berbagai jenis rockwool, glasswool, dan material peredam suara/insulasi terbaik untuk kebutuhan industri dan proyek konstruksi.
                </div>
                <div class="keunggulan-card fade-up">
                    <b>Belanja Mudah & Aman:</b> Proses pembelian online cepat, aman, dan praktis langsung melalui website. Bisa cek stok dan harga secara real-time.
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
                <strong class="text-danger">
                <p class="text-success mb-1 fw-bold">
                    Rp{{ number_format($min, 0, ',', '.') }}
                    @if ($min != $max)
                    ~ Rp{{ number_format($max, 0, ',', '.') }}
                    @endif
                </p>
                </strong>

                <p class="produk-deskripsi">{{ \Illuminate\Support\Str::limit($produk->deskripsi, 80) }}</p>
                </div>
            </div>
            @empty
            <p class="text-muted">Belum ada produk tersedia.</p>
            @endforelse
        </div>
        </section>

        <br>
        <br>
        <br>

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
        <section id="brand" class="snap-section">
            <h2 class="section-title" id="proyek">Proyek Kami</h2>
            <div class="galeri-list">
                <div class="galeri-item">
                    <img src="https://images.unsplash.com/photo-1615873968403-89e1e38c5693?auto=format&fit=crop&w=400&q=80" alt="Proyek Gedung">
                    <p>Pemasangan insulasi akustik pada proyek ballroom hotel di Jakarta.</p>
                </div>
                <div class="galeri-item">
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161c458f9?auto=format&fit=crop&w=400&q=80" alt="Proyek Industri">
                    <p>Instalasi peredam suara untuk ruang karaoke dan studio musik di Surabaya.</p>
                </div>
                <div class="galeri-item">
                    <img src="https://images.unsplash.com/photo-1598300056391-5acb9fc16e25?auto=format&fit=crop&w=400&q=80" alt="Proyek Mall">
                    <p>Distribusi bahan insulasi untuk proyek renovasi pusat perbelanjaan di Bandung.</p>
                </div>
            </div>
        </section>

        <!-- Our Brand -->
        <section id="brand" class="snap-section">
            <h2 class="section-title">Merek Terpercaya</h2>
            <div class="produk-list">
                <div class="produk-item brand-logo">
                <img src="assets/img/brands/rockwool.svg" alt="Rockwool">
                <h4>ROCKWOOL</h4>
                <p>Batu mineral untuk isolasi termal dan akustik kelas dunia.</p>
                </div>
                <div class="produk-item brand-logo">
                <img src="assets/img/brands/knauf.svg" alt="Knauf">
                <h4>KNAUF</h4>
                <p>Material insulasi premium untuk konstruksi modern dan tahan api.</p>
                </div>
                <div class="produk-item brand-logo">
                <img src="assets/img/brands/glasswool.svg" alt="Glasswool">
                <h4>GLASSWOOL</h4>
                <p>Solusi ringan dan ekonomis untuk peredaman suara dan panas.</p>
                </div>
            </div>
        </section>
    </div>

    <div id="live-chat-toggle" style="
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 9999;
        cursor: pointer;
        background-color: #8B0000;
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    ">
        <i class="bi bi-chat-dots-fill" style="font-size: 24px; color: white;"></i>
    </div>

    <div id="live-chat-widget" style="
        position: fixed;
        bottom: 43px;
        right: 25px;
        width: 320px;
        height: 480px; /* Sedikit diperbesar untuk mengakomodasi konten baru */
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 6px 24px rgba(0,0,0,0.2);
        overflow: hidden;
        display: none;
        flex-direction: column;
        z-index: 10000;
        transition: all 0.3s ease;
    ">
        <div style="background: #8B0000; color: white; padding: 16px; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
            <strong>Help</strong> <div>
                <button id="minimize-chat" style="background: none; border: none; color: white; font-size: 18px; margin-right: 8px; cursor: pointer;">−</button>
                <button id="close-chat" style="background: none; border: none; color: white; font-size: 18px; cursor: pointer;">×</button>
            </div>
        </div>

        <div id="widget-content" style="flex: 1; overflow-y: auto; display: flex; flex-direction: column;">
            
            <div id="initial-screen" style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
                <div style="position: relative; margin-bottom: 24px;">
                    <i class="bi bi-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #888;"></i>
                    <input type="text" placeholder="Cari panduan (cth: deposit)" style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
                </div>

                <strong>Top Suggestions</strong>
                <ul style="list-style: none; padding: 0; margin-top: 16px;">
                    <li style="margin-bottom: 12px;">❓ Apakah Rockwool tersedia dalam berbagai ukuran dan ketebalan?</li>
                    <li style="margin-bottom: 12px;">📦 Berapa lama pengiriman untuk wilayah luar pulau Jawa?</li>
                    <li style="margin-bottom: 12px;">💰 Apakah ada diskon untuk pembelian grosir?</li>
                    <li style="margin-bottom: 12px;">📋 Bagaimana cara cek stok barang sebelum membeli?</li>
                    <li style="margin-bottom: 12px;">🛒 Apakah bisa beli satuan atau hanya per dus?</li>
                    <li style="margin-bottom: 12px;">📍 Apakah bisa dikirim ke lokasi proyek saya?</li>
                    <li style="margin-bottom: 12px;">💳 Apa saja metode pembayaran yang tersedia?</li>
                    <li style="margin-bottom: 12px;">🎧 Rockwool tipe apa yang cocok untuk ruang studio?</li>
                    <li style="margin-bottom: 12px;">📞 Apakah bisa konsultasi sebelum membeli?</li>
                    <li style="margin-bottom: 12px;">🔄 Apakah bisa retur jika barang tidak sesuai?</li>
                    <li style="margin-bottom: 12px;">🧾 Apakah ada invoice resmi untuk keperluan proyek?</li>
                    <li style="margin-bottom: 12px;">🕒 Kapan layanan customer service tersedia?</li>
                </ul>

                <div style="margin-top: auto;"> <button id="start-chat-btn" style="width: 100%; background: #8B0000; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-size: 16px;">
                        Live chat
                    </button>
                </div>
            </div>

            <div id="chat-body" style="flex: 1; padding: 16px; background: #f7f7f7; overflow-y: auto; display: none;">
                <div style="background: #eeeeee; border-radius: 12px; padding: 10px 14px; max-width: 85%; margin-bottom: 12px;">
                    👋 Halo! Ada yang bisa kami bantu?
                </div>
            </div>
        </div>

        <div id="chat-footer" style="padding: 12px; background: white; border-top: 1px solid #ddd; display: none; gap: 8px; flex-shrink: 0;">
            <input type="text" id="chat-input" placeholder="Ketik pesan..." style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
            <button id="send-chat" style="background: #8B0000; color: white; border: none; border-radius: 8px; padding: 10px 14px; cursor: pointer;">
                Kirim
            </button>
        </div>
    </div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@endsection

