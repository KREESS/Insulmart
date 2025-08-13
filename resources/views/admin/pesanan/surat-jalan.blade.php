<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan - {{ $pemesanan->kode_pemesanan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.4;
            background: #fff;
        }
        .info-section {
            margin-bottom: 15px;
        }
        .info-container {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background: #fcfcfc;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .info-box {
            width: 48%;
            background: #fff;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #eee;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #800000;
            font-size: 14px;
            border-bottom: 2px solid #800000;
            padding-bottom: 5px;
            letter-spacing: 0.5px;
        }
        .info-content {
            font-size: 12px;
        }
        .info-content table {
            width: 100%;
        }
        .info-content td {
            padding: 4px 0;
            line-height: 1.4;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .items-table th {
            background: #800000;
            color: white;
            padding: 10px 8px;
            font-size: 12px;
            font-weight: 600;
            text-align: left;
            border: 1px solid #600000;
        }
        .items-table td {
            padding: 8px;
            font-size: 12px;
            border: 1px solid #eee;
            background: #fff;
        }
        .items-table tbody tr:hover td {
            background: #fcfcfc;
        }
        .signatures {
            margin-top: 30px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }
        .signature-box {
            width: 31%;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .signature-title {
            font-weight: bold;
            color: #800000;
            font-size: 12px;
            margin-bottom: 30px;
            letter-spacing: 0.5px;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            margin: 8px auto;
            width: 80%;
        }
        .signature-name {
            font-size: 12px;
            margin-top: 5px;
        }
        .signature-role {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }
        .warning-text {
            margin-top: 20px;
            font-size: 11px;
            color: #666;
            text-align: center;
            font-style: italic;
            border-top: 1px dashed #ddd;
            padding: 15px 0;
            line-height: 1.5;
            background: #fcfcfc;
            border-radius: 0 0 8px 8px;
        }
    </style>
</head>
<body>
    <!-- Header dengan logo dan informasi perusahaan -->
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px; overflow: hidden; border-bottom: 2px solid #800000;">
        <table width="100%" style="border-collapse: separate; border-spacing: 0;">
            <tr>
                <td style="width: 80px; text-align: left; vertical-align: middle; padding: 15px;">
                    <img src="{{ public_path('/assets/img/icon-logo.png') }}"
                        alt="Logo PT"
                        style="height: 90px; width: auto; display: block; object-fit: contain; margin-bottom: 5px;">
                    <div style="text-align: center; font-size: 9px; color: #666;">www.insulmart.co.id</div>
                </td>
                <td style="vertical-align: middle; padding: 15px 20px;">
                    <div style="border-bottom: 2px solid #800000; padding-bottom: 10px; margin-bottom: 10px;">
                        <div style="font-size: 22px; color: #800000; font-weight: 700; letter-spacing: 1px; margin-bottom: 5px;">
                            SURAT JALAN
                        </div>
                        <div style="font-size: 13px; color: #800000;">
                            <span style="font-weight: 600;">No.: </span>
                            <span>SJ-{{ $pemesanan->kode_pemesanan }}</span>
                            <span style="margin: 0 10px;">|</span>
                            <span style="font-weight: 600;">Tanggal: </span>
                            <span>{{ \Carbon\Carbon::parse($pemesanan->created_at)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y - H:i:s') }} WIB</span>
                        </div>
                    </div>
                    <div style="font-size: 15px; color: #800000; font-weight: 700; margin-bottom: 5px;">
                        CV. INSULMART INDONESIA
                    </div>
                    <div style="font-size: 12px; color: #666; line-height: 1.4;">
                        JL. RAYA TARUMAJAYA NO. 13 RT 001 RW 029 DESA SETIA ASIH,<br>
                        Kec. Tarumajaya, Kab. Bekasi 17215
                    </div>
                    <div style="font-size: 11px; color: #666; margin-top: 3px;">
                        <span style="font-weight: 600;">NPWP:</span> 1000-0000-0424-4481
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table width="100%" style="margin: 15px 0; border-collapse: separate; border-spacing: 0; background: #fcfcfc; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <tr>
            <td width="50%" style="padding: 15px; border-right: 1px solid #eee;">
                <div style="background: #fff; padding: 15px; border-radius: 6px; border: 1px solid #eee;">
                    <div style="color: #800000; font-size: 14px; font-weight: bold; border-bottom: 2px solid #800000; padding-bottom: 5px; margin-bottom: 12px; letter-spacing: 0.5px;">
                        INFORMASI PENGIRIMAN
                    </div>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 4px 0; color: #555; width: 35%; font-size: 12px;">Tanggal Pemesanan</td>
                            <td style="width: 5%; padding: 4px 8px; color: #555; font-size: 12px;">:</td>
                            <td style="padding: 4px 0; font-size: 12px;">{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y - H:i:s') }} WIB</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; color: #555; width: 35%; font-size: 12px;">Tanggal Kirim</td>
                            <td style="width: 5%; padding: 4px 8px; color: #555; font-size: 12px;">:</td>
                            <td style="padding: 4px 0; font-size: 12px;">{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y - H:i:s') }} WIB</td>
                        </tr>                        <tr>
                            <td style="padding: 4px 0; color: #555; font-size: 12px;">No. Pesanan</td>
                            <td style="padding: 4px 8px; color: #555; font-size: 12px;">:</td>
                            <td style="padding: 4px 0; font-size: 12px;">{{ $pemesanan->kode_pemesanan }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; color: #555; font-size: 12px;">Status</td>
                            <td style="padding: 4px 8px; color: #555; font-size: 12px;">:</td>
                            <td style="padding: 4px 0; font-size: 12px;">
                                <span style="padding: 2px 8px; border-radius: 12px; font-size: 11px; 
                                    background-color: {{ $pemesanan->status_pemesanan == 'selesai' ? '#e8f5e9' : 
                                    ($pemesanan->status_pemesanan == 'diproses' ? '#e3f2fd' : '#fff3e0') }}; 
                                    color: {{ $pemesanan->status_pemesanan == 'selesai' ? '#2e7d32' : 
                                    ($pemesanan->status_pemesanan == 'diproses' ? '#1565c0' : '#f57f17') }};">
                                    {{ ucfirst($pemesanan->status_pemesanan) }} Dikirim
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td width="50%" style="padding: 15px;">
                <div style="background: #fff; padding: 15px; border-radius: 6px; border: 1px solid #eee;">
                    <div style="color: #800000; font-size: 14px; font-weight: bold; border-bottom: 2px solid #800000; padding-bottom: 5px; margin-bottom: 12px; letter-spacing: 0.5px;">
                        INFORMASI PENERIMA
                    </div>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 4px 0; color: #555; width: 25%; font-size: 12px;">Nama</td>
                            <td style="width: 5%; padding: 4px 8px; color: #555; font-size: 12px;">:</td>
                            <td style="padding: 4px 0; font-size: 12px;">{{ $pemesanan->pengguna->name }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; color: #555; width: 25%; font-size: 12px;">Perusahaan</td>
                            <td style="width: 5%; padding: 4px 8px; color: #555; font-size: 12px;">:</td>
                            <td style="padding: 4px 0; font-size: 12px;">{{ $pemesanan->pengguna->perusahaan }}</td>
                        </tr>                        <tr>
                            <td style="padding: 4px 0; color: #555; font-size: 12px;">No. HP</td>
                            <td style="padding: 4px 8px; color: #555; font-size: 12px;">:</td>
                            <td style="padding: 4px 0; font-size: 12px;">{{ $pemesanan->pengguna->nomor_telepon }}</td>
                        </tr>
                        @if($pemesanan->alamatPengiriman)
                        <tr>
                            <td style="padding: 4px 0; color: #555; font-size: 12px; vertical-align: top;">Alamat</td>
                            <td style="padding: 4px 8px; color: #555; font-size: 12px; vertical-align: top;">:</td>
                            <td style="padding: 4px 0; font-size: 12px;">
                                <div style="line-height: 1.5;">
                                    <div style="margin-bottom: 3px;">{{ $pemesanan->alamatPengiriman->alamat_lengkap }}</div>
                                    <div>{{ $pemesanan->alamatPengiriman->village }}, 
                                        Kec. {{ $pemesanan->alamatPengiriman->district }}</div>
                                    <div>{{ $pemesanan->alamatPengiriman->regency }}, 
                                        {{ $pemesanan->alamatPengiriman->province }}</div>
                                    <div>Kode Pos: {{ $pemesanan->alamatPengiriman->kode_pos }}</div>
                                    @if($pemesanan->alamatPengiriman->koordinat)
                                    <div style="color: #666; margin-top: 3px; font-size: 11px;">
                                        Koordinat: {{ $pemesanan->alamatPengiriman->koordinat }}
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <table class="items-table" style="border: 1px solid #eee;">
        <thead>
            <tr>
                <th style="width: 5%; background: #800000; color: white; padding: 10px 8px; font-size: 12px; font-weight: 600; text-align: center;">No.</th>
                <th style="width: 35%; background: #800000; color: white; padding: 10px 8px; font-size: 12px; font-weight: 600; text-align: left;">Nama Produk</th>
                <th style="width: 20%; background: #800000; color: white; padding: 10px 8px; font-size: 12px; font-weight: 600; text-align: left;">Varian</th>
                <th style="width: 15%; background: #800000; color: white; padding: 10px 8px; font-size: 12px; font-weight: 600; text-align: center;">Jumlah</th>
                <th style="width: 25%; background: #800000; color: white; padding: 10px 8px; font-size: 12px; font-weight: 600; text-align: left;">Armada Pengiriman</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemesanan->detailPemesanan as $index => $detail)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $detail->varianProduk->produk->nama_produk }}</td>
                <td>{{ $detail->varianProduk->tipe }}</td>
                <td style="text-align: center;">{{ $detail->kuantitas }} Ball/Pack</td>
                <td>
                    @if($pemesanan->armadaPemesanan->count() > 0)
                        @foreach($pemesanan->armadaPemesanan as $armada)
                            {{ $armada->armada->nama }} ({{ $armada->jumlah_mobil }} Unit)
                            @if(!$loop->last)
                            <br>
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:15px;">
        <table width="100%" style="border-collapse:collapse;">
            <tr>
                <td width="33%" style="text-align:center; padding:10px;">
                    <div style="font-weight:bold; color:#800000; font-size:11px;">Pengirim</div>
                    <div style="height:50px;"></div>
                    <div style="border-bottom:1px solid #333; width:80%; margin:0 auto;"></div>
                    <div style="margin-top:5px; font-size:11px;">(_______________________)</div>
                    <div style="margin-top:2px; font-size:10px; color:#666;">CV. INSULMART INDONESIA</div>
                </td>
                <td width="33%" style="text-align:center; padding:10px;">
                    <div style="font-weight:bold; color:#800000; font-size:11px;">Sopir</div>
                    <div style="height:50px;"></div>
                    <div style="border-bottom:1px solid #333; width:80%; margin:0 auto;"></div>
                    <div style="margin-top:5px; font-size:11px;">(_______________________)</div>
                    <div style="margin-top:2px; font-size:10px; color:#666;">Driver Pengiriman</div>
                </td>
                <td width="33%" style="text-align:center; padding:10px;">
                    <div style="font-weight:bold; color:#800000; font-size:11px;">Penerima</div>
                    <div style="height:50px;"></div>
                    <div style="border-bottom:1px solid #333; width:80%; margin:0 auto;"></div>
                    <div style="margin-top:5px; font-size:11px;">({{ $pemesanan->pengguna->name }})</div>
                    <div style="margin-top:2px; font-size:10px; color:#666;">Customer</div>
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-top:15px; font-size:10px; color:#666; text-align:center; font-style:italic; border-top:1px dashed #ddd; padding-top:8px; line-height:1.3;">
        * Barang yang sudah diterima tidak dapat dikembalikan kecuali ada perjanjian tertulis<br>
        * Mohon periksa barang sebelum menandatangani surat jalan<br>
        * Dokumen ini adalah bukti resmi pengiriman barang
    </div>
</body>
</html>
