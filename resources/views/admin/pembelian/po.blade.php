<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>{{ $kodePo }} — CV. INSULMART INDONESIA</title>
  <style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #111; }
    .header { /* flex kurang didukung dompdf, tapi header ini sederhana */ display:flex; justify-content:space-between; align-items:center; margin-bottom: 16px; }
    .title { font-size: 18px; font-weight: bold; text-transform: uppercase; }
    .meta  { font-size: 12px; color:#555; text-align:right; }
    .box   { border:1px solid #ddd; border-radius:8px; padding:12px; margin-bottom:12px; }
    .box h4 { margin:0 0 6px 0; font-size: 13px; text-transform:uppercase; }
    table { width:100%; border-collapse: collapse; }
    th, td { border: 1px solid #e5e5e5; padding:8px; text-align:left; vertical-align: top; }
    th { background:#f7f7f7; }
    .right { text-align:right; }
    .muted { color:#666; }

    /* TTD styles */
    .ttd-box { text-align: right; }
    .ttd-label { font-weight: bold; margin-bottom: 6px; }
    .ttd-img { height: 70px; margin: 6px 0; }
    .ttd-nama { font-weight: bold; letter-spacing: .3px; }
    .small { font-size: 11px; color: #555; }
  </style>
</head>
<body>
  <div class="header">
    <div class="title">Purchase Order (PO)</div>
    <div class="meta">
      <div><strong>No. PO:</strong> {{ $kodePo }}</div>
      <div>
        <strong>Tanggal:</strong>
        @php
          // pastikan $pembelian->tanggal_beli dicast ke datetime di Model
          $tglWIB = $pembelian->tanggal_beli?->copy()->timezone('Asia/Jakarta');
        @endphp
        {{ $tglWIB ? ($tglWIB->format('H:i') !== '00:00' ? $tglWIB->format('d M Y H:i') : $tglWIB->format('d M Y')) : '-' }}
      </div>
    </div>
  </div>

  {{-- Identitas Pembeli & Pemasok --}}
  <div class="box">
    <table style="border:0;">
      <tr>
        <td style="width:50%; border:0;">
          <h4>Pembeli (Buyer)</h4>
          <strong>CV. INSULMART INDONESIA</strong><br>
          Telp: 021-29470622, 021-22889956 <br>
          Email: insulmart@gmail.com<br>
          NPWP: 1000-0000-0424-4481
        </td>
        <td style="width:50%; border:0;">
          <h4>Pemasok (Supplier)</h4>
          <strong>{{ $supplier->nama ?? '-' }}</strong><br>
          {{ $supplier->alamat ?? '—' }}<br>
          Telp: {{ $supplier->telepon ?? '—' }} &middot; Email: {{ $supplier->email ?? '—' }}<br>
          NPWP: {{ $supplier->npwp ?? '—' }}
        </td>
      </tr>
      <tr>
        <td style="border:0;">
          <h4>Kirim Ke (Ship To)</h4>
          Gudang CV. INSULMART INDONESIA<br>
          Alamat Gudang: JL. RAYA TARUMAJAYA NO. 13 RT 001 RW 029 DESA SETIA ASIH, Kec. Tarumajaya, Kab. Bekasi<br>
          17215
        </td>
        <td style="border:0;">
          <h4>Tagih Ke (Bill To)</h4>
          CV. INSULMART INDONESIA &middot; Finance<br>
          Email: insulmart@gmail.com
        </td>
      </tr>
    </table>
  </div>

  {{-- Ringkasan Produk --}}
  <div class="box">
    <strong>Produk:</strong> {{ optional($pembelian->varian->produk)->nama_produk ?? '-' }}<br>
    <strong>Varian:</strong> {{ $pembelian->varian->tipe ?? '-' }}<br>
    <strong>Status:</strong> {{ str_replace('_',' ', ucfirst($pembelian->status)) }}<br>
    @if($pembelian->catatan)
      <strong>Catatan:</strong> {{ $pembelian->catatan }}
    @endif
  </div>

  {{-- Tabel Item --}}
  <table>
    <thead>
      <tr>
        <th>Deskripsi Barang</th>
        <th class="right">Qty</th>
        <th class="right">Harga Satuan (Rp)</th>
        <th class="right">Total (Rp)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ optional($pembelian->varian->produk)->nama_produk ?? '-' }} — {{ $pembelian->varian->tipe ?? '-' }}</td>
        <td class="right">{{ number_format($pembelian->qty, 0, ',', '.') }}</td>
        <td class="right">{{ number_format($pembelian->harga_satuan, 0, ',', '.') }}</td>
        <td class="right">{{ number_format($pembelian->total_harga, 0, ',', '.') }}</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3" class="right">Grand Total</th>
        <th class="right">{{ number_format($pembelian->total_harga, 0, ',', '.') }}</th>
      </tr>
    </tfoot>
  </table>

  {{-- Tanda Tangan --}}
  <table style="width:100%; margin-top:24px; border:0;">
    <tr>
      <td style="width:50%; border:0; vertical-align:top;">
        <div><strong>Disetujui oleh (Pemasok),</strong></div>
        <div style="margin-top:56px;">__________________________</div>
        <div class="meta">{{ $supplier->nama ?? 'Nama Pemasok' }}</div>
      </td>
      <td style="width:50%; border:0; vertical-align:top; text-align:right;">
        <div class="ttd-box" style="margin-left: 24px;">
          <div class="ttd-label">Hormat Kami,</div>
          <img src="{{ public_path('/assets/img/ttd.png') }}" alt="Tanda Tangan" class="ttd-img">
          <div class="ttd-nama">YUDHISTIRA JALU</div>
          <div class="small">Jakarta, {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}</div>
        </div>
      </td>
    </tr>
  </table>
</body>
</html>
