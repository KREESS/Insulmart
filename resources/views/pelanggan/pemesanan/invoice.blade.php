<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Invoice #{{ $pemesanan->kode_pemesanan }} Termin {{ $termin->termin_ke }}</title>
        <link rel="icon" href="{{ asset('assets/img/insulmart_new1.png') }}" type="image/png">
        <style>
            body { 
                font-family: DejaVu Sans, sans-serif; 
                font-size: 11px; 
                color: #333; 
                margin: 0; 
                padding: 0;
                line-height: 1.3;
            }

            .wrapper { 
                max-width: 800px; 
                margin: 0 auto; 
                background: #fff; 
                padding: 14px 14px 16px;
                box-shadow: 0 0 20px rgba(0,0,0,0.03);
            }

            /* Info Table Styles */
            .info-table { 
                width: 100%; 
                margin: 10px 0 16px;
                border-spacing: 0;
                border-collapse: separate;
            }

            .info-table td { 
                padding: 4px 8px; 
                font-size: 10.5px;
                line-height: 1.35;
                vertical-align: top;
            }

            .info-table .label { 
                width: 130px; 
                color: #800000;
                font-weight: 600;
                padding-left: 0;
            }

            /* Section Titles */
            .section-title { 
                color: #800000; 
                font-weight: 700; 
                font-size: 13px; 
                margin: 18px 0 10px;
                letter-spacing: 0.3px;
                padding-bottom: 6px;
                border-bottom: 1px solid rgba(128,0,0,0.1);
            }

            /* Main Tables */
            .table { 
                width: 100%; 
                border-collapse: separate;
                border-spacing: 0;
                margin: 6px 0;
                border-radius: 4px;
                overflow: hidden;
                box-shadow: 0 0 0 1px #e4dada;
            }

            .table th { 
                background: #800000; 
                color: #fff; 
                font-weight: 600;
                font-size: 10px;
                padding: 6px 8px;
                text-align: left;
                border-bottom: 1px solid #700000;
            }

            .table td { 
                padding: 4px 8px; 
                font-size: 10px;
                background: #fff;
                border-bottom: 1px solid #e4dada;
            }

            .table tr:last-child td {
                border-bottom: none;
            }

            .table tr:nth-child(even) td { 
                background: #fdfafa;
            }

            .table .right {
                text-align: right;
            }

            .total { 
                font-weight: 700; 
                background: #f8ecec !important;
                color: #800000;
            }

            /* Notes */
            .note-PPN, .note-rekening { 
                font-size: 9px; 
                color: #666; 
                margin-top: 4px;
                line-height: 1.2;
                padding: 4px 8px;
                background: #fafafa;
                border-radius: 3px;
                border-left: 2px solid #800000;
            }

            /* Payment Section */
            .inline-container {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-top: 16px;
                gap: 24px;
            }

            .inline-left {
                flex: 1;
                max-width: 450px;
            }

            .inline-right {
                width: 180px;
            }

            .nominal-section {
                display: flex;
                align-items: center;
                margin-bottom: 8px;
                gap: 12px;
                flex-wrap: wrap;
            }

            .nominal-label {
                color: #800000;
                font-weight: 700;
                font-size: 12px;
                white-space: nowrap;
            }

            .nominal-box {
                background: #f8f3f3;
                padding: 6px 12px;
                border-radius: 4px;
                box-shadow: 0 1px 4px rgba(128,0,0,0.08);
                border: 1px solid rgba(128,0,0,0.1);
                font-size: 13px;
                font-weight: 700;
                color: #800000;
                text-align: right;
                flex: 1;
                min-width: 240px;
            }

            /* Signature Box */
            .ttd-box {
                font-size: 10px;
                width: 160px;
                text-align: center;
            }

            .ttd-img {
                width: 100px;
                height: auto;
                display: block;
                margin: 4px auto;
            }

            .ttd-nama {
                font-weight: 700;
                color: #800000;
                border-bottom: 1px solid #800000;
                display: inline-block;
                padding-bottom: 1px;
                margin: 2px 0;
            }

            .ttd-label {
                margin-bottom: 2px;
                color: #555;
            }

            .small {
                font-size: 9px;
                color: #666;
            }

            /* === Compact Header & Customer Card === */
            .header-card {
                background: #fff; 
                border-radius: 4px; 
                box-shadow: 0 1px 3px rgba(128,0,0,0.08); 
                margin-bottom: 10px; 
                overflow: hidden; 
                border: none;
                border-bottom: 3px solid #800000;
            }

            .header-table {
                width: 100%;
                border-collapse: separate; 
                border-spacing: 0;
            }
            .header-logo-cell {
                width: 75px; 
                text-align: center; 
                vertical-align: middle; 
                padding: 6px; 
                border-right: none;          /* <-- HILANGKAN GARIS KANAN CELL LOGO */
            }
            .header-logo {
                height: 60px;                /* <-- LOGO DIBESARKAN SEDIKIT (50px -> 60px) */
                width: auto; 
                display: block; 
                object-fit: contain; 
                margin: 0 auto 2px;
            }
            .header-url {
                text-align: center; 
                font-size: 7px; 
                color: #800000; 
                font-weight: 500;
            }
            .header-info-cell {
                vertical-align: middle; 
                padding: 6px 10px;
            }
            /* === DIPERKECIL LAGI SESUAI PERMINTAAN === */
            .header-title {
                font-size: 12px; /* 14px -> 12px */
                color: #800000; 
                font-weight: 700; 
                letter-spacing: 0.3px; 
                margin-bottom: 2px;
            }
            .header-meta {
                font-size: 8.5px; /* 9px -> 8.5px */
                color: #800000; 
                display: flex; 
                align-items: center; 
                gap: 4px;
            }
            .company-name {
                font-size: 10.5px; /* 12px -> 10.5px */
                color: #800000; 
                font-weight: 700; 
                margin-bottom: 2px;
            }
            .company-text, .company-tax {
                font-size: 9.5px; /* 10px -> 9.5px */
                color: #666; 
                line-height: 1.3;
            }

            /* === Kolom Kanan: Info Kontak === */
            .header-contact-cell{
                width: 240px; 
                border-left: none;           /* <-- HILANGKAN GARIS KIRI CELL KONTAK */
                padding: 6px 10px;
                vertical-align: middle;
            }
            .contact-title{
                font-size: 9.5px;
                font-weight: 700;
                color: #800000;
                letter-spacing: .3px;
                margin: 0 0 4px 0;
                text-transform: uppercase;
            }
            .contact-line{
                font-size: 9px;
                color: #555;
                line-height: 1.35;
                margin: 0;
            }

            .customer-card {
                border: 1px solid #e9dede;
                border-radius: 6px;
                padding: 8px 10px;
                background: #fff;
                box-shadow: 0 1px 3px rgba(128,0,0,0.05);
            }
            .customer-title {
                font-size: 11.5px;
                font-weight: 700;
                color: #800000;
                margin: 0 0 6px;
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .customer-grid {
                display: grid;
                grid-template-columns: 150px 1fr;
                gap: 4px 10px;
                font-size: 10.5px;
            }
            .customer-label {
                color: #800000;
                font-weight: 600;
            }
            .customer-value {
                color: #333;
            }

            .customer-card {
                border: 1px solid #e9dede;
                border-radius: 6px;
                padding: 6px 10px;
                background: #fff;
                box-shadow: 0 1px 3px rgba(128,0,0,0.05);
                margin-bottom: 14px;
            }
            .customer-title {
                font-size: 11.5px;
                font-weight: 700;
                color: #800000;
                margin: 0 0 6px;
            }
            .customer-label {
                font-weight: 600;
                color: #800000;
                margin-right: 4px;
            }

            .customer-card {
                border: 1px solid #e9dede;
                border-radius: 6px;
                padding: 8px 10px;
                background: #fff;
                box-shadow: 0 1px 3px rgba(128,0,0,0.05);
                margin-bottom: 14px;
            }
            .customer-title {
                font-size: 11.5px;
                font-weight: 700;
                color: #800000;
                margin: 0 0 8px;
            }
            .customer-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 10.5px;
            }
            .customer-table td {
                border: 1px solid #eee;
                padding: 6px 8px;
                vertical-align: top;
            }
            .customer-table .label {
                font-weight: 600;
                color: #800000;
                width: 120px;
                background: #fafafa;
            }

            @media print {
                body { background: #fff; }
                .wrapper { 
                    box-shadow: none;
                    padding: 16px 18px;
                }
                .table { box-shadow: 0 0 0 1px #e4dada; }
                .nominal-box, .ttd-box, .customer-card, .header-card {
                    box-shadow: none;
                    border: 1px solid rgba(128,0,0,0.12);
                }
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <!-- Header dengan ukuran diperkecil + kolom kontak kanan -->
            <div class="header-card">
                <table class="header-table">
                    <tr>
                        <td class="header-logo-cell">
                            <img src="{{ public_path('/assets/img/icon-logo.png') }}"
                                alt="Logo PT"
                                class="header-logo">
                            <div class="header-url">www.insulmart.co.id</div>
                        </td>
                        <td class="header-info-cell">
                            <div style="border-bottom: 1px solid #f0f0f0; padding-bottom: 4px; margin-bottom: 4px;">
                                <div class="header-title">
                                    INVOICE TERMIN {{ $termin->termin_ke }}
                                </div>
                                <div class="header-meta">
                                    <span style="font-weight: 600;">No.:</span>
                                    <span style="font-weight: 500;">INV-{{ $pemesanan->kode_pemesanan }}</span>
                                    <span style="color: #ddd;">|</span>
                                    <span style="font-weight: 600;">Tanggal:</span>
                                    <span style="font-weight: 500;">{{ \Carbon\Carbon::parse($pemesanan->created_at)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y - H:i') }} WIB</span>
                                </div>
                            </div>
                            <div class="company-name">CV. INSULMART INDONESIA</div>
                            <div class="company-text">
                                JL. RAYA TARUMAJAYA NO. 13 RT 001 RW 029 DESA SETIA ASIH,
                                Kec. Tarumajaya, Kab. Bekasi 17215
                            </div>
                            <div class="company-tax" style="margin-top: 2px;">
                                <span style="font-weight: 600;">NPWP:</span> 1000-0000-0424-4481
                            </div>
                        </td>
                        <!-- Kolom kanan: informasi kontak -->
                        <td class="header-contact-cell">
                            <div class="contact-title">SOUND PROOFING &amp; INSULATION SPECIALIST</div>
                            <p class="contact-line">Telp. : (021) 29470622</p>
                            <p class="contact-line">Fax  : (021) 29470622</p>
                            <p class="contact-line">Email: insulmartindonesia@gmail.com</p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Informasi Customer dengan tabel 2x2 -->
            <div class="customer-card">
                <div class="customer-title">Informasi Customer</div>
                <table class="customer-table">
                    <tr>
                        <td class="label">Nama Customer</td>
                        <td>{{ $pemesanan->pengguna->name }}</td>
                        <td class="label">Perusahaan</td>
                        <td>{{ $pemesanan->pengguna->perusahaan }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td>{{ $pemesanan->pengguna->email }}</td>
                        <td class="label">No. Telepon</td>
                        <td>{{ $pemesanan->pengguna->nomor_telepon ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="section-title">Rincian Pesanan</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Tipe</th>
                        <th class="right">Harga</th>
                        <th class="right">Qty</th>
                        <th class="right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($pemesanan->detailPemesanan as $item)
                        @php
                            $subtotal = ($item->varianProduk->harga ?? 0) * $item->kuantitas;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $item->varianProduk->produk->nama_produk ?? '-' }}</td>
                            <td>{{ $item->varianProduk->tipe ?? '-' }}</td>
                            <td class="right">Rp{{ number_format($item->varianProduk->harga,0,',','.') }}</td>
                            <td class="right">{{ $item->kuantitas }} Ball</td>
                            <td class="right">Rp{{ number_format($subtotal,0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="right total">TOTAL</td>
                        <td class="right total">Rp{{ number_format($total,0,',','.') }}</td>
                    </tr>
                </tfoot>
            </table>
            <div class="note-PPN" style="font-size: 10px; color: #555; margin-top: 6px;">
                *Harga di atas sudah termasuk PPN
            </div>

            <div class="section-title">Rincian Ongkos Kirim</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Armada</th>
                        <th>Kapasitas</th>
                        <th class="right">Jumlah Mobil</th>
                        <th class="right">Tarif per km</th>
                        <th class="right">Jarak (km)</th>
                        <th class="right">Subtotal Ongkir</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalOngkir = 0; @endphp
                    @foreach($pemesanan->armadaPemesanan as $armada)
                        @php $totalOngkir += $armada->subtotal_ongkir; @endphp
                        <tr>
                            <td>{{ $armada->armada->nama ?? '-' }}</td>
                            <td>{{ $armada->armada->kapasitas_pack ?? '-' }} ball</td>
                            <td class="right">{{ $armada->jumlah_mobil }}</td>
                            <td class="right">Rp{{ number_format($armada->armada->tarif_per_km ?? 0, 0, ',', '.') }}/km</td>
                            <td class="right">{{ number_format($armada->jarak_km, 2) }}</td>
                            <td class="right">Rp{{ number_format($armada->subtotal_ongkir, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="right total">Total Ongkir</td>
                        <td class="right total">Rp{{ number_format($totalOngkir, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <div style="margin-top: 20px;">
                <div class="nominal-section">
                    <div class="nominal-label">Nominal Pembayaran Termin {{ $termin->termin_ke }}:</div>
                    <div class="nominal-box">
                        Rp{{ number_format($termin->jumlah_dibayar, 0, ',', '.') }}
                    </div>

                    <div class="ttd-box" style="margin-left: auto;">
                        <div class="ttd-label">Hormat Kami,</div>
                        <img src="{{ public_path('/assets/img/ttd.png') }}" alt="Tanda Tangan" class="ttd-img">
                        <div class="ttd-nama">YUDHISTIRA JALU</div>
                        <div class="small">Jakarta, {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}</div>
                    </div>
                </div>

                <div class="note-rekening" style="margin-top: 6px;">
                    Pembayaran dapat ditransfer melalui Bank <b>BCA</b><br> 
                    No. Rek: <b>066-3059367</b> a/n <b>PT TALI REJEKI</b>
                </div>
            </div>
        </div>
    </body>
</html>
