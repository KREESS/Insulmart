@extends('components.layout-bootstrap')

<head>
    <title>@yield('title', $produk->nama_produk.' Insulasi | Insulmart')</title>
    <!-- Tag lain seperti meta, link CSS, dll -->
</head>

@section('content')
    <br><br><br>

    <div class="container py-5">
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
        <div class="row justify-content-center">
            <div class="col-lg-10 bg-white p-4 rounded shadow-sm">
                {{-- Tombol Kembali --}}
                <div class="mb-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-merah">
                        <i class="bi bi-arrow-left me-2"></i> Kembali
                    </a>
                </div>
                <div class="row">
                    {{-- Gambar Produk --}}
                    <div class="col-md-6 mb-4 mb-md-0">
                    @php
                        $habis = ($produk->varians->sum('stok') <= 0);
                    @endphp

                    <div class="produk-media position-relative rounded overflow-hidden">
                        @if ($habis)
                        {{-- Badge di atas gambar --}}
                        <span class="stock-badge shadow-sm">
                            <i class="bi bi-exclamation-triangle me-1"></i> Stok Habis
                        </span>
                        {{-- Overlay halus agar badge lebih kebaca --}}
                        <span class="stock-mask"></span>
                        @endif

                        @if ($produk->gambars->count() > 0)
                        <div id="carouselDetailProduk" class="carousel slide" data-bs-ride="carousel">
                            {{-- Indicators --}}
                            <div class="carousel-indicators">
                            @foreach ($produk->gambars as $index => $gambar)
                                <button type="button" data-bs-target="#carouselDetailProduk"
                                        data-bs-slide-to="{{ $index }}"
                                        class="{{ $index == 0 ? 'active' : '' }}"
                                        aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                        aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                            </div>

                            {{-- Slides --}}
                            <div class="carousel-inner carousel-fixed-height rounded">
                            @foreach ($produk->gambars as $index => $gambar)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="d-flex align-items-center justify-content-center w-100 h-100">
                                    <img src="{{ asset('storage/' . $gambar->path) }}"
                                        class="img-fluid"
                                        style="max-height: 100%; max-width: 100%; object-fit: contain; cursor: zoom-in;"
                                        alt="Gambar Produk {{ $index + 1 }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalGambar{{ $index }}">
                                </div>

                                {{-- Modal Zoom --}}
                                <div class="modal fade" id="modalGambar{{ $index }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content bg-transparent border-0">
                                        <div class="modal-body p-0 position-relative">
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        <img src="{{ asset ('storage/' . $gambar->path) }}"
                                            class="img-fluid rounded mx-auto d-block"
                                            style="max-height: 90vh; object-fit: contain;">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            @endforeach
                            </div>

                            {{-- Controls --}}
                            <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#carouselDetailProduk" data-bs-slide="prev">
                            <span class="custom-carousel-icon">&#10094;</span>
                            <span class="visually-hidden">Sebelumnya</span>
                            </button>
                            <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#carouselDetailProduk" data-bs-slide="next">
                            <span class="custom-carousel-icon">&#10095;</span>
                            <span class="visually-hidden">Berikutnya</span>
                            </button>
                        </div>
                        @else
                        <img src="{{ asset('assets/img/no-img-ava.jpg') }}"
                            class="img-fluid rounded"
                            style="max-width: 100%; object-fit: contain; background-color: #f8f9fa;"
                            alt="No image available">
                        @endif
                    </div>
                    </div>

                    {{-- Detail Produk --}}
                    <div class="col-md-6">
                        <h2 class="fw-bold mb-3">{{ $produk->nama_produk }}</h2>
                        <p class="text-muted mb-2">
                        <i class="bi bi-tag-fill me-1 text-danger"></i> {{ ucfirst($produk->jenis_produk) }}
                        </p>

                        @php
                        $min = $produk->varians->min('harga');
                        $max = $produk->varians->max('harga');
                        $totalStok = $produk->varians->sum('stok');
                        $habis = $totalStok <= 0;
                        @endphp

                        <h4 class="text-black fw-bold mb-3">
                        Rp{{ number_format($min, 0, ',', '.') }}
                        @if ($min != $max)
                            <span class="text-black">~ Rp{{ number_format($max, 0, ',', '.') }}</span>
                        @endif
                        </h4>

                        <div class="mb-2 d-flex align-items-center gap-2">
                        <span>
                            <i class="bi bi-box-seam me-1 text-danger"></i>
                            <span class="fw-semibold">Stok Tersedia:</span>
                            <span class="text-dark">{{ $totalStok }}</span>
                        </span>
                        @if($habis)
                            {{-- ← badge stok habis --}}
                            <span class="badge bg-danger">Stok Habis</span>
                        @endif
                        </div>

                        <div class="deskripsi-produk mb-4 p-3 rounded">
                        <h5 class="fw-semibold mb-2 text-dark">
                            <i class="bi bi-info-circle me-2 text-danger"></i> Deskripsi Produk
                        </h5>

                        {{-- Wrapper untuk animasi slide --}}
                        <div id="deskripsiWrapper" class="deskripsi-wrapper collapsed">
                            <div id="deskripsiFull" class="text-secondary">
                            {!! $produk->deskripsi !!}
                            </div>
                        </div>

                        <button id="toggleDeskripsiBtn" class="btn btn-sm btn-outline-merah mt-3">
                            Lebih Lengkap <i class="bi bi-chevron-down"></i>
                        </button>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-grid gap-2 d-md-flex">
                        @if ($habis)
                            {{-- tombol disabled + tidak membuka modal --}}
                            <button class="btn btn-outline-secondary px-4 py-2" type="button" disabled aria-disabled="true" title="Stok habis">
                            <i class="bi bi-bag-x me-1"></i> Stok Habis
                            </button>
                        @else
                            {{-- tombol normal membuka modal varian --}}
                            <button class="btn btn-outline-merah px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalVarian" name="beli_sekarang" value="1">
                            <i class="bi bi-bag-check me-1"></i> Beli Sekarang
                            </button>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pilih Varian Produk -->
    <div class="modal fade" id="modalVarian" tabindex="-1" aria-labelledby="modalVarianLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded shadow">
                <div class="modal-header bg-merah text-white">
                    <h5 class="modal-title" id="modalVarianLabel"><i class="bi bi-bag-plus me-2"></i> Pilih Varian Produk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($produk->varians->count() > 0)
                    <form id="formTambahKeranjang" method="POST" action="{{ route('keranjang.tambah') }}">
                        @csrf
                        <input type="hidden" name="varian_id" id="selectedVarian">
                        <input type="hidden" name="jumlah" id="jumlahProdukHidden" value="1">
                        <input type="hidden" name="beli_sekarang" id="beliSekarangHidden" value="0">

                        <div class="row g-3">
                            @foreach ($produk->varians as $varian)
                            @php
                                $isOut = $varian->stok <= 0;
                            @endphp
                            <div class="col-md-6">
                                <label class="border rounded p-3 w-100 h-100 d-flex gap-3 align-items-center varian-card position-relative {{ $isOut ? 'bg-light' : '' }}"
                                    style="{{ $isOut ? 'opacity:0.65; cursor:not-allowed;' : '' }}">
                                    <img src="{{ $produk->gambars->first() ? asset('storage/' . $produk->gambars->first()->path) : asset('assets/img/no-image.png') }}"
                                        class="rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="Varian">

                                    <div class="flex-grow-1">
                                        <div class="fw-semibold text-dark">{{ $varian->tipe }}</div>
                                        <div class="text-muted small">
                                            Ukuran: {{ $varian->ukuran }}<br>
                                            Ketebalan: {{ $varian->ketebalan }} mm<br>
                                            Densitas: {{ $varian->densitas }} kg/m³<br>
                                            Ketersediaan: {{ $varian->status_ketersediaan }}<br>
                                            Stok:
                                            <span class="{{ $isOut ? 'text-danger' : 'text-success' }}">
                                                {{ $varian->stok }} Ball
                                            </span><br>
                                            <strong class="text-dark">Rp{{ number_format($varian->harga, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>

                                    <input type="radio"
                                        name="varian_id_radio"
                                        value="{{ $varian->id }}"
                                        class="form-check-input position-absolute top-0 end-0 m-2"
                                        data-stok="{{ $varian->stok }}"
                                        {{ $isOut ? 'disabled' : '' }}>

                                    @if($isOut)
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">Stok Habis</span>
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <label for="jumlahProduk" class="form-label fw-semibold">Jumlah</label>
                            <input type="number" id="jumlahProduk" class="form-control" min="1" value="1" style="max-width: 120px;" />
                        </div>

                        <div class="modal-footer justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-merah px-4 py-2" onclick="submitCart(0)">
                                <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                            </button>
                            <button type="button" class="btn btn-outline-merah px-4 py-2" onclick="submitCart(1)">
                                <i class="bi bi-bag-check me-1"></i> Beli Sekarang
                            </button>
                        </div>
                    </form>
                    @else
                        <p class="text-muted">Tidak ada varian tersedia untuk produk ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const konfirmasiBtn = document.getElementById('konfirmasiVarianBtn');

            konfirmasiBtn.addEventListener('click', function () {
                const selected = document.querySelector('input[name="varian_id"]:checked');
                const jumlah = parseInt(document.getElementById('jumlahProduk').value) || 1;

                if (!selected) {
                    alert('Silakan pilih salah satu varian terlebih dahulu.');
                    return;
                }

                const varianId = selected.value;
                console.log('Varian ID:', varianId, 'Jumlah:', jumlah);

                // Kirim ke backend (optional)
                // window.location.href = `/keranjang/add/${varianId}?qty=${jumlah}`;

                alert('Produk berhasil ditambahkan ke keranjang!');

                // Tutup modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalVarian'));
                modal.hide();
            });
        });
    </script>

    <style>
        .modal-backdrop.show {
            z-index: 10000;
        }

        .modal.show {
            z-index: 10001;
        }

        .bg-merah {
            background-color: #8B0000 !important;
        }

        .btn-merah {
            background-color: #8B0000;
            color: white;
            border: none;
        }

        .btn-merah:hover {
            background-color: #a41515;
        }

        .varian-card {
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .varian-card:hover {
            border-color: #8B0000;
            box-shadow: 0 0 10px rgba(139, 0, 0, 0.1);
        }

        .form-check-input:checked {
            background-color: #8B0000;
            border-color: #8B0000;
        }
    </style>

    {{-- CSS --}}
    <style>
        .deskripsi-wrapper {
            overflow: hidden;
            transition: max-height 0.5s ease;
            max-height: 100px;
            position: relative;
        }

        .deskripsi-wrapper.collapsed {
            max-height: 100px;
        }

        .deskripsi-wrapper.expanded {
            max-height: 1000px; /* Sesuaikan dengan panjang maksimum konten */
        }

        .deskripsi-produk {
            /* background-color: #fdf9f9; */
            border-left: 4px solid #8B0000;
            font-size: 0.95rem;
        }

        .btn-outline-merah {
            border: 1px solid #8B0000;
            color: #8B0000;
            background-color: transparent;
            transition: all 0.3s;
        }

        .btn-outline-merah:hover {
            background-color: #8B0000;
            color: white;
        }

        .btn-merah {
            background-color: #8B0000;
            color: white;
            border: none;
        }

        .btn-merah:hover {
            background-color: #a41515;
        }

        .btn-outline-merah {
            border: 2px solid #8B0000;
            color: #8B0000;
            background: transparent;
        }

        .btn-outline-merah:hover {
            background-color: #8B0000;
            color: white;
        }

        .carousel-fixed-height {
            height: 400px;
            background-color: #f8f9fa;
        }

        .carousel-item {
            height: 100%;
        }

        .custom-carousel-control {
            width: 5%;
        }

        .custom-carousel-icon {
            font-size: 2rem;
            color: #8B0000;
            border-radius: 10%;
            padding: 1px 1px;
        }

        .custom-carousel-icon:hover {
            color: #a41515;
        }

        .carousel-indicators [data-bs-target] {
            background-color: #8B0000;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin: 0 5px;
            opacity: 0.6;
            transition: opacity 0.3s ease, background-color 0.3s ease;
            border: none;
        }

        .carousel-indicators .active {
            background-color: #a41515;
            opacity: 1;
        }
        .navbar {
            padding: 0px 24px;
        }

        .deskripsi-wrapper table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
        table-layout: auto;
        }

        .deskripsi-wrapper th,
        .deskripsi-wrapper td {
        padding: 8px 12px;
        border: 1px solid #dee2e6;
        text-align: left;
        white-space: nowrap; /* agar tidak turun baris */
        }

        .deskripsi-wrapper th {
        background-color: #f2f2f2;
        font-weight: bold;
        }

        /* Wrapper media di detail produk */
        .produk-media { position: relative; }

        /* Badge stok habis — tampil cakep & terbaca di atas gambar */
        .stock-badge{
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 5;
        background: linear-gradient(135deg, #b30000, #ff3b3b);
        color: #fff;
        padding: 8px 12px;
        border-radius: 999px;     /* pill */
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .2px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid rgba(255,255,255,.35);
        box-shadow: 0 6px 18px rgba(179,0,0,.25);
        }

        /* Overlay halus agar badge kontras, tanpa mengganggu gambar */
        .stock-mask{
        position: absolute;
        inset: 0;
        z-index: 4;
        pointer-events: none;
        background: linear-gradient(
            180deg,
            rgba(0,0,0,.18) 0%,
            rgba(0,0,0,0) 35%
        );
        }

        /* Optional: kecilkan badge di layar kecil */
        @media (max-width: 575.98px){
        .stock-badge{ top: 10px; left: 10px; padding: 7px 10px; font-size: 12px; }
        }

        /* Animasi untuk pergerakan produk ke keranjang */
        @keyframes moveToCart {
            0% {
                transform: translate(0, 0);
                opacity: 1;
            }
            50% {
                transform: translate(50px, -50px);
                opacity: 0.7;
            }
            100% {
                transform: translateX(200px) translateY(-60px); /* Sesuaikan dengan posisi ikon keranjang */
                opacity: 0;
            }
        }

        .cart-animation {
            animation: moveToCart 1s ease forwards;
            position: absolute;
            z-index: 9999;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('toggleDeskripsiBtn');
            const wrapper = document.getElementById('deskripsiWrapper');

            btn.addEventListener('click', function () {
                if (wrapper.classList.contains('collapsed')) {
                    wrapper.classList.remove('collapsed');
                    wrapper.classList.add('expanded');
                    btn.innerHTML = 'Tampilkan Lebih Sedikit <i class="bi bi-chevron-up"></i>';
                } else {
                    wrapper.classList.remove('expanded');
                    wrapper.classList.add('collapsed');
                    btn.innerHTML = 'Lebih Lengkap <i class="bi bi-chevron-down"></i>';
                }
            });
        });

        document.getElementById('addToCartBtn').addEventListener('click', function() {
            var productImage = document.querySelector('.product-image'); // Ambil elemen gambar produk
            var cartIcon = document.querySelector('.cart-icon'); // Ambil elemen ikon keranjang

            var clonedImage = productImage.cloneNode(true); // Membuat salinan gambar produk

            // Tambahkan kelas animasi
            clonedImage.classList.add('cart-animation');

            // Tempatkan gambar produk di posisi awal
            clonedImage.style.position = 'absolute';
            clonedImage.style.top = productImage.offsetTop + 'px';
            clonedImage.style.left = productImage.offsetLeft + 'px';

            document.body.appendChild(clonedImage); // Tambahkan gambar ke body

            // Animasi bergerak menuju ikon keranjang
            setTimeout(function() {
                clonedImage.style.top = cartIcon.offsetTop + 'px'; // Sesuaikan posisi ke ikon keranjang
                clonedImage.style.left = cartIcon.offsetLeft + 'px';
            }, 0);

            // Hapus gambar setelah animasi selesai
            setTimeout(function() {
                clonedImage.remove();
            }, 1000);
        });
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        (function () {
        // jalan setelah DOM siap
        document.addEventListener('DOMContentLoaded', () => {
            const jumlahInput = document.getElementById('jumlahProduk');
            const radios = document.querySelectorAll('input[name="varian_id_radio"]');

            // Clamp jumlah berdasar stok saat varian berubah
            radios.forEach(radio => {
            radio.addEventListener('change', function () {
                const stok = parseInt(this.dataset.stok || this.getAttribute('data-stok')) || 0;
                if (stok > 0) {
                jumlahInput.max = stok;
                if (parseInt(jumlahInput.value || 0) > stok) {
                    jumlahInput.value = stok;
                }
                } else {
                jumlahInput.max = 0;
                jumlahInput.value = 0;
                }
            });
            });

            // Clamp manual input (min 1, max stok)
            jumlahInput.addEventListener('input', () => {
            let val = parseInt(jumlahInput.value || 0);
            if (isNaN(val) || val < 1) val = 1;
            const checked = document.querySelector('input[name="varian_id_radio"]:checked');
            const stok = checked ? parseInt(checked.dataset.stok || checked.getAttribute('data-stok')) || Infinity : Infinity;
            if (val > stok) val = stok;
            jumlahInput.value = val;
            });
        });

        // single submit function (global)
        window.submitCart = function (beliSekarang) {
            const selectedRadio = document.querySelector('input[name="varian_id_radio"]:checked');
            const jumlahInput = document.getElementById('jumlahProduk');

            if (!selectedRadio) {
            return Swal.fire({
                icon: 'warning',
                title: 'Varian Belum Dipilih',
                text: 'Silakan pilih salah satu varian produk terlebih dahulu.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#800000',
            });
            }

            const stokTersedia = parseInt(selectedRadio.dataset.stok || selectedRadio.getAttribute('data-stok')) || 0;
            let jumlah = parseInt(jumlahInput.value || 0);
            if (isNaN(jumlah) || jumlah < 1) jumlah = 1;

            if (jumlah > stokTersedia) {
            jumlahInput.value = stokTersedia > 0 ? stokTersedia : 0;
            return Swal.fire({
                icon: 'error',
                title: 'Jumlah Melebihi Stok',
                text: `Stok tersedia hanya ${stokTersedia}. Silakan kurangi jumlah pembelian.`,
                confirmButtonText: 'OK',
                confirmButtonColor: '#800000',
            });
            }

            // set hidden fields
            document.getElementById('selectedVarian').value = selectedRadio.value;
            document.getElementById('jumlahProdukHidden').value = jumlah;
            document.getElementById('beliSekarangHidden').value = beliSekarang;

            // animasi (optional)
            try {
            if (typeof animateToCart === 'function') {
                const img = selectedRadio.closest('.varian-card')?.querySelector('img');
                if (img) animateToCart(img.src);
            }
            } catch (e) { /* ignore */ }

            // submit normal form (biar redirect auth ke /login jalan)
            document.getElementById('formTambahKeranjang').submit();
        };
        })();
    </script>

    <script>
        function animateToCart(imageUrl) {
            const cartIcon = document.getElementById('navbarCartIcon');
            const imgFly = document.createElement('img');

            imgFly.src = imageUrl;
            imgFly.style.position = 'fixed';
            imgFly.style.width = '60px';
            imgFly.style.zIndex = 9999;
            imgFly.style.transition = 'all 0.8s ease-in-out';

            // Ambil posisi gambar pertama di modal (default)
            const sourceImage = document.querySelector('.varian-card img');
            const rect = sourceImage.getBoundingClientRect();

            imgFly.style.left = rect.left + 'px';
            imgFly.style.top = rect.top + 'px';
            document.body.appendChild(imgFly);

            // Ambil posisi cart
            const cartRect = cartIcon.getBoundingClientRect();
            setTimeout(() => {
                imgFly.style.left = cartRect.left + 'px';
                imgFly.style.top = cartRect.top + 'px';
                imgFly.style.opacity = '0.2';
                imgFly.style.transform = 'scale(0.5)';
            }, 10);

            // Hapus gambar setelah animasi selesai
            setTimeout(() => {
                imgFly.remove();
            }, 900);
        }
    </script>

    <style>
        .swal2-container {
            z-index: 10010 !important;
        }

        .swal2-popup.swal-custom-popup {
            border: 2px solid #800000;
            font-family: 'Poppins', sans-serif;
            z-index: 1210 !important;
        }

        .swal2-title {
            color: #800000;
        }
    </style>
@endsection
