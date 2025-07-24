@extends('components.layout-bootstrap')

@section('title', 'Detail Pesanan')

@section('content')

<style>
    :root {
        --maroon-dark: #800000;
        --maroon-hover: #660000;
        --maroon-light: #f8e5e5;
        --maroon-very-light: #fdf7f7;
        --radius: 18px;
        --transition-fast: 0.2s;
        --shadow-light: 0 2px 24px 0 rgba(128,0,0,0.07);
        --shadow-hover: 0 4px 32px 0 rgba(128,0,0,0.13);
        --table-border: #e0e0e0;
    }

    .content-wrapper {
        padding: 2.5rem 0.5rem 3rem 0.5rem;
        max-width: 1100px;
        margin: 0 auto;
    }

    .card-accent {
        border: none;
        border-top: 6px solid var(--maroon-dark);
        border-radius: var(--radius);
        box-shadow: var(--shadow-light);
        transition: box-shadow var(--transition-fast);
        background: #fff;
    }

    .card-accent:hover {
        box-shadow: var(--shadow-hover);
    }

    .title-header {
        margin-top: 5rem;
        margin-bottom: 2.25rem;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid var(--maroon-light);
    }

    .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--maroon-dark);
        margin-bottom: 1.2rem;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .btn-maroon {
        background-color: var(--maroon-dark);
        color: #fff;
        border-radius: var(--radius);
        transition: background var(--transition-fast);
        font-weight: 600;
    }

    .btn-maroon:hover {
        background-color: var(--maroon-hover);
    }

    .btn-outline-secondary {
        border-radius: var(--radius);
        font-weight: 500;
    }

    .badge-maroon {
        background: var(--maroon-dark);
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.45em 1.05em;
        font-size: .96em;
        letter-spacing: .5px;
    }
    .badge-light-maroon {
        background: var(--maroon-light);
        color: var(--maroon-dark);
        font-weight: 600;
        border: 1px solid var(--maroon-dark);
        border-radius: 8px;
        padding: 0.45em 1.05em;
        font-size: .96em;
    }
    .badge-danger {
        background: #e74c3c;
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.45em 1.05em;
        font-size: .96em;
    }

    .table-wrapper {
        border-radius: var(--radius);
        overflow-x: auto;
        box-shadow: var(--shadow-light);
        margin-bottom: 0;
    }

    table.table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 650px;
        background: #fff;
    }

    table thead {
        background: var(--maroon-dark);
        color: white;
    }

    table thead th {
        border: none !important;
        font-weight: 700;
        font-size: 1.01rem;
        padding-top: 0.92rem;
        padding-bottom: 0.92rem;
        letter-spacing: .2px;
    }

    table tbody tr {
        border-bottom: 1px solid var(--table-border);
        transition: background 0.2s, box-shadow 0.2s;
    }

    table tbody tr:nth-child(even) {
        background: var(--maroon-very-light);
    }

    table tbody tr:hover {
        background: var(--maroon-light);
    }

    table tfoot {
        background: #faf6f6;
        font-weight: 700;
    }

    table tfoot td {
        border-top: 2px solid var(--table-border);
        background-color: #f9f9f9;
    }

    .table td, .table th {
        vertical-align: middle !important;
        padding: 0.83rem 1.05rem;
        border-color: var(--table-border);
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1.25rem 0.25rem 2.5rem 0.25rem;
        }
        .title-header {
            margin-top: 2.2rem;
            margin-bottom: 1.4rem;
            padding-bottom: 0.25rem;
        }
        .section-title {
            font-size: 1.02rem;
        }
        .card-accent {
            margin-bottom: 1rem;
        }
        table.table {
            font-size: 0.96rem;
            min-width: 520px;
        }
        .table-responsive {
            padding-bottom: 1rem;
        }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: none; }
    }

    .animate-up {
        animation: fadeInUp 0.75s cubic-bezier(.18,.78,.43,1.11) both;
        opacity: 0;
    }
    .navbar { padding: 0 24px; }

    @media (max-width: 991.98px) { /* tablet ke bawah */
    .main-content {
        margin-top: 3rem !important;
        padding-top: 1.1rem !important;
    }
}
@media (max-width: 767.98px) { /* HP */
    .main-content {
        margin-top: 7rem !important;
        padding-top: 0.85rem !important;
    }
}
@media (max-width: 575.98px) { /* HP kecil */
    .main-content {
        margin-top: 8rem !important;
        padding-top: 0.5rem !important;
    }
}
</style>

