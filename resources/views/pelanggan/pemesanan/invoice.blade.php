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
                padding: 16px 16px 16px;
                box-shadow: 0 0 20px rgba(0,0,0,0.03);
            }

            /* Info Table Styles */
            .info-table { 
                width: 100%; 
                margin: 16px 0 20px;
                border-spacing: 0;
                border-collapse: separate;
            }

            .info-table td { 
                padding: 4px 8px; 
                font-size: 12px;
                line-height: 1.4;
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
                font-size: 14px; 
                margin: 24px 0 12px;
                letter-spacing: 0.5px;
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
            }

            .nominal-label {
                color: #800000;
                font-weight: 700;
                font-size: 12px;
                margin-right: 12px;
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
            }

            /* Signature Box */
            .ttd-box {
                font-size: 10px;
                width: 160px;
                text-align: center;
            }

            .ttd-img {
                width: 75px;
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

            @media print {
                body { background: #fff; }
                .wrapper { 
                    box-shadow: none;
                    padding: 20px;
                }
                .table { box-shadow: 0 0 0 1px #e4dada; }
                .nominal-box, .ttd-box {
                    box-shadow: none;
                    border: 1px solid rgba(128,0,0,0.1);
                }
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <!-- Header dengan logo dan informasi perusahaan -->
            <div style="background: #fff; border-radius: 4px; box-shadow: 0 1px 3px rgba(128,0,0,0.08); margin-bottom: 12px; overflow: hidden; border: 1px solid #f0f0f0; border-bottom: 2px solid #800000;">
                <table width="100%" style="border-collapse: separate; border-spacing: 0;">
                    <tr>
                        <td style="width: 80px; text-align: center; vertical-align: middle; padding: 8px; border-right: 1px solid #f5f5f5;">
                            <img src="{{ public_path('/assets/img/icon-logo.png') }}"
                                alt="Logo PT"
                                style="height: 65px; width: auto; display: block; object-fit: contain; margin: 0 auto 2px;">
                            <div style="text-align: center; font-size: 8px; color: #800000; font-weight: 500;">www.insulmart.co.id</div>
                        </td>
                        <td style="vertical-align: middle; padding: 8px 12px;">
                            <div style="border-bottom: 1px solid #f0f0f0; padding-bottom: 6px; margin-bottom: 6px;">
                                <div style="font-size: 16px; color: #800000; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 3px;">
                                    INVOICE TERMIN {{ $termin->termin_ke }}
                                </div>
                                <div style="font-size: 10px; color: #800000; display: flex; align-items: center; gap: 6px;">
                                    <span style="font-weight: 600;">No.:</span>
                                    <span style="font-weight: 500;">INV-{{ $pemesanan->kode_pemesanan }}</span>
                                    <span style="color: #ddd;">|</span>
                                    <span style="font-weight: 600;">Tanggal:</span>
                                    <span style="font-weight: 500;">{{ \Carbon\Carbon::parse($pemesanan->created_at)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y - H:i') }} WIB</span>
                                </div>
                            </div>
                            <div style="font-size: 14px; color: #800000; font-weight: 700; margin-bottom: 4px;">
                                CV. INSULMART INDONESIA
                            </div>
                            <div style="font-size: 11px; color: #666; line-height: 1.3;">
                                JL. RAYA TARUMAJAYA NO. 13 RT 001 RW 029 DESA SETIA ASIH,
                                Kec. Tarumajaya, Kab. Bekasi 17215
                            </div>
                            <div style="font-size: 11px; color: #666; margin-top: 2px;">
                                <span style="font-weight: 600;">NPWP:</span> 1000-0000-0424-4481
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- === SISA TIDAK BERUBAH === -->
            <table class="info-table borderless">
                <tr>
                    <td class="label">Nama Customer</td>
                    <td>: {{ $pemesanan->pengguna->name }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Perusahaan</td>
                    <td>: {{ $pemesanan->pengguna->perusahaan }}</td>
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

            <div style="margin-top: 24px;">
                <div class="nominal-section">
                    <div class="nominal-label">Nominal Pembayaran Termin {{ $termin->termin_ke }}:</div>
                    <div class="nominal-box">
                        Rp{{ number_format($termin->jumlah_dibayar, 0, ',', '.') }}
                    </div>
                    <div class="note-rekening" style="margin-top: 8px;">
                        Pembayaran dapat ditransfer melalui Bank <b>BCA</b><br> 
                        No. Rek: <b>066-3059367</b> a/n <b>PT TALI REJEKI</b>
                    </div>
                    <div class="ttd-box" style="margin-left: 24px;">
                        <div class="ttd-label">Hormat Kami,</div>
                        <img src="{{ public_path('/assets/img/ttd.png') }}" alt="Tanda Tangan" class="ttd-img">
                        <div class="ttd-nama">YUDHISTIRA JALU</div>
                        <div class="small">Jakarta, {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}</div>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>
