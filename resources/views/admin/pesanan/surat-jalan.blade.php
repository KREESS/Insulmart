<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan - {{ $pemesanan->kode_pemesanan }}</title>
    <style>
        :root{
            --maroon:#800000;
            --maroon-dark:#600000;
            --border:#eee;
            --muted:#666;
            --card:#fff;
            --card-soft:#fcfcfc;
            --thead-bg:#f2f2f2;   /* header tabel netral terang */
            --thead-text:#222;    /* teks gelap, kontras tinggi */
            --thead-line:#d9d9d9; /* garis bawah header tabel */
        }
        body{
            font-family: Arial, sans-serif;
            margin:0;
            padding:20px;
            color:#333;
            line-height:1.4;
            background:#fff;
            font-size:12px;
        }

        /* ==== HEADER (diperkecil lagi) ==== */
        .doc-header{
            background:var(--card);
            border-radius:6px;
            box-shadow:0 1px 3px rgba(0,0,0,0.08);
            margin-bottom:12px;            /* lebih hemat */
            overflow:hidden;
            border-bottom:2px solid var(--maroon);
        }
        .doc-header table{
            width:100%;
            border-collapse:separate;
            border-spacing:0;
        }
        .logo-cell{
            width:64px;                     /* sedikit lebih kecil */
            text-align:left;
            vertical-align:middle;
            padding:6px 8px;                /* sebelumnya 8px 10px */
        }
        .logo-cell img{
            height:75px;                    /* 58px -> 40px */
            width:auto;
            display:block;
            object-fit:contain;
            margin-bottom:2px;
        }
        .site-url{
            text-align:center;
            font-size:8.5px;               /* 9px -> 8.5px */
            color:var(--muted);
        }
        .header-info{
            vertical-align:middle;
            padding:6px 10px;              /* 8px 14px -> 6px 10px */
        }
        .title-wrap{
            border-bottom:1px solid #e6e6e6;/* halus, bukan maroon solid */
            padding-bottom:4px;             /* 6px -> 4px */
            margin-bottom:4px;              /* 6px -> 4px */
        }
        .doc-title{
            font-size:14px;                 /* 16px -> 14px */
            color:var(--maroon);
            font-weight:700;
            letter-spacing:.3px;
            margin:0 0 1px 0;
        }
        .meta{
            font-size:10px;                 /* 11px -> 10px */
            color:#444;
        }
        .company{
            font-size:11px;                 /* 13px -> 11px */
            color:var(--maroon);
            font-weight:700;
            margin:1px 0 2px 0;
        }
        .company-addr{
            font-size:10px;                 /* 10.5px -> 10px */
            color:#666;
            line-height:1.3;
        }
        .company-tax{
            font-size:9.5px;                /* 10px -> 9.5px */
            color:#666;
            margin-top:2px;
        }

        /* ==== INFO BOXES (diperkecil) ==== */
        .info-shell{
            width:100%;
            margin:10px 0;                  /* 12px -> 10px */
            border-collapse:separate;
            border-spacing:0;
            background:var(--card-soft);
            border-radius:8px;
            box-shadow:0 1px 3px rgba(0,0,0,0.05);
        }
        .info-shell td{
            vertical-align:top;
            padding:10px;                   /* 12px -> 10px */
        }
        .info-shell td:first-child{
            border-right:1px solid var(--border);
        }
        .ibox{
            background:var(--card);
            padding:8px;                    /* 12px -> 8px */
            border-radius:6px;
            border:1px solid var(--border);
        }
        .ibox h3{
            margin:0 0 6px 0;               /* 8px -> 6px */
            color:#444;                     /* netral agar irit tinta */
            font-size:11.5px;               /* 12.5px -> 11.5px */
            font-weight:700;
            letter-spacing:.3px;
        }
        .ibox table{
            width:100%;
            border-collapse:collapse;
            font-size:10.5px;               /* 11.5px -> 10.5px */
        }
        .ibox td{
            padding:2px 0;                  /* 3px -> 2px */
            line-height:1.3;                /* 1.35 -> 1.3 */
            vertical-align:top;
        }
        .label{
            color:#4a4a4a;
            width:34%;
            white-space:nowrap;
        }
        .colon{
            width:4%;
            padding:0 8px;
            color:#777;
        }
        .ibox .label--rcv{
            width:25%;
        }
        .field-label{
            color:#444;
            font-weight:600;
        }

        /* ==== ITEMS TABLE (header diperjelas) ==== */
        .items-table{
            width:100%;
            border-collapse:collapse;
            margin:12px 0;                  /* 14px -> 12px */
            box-shadow:0 1px 3px rgba(0,0,0,0.06);
            border-radius:6px;              /* 8px -> 6px */
            overflow:hidden;
            border:1px solid var(--border);
            font-size:10.5px;               /* 11.5px -> 10.5px */
        }
        .items-table thead th{
            background:var(--thead-bg);     /* netral terang */
            color:var(--thead-text);        /* teks gelap */
            padding:6px 8px;                /* 8px -> 6px */
            font-size:10.5px;               /* 11px -> 10.5px */
            font-weight:700;
            text-align:left;
            border-bottom:1px solid var(--thead-line);
            letter-spacing:.3px;
            text-transform:uppercase;       /* lebih tegas, mudah dibaca */
        }
        .items-table td{
            padding:5px 8px;                /* 6px -> 5px */
            font-size:10.5px;               /* 11px -> 10.5px */
            border-bottom:1px solid var(--border);
            background:#fff;
            color:#222;
        }
        .items-table tbody tr:nth-child(even) td{
            background:#fbfbfb;             /* zebra lembut */
        }
        .items-table tr:last-child td{
            border-bottom:none;
        }
        .items-table th:nth-child(1),
        .items-table td:nth-child(1){
            text-align:center;
            width:5%;
        }

        /* ==== SIGNATURES ==== */
        .sig-wrap{
            margin-top:16px;                /* 18px -> 16px */
            margin-bottom:14px;
            width:100%;
            border-collapse:collapse;
        }
        .sig-col{
            width:33%;
            text-align:center;
            padding:8px;                    /* 10px -> 8px */
        }
        .sig-title{
            font-weight:bold;
            color:var(--maroon);
            font-size:10.5px;               /* 11px -> 10.5px */
            letter-spacing:.3px;
            margin-bottom:18px;             /* 22px -> 18px */
        }
        .sig-line{
            border-bottom:1px solid #333;
            margin:6px auto;                /* 8px -> 6px */
            width:80%;
            height:22px;
        }
        .sig-name{
            font-size:10.5px;               /* 11px -> 10.5px */
            margin-top:4px;
        }
        .sig-role{
            font-size:10px;
            color:#666;
            margin-top:2px;
        }

        /* ==== FOOT NOTE ==== */
        .foot-note{
            margin-top:12px;                /* 14px -> 12px */
            font-size:9.8px;                /* sedikit lebih kecil */
            color:#666;
            text-align:center;
            font-style:italic;
            border-top:1px dashed #ddd;
            padding-top:6px;                /* 8px -> 6px */
            line-height:1.3;
        }

        @media print{
            body{ padding:12px; }
            .doc-header,
            .ibox{ box-shadow:none; }
            .items-table{ border-color:#ddd; }
        }

    /* Header Card ala invoice */
    .header-card {
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(128,0,0,0.08);
        margin-bottom: 10px;
        overflow: hidden;
        border: none;
        border-bottom: 3px solid var(--maroon, #800000);
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
        border-right: none;
    }
    .header-logo {
        height: 60px;                /* seragam dg invoice */
        width: auto;
        display: block;
        object-fit: contain;
        margin: 0 auto 2px;
    }
    .header-url {
        text-align: center;
        font-size: 7px;
        color: var(--maroon, #800000);
        font-weight: 500;
    }
    .header-info-cell {
        vertical-align: middle;
        padding: 6px 10px;
    }
    .header-title {
        font-size: 12px;             /* kecil & tegas */
        color: var(--maroon, #800000);
        font-weight: 700;
        letter-spacing: .3px;
        margin-bottom: 2px;
    }
    .header-meta {
        font-size: 8.5px;
        color: var(--maroon, #800000);
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }
    .company-name {
        font-size: 10.5px;
        color: var(--maroon, #800000);
        font-weight: 700;
        margin-bottom: 2px;
    }
    .company-text,
    .company-tax {
        font-size: 9.5px;
        color: #666;
        line-height: 1.3;
    }

    /* Kolom kanan: info kontak */
    .header-contact-cell {
        width: 240px;
        border-left: none;
        padding: 6px 10px;
        vertical-align: middle;
    }
    .contact-title {
        font-size: 9.5px;
        font-weight: 700;
        color: var(--maroon, #800000);
        letter-spacing: .3px;
        margin: 0 0 4px 0;
        text-transform: uppercase;
    }
    .contact-line {
        font-size: 9px;
        color: #555;
        line-height: 1.35;
        margin: 0;
    }

    @media print {
        .header-card { 
            box-shadow: none;
            border: 1px solid rgba(128,0,0,0.12);
            border-bottom-width: 2px;
        }
    }
    </style>
</head>
<body>
<!-- ====== HTML: HEADER SURAT JALAN (ganti blok .doc-header lama dengan ini) ====== -->
<div class="header-card">
    <table class="header-table">
        <tr>
            <td class="header-logo-cell">
                <img src="{{ public_path('/assets/img/icon-logo.png') }}" alt="Logo PT" class="header-logo">
                <div class="header-url">www.insulmart.co.id</div>
            </td>

            <td class="header-info-cell">
                <div style="border-bottom: 1px solid #f0f0f0; padding-bottom: 4px; margin-bottom: 4px;">
                    <div class="header-title">SURAT JALAN</div>
                    <div class="header-meta">
                        <span style="font-weight:600;">No.:</span>
                        <span style="font-weight:500;">SJ-{{ $pemesanan->kode_pemesanan }}</span>
                        <span style="color:#ddd;">|</span>
                        <span style="font-weight:600;">Tanggal:</span>
                        <span style="font-weight:500;">
                            {{ \Carbon\Carbon::parse($pemesanan->created_at)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y - H:i') }} WIB
                        </span>
                    </div>
                </div>

                <div class="company-name">CV. INSULMART INDONESIA</div>
                <div class="company-text">
                    JL. RAYA TARUMAJAYA NO. 13 RT 001 RW 029 DESA SETIA ASIH,
                    Kec. Tarumajaya, Kab. Bekasi 17215
                </div>
                <div class="company-tax" style="margin-top:2px;">
                    <span style="font-weight:600;">NPWP:</span> 1000-0000-0424-4481
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

    <!-- INFORMASI PENGIRIMAN & PENERIMA (lebih rapat + label jelas) -->
    <table class="info-shell">
        <tr>
            <td width="50%">
                <div class="ibox">
                    <h3>INFORMASI PENGIRIMAN</h3>
                    <table>
                        <tr>
                            <td class="label"><span class="field-label">Tanggal Pemesanan</span></td>
                            <td class="colon">:</td>
                            <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y - H:i:s') }} WIB</td>
                        </tr>
                        <tr>
                            <td class="label"><span class="field-label">Tanggal Kirim</span></td>
                            <td class="colon">:</td>
                            <td>{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y - H:i:s') }} WIB</td>
                        </tr>
                        <tr>
                            <td class="label"><span class="field-label">No. Pesanan</span></td>
                            <td class="colon">:</td>
                            <td>{{ $pemesanan->kode_pemesanan }}</td>
                        </tr>
                        <tr>
                            <td class="label"><span class="field-label">Status</span></td>
                            <td class="colon">:</td>
                            <td>
                                <span style="padding:1px 6px; border:1px solid #dcdcdc; border-radius:999px; font-size:10px; background:#fff; color:#333;">
                                    {{ ucfirst($pemesanan->status_pemesanan) }} · Dikirim
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td width="50%">
                <div class="ibox">
                    <h3>INFORMASI PENERIMA</h3>
                    <table>
                        <tr>
                            <td class="label label--rcv"><span class="field-label">Nama</span></td>
                            <td class="colon">:</td>
                            <td>{{ $pemesanan->pengguna->name }}</td>
                        </tr>
                        <tr>
                            <td class="label label--rcv"><span class="field-label">Perusahaan</span></td>
                            <td class="colon">:</td>
                            <td>{{ $pemesanan->pengguna->perusahaan }}</td>
                        </tr>
                        <tr>
                            <td class="label label--rcv"><span class="field-label">No. HP</span></td>
                            <td class="colon">:</td>
                            <td>{{ $pemesanan->pengguna->nomor_telepon ?? '-' }}</td>
                        </tr>
                        @if($pemesanan->alamatPengiriman)
                        <tr>
                            <td class="label label--rcv" style="vertical-align:top;"><span class="field-label">Alamat</span></td>
                            <td class="colon" style="vertical-align:top;">:</td>
                            <td>
                                <div style="line-height:1.35;">
                                    <div style="margin-bottom:3px;">{{ $pemesanan->alamatPengiriman->alamat_lengkap }}</div>
                                    <div>{{ $pemesanan->alamatPengiriman->village }}, Kec. {{ $pemesanan->alamatPengiriman->district }}</div>
                                    <div>{{ $pemesanan->alamatPengiriman->regency }}, {{ $pemesanan->alamatPengiriman->province }}</div>
                                    <div>Kode Pos: {{ $pemesanan->alamatPengiriman->kode_pos }}</div>
                                    @if($pemesanan->alamatPengiriman->koordinat)
                                    <div style="color:#666; margin-top:3px; font-size:10px;">
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

    <!-- TABEL BARANG -->
    <table class="items-table">
        <thead>
            <tr>
                <th>No.</th>
                <th style="width:35%;">Nama Produk</th>
                <th style="width:20%;">Varian</th>
                <th style="width:15%; text-align:center;">Jumlah</th>
                <th style="width:25%;">Armada Pengiriman</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemesanan->detailPemesanan as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->varianProduk->produk->nama_produk }}</td>
                <td>{{ $detail->varianProduk->tipe }}</td>
                <td style="text-align:center;">{{ $detail->kuantitas }} Ball/Pack</td>
                <td>
                    @if($pemesanan->armadaPemesanan->count() > 0)
                        @foreach($pemesanan->armadaPemesanan as $armada)
                            {{ $armada->armada->nama }} ({{ $armada->jumlah_mobil }} Unit)@if(!$loop->last)<br>@endif
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <table class="sig-wrap">
        <tr>
            <td class="sig-col">
                <div class="sig-title">Pengirim</div>
                <div class="sig-line"></div>
                <div class="sig-name">(_______________________)</div>
                <div class="sig-role">CV. INSULMART INDONESIA</div>
            </td>
            <td class="sig-col">
                <div class="sig-title">Sopir</div>
                <div class="sig-line"></div>
                <div class="sig-name">(_______________________)</div>
                <div class="sig-role">Driver Pengiriman</div>
            </td>
            <td class="sig-col">
                <div class="sig-title">Penerima</div>
                <div class="sig-line"></div>
                <div class="sig-name">({{ $pemesanan->pengguna->name }})</div>
                <div class="sig-role">Customer</div>
            </td>
        </tr>
    </table>

    <!-- CATATAN -->
    <div class="foot-note">
        * Barang yang sudah diterima tidak dapat dikembalikan kecuali ada perjanjian tertulis<br>
        * Mohon periksa barang sebelum menandatangani surat jalan<br>
        * Dokumen ini adalah bukti resmi pengiriman barang
    </div>
</body>
</html>
