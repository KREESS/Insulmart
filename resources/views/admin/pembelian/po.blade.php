<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>{{ $po_code }} — CV. INSULMART INDONESIA</title>
  <style>
    /* ====== Reset & token ====== */
    * { box-sizing: border-box; }
    body {
      font-family: DejaVu Sans, Arial, sans-serif;
      font-size: 10px;                 /* 12 -> 10: lebih hemat */
      color: #111;
      margin: 12px;                    /* 24 -> 12 */
      line-height: 1.25;               /* 1.3 -> 1.25 */
    }
    .muted { color:#666; }
    .right { text-align:right; }
    .center { text-align:center; }
    .nowrap { white-space:nowrap; }

    /* ====== Branding / warna ====== */
    .brand { color:#8B0000; }
    .chip {
      display:inline-block; background:#fbeaec; color:#8B0000; border:1px solid #f0cfd2;
      padding:2px 6px;                 /* 4x8 -> 2x6 */
      border-radius:10px;
      font-weight:700; letter-spacing:.2px;
      font-size: 9px;                  /* 12 -> 9 */
    }

    /* ====== Blocks & box ====== */
    .section { margin-bottom: 10px; }   /* 14 -> 10 */
    .box {
      border:1px solid #e5d7da;
      border-radius:4px;               /* 8 -> 4 */
      padding:8px;                     /* 12 -> 8 */
      background:#fff;
    }
    .box-title {
      font-weight:700; text-transform:uppercase;
      font-size:10px;                  /* 12 -> 10 */
      margin:0 0 6px 0;                /* 8 -> 6 */
      color:#8B0000;
      letter-spacing:.2px;
    }
    .divider { height:1px; background:#eee; margin:8px 0; } /* 10 -> 8 */

    /* ====== Header ====== */
    .header-table { width:100%; border-collapse:collapse; margin-bottom: 8px; } /* 12 -> 8 */
    .header-table td { vertical-align:top; }
    .head-po { border:1px solid #e5d7da; background:#fbeaec; border-radius:4px; padding:6px; } /* 10 -> 6 */
    .title { font-size:14px; font-weight:700; text-transform:uppercase; margin:0 0 4px 0; } /* 18 -> 14 */
    .meta { font-size:9px; color:#444; } /* 12 -> 9 */
    .subtitle { font-size:9.5px; color:#444; } /* 11 -> 9.5 */

    /* ====== Two columns compact (buyer / supplier) ====== */
    .twocol { width:100%; border-collapse:separate; border-spacing:8px 0; } /* 12 -> 8 */
    .twocol td { width:50%; vertical-align:top; padding:0; }

    /* ====== Key-value mini table (padat) ====== */
    table.kv { width:100%; border-collapse:collapse; }
    table.kv td { padding:1px 0; vertical-align:top; }        /* 2px -> 1px */
    table.kv .k { width:72px; color:#555; }                   /* 90 -> 72 */
    table.kv .v { }

    /* ====== Items table (padat) ====== */
    table.items { width:100%; border-collapse:collapse; }
    table.items th, table.items td {
      border: 1px solid #e5e5e5;
      padding:4px 6px;                                       /* 8 -> 4x6 */
      vertical-align:top;
      line-height: 1.2;
      font-size: 9.5px;                                      /* 10 -> 9.5 */
    }
    table.items th {
      background:#faf5f6; color:#7b0f0f; font-weight:700;
    }
    .w-desc { width:56%; }   /* 58 -> 56 */
    .w-qty  { width:10%; }
    .w-price{ width:16%; }
    .w-total{ width:18%; }   /* 16 -> 18 agar ruang angka cukup */

    /* ====== Totals box (ringkas) ====== */
    .totals-wrap { width:100%; border-collapse:collapse; margin-top:8px; } /* 12 -> 8 */
    .summary {
      display:inline-table; width:320px;                      /* 360 -> 320 */
      border-collapse:separate; border-spacing:0;
      border:1px solid #e5d7da; border-radius:4px; overflow:hidden;
      background:#fff; font-size:9.5px;
    }
    .summary td { padding:6px 8px; }                          /* 8-10 -> 6-8 */
    .summary .head { background:#faf5f6; border-bottom:1px solid #e5d7da; color:#333; }
    .summary .label { text-align:right; color:#8B0000; font-weight:700; }
    .summary .value { text-align:right; font-weight:700; color:#8B0000; white-space:nowrap; }

    /* ====== Signatures (hemat) ====== */
    .sign { width:100%; margin-top:16px; border-collapse:collapse; } /* 24 -> 16 */
    .sign td { vertical-align:top; padding-top:4px; }
    .sign .line { margin-top:52px; width:200px; border-top:1px solid #777; height:1px; } /* lebih pendek */
    .small { font-size:9px; color:#555; }                     /* 11 -> 9 */

    /* ====== Cetak ====== */
    @media print {
      body { margin: 8mm; font-size: 9.5px; }                 /* sedikit lebih kecil saat print */
      .section { margin-bottom: 8px; }
      .box, .head-po { border-radius: 0; }
      .summary { width: 300px; }                              /* lebih hemat ruang di print */
      /* Biarkan tabel item boleh terpotong halaman untuk efisiensi */
      .avoid-break { page-break-inside: avoid; }
    }
  </style>
</head>
<body>

  {{-- ===== HEADER (ringkas) ===== --}}
  <table class="header-table">
    <tr>
      <td>
        <div class="title brand">Purchase Order (PO)</div>
        <div class="subtitle">CV. INSULMART INDONESIA</div>
      </td>
      <td class="right">
        <div class="head-po">
          <div class="chip">No. PO: {{ $po_code }}</div>
          <div class="meta" style="margin-top:4px;">
            <strong>Tanggal:</strong>
            @php
              $firstWIB = isset($firstDate) && $firstDate ? \Carbon\Carbon::parse($firstDate)->timezone('Asia/Jakarta') : null;
              $lastWIB  = isset($lastDate)  && $lastDate  ? \Carbon\Carbon::parse($lastDate)->timezone('Asia/Jakarta')  : null;
            @endphp
            @if($firstWIB && $lastWIB)
              @if($firstWIB->isSameDay($lastWIB))
                {{ $firstWIB->format('d M Y') }}
              @else
                {{ $firstWIB->format('d M Y') }} — {{ $lastWIB->format('d M Y') }}
              @endif
            @else
              -
            @endif
          </div>
        </div>
      </td>
    </tr>
  </table>

  {{-- ===== BUYER & SUPPLIER (ringkas & efisien) ===== --}}
  @php
    // Supplier detail (Distributor model)
    $namaSupplier   = optional($supplier)->name_pt ?? '-';
    $cp             = optional($supplier)->contact_person ?: null;
    $telepon        = optional($supplier)->phone ?? '—';
    $emailSup       = optional($supplier)->email ?? '—';
    $npwpSup        = optional($supplier)->npwp ?? '—';
    $alamatLengkap  = trim(optional($supplier)->alamat_lengkap ?? '');

    $rt = trim(optional($supplier)->rt ?? '');
    $rw = trim(optional($supplier)->rw ?? '');
    $rtRw = ($rt || $rw) ? ('RT '.($rt ?: '—').' / RW '.($rw ?: '—')) : '';

    $village  = optional($supplier)->village;
    $district = optional($supplier)->district;
    $regency  = optional($supplier)->regency;
    $province = optional($supplier)->province;
    $kodePos  = optional($supplier)->kode_pos;
    $coord    = trim(optional($supplier)->coordinate ?? '');

    $barisWilayah  = collect([$village, $district, $regency])->filter()->implode(', ');
    $provKode      = ($province ? ' - '.$province : '') . ($kodePos ? ' '.$kodePos : '');

    // address block yang “dari bawah” & lengkap
    $alamatBlock = [];
    if ($alamatLengkap !== '') { $alamatBlock[] = $alamatLengkap; }
    if ($rtRw !== '')          { $alamatBlock[] = $rtRw; }
    if ($barisWilayah !== '' || $provKode !== '') {
      $alamatBlock[] = trim($barisWilayah.$provKode);
    }
    if ($coord !== '') { $alamatBlock[] = 'Koordinat: '.$coord; }
  @endphp

  <div class="section">
    <table class="twocol">
      <tr>
        <td>
          <div class="box">
            <div class="box-title">Pembeli (Buyer)</div>
            <div style="font-weight:700; margin-bottom:2px;">CV. INSULMART INDONESIA</div>
            <div class="muted">Telp: 021-29470622, 021-22889956 <br> Email: insulmartindonesia@gmail.com <br> NPWP: 1000-0000-0424-4481</div>
            <div class="divider" style="margin:6px 0;"></div>
            <table class="kv">
              <tr>
                <td class="k">Ship To</td>
                <td class="v">
                  Gudang CV. INSULMART INDONESIA<br>
                  JL. RAYA TARUMAJAYA NO. 13 RT 001 RW 029, DESA SETIA ASIH, Kec. Tarumajaya, Kab. Bekasi — 17215
                </td>
              </tr>
              <tr>
                <td class="k">Bill To</td>
                <td class="v">CV. INSULMART INDONESIA · Finance (insulmartindonesia@gmail.com)</td>
              </tr>
            </table>
          </div>
        </td>
        <td>
          <div class="box">
            <div class="box-title">Pemasok (Supplier)</div>
            <div style="font-weight:700; margin-bottom:2px;">
              {{ $namaSupplier }}
              @if($cp)<span class="muted" style="font-weight:400;"> · PIC: {{ $cp }}</span>@endif
            </div>

            {{-- Alamat lengkap tersusun dari bawah (disatukan bila pendek) --}}
            @if(count($alamatBlock))
              @php $lines = implode(' · ', $alamatBlock); @endphp
              <div>{{ $lines }}</div>
            @else
              <div>—</div>
            @endif

            <div class="divider" style="margin:6px 0;"></div>
            <table class="kv">
              <tr>
                <td class="k">Telepon</td><td class="v">{{ $telepon }}</td>
              </tr>
              <tr>
                <td class="k">Email</td><td class="v">{{ $emailSup }}</td>
              </tr>
              <tr>
                <td class="k">NPWP</td><td class="v">{{ $npwpSup }}</td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>

  {{-- ===== ITEMS TABLE (padat) ===== --}}
  <div class="section">
    <table class="items">
      <thead>
        <tr>
          <th class="w-desc">Deskripsi Barang</th>
          <th class="w-qty right">Qty</th>
          <th class="w-price right">Harga Satuan (Rp)</th>
          <th class="w-total right">Total (Rp)</th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $it)
          <tr>
            <td>
              <div><strong>{{ optional($it->varian->produk)->nama_produk ?? '-' }}</strong></div>
              <div class="muted">Varian: {{ $it->varian->tipe ?? '-' }}@if($it->catatan) · Catatan: {{ $it->catatan }}@endif</div>
            </td>
            <td class="right nowrap">{{ number_format((int)$it->qty, 0, ',', '.') }}</td>
            <td class="right nowrap">{{ number_format((int)$it->harga_satuan, 0, ',', '.') }}</td>
            <td class="right nowrap">{{ number_format((int)$it->total_harga, 0, ',', '.') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    {{-- ===== TOTALS BOX (ringkas) ===== --}}
    <table class="totals-wrap">
      <tr>
        <td style="border:0; padding:0; text-align:right;">
          <table class="summary">
            <tr class="head">
              <td class="right">Subtotal Qty</td>
              <td class="right nowrap" style="font-weight:700;">
                {{ number_format((int) $totalQty, 0, ',', '.') }}
              </td>
            </tr>
            <tr>
              <td class="label">Grand Total</td>
              <td class="value nowrap">Rp {{ number_format((int) $grandTotal, 0, ',', '.') }}</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>

  {{-- ===== SIGNATURES (hemat ruang) ===== --}}
  <table class="sign">
    <tr>
      <td style="width:50%; vertical-align:top;">
        <div><strong>Disetujui oleh (Pemasok),</strong></div>
        <div class="line" style="margin-top:75px;"></div>
        <div style="font-weight:700; margin-top:6px;">{{ $namaSupplier }}</div>
        <div class="small">Tanda tangan &amp; stempel</div>
      </td>

      <td style="width:50%; text-align:right;">
        <div><strong>Hormat Kami,</strong></div>
        @if(file_exists(public_path('/assets/img/ttd.png')))
          <img src="{{ public_path('/assets/img/ttd.png') }}" alt="Tanda Tangan" style="height:60px; margin: 4px 0;">
        @else
          <div class="line" style="margin-left:auto;"></div>
        @endif
        <div style="font-weight:700; margin-top:4px;">YUDHISTIRA JALU</div>
        <div class="small">Bekasi, {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') }}</div>
      </td>
    </tr>
  </table>

</body>
</html>
