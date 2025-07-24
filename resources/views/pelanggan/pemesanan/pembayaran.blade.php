@extends('components.layout-bootstrap')

@section('title', 'Pembayaran Pesanan')

@section('content')
        @php use Illuminate\Support\Str; @endphp

        <style>
            :root {
                --maroon-dark: #800000;
                --maroon-light: #f8e5e5;
                --maroon-hover: #660000;
                --radius: 12px;
            }

            body {
                padding-top: 5rem;
            }

            .text-maroon { color: var(--maroon-dark) !important; }
            .bg-maroon-light { background-color: var(--maroon-light); }

            .btn-maroon {
                background-color: var(--maroon-dark);
                color: #fff;
                font-weight: 600;
                border-radius: var(--radius);
            }

            .btn-maroon:hover { background-color: var(--maroon-hover); }

            .btn-outline-maroon {
                border: 1px solid var(--maroon-dark);
                color: var(--maroon-dark);
                border-radius: var(--radius);
            }

            .btn-outline-maroon:hover {
                background-color: var(--maroon-dark);
                color: #fff;
            }

            .card-custom {
                border-radius: var(--radius);
                box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.08);
            }

            .card-section-title {
                font-weight: bold;
                font-size: 1.25rem;
                color: var(--maroon-dark);
                margin-bottom: 1rem;
            }

            .img-preview {
                max-width: 220px;
                height: auto;
                border-radius: var(--radius);
                border: 1px solid #ccc;
                margin-bottom: 0.75rem;
            }
            .navbar {
                padding: 0px 24px;
            }
        </style>

        <div class="container py-5 pt-5 mt-4 fade-up">
            <h3 class="text-maroon fw-bold mb-4"><i class="bi bi-wallet2 me-2"></i>Upload PO & Bukti Pembayaran</h3>

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show shadow-sm">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- PO Section --}}
            <div class="card mb-4 card-custom">
                <div class="card-body fade-up">
                    <h5 class="card-section-title"><i class="bi bi-file-earmark-arrow-up me-2"></i>Dokumen PO</h5>

                    @if($pemesanan->file_po)
                        <p class="mb-1"><strong>PO:</strong> {{ $pemesanan->nomor_po ?? '–' }}</p>
                        <p class="mb-2">
                            ✅ Sudah diunggah:
                            <a href="{{ asset('storage/' . $pemesanan->file_po) }}" target="_blank" class="fw-bold text-decoration-underline text-maroon">Lihat PO</a>
                        </p>

                        {{-- Preview kecil untuk gambar atau PDF --}}
                        @php
                            $ext = pathinfo($pemesanan->file_po, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                            $isPdf = strtolower($ext) === 'pdf';
                        @endphp

                        <div class="mb-3">
                            @if($isImage)
                                <img src="{{ asset('storage/' . $pemesanan->file_po) }}" alt="Preview PO" style="max-width: 150px; border-radius: 6px; border: 1px solid #ccc;">
                            @elseif($isPdf)
                                <iframe src="{{ asset('storage/' . $pemesanan->file_po) }}" width="100%" height="180px" style="border: 1px solid #ccc; border-radius: 6px;"></iframe>
                            @endif
                        </div>

                        <form id="delete-po-form" action="{{ route('pemesanan.hapus_po', $pemesanan->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('delete-po-form', 'Yakin ingin menghapus file PO ini?')" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash me-1"></i> Hapus PO
                            </button>
                        </form>
                    @else
                        <form action="{{ route('pemesanan.upload_po', $pemesanan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nomor PO</label>
                                <input type="text" name="nomor_po" class="form-control" required placeholder="Masukkan Nomor PO"
                                    value="{{ old('nomor_po', $pemesanan->nomor_po) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Upload File PO (PDF / JPG)</label>
                                <input type="file" name="file_po" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-maroon"><i class="bi bi-upload me-1"></i> Upload PO</button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Info Rekening Tujuan --}}
            <div class="card mb-4 card-custom fade-up">
                <div class="card-body">
                    <h5 class="card-section-title"><i class="bi bi-bank me-2"></i>Transfer ke Rekening Berikut</h5>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-transparent">
                            <strong>Bank:</strong> Bank Central Asia (BCA)
                        </li>
                        <li class="list-group-item bg-transparent">
                            <strong>Nama Pemilik:</strong> PT Tali Rejeki
                        </li>
                        <li class="list-group-item bg-transparent">
                            <strong>No. Rekening:</strong> 123 456 7890
                        </li>
                    </ul>

                    <p class="mt-3 mb-0 small text-muted">
                        Harap cantumkan <strong>Nomor Pemesanan</strong> atau <strong>Nama Perusahaan</strong> pada berita transfer untuk memudahkan verifikasi.
                    </p>
                </div>
            </div>

            {{-- Bukti Pembayaran Section --}}
            <div class="card card-custom fade-up">
                <div class="card-body">
                    <h5 class="card-section-title fade-up">
                        <i class="bi bi-receipt me-2"></i>Bukti Pembayaran
                    </h5>

                    {{-- Total Pesanan --}}
                    <div class="mb-4 fade-up">
                        <span class="fw-semibold">Total Pesanan:</span>
                        <span class="fs-5 fw-bold text-maroon">
                            Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                        </span>
                    </div>

                    @foreach($pemesanan->pembayaran as $termin)
                        <div class="border p-4 rounded mb-4 bg-light shadow-sm fade-up">
                            <div class="row g-4 align-items-start">
                                <div class="col-md-8">
                                    {{-- Termin --}}
                                    <div class="mb-2 fade-up">
                                        <span class="fw-semibold text-muted">Termin:</span>
                                        <span class="ms-1 fw-bold text-dark">Ke-{{ $termin->termin_ke }}</span>
                                    </div>

                                    {{-- Jumlah + Persentase --}}
                                    @php
                                        $percent = $pemesanan->total_harga
                                            ? round($termin->jumlah_dibayar / $pemesanan->total_harga * 100, 2)
                                            : 0;
                                    @endphp
                                    <div class="mb-2 fade-up">
                                        <span class="fw-semibold text-muted">Jumlah Dibayar:</span>
                                        <span class="ms-1 fw-bold text-maroon">
                                            Rp{{ number_format($termin->jumlah_dibayar, 0, ',', '.') }}
                                        </span>
                                        <small class="text-muted">({{ $percent }}%)</small>
                                    </div>

                                    {{-- Status Verifikasi --}}
                                    <div class="mb-2 fade-up">
                                        <span class="fw-semibold text-muted">Status:</span>
                                        @if($termin->status_verifikasi === 'diterima')
                                            <span class="badge bg-success ms-1">
                                                <i class="bi bi-check-circle me-1"></i>Diterima
                                            </span>
                                        @elseif($termin->status_verifikasi === 'ditolak')
                                            <span class="badge bg-danger ms-1">
                                                <i class="bi bi-x-circle me-1"></i>Ditolak
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark ms-1">
                                                <i class="bi bi-hourglass-split me-1"></i>Menunggu
                                            </span>
                                        @endif
                                        </div>
                                    </div>

                                    {{-- Bukti & Aksi Hapus --}}
                                    @if($termin->bukti_transfer)
                                        <div class="mt-3 fade-up">
                                            <p class="mb-1"><strong>Bukti Transfer:</strong></p>
                                            <a href="{{ asset('storage/'.$termin->bukti_transfer) }}"
                                            target="_blank" class="text-decoration-underline">
                                                <i class="bi bi-eye me-1"></i>Lihat File
                                            </a>

                                            @if(Str::endsWith($termin->bukti_transfer, ['.jpg','jpeg','png']))
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/'.$termin->bukti_transfer) }}"
                                                        alt="Bukti Transfer"
                                                        class="img-preview">
                                                </div>
                                            @endif

                                            <form id="hapus-bukti-{{ $termin->id }}"
                                                action="{{ route('pemesanan.hapus_bukti', $termin->id) }}"
                                                method="POST" class="mt-3">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        onclick="confirmDelete(
                                                            'hapus-bukti-{{ $termin->id }}',
                                                            'Yakin ingin menghapus bukti transfer termin ke-{{ $termin->termin_ke }}?'
                                                        )"
                                                        class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash me-1"></i> Hapus Bukti
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                {{-- Form Upload Baru --}}
                                <div class="col-md-4 fade-up">
                                    @if(! $termin->bukti_transfer)
                                        <form action="{{ route('pemesanan.upload_bukti', $termin->id) }}"
                                            method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-2">
                                                <label class="form-label fw-semibold">
                                                    Upload Bukti Transfer
                                                </label>
                                                <input type="file" name="bukti_transfer"
                                                    class="form-control" required>
                                            </div>
                                            <button type="submit"
                                                    class="btn btn-sm btn-maroon w-100">
                                                <i class="bi bi-upload me-1"></i> Upload Bukti
                                            </button>
                                        </form>
                                        <a href="{{ route('pemesanan.invoice', [$pemesanan->id, 'termin' => $termin->termin_ke]) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-maroon w-100 mt-2">
                                            <i class="bi bi-file-earmark-arrow-down me-1"></i> Download Invoice Termin {{ $termin->termin_ke }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-end mt-3 mb-5 fade-up pe-5"> {{-- Bootstrap 5 --}}
                <a href="{{ route('pemesanan.index') }}" class="btn btn-maroon">
                    <i class="bi bi-arrow-right-circle me-1"></i>
                    Lanjut ke Pesanan Saya
                </a>
            </div>
        </div>
        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(formId, pesan = 'Yakin ingin menghapus data ini?') {
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: pesan,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#800000', // maroon
                    cancelButtonColor: '#888',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                });
            }
        </script>
@endpush

@endsection
