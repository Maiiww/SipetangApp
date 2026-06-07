<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Statistik - SIPETANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
            min-height: 100vh;
            color: #1f2937;
        }

        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #0a3b99 0%, #1d65d0 100%);
            color: white;
            padding: 34px 26px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            box-shadow: 4px 0 36px rgba(0, 0, 0, 0.18);
            overflow-y: auto;
            z-index: 20;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 38px;
            font-weight: 700;
        }

        .sidebar-logo-box {
            background: white;
            width: 62px;
            height: 62px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12);
        }

        .sidebar-logo-image {
            width: 86%;
            height: 86%;
            object-fit: contain;
        }

        .sidebar-logo-text h3 {
            font-size: 18px;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .sidebar-logo-text p {
            font-size: 11px;
            opacity: 0.82;
            margin: 4px 0 0;
            line-height: 1.35;
        }

        .sidebar-menu {
            flex: 1;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 12px;
        }

        .sidebar-menu a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 18px;
            border-radius: 18px;
            transition: background 0.25s ease, transform 0.15s ease, color 0.25s ease;
            font-size: 15px;
            font-weight: 700;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        .sidebar-menu a.active {
            background: #ffffff;
            color: #0a3b99;
            box-shadow: 0 14px 30px rgba(9, 45, 112, 0.14);
        }

        .sidebar-menu a.active i {
            color: #0a3b99;
        }

        .sidebar-menu a:active {
            transform: scale(0.98);
        }

        .sidebar-menu i {
            width: 20px;
            text-align: center;
            font-size: 18px;
        }

        .sidebar-logout {
            margin-top: auto;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.18);
        }

        .sidebar-logout-button {
            color: #ffffff;
            background: #1a4d7d;
            border-radius: 25px;
            padding: 12px 20px;
            width: 100%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-logout-button:hover {
            background: #0f3a5f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .sidebar-logout-button i {
            font-size: 16px;
        }

        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .date-selector {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: #f5f5f5;
            border-radius: 6px;
            font-size: 13px;
            color: #333;
        }

        .header-icons {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .header-icon {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s;
        }

        .header-icon:hover {
            background: #e0e0e0;
        }

        /* Profile Modal Styles */
        .profile-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
        }

        .profile-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-modal-content {
            background-color: white;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .profile-modal-header {
            background: linear-gradient(135deg, #0d2640 0%, #1a4d7d 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .profile-modal-close {
            position: absolute;
            right: 20px;
            top: 20px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .profile-modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border: 3px solid white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 32px;
            font-weight: 700;
        }

        .profile-name {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .profile-role {
            font-size: 12px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-modal-body {
            padding: 30px;
        }

        .profile-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .profile-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .profile-item-icon {
            width: 40px;
            height: 40px;
            background: #e3f2fd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1976d2;
            font-size: 18px;
            flex-shrink: 0;
        }

        .profile-item-content {
            flex: 1;
        }

        .profile-item-label {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .profile-item-value {
            font-size: 14px;
            color: #0d2640;
            font-weight: 500;
        }

        .profile-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .profile-status.active {
            background: #d4edda;
            color: #155724;
        }

        .profile-status.inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .page-title {
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 600;
            color: #1a4d7d;
            margin-bottom: 5px;
        }

        .page-title p {
            font-size: 14px;
            color: #666;
        }

        .stats-panel {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card,
        .insight-card,
        .detail-card,
        .region-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }

        .chart-card {
            min-height: 360px;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }

        .chart-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }

        .chart-header span {
            font-size: 12px;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .chart-meta {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .meta-pill {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            padding: 8px 14px;
            font-size: 12px;
            color: #475569;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .meta-pill i {
            color: #1d4ed8;
        }

        .chart-area {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 220px;
            background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
            border-radius: 16px;
            position: relative;
            overflow: hidden;
        }

        .chart-area::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top, rgba(59, 130, 246, 0.12), transparent 35%);
        }

        .chart-svg {
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 1;
        }

        .chart-line {
            stroke: #0d2640;
            stroke-width: 4;
            fill: none;
        }

        .chart-grid {
            stroke: #e2e8f0;
            stroke-width: 1;
        }

        .chart-axis text,
        .chart-axis tspan {
            fill: #94a3b8;
            font-size: 11px;
        }

        .key-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .key-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 22px;
        }

        .key-card .label {
            font-size: 11px;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.12em;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .key-card .value {
            font-size: 34px;
            font-weight: 700;
            color: #0d2640;
            margin-bottom: 6px;
        }

        .key-card .note {
            font-size: 13px;
            color: #64748b;
        }

        .insight-card h3 {
            font-size: 14px;
            margin-bottom: 18px;
            color: #0f172a;
        }

        .insight-item {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: center;
            margin-bottom: 18px;
        }

        .insight-item:last-child {
            margin-bottom: 0;
        }

        .insight-meta {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .insight-meta strong {
            font-size: 16px;
            color: #0d2640;
        }

        .insight-meta small {
            color: #64748b;
            font-size: 12px;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #0d2640, #1a4d7d);
        }

        .region-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .region-info h2 {
            margin: 0 0 12px;
            font-size: 18px;
            color: #0f172a;
        }

        .region-info p {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .region-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 14px;
        }

        .region-list li {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .region-status {
            font-size: 11px;
            font-weight: 700;
            color: #0d2640;
            background: #eff6ff;
            padding: 5px 10px;
            border-radius: 999px;
        }

        .map-card {
            background: white;
            border-radius: 18px;
            min-height: 400px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        #map {
            width: 100%;
            height: 400px;
            border-radius: 16px;
        }

        .leaflet-control-attribution {
            display: none;
        }

        .map-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            z-index: 1;
        }

        .map-dot {
            position: absolute;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #0d2640;
            box-shadow: 0 0 0 6px rgba(13, 37, 64, 0.12);
        }

        .map-dot.dot-1 {
            top: 32%;
            left: 28%;
        }

        .map-dot.dot-2 {
            top: 54%;
            left: 64%;
        }

        .map-dot.dot-3 {
            top: 68%;
            left: 44%;
        }

        .dashboard-footer {
            text-align: center;
            font-size: 11px;
            color: #999;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        @media (max-width: 1024px) {
            .stats-panel {
                grid-template-columns: 1fr;
            }

            .region-card {
                grid-template-columns: 1fr;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                flex-direction: row;
                padding: 20px;
            }

            .sidebar-menu {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .sidebar-menu li {
                margin-bottom: 0;
            }

            .sidebar-logout {
                margin-top: 20px;
                border-top: none;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }

            .header-right {
                width: 100%;
                justify-content: space-between;
                flex-wrap: wrap;
            }

            .search-box {
                max-width: 100%;
            }

            .chart-card,
            .insight-card,
            .detail-card,
            .region-card {
                padding: 20px;
            }

            .meta-pill,
            .date-selector,
            .btn-input {
                width: 100%;
            }

            .header-icons {
                justify-content: flex-end;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <div class="main-content">
        <div class="header">
            <div class="header-right">
                <div class="header-icons">
                    <a href="#" style="text-decoration: none; color: inherit;" onclick="openProfileModal(event)">
                        <div class="header-icon" style="cursor: pointer;"><i class="fas fa-user"
                                style="color: #1a4d7d;"></i></div>
                    </a>
                </div>
            </div>
        </div>

        <div class="page-title">
            <h1>Data Statistik</h1>
            <p>Analisis komprehensif sektor kelautan dan perikanan Kabupaten Subang. Visualisasi data real-time untuk
                mendukung pengambilan keputusan administratif.</p>
        </div>

        <div class="stats-panel">
            <div class="chart-card">
                <div class="chart-header">
                    <div>
                        <h2>Produksi Ikan Bulanan</h2>
                        <div class="chart-meta">
                            <span class="meta-pill"><i class="fas fa-chart-line"></i> Data kumulatif tangkapan laut
                                (Ton) - {{ now()->year }}</span>
                        </div>
                    </div>
                    <span class="meta-pill"><i class="fas fa-water"></i> Tangkapan Laut</span>
                </div>
                <div class="chart-area">
                    <canvas id="produksiChart"></canvas>
                </div>
            </div>

            <div class="insight-card">
                <h3>Komoditas Teratas</h3>
                @foreach ($komoditasTop as $item)
                    <div class="insight-item">
                        <div class="insight-meta">
                            <strong>{{ $item['nama'] }}</strong>
                            <small>{{ $item['persentase'] }}%</small>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $item['persentase'] }}%;"></div>
                        </div>
                    </div>
                @endforeach
                <small style="display:block; margin-top:18px; color:#64748b; font-size:12px;">Terakhir diperbarui:
                    {{ now()->format('d M Y') }}</small>
            </div>
        </div>

        <div class="key-cards">
            <div class="key-card">
                <div class="label"><i class="fas fa-exclamation-triangle"></i> TPI Teraktif</div>
                <div class="value">{{ $tpiTeraktif['nama'] }}</div>
                <div class="note">{{ $tpiTeraktif['totalLaporan'] }} Laporan</div>
            </div>
            <div class="key-card">
                <div class="label"><i class="fas fa-boxes"></i> Total Produksi</div>
                <div class="value">{{ $totalProduksi['totalFormatted'] }} <span
                        style="font-size: 18px; color:#64748b;">{{ $totalProduksi['unit'] }}</span></div>
                <div class="note">Pertumbuhan +{{ $totalProduksi['growth'] }}%</div>
            </div>
        </div>

        <div class="region-card">
            <div class="region-info">
                <h2>Sebaran Tempat Pelelangan Ikan (TPI)</h2>
                <p>Data lengkap 8 Tempat Pelelangan Ikan di Kabupaten Subang. Pantau aktivitas perikanan secara
                    geografis untuk mengambil keputusan alokasi sumber daya dan logistik.</p>
                <ul class="region-list" style="margin-top: 20px;">
                    <li><span>Patimban</span></li>
                    <li><span>Genteng</span></li>
                    <li><span>Mayangan</span></li>
                    <li><span>Cirewang</span></li>
                    <li><span>Muara Ciasem</span></li>
                    <li><span>Blanakan</span></li>
                    <li><span>Rawameneng</span></li>
                    <li><span>Cilamaya Girang</span></li>
                </ul>
            </div>
            <div class="map-card">
                <div id="map"></div>
            </div>

            <script>
                // Data Produksi Ikan Bulanan dari Server
                const produksiData = @json($produksiBulanan);

                // Extract labels dan values
                const labels = produksiData.map(item => item.month);
                const values = produksiData.map(item => item.value);

                // Buat Chart
                const ctx = document.getElementById('produksiChart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Produksi (Ton)',
                            data: values,
                            borderColor: '#0d2640',
                            backgroundColor: 'rgba(13, 38, 64, 0.08)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#0d2640',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: {
                                    size: 13,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 12
                                },
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y.toFixed(2) + ' Ton';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.5)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 11
                                    },
                                    callback: function(value) {
                                        return value + '';
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
            </script>

            <script>
                // Inisialisasi peta Leaflet
                const map = L.map('map').setView([-6.24, 107.76], 11);

                // Tambahkan tile layer dari OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'OpenStreetMap',
                    maxZoom: 19
                }).addTo(map);

                // Data TPI dengan koordinat yang akurat
                const tpiLocations = [{
                        name: 'Patimban',
                        lat: -6.2499579,
                        lng: 107.9193405
                    },
                    {
                        name: 'Genteng',
                        lat: -6.2344311,
                        lng: 107.8773191
                    },
                    {
                        name: 'Mayangan',
                        lat: -6.212156,
                        lng: 107.783512
                    },
                    {
                        name: 'Cirewang',
                        lat: -6.1911136,
                        lng: 107.8493557
                    },
                    {
                        name: 'Muara Ciasem',
                        lat: -6.236964,
                        lng: 107.7012623
                    },
                    {
                        name: 'Blanakan',
                        lat: -6.2703712,
                        lng: 107.6631992
                    },
                    {
                        name: 'Rawameneng',
                        lat: -6.2427331,
                        lng: 107.6281886
                    },
                    {
                        name: 'Cilamaya Girang',
                        lat: -6.2223626,
                        lng: 107.6240459
                    }
                ];

                // Tambahkan marker untuk setiap TPI
                tpiLocations.forEach(function(tpi) {
                    L.circleMarker([tpi.lat, tpi.lng], {
                        radius: 8,
                        fillColor: '#0d2640',
                        color: '#0d2640',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).bindPopup('<strong>' + tpi.name + '</strong>').addTo(map);
                });
            </script>
        </div>

        <div class="dashboard-footer">
            SISTEM INFORMASI PENCATATAN HASIL TANGKAP
        </div>

        <!-- Profile Modal -->
        <div id="profileModal" class="profile-modal">
            <div class="profile-modal-content">
                <div class="profile-modal-header">
                    <button class="profile-modal-close" onclick="closeProfileModal()">&times;</button>
                    <div class="profile-avatar">
                        {{ strtoupper(substr(Auth::user()->nama ?? Auth::user()->username, 0, 2)) }}</div>
                    <div class="profile-name">{{ Auth::user()->nama ?? Auth::user()->username }}</div>
                    <div class="profile-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
                <div class="profile-modal-body">
                    <div class="profile-item">
                        <div class="profile-item-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="profile-item-content">
                            <div class="profile-item-label">Lokasi Penempatan</div>
                            <div class="profile-item-value">{{ Auth::user()->wilayah ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="profile-item">
                        <div class="profile-item-icon">
                            <i class="fas fa-venus-mars"></i>
                        </div>
                        <div class="profile-item-content">
                            <div class="profile-item-label">Jenis Kelamin</div>
                            <div class="profile-item-value">{{ Auth::user()->jenis_kelamin ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="profile-item">
                        <div class="profile-item-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="profile-item-content">
                            <div class="profile-item-label">No. Telepon</div>
                            <div class="profile-item-value">{{ Auth::user()->no_telepon ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="profile-item">
                        <div class="profile-item-icon">
                            <i class="fas fa-map-pin"></i>
                        </div>
                        <div class="profile-item-content">
                            <div class="profile-item-label">Alamat</div>
                            <div class="profile-item-value">{{ Auth::user()->alamat ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="profile-item">
                        <div class="profile-item-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="profile-item-content">
                            <div class="profile-item-label">Status</div>
                            @if (Auth::user()->is_active ?? true)
                                <span class="profile-status active">Aktif</span>
                            @else
                                <span class="profile-status inactive">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // === PROFILE MODAL ===
        function openProfileModal(event) {
            event.preventDefault();
            document.getElementById('profileModal').classList.add('active');
        }

        function closeProfileModal() {
            document.getElementById('profileModal').classList.remove('active');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('profileModal');
            if (event.target === modal) {
                closeProfileModal();
            }
        }
    </script>
</body>

</html>