<div class="container-fluid content-wrapper main-content">
    {{-- Judul --}}
    <div class="title-header animate-up">
        <h2 class="fw-bold text-maroon mb-1" style="letter-spacing:1.5px;">
            <i class="bi bi-file-earmark-text-fill me-2 text-maroon"></i>
            Detail Pesanan
        </h2>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <p class="text-muted small mb-0">
                Kode Pesanan: <strong>#{{ $pesanan->kode_pemesanan }}</strong>
            </p>
            @php
                $status = strtolower($pesanan->status_pemesanan ?? '');
                $statusMap = [
                    'menunggu'   => ['badge bg-warning text-dark', 'Menunggu'],
                    'diproses'   => ['badge bg-primary', 'Diproses'],
                    'selesai'    => ['badge bg-success', 'Selesai'],
                    'dibatalkan' => ['badge bg-danger', 'Dibatalkan'],
                ];
                $cls = $statusMap[$status][0] ?? 'badge bg-secondary';
                $label = $statusMap[$status][1] ?? ucfirst($status ?: '-');
            @endphp
            <span class="{{ $cls }} rounded-pill px-3 py-2" style="font-size:.95rem">
                {{ $label }}
            </span>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="row gx-4 gy-4 mb-5 animate-up">
        {{-- Data Pelanggan --}}
        <div class="col-md-4 col-12">
            <div class="card card-accent shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted mb-2" style="font-weight: 600;">Data Pelanggan</h6>
                    <h5 class="mb-2">{{ $pesanan->pengguna->name }}</h5>
                    <div class="d-flex align-items-center mb-1">
                        <i class="bi bi-envelope-fill me-2"></i>
                        <span class="small">{{ $pesanan->pengguna->email }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-telephone-fill me-2"></i>
                        <span class="small">{{ $pesanan->pengguna->nomor_telepon ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
        {{-- Alamat Pengiriman --}}
        <div class="col-md-4 col-12">
            <div class="card card-accent shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted mb-2" style="font-weight: 600;">Alamat Pengiriman</h6>
                    <h5 class="mb-2">{{ $pesanan->alamatPengiriman->label ?? '–' }}</h5>
                    <div class="mb-1 small">
                        {{ $pesanan->alamatPengiriman->alamat_lengkap }}
                    </div>
                    <div class="mb-1 small">
                        {{ $pesanan->alamatPengiriman->district }}, {{ $pesanan->alamatPengiriman->regency }}
                    </div>
                    <div class="small">
                        {{ $pesanan->alamatPengiriman->province }} {{ $pesanan->alamatPengiriman->kode_pos }}
                    </div>
                </div>
            </div>
        </div>
        {{-- Info Pesanan --}}
        <div class="col-md-4 col-12">
            <div class="card card-accent shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h6 class="text-uppercase text-muted mb-2" style="font-weight: 600;">Info Pesanan</h6>
                    <p class="mb-1"><strong>Kode:</strong> #{{ $pesanan->kode_pemesanan }}</p>
                    <p class="mb-1"><strong>PO:</strong> {{ $pesanan->nomor_po ?? '–' }}</p>
                    <p class="mb-1">
                        <strong>Status PO:</strong>
                        @php
                            $status = strtolower($pesanan->status_po ?? '');
                            $statusMap = [
                                'menunggu'   => ['badge bg-warning text-dark', 'Menunggu'],
                                'pending'    => ['badge bg-warning text-dark', 'Menunggu'],
                                'disetujui'  => ['badge bg-success', 'Disetujui'],
                                'accepted'   => ['badge bg-success', 'Disetujui'],
                                'ditolak'    => ['badge bg-danger', 'Ditolak'],
                                'rejected'   => ['badge bg-danger', 'Ditolak'],
                            ];
                            $cls = $statusMap[$status][0] ?? 'badge bg-secondary';
                            $label = $statusMap[$status][1] ?? ucfirst($status ?: '-');
                        @endphp
                        <span class="{{ $cls }} rounded-pill px-3">
                            {{ $label }}
                        </span>
                    </p>
                    <p class="mb-1"><strong>Metode:</strong> {{ ucfirst($pesanan->metode_pembayaran) }}</p>
                    <p class="mb-3"><strong>Total:</strong> 
                        <span class="text-maroon">Rp {{ number_format($pesanan->total_harga,0,',','.') }}</span>
                    </p>
                    <div class="mt-auto">
                        @if($pesanan->file_po)
                            <a href="{{ asset('storage/'.$pesanan->file_po) }}" class="btn btn-maroon w-100 mb-2">
                                <i class="bi bi-download me-1"></i> Unduh PO
                            </a>
                        @else
                            <span class="text-muted small">PO belum di-upload</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Rincian Produk --}}
    <div class="card shadow-sm mb-5 animate-up">
        <div class="card-body pb-3">
            <h5 class="section-title">
                <i class="bi bi-box-seam me-2 text-maroon"></i>Rincian Produk
            </h5>
            <div class="table-responsive table-wrapper">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Produk</th>
                            <th>Tipe</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach($pesanan->detailPemesanan as $item)
                            @php
                                $rowTotal = ($item->varianProduk->harga ?? 0) * $item->kuantitas;
                                $subtotal += $rowTotal;
                            @endphp
                            <tr>
                                <td style="width:64px;">
                                    @php
                                        $produk = $item->varianProduk->produk ?? null;
                                        // ambil gambar pertama dari relasi gambars
                                        $gambar = ($produk && $produk->gambars && $produk->gambars->count())
                                            ? $produk->gambars->first()
                                            : null;
                                    @endphp
                                    @if($gambar)
                                        <img src="{{ asset('storage/'.$gambar->path) }}" alt="Gambar Produk" class="img-thumbnail" style="max-width:56px; max-height:56px;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $item->varianProduk->produk->nama_produk ?? '-' }}</td>
                                <td>{{ $item->varianProduk->tipe }}</td>
                                <td class="text-end">Rp {{ number_format($item->varianProduk->harga,0,',','.') }}</td>
                                <td class="text-center">{{ $item->kuantitas }}</td>
                                <td class="text-end">Rp {{ number_format($rowTotal,0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end">Total</td>
                            <td class="text-end">Rp {{ number_format($subtotal,0,',','.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Riwayat Pembayaran --}}
    @if($pesanan->pembayaran->isNotEmpty())
        <div class="card shadow-sm mb-5 animate-up">
            <div class="card-body pb-3">
                <h5 class="section-title">
                    <i class="bi bi-clock-history me-2 text-maroon"></i>Riwayat Pembayaran
                </h5>
                <div class="table-responsive table-wrapper">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Termin</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-end">Jumlah</th>
                                <th>Status</th>
                                <th>Catatan Admin</th>
                                <th class="text-center">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan->pembayaran as $bayar)
                            <tr>
                                <td>{{ $bayar->termin_ke }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($bayar->tanggal_pembayaran)->format('d-m-Y') }}</td>
                                <td class="text-end">Rp {{ number_format($bayar->jumlah_dibayar,0,',','.') }}</td>
                                <td>
                                    @php
                                        if (empty($bayar->bukti_transfer)) {
                                            // Jika belum upload bukti transfer
                                            $cls = 'badge bg-secondary';
                                            $label = 'Belum Bayar';
                                        } else {
                                            $status = strtolower($bayar->status_verifikasi);
                                            $statusMap = [
                                                'diterima'        => ['badge bg-success',  'Diterima'],
                                                'accepted'        => ['badge bg-success',  'Diterima'],
                                                'menunggu'        => ['badge bg-warning text-dark', 'Menunggu'],
                                                'pending'         => ['badge bg-warning text-dark', 'Menunggu'],
                                                'ditolak'         => ['badge bg-danger', 'Ditolak'],
                                                'rejected'        => ['badge bg-danger', 'Ditolak'],
                                                'termin1_lunas'   => ['badge bg-primary', 'Termin 1 Lunas'],
                                                'termin2_lunas'   => ['badge bg-primary', 'Termin 2 Lunas'],
                                                'termin3_lunas'   => ['badge bg-primary', 'Termin 3 Lunas'],
                                            ];
                                            $cls = $statusMap[$status][0] ?? 'badge bg-secondary';
                                            $label = $statusMap[$status][1] ?? ucfirst($status);
                                        }
                                    @endphp
                                    <span class="{{ $cls }} rounded-pill px-3">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td>{{ $bayar->catatan_admin ?? '-' }}</td>
                                <td class="text-center">
                                    @if($bayar->bukti_transfer)
                                        <a href="{{ asset('storage/'.$bayar->bukti_transfer) }}" target="_blank">
                                            <i class="bi bi-file-earmark-image-fill fs-4 text-maroon"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- Tombol Kembali --}}
    <div class="text-end mt-4 animate-up">
        <a href="{{ route('pemesanan.index') }}" class="btn btn-outline-secondary px-4 py-2 shadow-sm">
            <i class="bi bi-arrow-left-circle me-2"></i>
            Kembali
        </a>
    </div>
</div>
@endsection
