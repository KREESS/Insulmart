<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Invoice #{{ $pemesanan->kode_pemesanan }} Termin {{ $termin->termin_ke }}</title>
        <link rel="icon" href="{{ asset('assets/img/insulmart_new1.png') }}" type="image/png">
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #222; margin: 0; padding: 0;}
            .wrapper { max-width: 800px; margin: 0 auto; background: #fff; padding: 32px 28px 22px 28px;}
            .header-grid {
                display: grid;
                grid-template-columns: 105px 1fr 210px;
                align-items: center;
                padding-bottom: 16px;
                border-bottom: 2.5px solid #800000;
                margin-bottom: 28px;
                gap: 14px;
            }
            .logo-img {
                width: 92px;
                height: 65px;
                object-fit: contain;
                display: block;
                margin: 0 auto;
            }
            .center-info {
                text-align: center;
            }
            .pt-name {
                font-size: 17px;
                font-weight: bold;
                color: #800000;
                letter-spacing: 1.1px;
                margin-bottom: 2px;
            }
            .pt-info, .npwp {
                font-size: 11px;
                color: #a12c2c;
                line-height: 1.4;
            }
            .npwp { margin-top: 1.5px; }
            .invoice-block {
                text-align: right;
            }
            .invoice-title {
                font-size: 18px;
                font-weight: bold;
                color: #800000;
                margin-bottom: 5px;
                letter-spacing: 1.1px;
            }
            .invoice-data {
                font-size: 13px;
                color: #800000;
            }
            .invoice-data .label { font-weight: bold; color: #800000; }
            .info-table { width: 100%; margin-bottom: 18px;}
            .info-table td { padding: 2px 0; font-size: 13px;}
            .info-table .label { width: 125px; color: #800000; }
            .section-title { color: #800000; font-weight: 700; font-size: 15px; margin-bottom: 8px; margin-top: 30px; letter-spacing: .7px;}
            .table { width: 100%; border-collapse: collapse; margin-top: 14px;}
            .table, .table th, .table td { border: 1.5px solid #e4dada;}
            .table th, .table td { padding: 8px 11px; font-size: 13px;}
            .table th { background: #800000; color: #fff; font-weight: 600;}
            .table td { background: #fdfbfa;}
            .table tr:nth-child(even) td { background: #faf6f6;}
            .total { font-weight: bold; background: #f8ecec;}
            .right { text-align: right;}
            .nominal-box { padding: 13px 24px; background: #f8ecec; border-radius: 12px; display: inline-block; font-size: 16px; font-weight: 700; color: #800000; box-shadow: 0 2px 8px rgba(128,0,0,0.08);}
            .inline-container {
                display: table;
                width: 100%;
                margin-top: 48px;
                table-layout: fixed;
            }

            .inline-left, .inline-right {
                display: table-cell;
                vertical-align: bottom;
            }

            .inline-left {
                width: 60%;
            }

            .inline-right {
                text-align: right;
                width: 40%;
            }

            .nominal-box {
                font-size: 1.6rem;
                font-weight: bold;
                color: #800000;
                background: #f8f8f8;
                padding: 16px 24px;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.06);
                display: inline-block;
                max-width: 100%;
                word-break: break-word;
            }

            .ttd-box {
                font-size: 0.9rem;
            }

            .ttd-img {
                width: 140px;
                height: auto;
                margin: 4px 0;
            }

            .ttd-nama {
                font-weight: bold;
                margin-top: 6px;
                text-decoration: underline;
            }

            .ttd-jabatan {
                font-size: 0.85rem;
                color: #555;
            }

            @media (max-width: 650px) {
                .inline-container {
                    display: block;
                }
                .inline-left, .inline-right {
                    display: block;
                    width: 100%;
                }
                .inline-right {
                    text-align: left;
                    margin-top: 24px;
                }
            }


            @media (max-width: 650px) {
                .wrapper { padding: 16px 6px 8px 6px;}
                .header-grid { grid-template-columns: 72px 1fr 1fr; gap: 7px; }
                .invoice-block { font-size: 11px; }
                .invoice-title { font-size: 15px;}
                .logo-img { width: 58px; height: 40px;}
                .pt-name { font-size: 13px; }
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <table width="100%" style="border-bottom:2px solid #800000; margin-bottom:24px; border-collapse:separate;">
                <tr>
                    <!-- Logo besar, rata tengah -->
                    <td style="width:122px; text-align:left; vertical-align:middle; padding-left:0;">
                        <img src="{{ public_path('/assets/img/icon-logo.png') }}"
                            alt="Logo PT"
                            style="height:190px; width:auto; display:block; object-fit:contain;">
                    </td>
                    <!-- HEADER KANAN: semua info inline, font kecil proporsional -->
                    <td style="vertical-align:middle; text-align:left; padding-left:22px;">
                        <div style="display:flex; align-items:center; gap:15px; flex-wrap:wrap;">
                            <span style="font-size:20px; color:#800000; font-weight:700; letter-spacing:1px;">
                                INVOICE TERMIN {{ $termin->termin_ke }}
                            </span>
                            <br>
                            <span style="font-size:13px; color:#800000; font-weight:bold;">
                                No.: <span style="font-weight:400;">#{{ $pemesanan->kode_pemesanan }}</span>
                            </span>
                            <br>
                            <span style="font-size:13px; color:#800000; font-weight:bold;">
                                Tanggal: <span style="font-weight:400;">{{ \Carbon\Carbon::parse($pemesanan->created_at)->format('d-m-Y') }}</span>
                            </span>
                        </div>
                        <div style="margin-top:7px; font-size:15px; color:#800000; font-weight:700;">
                            CV. INSULMART INDONESIA
                        </div>
                        <div style="font-size:12px; color:#a12c2c;">
                            JL. RAYA TARUMAJAYA NO. 13 RT 001 RW 029 DESA SETIA ASIH<br>
                            Kec. Tarumajaya, Kab. Bekasi 17215
                        </div>
                        <div style="font-size:11px; color:#a12c2c;">
                            NPWP: 1000-0000-0424-4481
                        </div>
                    </td>
                </tr>
            </table>

            <!-- === SISA TIDAK BERUBAH === -->
            <table class="info-table borderless">
                <tr>
                    <td class="label">Nama Customer</td>
                    <td>: {{ $pemesanan->pengguna->name }}</td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td>: {{ $pemesanan->pengguna->email }}</td>
                </tr>
                <tr>
                    <td class="label">No. Telepon</td>
                    <td>: {{ $pemesanan->pengguna->nomor_telepon ?? '-' }}</td>
                </tr>
            </table>

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
                            <td class="right">{{ $item->kuantitas }}</td>
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
            <div class="note-PPN" style="font-size: 11px; color: #555; margin-top: 6px;">
                *Harga Diatas Sudah Temasuk PPN
            </div>

            <!-- ... (table produk di atas) -->

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
                            <td>{{ $armada->armada->kapasitas_pack ?? '-' }} bal</td>
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

            <div class="inline-container">
                <div class="inline-left">
                    <div class="section-title">Nominal Pembayaran Termin {{ $termin->termin_ke }}</div>
                    <div class="nominal-box">
                        Rp{{ number_format($termin->jumlah_dibayar, 0, ',', '.') }}
                    </div>
                    <div class="note-rekening" style="font-size: 11px; color: #555; margin-top: 6px;">
                        Pembayaran dapat ditransfer melalui Bank <b>BCA</b><br> 
                        No. Rek: <b>066-3059367</b> a/n <b>PT TALI REJEKI</b>
                    </div>
                </div>

                <div class="inline-right">
                    <div class="ttd-box">
                        <div class="ttd-label">Hormat Kami,</div>
                        <img src="{{ public_path('/assets/img/ttd.png') }}" alt="Tanda Tangan" class="ttd-img">
                        <div class="ttd-nama">YUDHISTIRA JALU</div>
                        <div class="small" style="margin-top:6px;">{{ date('d-m-Y') }}</div>
                    </div>
                </div>
            </div>


        </div>
    </body>
</html>
