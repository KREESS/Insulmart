@extends('admin.components.app')

    <head>
        <title>@yield('title', 'Pesanan Admin | Insulmart')</title>
        <!-- Tag lain seperti meta, link CSS, dll -->
    </head>
@section('content')
<style>
  :root {
    --maroon: #8B0000;
    --maroon-light: #fbeaec;
    --maroon-gradient: linear-gradient(135deg, #8B0000 0%, #b44545 100%);
    --gold: #ffc107;
    --teal: #20c997;
    --blue: #0d6efd;
    --gray-100: #f7f7fa;
    --gray-200: #ececf1;
    --radius: 1rem;
  }
  body { background: var(--gray-100); }
  .dashboard-header {
    font-size: 2rem;
    font-weight: 800;
    color: var(--maroon);
    letter-spacing: -1px;
  }
  .info-card {
    border: none;
    border-radius: var(--radius);
    box-shadow: 0 6px 24px rgba(120,0,0,0.06);
    overflow: hidden;
    background: #fff;
    position: relative;
    min-height: 120px;
    transition: transform .2s;
  }
  .info-card:hover { transform: translateY(-6px) scale(1.015);}
  .info-icon {
    font-size: 2.4rem;
    width: 56px; height: 56px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin-right: 1rem;
    box-shadow: 0 2px 10px rgba(139,0,0,0.1);
    color: #fff;
    flex-shrink: 0;
  }
  .icon-maroon { background: var(--maroon-gradient);}
  .icon-gold { background: linear-gradient(120deg, #ffd966 0%, #ffc107 100%);}
  .icon-teal { background: linear-gradient(120deg, #20c997 0%, #64e4c1 100%);}
  .icon-blue { background: linear-gradient(120deg, #0d6efd 0%, #5caaff 100%);}
  .info-stat-title {font-size: 1.06rem;}
  .info-stat-value {font-size: 1.7rem; font-weight: 800; letter-spacing: -1px;}
  .card-section-title { font-size: 1.15rem; font-weight: bold; color: var(--maroon);}
  .summary-mini { font-size: .97rem; color: #777; }

  .summary-box {
    background: var(--maroon-gradient);
    color: #fff;
    border-radius: var(--radius);
    padding: 1.2rem 1.7rem;
    margin-bottom: 1.2rem;
    box-shadow: 0 2px 12px rgba(80,0,0,0.06);
    display: flex; flex-direction:column; align-items:flex-start;
    min-height: 90px;
    position: relative;
  }
  .summary-box .summary-label { font-size: .97rem; opacity:.87; }
  .summary-box .summary-value { font-size: 1.4rem; font-weight: 700;}
  .summary-box .summary-date { font-size: .87rem; opacity:.6; }

  .table-pesanan {
    border-collapse: separate; border-spacing: 0 7px;
    background: none;
  }
  .table-pesanan th, .table-pesanan td {
    vertical-align: middle;
    font-size: .97rem;
    border: none;
    background: #fff;
    box-shadow: 0 1px 6px rgba(180,0,0,0.04);
    transition: background .17s;
  }
  .table-pesanan th {
    background: var(--maroon-gradient);
    color: #fff; font-weight: 600; font-size: 1.03rem;
    border-radius: 0.5rem 0.5rem 0 0;
  }
  .table-pesanan tbody tr:hover td {
    background: var(--maroon-light);
    cursor: pointer;
  }
  .avatar-cust {
    width: 38px; height: 38px; border-radius: 50%;
    object-fit: cover; border:2px solid var(--gray-200); margin-right:7px;
    box-shadow: 0 1px 4px rgba(120,0,0,0.05);
  }
  .address-block { line-height: 1.25; }
  .badge-status {
    font-size: .87em;
    padding: .25em .7em;
    border-radius: .7em;
    font-weight: 700;
    text-transform: capitalize;
    letter-spacing: .03em;
    border: 1.5px solid #eee;
  }
  .status-menunggu { background: #ffe066; color: #a88904; border-color: #fff9cc;}
  .status-diproses { background: #b4eaff; color: #106487; border-color: #e6faff;}
  .status-selesai { background: #c8ffd6; color: #167647; border-color: #e0fff1;}
  .status-dibatalkan { background: #ffd2d8; color: #af344a; border-color: #ffe8ec;}
  .badge-termin {
    background: var(--gold); color: #6e4200; font-weight: 700;
    font-size: .86em; margin-right: 4px;
  }
  .badge-lunas {
    background: var(--teal); color: #fff; font-weight: 700;
    font-size: .87em; margin-left:4px;
    letter-spacing: .01em;
    box-shadow: 0 1px 4px rgba(32,201,151,.13);
  }
  .progress { height: 7px; background: #e3e3e3; border-radius: 7px; overflow: hidden;}
  .progress-bar { background: var(--maroon);}
  .table-actions .btn { margin: 0 2px; }
  .table-responsive { border-radius: var(--radius); overflow: hidden;}
  /* Mini chart placeholder */
  .mini-chart {
    height: 54px; width: 100%;
    background: repeating-linear-gradient(90deg, #fff3, #fff3 2px, #eee 2px, #eee 8px);
    border-radius: .6rem;
    margin: .3rem 0 0.7rem 0;
  }
  .gradient-page-btn,
.gradient-page-btn-active {
  background: linear-gradient(95deg, #8B0000 60%, #c43e4b 100%);
  border: none !important;
  color: #fff !important;
  font-weight: 700;
  border-radius: 2em !important;
  min-width: 38px;
  height: 38px;
  padding: 0 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.08em;
  box-shadow: 0 1px 6px rgba(139,0,0,.08);
  transition: background .16s, transform .12s;
}

.gradient-page-btn:hover,
.gradient-page-btn:focus {
  background: linear-gradient(98deg, #b90a33 60%, #8B0000 100%);
  color: #fff !important;
  transform: translateY(-2px) scale(1.07);
}

.gradient-page-btn-active,
.page-item.active .page-link.gradient-page-btn {
  background: linear-gradient(95deg, #8B0000 70%, #d84559 100%);
  color: #fff !important;
  border: none;
  pointer-events: none;
  box-shadow: 0 2px 12px rgba(139,0,0,0.12);
}

.page-item.disabled .page-link {
  background: #f1f1f3 !important;
  color: #bbb !important;
  border: none !important;
  pointer-events: none;
}

.gradient-action-btn {
  background: linear-gradient(95deg, #8B0000 60%, #c43e4b 100%);
  color: #fff !important;
  border: none;
  font-weight: 600;
  border-radius: 2em;
  min-width: 34px;
  height: 34px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 1.13em;
  box-shadow: 0 1px 6px rgba(139,0,0,.10);
  transition: background .16s, transform .14s, box-shadow .16s;
}
.gradient-action-btn:hover, .gradient-action-btn:focus {
  background: linear-gradient(98deg, #b90a33 60%, #8B0000 100%);
  color: #fff !important;
  transform: translateY(-2px) scale(1.10);
  box-shadow: 0 3px 14px rgba(139,0,0,0.14);
}

.gradient-main-btn {
  background: linear-gradient(95deg, #8B0000 60%, #c43e4b 100%);
  color: #fff !important;
  border: none;
  font-weight: 700;
  border-radius: 2em;
  padding: 0.55rem 1.4rem;
  font-size: 1.09em;
  box-shadow: 0 1px 8px rgba(139,0,0,0.07);
  transition: background .15s, transform .11s;
}
.gradient-main-btn:hover, .gradient-main-btn:focus {
  background: linear-gradient(98deg, #b90a33 60%, #8B0000 100%);
  color: #fff !important;
  transform: translateY(-2px) scale(1.04);
}

.gradient-outline-btn {
  background: #fff;
  color: #8B0000 !important;
  border: 2px solid #c43e4b;
  font-weight: 600;
  border-radius: 2em;
  padding: 0.55rem 1.15rem;
  transition: background .15s, color .13s, border .13s;
}
.gradient-outline-btn:hover, .gradient-outline-btn:focus {
  background: linear-gradient(93deg, #8B0000 60%, #c43e4b 100%);
  color: #fff !important;
  border-color: #8B0000;
}

.gradient-outline-blue-btn {
  background: #fff;
  color: #2470d7 !important;
  border: 2px solid #5caaff;
  font-weight: 600;
  border-radius: 2em;
  padding: 0.55rem 1.15rem;
  transition: background .15s, color .13s, border .13s;
}
.gradient-outline-blue-btn:hover, .gradient-outline-blue-btn:focus {
  background: linear-gradient(93deg, #2470d7 60%, #5caaff 100%);
  color: #fff !important;
  border-color: #2470d7;
}

.status-select.status-menunggu  { background: #ffe066 !important; color: #a88904; }
.status-select.status-diproses  { background: #b4eaff !important; color: #106487; }
.status-select.status-selesai   { background: #c8ffd6 !important; color: #167647; }
.status-select.status-dibatalkan{ background: #ffd2d8 !important; color: #af344a; }
.status-select { border:none; font-weight:700;}
.status-select:focus { outline: 2px solid #c43e4b; }

.badge-status-po {
  font-size: .93em;
  padding: .35em 1em;
  border-radius: 1.2em;
  font-weight: 700;
  letter-spacing: .02em;
}
.status-po-menunggu {
  background: #ffe066;
  color: #a88904;
  border: 1.2px solid #fff7b3;
}
.status-po-disetujui {
  background: #d2ffd7;
  color: #168765;
  border: 1.2px solid #aaffb9;
}
.status-po-ditolak {
  background: #ffd7d7;
  color: #d13232;
  border: 1.2px solid #ffefef;
}

.status-po-select.status-po-menunggu      { background: #ffe066 !important; color: #a88904; }
.status-po-select.status-po-disetujui     { background: #d2ffd7 !important; color: #168765; }
.status-po-select.status-po-ditolak       { background: #ffd7d7 !important; color: #d13232; }
.status-po-select { border:none; font-weight:700; }
.status-po-select:focus { outline: 2px solid #c43e4b; }

.gradient-download-btn {
  background: linear-gradient(95deg, #0d6efd 65%, #60a6ff 100%);
  color: #fff !important;
  border: none;
  font-weight: 600;
  border-radius: 2em;
  padding: 0.48em 1.4em;
  font-size: .99em;
  box-shadow: 0 2px 10px rgba(0,40,200,0.07);
  transition: background .15s, transform .13s;
  display: inline-flex;
  align-items: center;
  gap: .5em;
}

.status-verif-select.status-verif-diterima  { background: #d1e7dd !important; color: #168765; }
.status-verif-select.status-verif-menunggu  { background: #fff3cd !important; color: #856404; }
.status-verif-select.status-verif-ditolak   { background: #f8d7da !important; color: #b21111; }
.status-verif-select { border:none; font-weight:700;}
.status-verif-select:focus { outline: 2px solid #c43e4b; }

.gradient-download-btn:hover, .gradient-download-btn:focus {
  background: linear-gradient(100deg, #388bfd 65%, #0d6efd 100%);
  color: #fff !important;
  transform: translateY(-2px) scale(1.04);
}

.gradient-bukti-btn {
  background: linear-gradient(95deg, #8B0000 60%, #c43e4b 100%);
  color: #fff !important;
  border: none;
  font-weight: 600;
  border-radius: 2em;
  padding: 0.46em 1.4em;
  font-size: .98em;
  box-shadow: 0 2px 10px rgba(139,0,0,0.10);
  transition: background .15s, transform .13s;
  display: inline-flex;
  align-items: center;
  gap: .5em;
}
.gradient-bukti-btn:hover, .gradient-bukti-btn:focus {
  background: linear-gradient(100deg, #b90a33 65%, #8B0000 100%);
  color: #fff !important;
  transform: translateY(-2px) scale(1.04);
}

.btn-gradient-catatan {
  background: linear-gradient(93deg, #8B0000 60%, #c43e4b 100%);
  color: #fff !important;
  border: none;
  border-radius: 2em;
  padding: 0.4em 1.1em;
  font-size: .97em;
  font-weight: 600;
  transition: background .14s, transform .13s;
}
.btn-gradient-catatan:hover, .btn-gradient-catatan:focus {
  background: linear-gradient(100deg, #b90a33 65%, #8B0000 100%);
  color: #fff !important;
  transform: translateY(-2px) scale(1.04);
}
.catatan-input {
  border-radius: 1em 0 0 1em !important;
  font-size: .97em;
}

.modal-detail-content {
  border-radius: 1.3rem;
  overflow: hidden;
}
.gradient-modal-header {
  background: linear-gradient(95deg, #8B0000 55%, #b44545 100%);
  border-bottom: none;
}
.avatar-cust {
  width: 38px; height: 38px; border-radius: 50%; object-fit: cover;
  border: 2px solid #ffe3e3; box-shadow: 0 1px 4px rgba(139,0,0,0.07);
}
.card-info, .card-po {
  border-radius: 1.1em; border: none;
  background: linear-gradient(97deg, #fbeaec 75%, #fff 100%);
  margin-bottom: 1em;
}
.card-section {
  border-radius: 1.1em; border: none;
  background: #fff;
}
.gradient-section-header {
  background: linear-gradient(98deg, #8B0000 70%, #b44545 100%);
  border-radius: 1.1em 1.1em 0 0;
  padding: .65em 1.2em;
  font-size: 1.09em;
  letter-spacing: 0.01em;
}
.address-block { line-height: 1.25;}
.address-info { font-size: .92em; color: #888; margin-left: 1.2em;}
.badge-status {
  font-size: .97em;
  padding: .31em 1.1em;
  border-radius: 1.3em;
  font-weight: 700;
}
.status-menunggu    { background: #ffe066; color: #a88904; }
.status-diproses    { background: #b4eaff; color: #106487; }
.status-selesai     { background: #c8ffd6; color: #167647; }
.status-dibatalkan  { background: #ffd2d8; color: #af344a; }

.status-po-select.status-po-menunggu      { background: #ffe066 !important; color: #a88904; }
.status-po-select.status-po-disetujui     { background: #d2ffd7 !important; color: #168765; }
.status-po-select.status-po-ditolak       { background: #ffd7d7 !important; color: #d13232; }
.status-po-select.status-po-belum-upload  { background: #f5f5f7 !important; color: #aaa; }

.status-verif-select.status-verif-diterima  { background: #d1e7dd !important; color: #168765; }
.status-verif-select.status-verif-menunggu  { background: #fff3cd !important; color: #856404; }
.status-verif-select.status-verif-ditolak   { background: #f8d7da !important; color: #b21111; }

.gradient-download-btn {
  background: linear-gradient(95deg, #0d6efd 65%, #60a6ff 100%);
  color: #fff !important;
  border: none;
  font-weight: 600;
  border-radius: 2em;
  padding: 0.48em 1.4em;
  font-size: .99em;
  box-shadow: 0 2px 10px rgba(0,40,200,0.07);
  transition: background .15s, transform .13s;
  display: inline-flex;
  align-items: center;
  gap: .5em;
}
.gradient-download-btn:hover, .gradient-download-btn:focus {
  background: linear-gradient(100deg, #388bfd 65%, #0d6efd 100%);
  color: #fff !important;
  transform: translateY(-2px) scale(1.04);
}
.gradient-bukti-btn {
  background: linear-gradient(95deg, #8B0000 60%, #c43e4b 100%);
  color: #fff !important;
  border: none;
  font-weight: 600;
  border-radius: 2em;
  padding: 0.46em 1.4em;
  font-size: .98em;
  box-shadow: 0 2px 10px rgba(139,0,0,0.10);
  transition: background .15s, transform .13s;
  display: inline-flex;
  align-items: center;
  gap: .5em;
}
.gradient-bukti-btn:hover, .gradient-bukti-btn:focus {
  background: linear-gradient(100deg, #b90a33 65%, #8B0000 100%);
  color: #fff !important;
  transform: translateY(-2px) scale(1.04);
}
.btn-gradient-catatan {
  background: linear-gradient(93deg, #8B0000 60%, #c43e4b 100%);
  color: #fff !important;
  border: none;
  border-radius: 2em;
  padding: 0.4em 1.1em;
  font-size: .97em;
  font-weight: 600;
  transition: background .14s, transform .13s;
}
.btn-gradient-catatan:hover, .btn-gradient-catatan:focus {
  background: linear-gradient(100deg, #b90a33 65%, #8B0000 100%);
  color: #fff !important;
  transform: translateY(-2px) scale(1.04);
}
.catatan-input {
  border-radius: 1em 0 0 1em !important;
  font-size: .97em;
}

.table-responsive.custom-scroll-x {
  overflow-x: auto;
  /* biar shadow saat scroll */
  box-shadow: 0 1px 8px rgba(139,0,0,0.06);
  border-radius: 1em;
}

.table-responsive.custom-scroll-x::-webkit-scrollbar {
  height: 9px;
  background: #f2f2f4;
  border-radius: 6px;
}
.table-responsive.custom-scroll-x::-webkit-scrollbar-thumb {
  background: linear-gradient(95deg, #8B0000 50%, #b44545 100%);
  border-radius: 8px;
}
@media (max-width: 991px) {
  .table-responsive.custom-scroll-x {
    /* always show horizontal scroll in mobile/tablet */
    overflow-x: scroll;
  }
  .table-pesanan th, .table-pesanan td {
    min-width: 135px;
    white-space: nowrap;
  }
}


  /* Table hide alamat on mobile */
  @media (max-width: 576px) {
    .table-pesanan th:nth-child(5),
    .table-pesanan td:nth-child(5) { display: none; }
  }
</style>
<main class="main-content p-4" id="mainContent">
  <div class="container-fluid">
    {{-- HEADER STATISTIC --}}
    <div class="row g-3 mb-3">
      <div class="col-xl-3 col-md-6">
        <div class="info-card d-flex align-items-center px-3">
          <span class="info-icon icon-maroon"><i class="bi bi-table"></i></span>
          <div>
            <div class="info-stat-title">Total Pesanan</div>
            <div class="info-stat-value">{{ \App\Models\Pemesanan::where('status_pemesanan', '!=', 'selesai')->count() }}</div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="info-card d-flex align-items-center px-3">
          <span class="info-icon icon-gold"><i class="bi bi-cash-stack"></i></span>
          <div>
            <div class="info-stat-title">Pendapatan Selesai</div>
            <div class="info-stat-value">
              Rp {{ number_format(
                  \App\Models\Pemesanan::where('status_pemesanan','selesai')
                  ->sum('total_harga'), 0,',','.'
              ) }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="info-card d-flex align-items-center px-3">
          <span class="info-icon icon-teal"><i class="bi bi-person-check"></i></span>
          <div>
            <div class="info-stat-title">Pesanan Selesai</div>
            <div class="info-stat-value">{{ \App\Models\Pemesanan::where('status_pemesanan','selesai')->count() }}</div>
            <span class="summary-mini">Sampai hari ini</span>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="info-card d-flex align-items-center px-3">
          <span class="info-icon icon-blue"><i class="bi bi-calendar-week"></i></span>
          <div>
            <div class="info-stat-title">Pesanan Minggu Ini</div>
            <div class="info-stat-value">
              {{ \App\Models\Pemesanan::whereBetween('tanggal_pemesanan', [now()->startOfWeek(), now()->endOfWeek()])->count() }}
            </div>
            <span class="summary-mini">Minggu ke-{{ now()->weekOfYear }}</span>
          </div>
        </div>
      </div>
    </div>

    {{-- RINGKASAN HARIAN / MINGGUAN --}}
    <div class="row g-3 mb-3">
      <div class="col-lg-6 col-md-12">
        <div class="summary-box">
          <div class="summary-label">Pendapatan Hari Ini</div>
          <div class="summary-value">
            Rp {{ number_format(
              \App\Models\Pemesanan::whereDate('tanggal_pemesanan', now()->toDateString())
                ->where('status_pemesanan','selesai')
                ->sum('total_harga'), 0,',','.'
            ) }}
          </div>
          <div class="summary-date">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12">
        <div class="summary-box" style="background: linear-gradient(95deg, #20c997 0%, #6ae8d2 100%); color:#fff;">
          <div class="summary-label">Pesanan Baru Hari Ini</div>
          <div class="summary-value">
            {{ \App\Models\Pemesanan::whereDate('tanggal_pemesanan', now()->toDateString())->count() }}
          </div>
          <div class="summary-date">Update {{ now()->format('H:i') }} WIB</div>
        </div>
      </div>
    </div>

    {{-- FILTER & RESET --}}
    <div class="card p-3 mb-3 shadow-sm" style="border-radius: 1rem;">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-2">
        <div>
          <h2 class="dashboard-header mb-0" style="font-size:1.4rem;">
            <i class="bi bi-clipboard-data"></i> Data Pesanan
          </h2>
        </div>
        <div>
        <a href="{{ route('admin.pesanan') }}" class="btn gradient-outline-btn btn-sm me-2">
            <i class="bi bi-arrow-clockwise"></i> Reset Filter
        </a>
        <div class="btn-group">
            <button type="button" class="btn gradient-outline-blue-btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-download"></i> Ekspor Data
            </button>
            <ul class="dropdown-menu shadow border-0">
                <li>
                <a class="dropdown-item" href="{{ route('admin.pesanan.export', request()->all()) }}">
                    <i class="bi bi-funnel"></i> Ekspor Data Ini Saja
                </a>
                </li>
                <li>
                <a class="dropdown-item" href="{{ route('admin.pesanan.export', ['all'=>'1']) }}">
                    <i class="bi bi-list-ul"></i> Ekspor Semua Data
                </a>
                </li>
            </ul>
        </div>
        </div>

      </div>
      <form class="row gx-2 gy-2 align-items-center" method="GET">
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" name="search" value="{{ request('search') }}"
                  class="form-control" placeholder="Cari nama / kode / email…">
          </div>
        </div>
        <div class="col-md-3">
          <select name="status" class="form-select">
            <option value="">Semua Status</option>
            @foreach(['menunggu','diproses','selesai','dibatalkan'] as $st)
              <option value="{{ $st }}" {{ request('status')==$st?'selected':'' }}>
                {{ ucfirst($st) }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
            <button class="btn gradient-main-btn w-100" type="submit">
            <i class="bi bi-funnel"></i> Terapkan
            </button>
        </div>
      </form>
    </div>

    {{-- TABEL PESANAN --}}
      <div class="table-responsive custom-scroll-x">
        <table class="table table-pesanan align-middle mb-0">
          <thead>
            <tr>
              <th>No</th><th>Kode Pesanan</th><th>Tanggal</th><th>Pelanggan</th>
              <th>Alamat</th><th>Produk</th><th>Total</th>
              <th>Status Pemesanan</th><th>Termin Pembayaran</th><th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          @forelse($pemesanans as $i => $o)
            @php
              $paid  = $o->pembayaran->where('status_verifikasi','diterima')->count();
              $total = $o->pembayaran->count();
              $pct   = $total ? round(100*$paid/$total) : 0;
              $cust  = $o->pengguna;
            @endphp
            <tr>
              <td>{{ $pemesanans->firstItem()+$i }}</td>
              <td><strong>{{ $o->kode_pemesanan }}</strong></td>
              <td>
                {{ \Carbon\Carbon::parse($o->tanggal_pemesanan)->format('d M Y H.i') }}
                <div class="small text-muted">{{ \Carbon\Carbon::parse($o->tanggal_pemesanan)->diffForHumans() }}</div>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <span>{{ $cust->name }}</span>
                </div>
                <div class="small text-muted">{{ $cust->email ?? '-' }}</div>
                <div class="small text-muted">{{ $cust->nomor_telepon ?? '-' }}</div>
              </td>
              <td>
                @php $a = $o->alamatPengiriman; @endphp
                @if($a)
                  <div class="address-block">
                    <span>
                      <i class="bi bi-geo-alt-fill text-danger"></i>
                      <span class="fw-bold">{{ $a->alamat_lengkap }}</span>
                    </span>
                    <div class="address-info">
                      {{ $a->village }}, Kec. {{ $a->district }},
                      {{ $a->regency }}, Prov. {{ $a->province }},
                      {{ $a->kode_pos }}
                    </div>
                  </div>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td>
                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">
                  {{ $o->detailPemesanan->count() }} item
                </span>
              </td>
            <td style="white-space: nowrap;">Rp {{ number_format($o->total_harga,0,',','.') }}</td>
        <td>
        <form class="form-inline update-status-form" method="POST" action="{{ route('admin.pesanan.updateStatus', $o->id) }}">
            @csrf
            @method('PATCH')
            <select name="status_pemesanan"
                class="form-select form-select-sm status-select fw-bold mb-1 status-{{ $o->status_pemesanan }}"
                style="min-width:110px; font-size:.95em; padding: 0.25em 0.75em;">
                @foreach(['menunggu','diproses','selesai','dibatalkan'] as $st)
                <option value="{{ $st }}"
                    {{ $o->status_pemesanan == $st ? 'selected' : '' }}>
                    {{ ucfirst($st) }}
                </option>
                @endforeach
            </select>

            </div>
        </form>
        </td>

              <td style="min-width:110px">
                <div class="progress mb-1">
                  <div class="progress-bar" role="progressbar"
                      style="width:{{ $pct }}%" aria-valuenow="{{ $pct }}"
                      aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small>{{ $paid }}/{{ $total }} termin</small>
                @if($pct===100)
                  <span class="badge badge-lunas ms-1"><i class="bi bi-patch-check-fill"></i> Lunas</span>
                @endif
              </td>
            <td class="table-actions">
                <a class="btn btn-sm gradient-action-btn me-1"
                    data-bs-toggle="modal" data-bs-target="#detail{{ $o->id }}"
                    title="Lihat Detail">
                <i class="bi bi-eye"></i>
                </a>
            </td>

            </tr>
          @empty
            <tr>
              <td colspan="10"
                  class="text-center py-4 text-muted">Belum ada pesanan.</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
      <div class="px-3 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2 border-top" style="border-radius:0 0 1.1rem 1.1rem; background: #fbeaec;">
        <small class="fw-semibold text-maroon" style="font-size:1.05rem;">
          Menampilkan {{ $pemesanans->firstItem() }}–{{ $pemesanans->lastItem() }}
          dari <b>{{ $pemesanans->total() }}</b> entri
        </small>
        <div>
          {{-- Custom Pagination --}}
          @if ($pemesanans->hasPages())
            <nav>
              <ul class="pagination mb-0" style="--maroon: #8B0000; --maroon-light: #d84559;">
                {{-- Previous --}}
                <li class="page-item {{ $pemesanans->onFirstPage() ? 'disabled' : '' }}">
                  <a class="page-link gradient-page-btn" href="{{ $pemesanans->previousPageUrl() ?? '#' }}" aria-label="Previous"
                    style="margin-right:6px;">
                    <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                  </a>
                </li>
                {{-- Page Numbers --}}
                @foreach ($pemesanans->getUrlRange(1, $pemesanans->lastPage()) as $page => $url)
                  @if ($page == $pemesanans->currentPage())
                    <li class="page-item active" aria-current="page">
                      <span class="page-link gradient-page-btn-active">{{ $page }}</span>
                    </li>
                  @elseif(abs($page - $pemesanans->currentPage()) < 3 || $page == 1 || $page == $pemesanans->lastPage())
                    <li class="page-item">
                      <a class="page-link gradient-page-btn" href="{{ $url }}">{{ $page }}</a>
                    </li>
                  @elseif($page == $pemesanans->currentPage() - 3 || $page == $pemesanans->currentPage() + 3)
                    <li class="page-item disabled"><span class="page-link text-muted border-0 bg-transparent">…</span></li>
                  @endif
                @endforeach
                {{-- Next --}}
                <li class="page-item {{ !$pemesanans->hasMorePages() ? 'disabled' : '' }}">
                  <a class="page-link gradient-page-btn" href="{{ $pemesanans->nextPageUrl() ?? '#' }}" aria-label="Next" style="margin-left:6px;">
                    <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                  </a>
                </li>
              </ul>
            </nav>
          @endif
        </div>
      </div>

    </div>

@foreach($pemesanans as $o)
<div class="modal fade" id="detail{{ $o->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content modal-detail-content shadow-lg border-0">
      <div class="modal-header gradient-modal-header">
        <h5 class="modal-title text-white fw-bold">
          <i class="bi bi-receipt me-2"></i> Pesanan #{{ $o->kode_pemesanan }}
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body py-4">
        {{-- SECTION: Info Utama --}}
        <div class="row g-3 mb-2 align-items-start">
          <div class="col-lg-7 col-md-6">
            <div class="card card-body card-info shadow-sm mb-3">
              <dl class="row mb-0">
                <dt class="col-sm-4">Pelanggan</dt>
                <dd class="col-sm-8 d-flex align-items-center">
                  <img 
                      src="{{ $o->pengguna->profile_photo_path && file_exists(public_path($o->pengguna->profile_photo_path)) 
                          ? asset($o->pengguna->profile_photo_path) 
                          : asset('images/default-avatar.png') }}" 
                      width="38"
                      height="38"
                      class="avatar-cust me-2 rounded-circle"
                      style="object-fit: cover;"
                      alt="user">
                  <span class="fw-bold">{{ $o->pengguna->name }}</span>
                </dd>
                <dt class="col-sm-4">Email</dt>
                <dd class="col-sm-8 text-break">{{ $o->pengguna->email }}</dd>
                <dt class="col-sm-4">No HP</dt>
                <dd class="col-sm-8">{{ $o->pengguna->nomor_telepon }}</dd>
                <dt class="col-sm-4">Alamat</dt>
                <dd class="col-sm-8">
                  @php $a = $o->alamatPengiriman; @endphp
                  @if($a)
                  <div class="address-block">
                    <span>
                      <i class="bi bi-geo-alt-fill text-danger"></i>
                      <span class="fw-bold">{{ $a->alamat_lengkap }}</span>
                    </span>
                    <div class="address-info">
                      {{ $a->village }}, Kec. {{ $a->district }},
                      {{ $a->regency }}, Prov. {{ $a->province }},
                      {{ $a->kode_pos }}
                    </div>
                  </div>
                  @else
                  <span class="text-muted">-</span>
                  @endif
                </dd>
                <dt class="col-sm-4">Metode Bayar</dt>
                <dd class="col-sm-8">{{ $o->metode_pembayaran }}</dd>
                <dt class="col-sm-4">Catatan Pel.</dt>
                <dd class="col-sm-8 text-break">{{ $o->catatan_pelanggan ?: '-' }}</dd>
                <dt class="col-sm-4">Status Pemesanan</dt>
                <dd class="col-sm-8">
                  <span id="detail-status-{{ $o->id }}" class="badge-status status-{{ $o->status_pemesanan }}">
                    {{ ucfirst($o->status_pemesanan) }}
                  </span>
                </dd>
                <dt class="col-sm-4">Total Harga</dt>
                <dd class="col-sm-8 fw-bold text-maroon">Rp {{ number_format($o->total_harga,0,',','.') }}</dd>
                @if(in_array($o->status_pemesanan, ['diproses', 'selesai']))
                <dt class="col-sm-4">Surat Jalan</dt>
                <dd class="col-sm-8">
                  <a href="{{ route('admin.pesanan.suratJalan', $o->id) }}" 
                     class="btn gradient-download-btn"
                     target="_blank">
                     <i class="bi bi-file-earmark-text"></i> Download Surat Jalan
                  </a>
                </dd>
                @endif
              </dl>
            </div>
          </div>
          <div class="col-lg-5 col-md-6">
            <div class="card card-body card-po shadow-sm mb-3">
              <dl class="row mb-0">
                <dt class="col-5">Nomor PO</dt>
                <dd class="col-7">{{ $o->nomor_po ?? '-' }}</dd>
                <dt class="col-5">File PO</dt>
                <dd class="col-7">
                  @if(!empty($o->file_po))
                    <a href="{{ asset($o->file_po) }}"
                       class="btn btn-sm gradient-download-btn"
                       target="_blank">
                       <i class="bi bi-file-earmark-arrow-down"></i> Lihat / Download
                    </a>
                  @else
                    <span class="text-muted">Belum upload</span>
                  @endif
                </dd>
                <dt class="col-5">Status PO</dt>
                <dd class="col-7">
                  <div style="max-width:170px;">
                    <form class="form-inline update-status-po-form" method="POST" action="{{ route('admin.pesanan.updateStatusPo', $o->id) }}">
                      @csrf
                      @method('PATCH')
                      <select name="status_po"
                          class="form-select form-select-sm status-po-select fw-bold status-po-{{ $o->status_po }}"
                          style="width:100%; font-size:.97em;">
                        @if(empty($o->file_po))
                          <option value="belum upload" selected>Belum upload</option>
                        @endif
                        @foreach(['menunggu','disetujui','ditolak'] as $st)
                        <option value="{{ $st }}"
                            {{ (!empty($o->file_po) && $o->status_po == $st) ? 'selected' : '' }}
                            {{ empty($o->file_po) ? 'disabled' : '' }}>
                            {{ ucfirst($st) }}
                        </option>
                        @endforeach
                      </select>
                    </form>
                  </div>
                </dd>
              </dl>
            </div>
          </div>
        </div>

        {{-- SECTION: Armada Pengiriman --}}
        <div class="mb-3">
          <div class="card card-section shadow-sm">
            <div class="card-header gradient-section-header text-white fw-bold">
              <i class="bi bi-truck me-1"></i> Armada Pengiriman
            </div>
            <div class="card-body p-2">
              <div class="table-responsive">
                <table class="table table-sm mb-0">
                  <thead>
                    <tr>
                      <th>Jenis Armada</th>
                      <th>Jumlah Unit</th>
                      <th>Jarak (KM)</th>
                      <th>Tarif/KM</th>
                      <th>Ongkir</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($o->armadaPemesanan->count() > 0)
                      @foreach($o->armadaPemesanan as $ap)
                      <tr>
                        <td>{{ $ap->armada->nama }}</td>
                        <td>{{ $ap->jumlah_mobil }} Unit</td>
                        <td>{{ $ap->jarak_km }} KM</td>
                        <td>Rp {{ number_format($ap->armada->tarif_per_km, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($ap->subtotal_ongkir, 0, ',', '.') }}</td>
                      </tr>
                      @endforeach
                      <tr>
                        <td colspan="4" class="text-end fw-bold">Total Ongkir:</td>
                        <td class="fw-bold">Rp {{ number_format($o->armadaPemesanan->sum('subtotal_ongkir'), 0, ',', '.') }}</td>
                      </tr>
                    @else
                      <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada armada yang ditentukan</td>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        {{-- SECTION: Produk Dipesan --}}
        <div class="mb-3">
          <div class="card card-section shadow-sm">
            <div class="card-header gradient-section-header text-white fw-bold">
              <i class="bi bi-box-seam me-1"></i> Produk Dipesan
            </div>
            <div class="card-body p-2">
              <div class="table-responsive">
                <table class="table table-sm mb-0">
                  <thead>
                    <tr>
                      <th>Gambar Produk</th><th>Produk</th><th>Varian</th><th>Qty</th><th>Ketersediaan</th>
                      <th>Harga</th><th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($o->detailPemesanan as $d)
                    <tr>
                      <td>
                        @php
                          $gambar = $d->varianProduk->produk->gambars->first();
                        @endphp
                        @if($gambar)
                          <img src="{{ asset('storage/' . $gambar->path) }}" alt="Gambar {{ $d->varianProduk->produk->nama_produk }}" style="width:48px; height:48px; object-fit:cover; border-radius:7px;">
                        @else
                          <span style="color:#999; font-size:13px;">Tidak ada gambar</span>
                        @endif
                      </td>
                      <td>{{ $d->varianProduk->produk->nama_produk }}</td>
                      <td>{{ $d->varianProduk->tipe }}</td>
                      <td>{{ $d->kuantitas }} Ball/Pack</td>
                      <td>{{ $d->status_ketersediaan }}</td>
                      <td>Rp {{ number_format($d->harga_satuan,0,',','.') }}</td>
                      <td>Rp {{ number_format($d->subtotal,0,',','.') }}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        {{-- SECTION: Termin & Pembayaran --}}
        <div>
          <div class="card card-section shadow-sm">
            <div class="card-header gradient-section-header text-white fw-bold">
              <i class="bi bi-cash-stack me-1"></i> Pembayaran Termin
            </div>
            <div class="card-body p-2">
              <div class="table-responsive">
                <table class="table table-sm mb-0">
                  <thead>
                    <tr>
                      <th>Termin</th><th>Jumlah</th><th>Tanggal</th>
                      <th>Status</th><th>Bukti</th><th>Catatan</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($o->pembayaran as $p)
                    <tr>
                      <td>{{ $p->termin_ke }}</td>
                      <td>Rp {{ number_format($p->jumlah_dibayar,0,',','.') }}</td>
                      <td>{{ optional(\Carbon\Carbon::parse($p->tanggal_pembayaran))->format('d/m/Y H.i') }}</td>
                      <td>
                          @if($p->bukti_transfer)
                            <form class="form-inline update-status-verif-form" method="POST"
                                  action="{{ route('admin.pembayaran.updateStatusVerif', $p->id) }}">
                              @csrf
                              @method('PATCH')
                              <select name="status_verifikasi"
                                class="form-select form-select-sm status-verif-select fw-bold status-verif-{{ $p->status_verifikasi }}"
                                style="min-width:110px; font-size:.96em; padding: 0.25em 0.75em;">
                                @foreach(['diterima','menunggu','ditolak'] as $verif)
                                  <option value="{{ $verif }}" {{ $p->status_verifikasi == $verif ? 'selected' : '' }}>
                                    {{ ucfirst($verif) }}
                                  </option>
                                @endforeach
                              </select>
                            </form>
                          @else
                            <span class="badge bg-secondary"
                                  style="font-size:.93em; padding:.32em 1em; border-radius:1.1em; font-weight:700;">
                              Belum Bayar
                            </span>
                          @endif
                      </td>
                      <td>
                        @if($p->bukti_transfer)
                          <a href="{{ asset($p->bukti_transfer) }}" target="_blank"
                            class="btn btn-sm gradient-bukti-btn">
                            <i class="bi bi-eye"></i> Lihat Bukti
                          </a>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td>
                        <form class="update-catatan-form" method="POST" action="{{ route('admin.pembayaran.updateCatatan', $p->id) }}">
                          @csrf
                          @method('PATCH')
                          <div class="input-group input-group-sm">
                            <input type="text"
                              name="catatan_admin"
                              class="form-control catatan-input"
                              value="{{ $p->catatan_admin }}"
                              placeholder="Tambah catatan…"
                              maxlength="250"
                              style="min-width: 110px; max-width: 200px;"
                              data-id="{{ $p->id }}">
                            <button class="btn btn-gradient-catatan" type="submit" title="Simpan">
                              <i class="bi bi-send"></i>
                            </button>
                          </div>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach

  </div>
</main>

@push('scripts')
<script>
document.querySelectorAll('.update-status-form .status-select').forEach(function(sel){
    sel.addEventListener('change', function(){
        var form = this.closest('form');
        var formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                // Update class select agar warna sesuai status baru
                sel.classList.remove('status-menunggu', 'status-diproses', 'status-selesai', 'status-dibatalkan');
                sel.classList.add('status-' + sel.value);
                // (Optional) Beri feedback sukses
                // showToast('Status berhasil diupdate');
            } else {
                alert(data.message || 'Gagal update status!');
            }
        }).catch(e=>{
            alert('Gagal update status!');
        });
    });
});

document.querySelectorAll('.update-status-form .status-select').forEach(function(sel){
    sel.addEventListener('change', function(){
        var form = this.closest('form');
        var formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                // Update warna select
                sel.classList.remove('status-menunggu', 'status-diproses', 'status-selesai', 'status-dibatalkan');
                sel.classList.add('status-' + sel.value);

                // === Tambahan: Update badge status di detail modal ===
                var pesananId = form.action.match(/(\d+)/g).pop(); // dapatkan id pesanan dari url action
                var badge = document.getElementById('detail-status-' + pesananId);
                if(badge){
                    badge.textContent = sel.options[sel.selectedIndex].text;
                    badge.className = 'badge-status status-' + sel.value;
                }
            } else {
                alert(data.message || 'Gagal update status!');
            }
        }).catch(e=>{
            alert('Gagal update status!');
        });
    });
});

document.querySelectorAll('.update-status-po-form .status-po-select').forEach(function(sel){
    sel.addEventListener('change', function(){
        var form = this.closest('form');
        var formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                sel.classList.remove('status-po-menunggu', 'status-po-disetujui', 'status-po-ditolak', 'status-po-belum-upload');
                sel.classList.add('status-po-' + sel.value.replace(' ', '-'));
                // Optional: Toast sukses
            } else {
                alert(data.message || 'Gagal update status PO!');
            }
        }).catch(e=>{
            alert('Gagal update status PO!');
        });
    });
});

document.querySelectorAll('.update-status-verif-form .status-verif-select').forEach(function(sel){
    sel.addEventListener('change', function(){
        var form = this.closest('form');
        var formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                sel.classList.remove('status-verif-diterima', 'status-verif-menunggu', 'status-verif-ditolak');
                sel.classList.add('status-verif-' + sel.value);
                // Optional: Show toast sukses
            } else {
                alert(data.message || 'Gagal update status verifikasi!');
            }
        }).catch(e=>{
            alert('Gagal update status verifikasi!');
        });
    });
});

document.querySelectorAll('.update-catatan-form').forEach(function(form){
  form.addEventListener('submit', function(e){
    e.preventDefault();
    var input = form.querySelector('.catatan-input');
    var formData = new FormData(form);
    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': formData.get('_token'),
        'Accept': 'application/json'
      },
      body: formData
    })
    .then(r => r.json())
    .then(data => {
      if(data.success){
        // Optionally: Tampilkan notifikasi sukses
        input.classList.add('is-valid');
        setTimeout(()=>input.classList.remove('is-valid'), 1000);
      } else {
        input.classList.add('is-invalid');
      }
    }).catch(e=>{
      input.classList.add('is-invalid');
    });
  });
});
</script>
@endpush

@endsection
