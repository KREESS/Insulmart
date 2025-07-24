@extends('admin.components.app')
    <head>
        <title>@yield('title', 'Dashboard Admin | Insulmart')</title>
        <!-- Tag lain seperti meta, link CSS, dll -->
    </head>
    @section('content')
        <style>
            :root {
                --maroon: #8B0000;
                --maroon-light: #fbeaec;
                --maroon-dark: #560606;
                --maroon-gradient: linear-gradient(135deg, #c24258 0%, #8B0000 100%);
                --radius: 1.2rem;
                --main-padding: 32px;
                --main-padding-mobile: 14px;
            }

            .dashboard-wrapper {
                padding: var(--main-padding) var(--main-padding);
                max-width: 1280px;
                margin: 0 auto;
            }

            @media (max-width: 991.98px) {
                .dashboard-wrapper { padding: 22px 10px; }
            }

            @media (max-width: 575.98px) {
                .dashboard-wrapper { padding: var(--main-padding-mobile); }
            }

            .dashboard-header {
                font-weight: 900;
                color: var(--maroon-dark);
                letter-spacing: 1.6px;
                margin-bottom: 2.1rem;
                background: var(--maroon-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                font-size: 2.25rem;
                text-align: left;
            }

            .stat-card {
                border: none;
                border-radius: var(--radius);
                box-shadow: 0 6px 32px -8px #8B000022;
                background: var(--maroon-gradient);
                color: #fff;
                overflow: hidden;
                position: relative;
                transition: transform 0.18s, box-shadow 0.18s;
                min-height: 135px;
            }

            .stat-card:hover { transform: translateY(-6px) scale(1.03); box-shadow: 0 10px 38px -7px #8B000055; }
            .stat-icon {
                width: 62px; height: 62px;
                border-radius: 50%;
                background: #fff3;
                display: flex; align-items: center; justify-content: center;
                font-size: 2.1rem;
                margin-left: 8px;
                box-shadow: 0 4px 14px -6px #fff;
            }

            .stat-title { font-size: 1.12rem; opacity: .89; font-weight: 500; }
            .stat-value { font-size: 2.45rem; font-weight: 900; margin-bottom: 0; line-height: 1.2; }
            .stat-foot {
                font-size: 0.92rem; margin-top: 0.3rem; color: #ffe2e2cc;
                font-weight: 500;
            }

            .stat-card.bg-produk   { background: linear-gradient(135deg, #F7971E 0%, #8B0000 88%); }
            .stat-card.bg-pesanan  { background: linear-gradient(135deg, #8B0000 0%, #d33048 88%); }
            .stat-card.bg-pelanggan{ background: linear-gradient(135deg, #63c1e0 0%, #8B0000 88%); }
            .stat-card.bg-pendapatan {background: linear-gradient(135deg, #198754 0%, #007d89 88%);}

            .quick-links-box {
                background: #fff;
                border-radius: var(--radius);
                padding: 1.6rem 1.5rem 1.1rem 1.5rem;
                margin: 30px 0 24px 0;
                box-shadow: 0 3px 18px -8px #8B000012;
                display: flex;
                flex-wrap: wrap;
                gap: 1.1rem;
                align-items: center;
                justify-content: start;
            }
            .quick-link {
                display: flex;
                align-items: center;
                gap: 8px;
                background: var(--maroon-light);
                color: var(--maroon);
                padding: 10px 22px;
                border-radius: 8px;
                font-weight: 600;
                text-decoration: none;
                box-shadow: 0 2px 8px #8B000012;
                font-size: 1.07rem;
                transition: background .18s, color .15s, box-shadow .16s;
            }
            .quick-link:hover {
                background: var(--maroon);
                color: #fff;
                transform: translateY(-2px) scale(1.03);
            }
            .quick-link .bi, .quick-link .emoji { font-size: 1.19rem; }

            /* Notif */
            .notif-bar {
                background: #fff6f0;
                color: #8B0000;
                padding: 0.82rem 1.2rem;
                border-radius: 10px;
                font-weight: 600;
                font-size: 1.03rem;
                box-shadow: 0 2px 10px #ffbaba11;
                margin-bottom: 1.8rem;
                display: flex; align-items: center; gap: 9px;
            }
            .notif-bar .bi { font-size: 1.16rem; }
            .notif-bar .badge { background: #F7971E; color: #fff; margin-left: 6px; }

            /* Chart dummy */
            .chart-card {
                background: #fff;
                border-radius: var(--radius);
                box-shadow: 0 3px 20px -10px #8B000019;
                padding: 2.1rem 1.6rem 1.1rem 1.6rem;
                margin-bottom: 2.2rem;
            }
            .chart-title {
                color: var(--maroon-dark); font-weight: 700; font-size: 1.17rem; margin-bottom: .4rem;
            }
            .chart-desc {
                color: #a12c2c; font-size: 1rem; margin-bottom: 1.2rem;
            }

            .chart-placeholder {
                width: 100%; height: 140px;
                background: linear-gradient(90deg, #fae6e6 40%, #faeded 100%);
                border-radius: 10px;
                display: flex; align-items: center; justify-content: center;
                font-size: 1.15rem; color: #a12c2c;
                font-style: italic;
                opacity: 0.7;
            }

            /* Recent activity */
            .recent-activity-box {
                background: #fff;
                border-radius: var(--radius);
                box-shadow: 0 3px 18px -8px #8B000012;
                padding: 2.2rem 1.4rem 1.2rem 1.4rem;
                margin-top: 2.5rem;
            }

            .activity-title {
                font-size: 1.3rem;
                color: var(--maroon-dark);
                font-weight: 700;
                margin-bottom: 1.5rem;
            }

            .activity-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .activity-list li {
                padding: 0.95rem 0.5rem;
                border-bottom: 1px solid #fae6e6;
                font-size: 1.09rem;
                display: flex;
                align-items: flex-start;
                gap: 11px;
                transition: background .11s;
            }

            .activity-list li:last-child { border-bottom: none; }
            .activity-icon {
                font-size: 1.47rem;
                border-radius: 50%;
                width: 36px; height: 36px;
                display: flex; align-items: center; justify-content: center;
                background: var(--maroon-light);
                color: var(--maroon);
                flex-shrink: 0;
            }

            .activity-content b { color: var(--maroon-dark); }
            .activity-date {
                font-size: 0.98rem;
                color: #a12c2c;
                margin-left: auto;
                font-weight: 500;
                white-space: nowrap;
            }    

            /* --- PAGINATION MODERN --- */
            .activity-pagination {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 1.5rem;
                margin-top: 18px;
            }

            .activity-pagination .ap-btn {
                padding: 0.42rem 1.55rem;
                font-weight: 700;
                border: none;
                border-radius: 1.2rem;
                background: linear-gradient(90deg, #a12525 0%, #8B0000 100%);
                color: #fff;
                box-shadow: 0 2px 8px #8b000027;
                letter-spacing: 0.5px;
                font-size: 1rem;
                transition: background 0.18s, transform 0.14s, box-shadow 0.17s;
                outline: none;
            }

            .activity-pagination .ap-btn[disabled] {
                background: #f0e5e5;
                color: #adadad;
                cursor: not-allowed;
                box-shadow: none;
            }

            .activity-pagination .ap-btn:not([disabled]):hover {
                background: linear-gradient(90deg, #8B0000 0%, #a12525 100%);
                transform: translateY(-2px) scale(1.04);
            }

            .activity-pagination .page-indicator {
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .activity-pagination .dot {
                width: 12px; height: 12px;
                border-radius: 50%;
                background: #f2b2b2;
                opacity: 0.4;
                transition: all 0.18s;
                border: 2px solid transparent;
            }

            .activity-pagination .dot.active {
                background: #8B0000;
                opacity: 1;
                border-color: #a12525;
                box-shadow: 0 0 0 2px #8B000044;
            }

            .chart-card {
                background: #fff;
                border-radius: 1.2rem;
                box-shadow: 0 2px 22px -8px #8B000012;
                padding: 2.1rem 1.6rem 1.2rem 1.6rem;
            }

            .chart-title {
                font-size: 1.22rem;
                font-weight: bold;
                color: #8B0000;
                margin-bottom: .25rem;
                letter-spacing: .5px;
            }

            .chart-desc {
                color: #a12525;
                font-size: .99rem;
                margin-bottom: 1.6rem;
            }

            #salesChart {
                width: 100% !important;
                min-height: 120px;
                max-height: 220px;
            }

            @media (max-width: 575.98px) {
                .activity-pagination { gap: 0.65rem; }
                .activity-pagination .ap-btn { padding: 0.28rem 1rem; font-size: .91rem; }
                .activity-pagination .dot { width: 9px; height: 9px; }
            }

            @media (max-width: 991.98px) {
                .stat-value { font-size: 1.65rem; }
                .stat-card { min-height: 110px; }
                .chart-card, .recent-activity-box { padding: 1.2rem 0.7rem; }
                .dashboard-header { font-size: 1.2rem; }
                .activity-title { font-size: 1.08rem; }
                .quick-links-box { padding: 1rem 0.5rem 0.7rem 0.5rem; }
            }

            @media (max-width: 575.98px) {
                .dashboard-header { font-size: 1rem; }
                .activity-list li { font-size: 0.98rem; }
                .stat-value { font-size: 1.12rem; }
                .stat-icon { width: 37px; height: 37px; font-size: 1.09rem; }
            }
        </style>
        <main class="main-content p-4 bg-light" id="mainContent">
            <div class="dashboard-wrapper">
                <div class="dashboard-header mb-4">
                    <span>Selamat Datang, <span style="font-weight:800;">Admin!</span></span>
                </div>

                <div class="notif-bar mb-4">
                    <i class="bi bi-bell-fill"></i> Notifikasi: Ada <span class="badge">{{ $totalPesananMenunggu  }}</span> pesanan baru &nbsp; • &nbsp; <i class="bi bi-lightning-charge"></i> Pantau aktivitas harian di bawah!
                </div>

                {{-- Statistik Card --}}
                <div class="row g-4 mb-1">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card stat-card bg-produk h-100 shadow">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="stat-title">Total Produk</div>
                                    <div class="stat-value">{{ $totalProduk }}</div>
                                    <div class="stat-foot">+{{ rand(1,4) }} hari ini</div>
                                </div>
                                <span class="stat-icon">📦</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card stat-card bg-pesanan h-100 shadow">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="stat-title">Total Pesanan Aktif</div>
                                    <div class="stat-value">{{ $totalPesananAktif }}</div>
                                    <div class="stat-foot">
                                        <span class="badge bg-success me-2" style="font-size: .96em;">✔️ Selesai: {{ $totalPesananSelesai }}</span>
                                        <span class="badge bg-danger" style="font-size: .96em;">❌ Dibatalkan: {{ $totalPesananBatal }}</span>
                                    </div>
                                </div>
                                <span class="stat-icon">🛒</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card stat-card bg-pelanggan h-100 shadow">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="stat-title">Total Pelanggan</div>
                                    <div class="stat-value">{{ $totalPelanggan }}</div>
                                    <div class="stat-foot">+{{ rand(2,7) }} pelanggan baru</div>
                                </div>
                                <span class="stat-icon">👥</span>
                            </div>
                        </div>
                    </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card stat-card bg-pendapatan h-100 shadow">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="stat-title">Pendapatan Hari Ini</div>
                                        <div class="stat-value">Rp {{ number_format($pendapatanHarian, 0, ',', '.') }}</div>
                                        <div class="stat-foot">
                                            <span class="badge bg-info text-dark" style="font-size:.96em;">
                                                {{ \Carbon\Carbon::today()->translatedFormat('l, d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    <span class="stat-icon">📅</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card stat-card bg-pendapatan h-100 shadow">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="stat-title">Pendapatan Minggu Ini</div>
                                        <div class="stat-value">Rp {{ number_format($pendapatanMingguan, 0, ',', '.') }}</div>
                                        <div class="stat-foot">
                                            <span class="badge bg-info text-dark" style="font-size:.96em;">
                                                Minggu ke-{{ \Carbon\Carbon::now()->weekOfYear }}
                                            </span>
                                        </div>
                                    </div>
                                    <span class="stat-icon">📆</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card stat-card bg-pendapatan h-100 shadow">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="stat-title">Pendapatan Bulan Ini</div>
                                        <div class="stat-value">Rp {{ number_format($pendapatanBulanan, 0, ',', '.') }}</div>
                                        <div class="stat-foot">
                                            <span class="badge bg-info text-dark" style="font-size:.96em;">
                                                {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    <span class="stat-icon">💰</span>
                                </div>
                            </div>
                        </div>
                </div>

                {{-- QUICK LINK --}}
                <div class="quick-links-box">
                    <a href="/" class="quick-link"><span class="emoji">🏠</span> Landing Page</a>
                    <a href="/admin/dashboard" class="quick-link"><span class="emoji">📊</span> Dashboard Admin</a>
                    <a href="/admin/produk" class="quick-link"><span class="emoji">🗂️</span> Kelola Produk Admin</a>
                    <a href="/admin/produk/tambah" class="quick-link"><span class="emoji">➕</span> Tambah Produk</a>
                    <a href="#" class="quick-link"><span class="emoji">📑</span> Lihat Semua Pesanan</a>
                    <a href="/admin/pengguna" class="quick-link"><span class="emoji">👤</span> Data Pelanggan</a>
                    <a href="#" class="quick-link"><span class="emoji">⚙️</span> Pengaturan</a>
                </div>

                {{-- DUMMY CHART --}}
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="chart-card">
                            <div class="chart-title">Statistik Pesanan Selesai (Mingguan)</div>
                            <canvas id="ordersChart" height="220"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="chart-card">
                            <div class="chart-title">Total Pendapatan (Mingguan)</div>
                            <canvas id="incomeChart" height="220"></canvas>
                        </div>
                    </div>
                </div>

                @php
                $allActivities = collect();
                foreach($recentOrders as $order) {
                    $allActivities->push([
                        'icon' => '🛒',
                        'type' => 'order',
                        'text' => 'Pesanan baru oleh <b>' . e($order->pengguna->name ?? '-') . '</b>',
                        'date' => $order->created_at->format('d M Y H:i'),
                        'created_at' => $order->created_at->timestamp,
                    ]);
                }
                foreach($recentProducts as $produk) {
                    $allActivities->push([
                        'icon' => '📦',
                        'type' => 'produk',
                        'text' => 'Produk <b>' . e($produk->nama_produk) . '</b> ditambahkan',
                        'date' => $produk->created_at->format('d M Y H:i'),
                        'created_at' => $produk->created_at->timestamp,
                    ]);
                }
                foreach($recentPayments as $pay) {
                    $allActivities->push([
                        'icon' => '💳',
                        'type' => 'pembayaran',
                        'text' => 'Pembayaran oleh <b>' . e($pay->pemesanan->pengguna->name ?? '-') . '</b>',
                        'date' => $pay->created_at->format('d M Y H:i'),
                        'created_at' => $pay->created_at->timestamp,
                    ]);
                }
                $allActivities = $allActivities->sortByDesc('created_at')->values()->all();
                @endphp


                <div class="recent-activity-box">
                    <div class="activity-title">Aktivitas Terbaru</div>
                    <ul class="activity-list" id="activityList"></ul>
                    <div class="activity-pagination" id="activityPagination" style="display:none;">
                        <button id="prevActivity" class="ap-btn" type="button"><i class="bi bi-chevron-left"></i> Prev</button>
                        <div class="page-indicator" id="activityPageDots"></div>
                        <button id="nextActivity" class="ap-btn" type="button">Next <i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </main>

        <script>
            const allActivities = @json($allActivities);
            let currentPage = 1;
            const pageSize = 10;
            const totalPage = Math.ceil(allActivities.length / pageSize);

            function renderActivityPage(page) {
                const list = document.getElementById('activityList');
                list.innerHTML = '';
                const start = (page - 1) * pageSize;
                const end = Math.min(page * pageSize, allActivities.length);
                for (let i = start; i < end; i++) {
                    const act = allActivities[i];
                    let li = document.createElement('li');
                    li.innerHTML = `
                        <span class="activity-icon">${act.icon}</span>
                        <span class="activity-content">${act.text}</span>
                        <span class="activity-date">${act.date}</span>
                    `;
                    list.appendChild(li);
                }
                // Page dots
                const dots = document.getElementById('activityPageDots');
                dots.innerHTML = '';
                for(let i=1; i<=totalPage; i++) {
                    let dot = document.createElement('span');
                    dot.className = 'dot' + (i === page ? ' active' : '');
                    dot.onclick = function() {
                        currentPage = i;
                        renderActivityPage(currentPage);
                    };
                    dots.appendChild(dot);
                }
                // Update button
                document.getElementById('prevActivity').disabled = (page === 1);
                document.getElementById('nextActivity').disabled = (page === totalPage);
                document.getElementById('activityPagination').style.display = (totalPage > 1 ? 'flex' : 'none');
            }

            document.addEventListener('DOMContentLoaded', function() {
                renderActivityPage(currentPage);

                document.getElementById('prevActivity').onclick = function() {
                    if(currentPage > 1) {
                        currentPage--;
                        renderActivityPage(currentPage);
                    }
                };
                document.getElementById('nextActivity').onclick = function() {
                    if(currentPage < totalPage) {
                        currentPage++;
                        renderActivityPage(currentPage);
                    }
                };
            });
        </script>
        <!-- CDN Chart.js (minimal build) -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Pesanan Selesai',
                        data: @json($data),
                        borderRadius: 8,
                        backgroundColor: 'rgba(139,0,0,0.65)',
                        maxBarThickness: 52,
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#8B0000',
                            titleColor: '#fff',
                            bodyColor: '#fff'
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { weight: 'bold', size: 13 }, color: '#8B0000' }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { font: { weight: 'bold', size: 13 }, color: '#8B0000', stepSize: 1 },
                            grid: { color: '#f8e5e5' }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const labels = @json($labels ?? []);
            const orderCounts = @json($orderCounts ?? []);
            const incomes = @json($incomes ?? []);

            // Grafik Jumlah Pesanan
            const ctxOrders = document.getElementById('ordersChart').getContext('2d');
            const ordersChart = new Chart(ctxOrders, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Pesanan',
                        data: orderCounts,
                        backgroundColor: 'rgba(139,0,0,0.7)',
                        borderRadius: 10
                    }]
                },
                options: {
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Grafik Total Pendapatan
            const ctxIncome = document.getElementById('incomeChart').getContext('2d');
            const incomeChart = new Chart(ctxIncome, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Pendapatan (Rp)',
                        data: incomes,
                        backgroundColor: 'rgba(255,99,132,0.12)',
                        borderColor: 'rgba(139,0,0,1)',
                        pointBackgroundColor: 'rgba(139,0,0,1)',
                        fill: true,
                        tension: 0.3,
                        borderWidth: 3
                    }]
                },
                options: {
                    scales: { y: { beginAtZero: true } },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    // Format Rupiah
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        </script>
@endsection
