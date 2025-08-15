<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>{{ $po_code }} — CV. INSULMART INDONESIA</title>
  <style>
    /* ====== Reset ringan & token ====== */
    * { box-sizing: border-box; }
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #111; margin: 24px; }
    .muted { color:#666; }
    .right { text-align:right; }
    .center { text-align:center; }

    /* ====== Branding / warna ====== */
    .brand { color:#8B0000; } /* maroon tua */
    .chip {
      display:inline-block; background:#fbeaec; color:#8B0000; border:1px solid #f0cfd2;
      padding:4px 8px; border-radius:12px; font-weight:bold; letter-spacing:.3px;
    }

    /* ====== Blocks & box ====== */
    .section { margin-bottom: 14px; }
    .box { border:1px solid #e5d7da; border-radius:8px; padding:12px; background:#fff; }
    .box-title { font-weight:bold; text-transform:uppercase; font-size:12px; margin:0 0 8px 0; color:#8B0000; }
    .divider { height:1px; background:#eee; margin:10px 0; }

    /* ====== Header ====== */
    .header-table { width:100%; border-collapse:collapse; margin-bottom: 12px; }
    .header-table td { vertical-align:top; }
    .head-po { border:1px solid #e5d7da; background:#fbeaec; border-radius:8px; padding:10px; }
    .title { font-size:18px; font-weight:bold; text-transform:uppercase; margin:0 0 6px 0; }
    .meta { font-size:12px; color:#555; }
    .subtitle { font-size:11px; color:#444; }

    /* ====== Two columns table (buyer / supplier) ====== */
    .twocol { width:100%; border-collapse:separate; border-spacing:12px 0; }
    .twocol td { width:50%; vertical-align:top; padding:0; }

    /* ====== Key-value mini table ====== */
    table.kv { width:100%; border-collapse:collapse; }
    table.kv td { padding:2px 0; vertical-align:top; }
    table.kv .k { width:90px; color:#555; }
    table.kv .v { }

    /* ====== Items table ====== */
    table.items { width:100%; border-collapse:collapse; }
    table.items th, table.items td { border: 1px solid #e5e5e5; padding:8px; vertical-align:top; }
    table.items th { background:#faf5f6; color:#7b0f0f; font-weight:bold; }
    .w-desc { width:58%; }
    .w-qty  { width:10%; }
    .w-price{ width:16%; }
    .w-total{ width:16%; }

    /* ====== Totals box ====== */
    .totals { width:100%; border-collapse:separate; border-spacing:0; margin-top:10px; }
    .totals td { padding:6px 8px; }
    .totals .label { text-align:right; color:#333; }
    .totals .value { text-align:right; font-weight:bold; }

    /* ====== Signatures ====== */
    .sign { width:100%; margin-top:24px; border-collapse:collapse; }
    .sign td { vertical-align:top; padding-top:6px; }
    .sign .line { margin-top:70px; border-top:1px solid #777; height:1px; }
    .small { font-size:11px; color: #555; }

    /* Hindari page-break di blok penting */
    .avoid-break { page-break-inside: avoid; }
  </style>
</head>
<body>

  {{-- ===== HEADER ===== --}}
  <table class="header-table">
    <tr>
      <td>
        <div class="title brand">Purchase Order (PO)</div>
        <div class="subtitle">CV. INSULMART INDONESIA</div>
      </td>
      <td class="right">
        <div class="head-po">
          <div class="chip">No. PO: {{ $po_code }}</div>
          <div class="meta" style="margin-top:6px;">
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

  {{-- ===== BUYER & SUPPLIER ===== --}}
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

  <div class="section avoid-break">
    <table class="twocol">
      <tr>
        <td>
          <div class="box">
            <div class="box-title">Pembeli (Buyer)</div>
            <strong>CV. INSULMART INDONESIA</strong><br>
            Telp: 021-29470622, 021-22889956<br>
            Email: insulmartindonesia@gmail.com<br>
            NPWP: 1000-0000-0424-4481
            <div class="divider"></div>
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
            <div style="font-size:14px; font-weight:bold; margin-bottom:2px;">
              {{ $namaSupplier }}
              @if($cp)<span class="muted" style="font-weight:normal;"> <br> PIC: {{ $cp }}</span>@endif
            </div>

            {{-- Alamat lengkap tersusun dari bawah --}}
            @if(count($alamatBlock))
              @foreach($alamatBlock as $line)
                {{ $line }}<br>
              @endforeach
            @else
              —<br>
            @endif

            <div class="divider"></div>
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

  {{-- ===== ITEMS TABLE ===== --}}
  <div class="section avoid-break">
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
              <div class="muted">Varian: {{ $it->varian->tipe ?? '-' }}</div>
              @if($it->catatan)
                <div class="muted">Catatan: {{ $it->catatan }}</div>
              @endif
            </td>
            <td class="right">{{ number_format((int)$it->qty, 0, ',', '.') }}</td>
            <td class="right">{{ number_format((int)$it->harga_satuan, 0, ',', '.') }}</td>
            <td class="right">{{ number_format((int)$it->total_harga, 0, ',', '.') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    {{-- ===== TOTALS BOX (inline styles) ===== --}}
    <table style="width:100%; border-collapse:collapse; margin-top:12px;">
      <tr>
        <td style="border:0; padding:0; text-align:right;">
          <!-- Kotak ringkasan di kanan -->
          <table style="
            display:inline-table; width:360px;
            border-collapse:separate; border-spacing:0;
            border:1px solid #e5d7da; border-radius:8px; overflow:hidden;
            background:#fff;
          ">
            <tr style="background:#faf5f6;">
              <td style="padding:8px 10px; text-align:right; color:#333; border-bottom:1px solid #e5d7da;">
                Subtotal Qty
              </td>
              <td style="padding:8px 10px; text-align:right; font-weight:bold; border-bottom:1px solid #e5d7da;">
                {{ number_format((int) $totalQty, 0, ',', '.') }}
              </td>
            </tr>
            <tr>
              <td style="padding:10px; text-align:right; color:#8B0000; font-weight:bold;">
                Grand Total
              </td>
              <td style="padding:10px; text-align:right; font-weight:bold; color:#8B0000;">
                Rp {{ number_format((int) $grandTotal, 0, ',', '.') }}
              </td>
            </tr>
          </table>
          <!-- /Kotak ringkasan -->
        </td>
      </tr>
    </table>
  </div>

  {{-- ===== SIGNATURES ===== --}}
  <table class="sign avoid-break">
    <tr>
      <td style="width:50%; vertical-align:top;">
        <div><strong>Disetujui oleh (Pemasok),</strong></div>

        {{-- Garis tanda tangan: lebih pendek + jarak atas lebih besar --}}
        <div style="margin-top: 95px; width: 220px; border-top: 1px solid #777;"></div>

        <div style="font-weight:bold; margin-top:8px;">{{ $namaSupplier }}</div>
        <div class="small">Tanda tangan &amp; stempel</div>
      </td>

      <td style="width:50%; text-align:right;">
        <div><strong>Hormat Kami,</strong></div>
        @if(file_exists(public_path('/assets/img/ttd.png')))
          <img src="{{ public_path('/assets/img/ttd.png') }}" alt="Tanda Tangan" style="height:72px; margin: 6px 0;">
        @else
          <div class="line"></div>
        @endif
        <div style="font-weight:bold; margin-top:6px;">YUDHISTIRA JALU</div>
        <div class="small">Bekasi, {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}</div>
      </td>
    </tr>
  </table>

</body>
</html>
