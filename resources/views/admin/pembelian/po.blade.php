<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>{{ $kodePo }} — CV INSULMART INDONESIA</title>
  <style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #111; }
    .header { display:flex; justify-content:space-between; align-items:center; margin-bottom: 16px; }
    .title { font-size: 18px; font-weight: bold; text-transform: uppercase; }
    .meta  { font-size: 12px; color:#555; text-align:right; }
    .box   { border:1px solid #ddd; border-radius:8px; padding:12px; margin-bottom:12px; }
    .box h4 { margin:0 0 6px 0; font-size: 13px; text-transform:uppercase; }
    table { width:100%; border-collapse: collapse; }
    th, td { border: 1px solid #e5e5e5; padding:8px; text-align:left; vertical-align: top; }
    th { background:#f7f7f7; }
    .right { text-align:right; }
    .muted { color:#666; }
  </style>
</head>
<body>
  <div class="header">
    <div class="title">Purchase Order (PO)</div>
    <div class="meta">
      <div><strong>No. PO:</strong> {{ $kodePo }}</div>
      <div><strong>Tanggal:</strong> {{ optional($pembelian->tanggal_beli)->format('d M Y H:i') ?? '-' }}</div>
    </div>
  </div>

  {{-- Identitas Pembeli & Pemasok --}}
  <div class="box">
    <table>
      <tr>
        <td style="width:50%;">
          <h4>Pembeli (Buyer)</h4>
          <strong>CV INSULMART INDONESIA</strong><br>
          Jl. ..................................................<br>
          Telp: 08xx-xxxx-xxxx &middot; Email: admin@insulmart.co.id<br>
          NPWP: — <span class="muted">(opsional)</span>
        </td>
        <td style="width:50%;">
          <h4>Pemasok (Supplier)</h4>
          <strong>{{ $supplier->nama ?? '-' }}</strong><br>
          {{ $supplier->alamat ?? '—' }}<br>
          Telp: {{ $supplier->telepon ?? '—' }} &middot; Email: {{ $supplier->email ?? '—' }}<br>
          NPWP: {{ $supplier->npwp ?? '—' }}
        </td>
      </tr>
      <tr>
        <td>
          <h4>Kirim Ke (Ship To)</h4>
          Gudang CV INSULMART INDONESIA<br>
          Alamat Gudang: ......................................
        </td>
        <td>
          <h4>Tagih Ke (Bill To)</h4>
          CV INSULMART INDONESIA &middot; Finance<br>
          Email: finance@insulmart.co.id
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
  <div style="margin-top:24px; display:flex; justify-content:space-between;">
    <div>
      <div><strong>Disetujui oleh (Pemasok),</strong></div>
      <div style="margin-top:56px;">__________________________</div>
      <div class="meta">Nama & Tanda Tangan</div>
    </div>
    <div>
      <div><strong>Hormat Kami,</strong></div>
      <div style="margin-top:56px;">__________________________</div>
      <div class="meta">CV INSULMART INDONESIA</div>
    </div>
  </div>
</body>
</html>
