<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Statistik - SIPETANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
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
            background: rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 14px 18px;
            width: 100%;
            border: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.25s ease;
        }

        .sidebar-logout-button:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar-logout-button i {
            font-size: 18px;
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
                <div class="date-selector">
                    <i class="fas fa-calendar"></i>
                    <span>Mei 2026</span>
                </div>
                <div class="header-icons">
                    <div class="header-icon"><i class="fas fa-bell" style="color: #1a4d7d;"></i></div>
                    <div class="header-icon"><i class="fas fa-cog" style="color: #1a4d7d;"></i></div>
                    <div class="header-icon"><i class="fas fa-user" style="color: #1a4d7d;"></i></div>
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
                                (Ton) - 2025</span>
                        </div>
                    </div>
                    <span class="meta-pill"><i class="fas fa-water"></i> Tangkapan Laut</span>
                </div>
                <div class="chart-area">
                    <svg class="chart-svg" viewBox="0 0 800 240" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="chartFill" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#0d2640" stop-opacity="0.22" />
                                <stop offset="100%" stop-color="#0d2640" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        <path class="chart-grid" d="M50 40 H750 M50 80 H750 M50 120 H750 M50 160 H750 M50 200 H750" />
                        <path class="chart-grid" d="M150 20 V220 M300 20 V220 M450 20 V220 M600 20 V220" />
                        <path class="chart-line"
                            d="M50 180 C150 170 170 120 250 130 C330 140 360 90 450 105 C540 120 620 80 750 100" />
                        <path
                            d="M50 180 C150 170 170 120 250 130 C330 140 360 90 450 105 C540 120 620 80 750 100 L750 220 L50 220 Z"
                            fill="url(#chartFill)" opacity="0.8" />
                        <g class="chart-axis">
                            <text x="50" y="235">Jan</text>
                            <text x="175" y="235">Feb</text>
                            <text x="300" y="235">Mar</text>
                            <text x="425" y="235">Apr</text>
                            <text x="550" y="235">Mei</text>
                            <text x="675" y="235">Jun</text>
                            <text x="750" y="235">Jul</text>
                        </g>
                    </svg>
                </div>
            </div>

            <div class="insight-card">
                <h3>Komoditas Teratas</h3>
                <div class="insight-item">
                    <div class="insight-meta">
                        <strong>Ikan Kembung</strong>
                        <small>42%</small>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 42%;"></div>
                    </div>
                </div>
                <div class="insight-item">
                    <div class="insight-meta">
                        <strong>Cumi-cumi</strong>
                        <small>28%</small>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 28%;"></div>
                    </div>
                </div>
                <div class="insight-item">
                    <div class="insight-meta">
                        <strong>Tongkol</strong>
                        <small>18%</small>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 18%;"></div>
                    </div>
                </div>
                <small style="display:block; margin-top:18px; color:#64748b; font-size:12px;">Terakhir diperbarui: 15
                    Okt 2025</small>
            </div>
        </div>

        <div class="key-cards">
            <div class="key-card">
                <div class="label"><i class="fas fa-exclamation-triangle"></i> TPI Teraktif</div>
                <div class="value">Blanakan</div>
                <div class="note">15 Laporan/tahun</div>
            </div>
            <div class="key-card">
                <div class="label"><i class="fas fa-boxes"></i> Total Produksi</div>
                <div class="value">8.4K <span style="font-size: 18px; color:#64748b;">Ton</span></div>
                <div class="note">Pertumbuhan +12%</div>
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
    </div>
</body>

</html>
