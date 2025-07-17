@extends('components.layout-bootstrap')

@section('title', $produk->nama_produk)

@section('content')
    <br><br><br>

    <div class="container py-5">
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
                        @if ($produk->gambars->count() > 0)
                        <div id="carouselDetailProduk" class="carousel slide" data-bs-ride="carousel">
                            {{-- Carousel Indicators --}}
                            <div class="carousel-indicators">
                                @foreach ($produk->gambars as $index => $gambar)
                                <button type="button" data-bs-target="#carouselDetailProduk"
                                    data-bs-slide-to="{{ $index }}"
                                    class="{{ $index == 0 ? 'active' : '' }}"
                                    aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            </div>

                            {{-- Carousel Slides --}}
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
                                                    <img src="{{ asset('storage/' . $gambar->path) }}"
                                                        class="img-fluid rounded mx-auto d-block"
                                                        style="max-height: 90vh; object-fit: contain;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            {{-- Tombol Panah Slider --}}
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

                    {{-- Detail Produk --}}
                    <div class="col-md-6">
                        <h2 class="fw-bold mb-3">{{ $produk->nama_produk }}</h2>
                        <p class="text-muted mb-2">
                            <i class="bi bi-tag-fill me-1 text-danger"></i> {{ ucfirst($produk->jenis_produk) }}
                        </p>

                        @php
                            $min = $produk->varians->min('harga');
                            $max = $produk->varians->max('harga');
                        @endphp

                        <h4 class="text-black fw-bold mb-3">
                            Rp{{ number_format($min, 0, ',', '.') }}
                            @if ($min != $max)
                                <span class="text-black">~ Rp{{ number_format($max, 0, ',', '.') }}</span>
                            @endif
                        </h4>

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
                            <button class="btn btn-merah px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalVarian">
                                <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                            </button>
                            <button class="btn btn-outline-merah px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalVarian">
                                <i class="bi bi-bag-check me-1"></i> Beli Sekarang
                            </button>
                            {{-- <a href="#" class="btn btn-outline-merah px-4 py-2">
                                <i class="bi bi-bag-check me-1"></i> Beli Sekarang
                            </a> --}}
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
            <div class="row g-3">
            @foreach ($produk->varians as $varian)
            <div class="col-md-6">
                <label class="border rounded p-3 w-100 h-100 d-flex gap-3 align-items-center varian-card position-relative">
                {{-- Gambar kecil --}}
                <img src="{{ $produk->gambars->first() ? asset('storage/' . $produk->gambars->first()->path) : asset('assets/img/no-image.png') }}"
                    class="rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="Varian">

                {{-- Info varian --}}
                <div class="flex-grow-1">
                <div class="fw-semibold text-dark">{{ $varian->tipe }}</div>
                <div class="text-muted small">
                    Ukuran: {{ $varian->ukuran }}<br>
                    Ketebalan: {{ $varian->ketebalan }} mm<br>
                    Densitas: {{ $varian->densitas }} kg/m³<br>
                    Stok: <span class="{{ $varian->stok > 0 ? 'text-success' : 'text-danger' }}">{{ $varian->stok }}</span><br>
                    <strong class="text-dark">Rp{{ number_format($varian->harga, 0, ',', '.') }}</strong>
                </div>
                </div>

                {{-- Radio --}}
                <input type="radio" name="varian_id" value="{{ $varian->id }}" class="form-check-input position-absolute top-0 end-0 m-2">
                </label>
            </div>
            @endforeach
            </div>

            {{-- Input jumlah --}}
            <div class="mt-4">
            <label for="jumlahProduk" class="form-label fw-semibold">Jumlah</label>
            <input type="number" id="jumlahProduk" class="form-control" min="1" value="1" style="max-width: 120px;">
            </div>
            @else
            <p class="text-muted">Tidak ada varian tersedia untuk produk ini.</p>
            @endif
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" id="konfirmasiVarianBtn" class="btn btn-merah">Tambah ke Keranjang</button>
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
    </script>


@endsection
