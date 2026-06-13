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
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
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
            background: white;
            border: 3px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 32px;
            font-weight: 700;
            color: #0a3b99;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
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
            font-weight: 700;
            color: #0d2640;
            margin-bottom: 5px;
        }

        .page-title p {
            font-size: 14.5px;
            color: #64748b;
        }

        .stats-panel {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 30px;
        }

        .chart-card,
        .insight-card,
        .detail-card,
        .region-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            padding: 24px;
            border: 1px solid #edf2f7;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .chart-card:hover,
        .insight-card:hover,
        .detail-card:hover,
        .region-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(10, 59, 153, 0.08);
            border-color: rgba(10, 59, 153, 0.15);
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
            font-weight: 750;
            color: #0d2640;
        }

        .chart-header span {
            font-size: 12px;
            color: #64748b;
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
            color: #0a3b99;
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
            background: radial-gradient(circle at top, rgba(59, 130, 246, 0.08), transparent 35%);
            pointer-events: none;
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
            gap: 24px;
            margin-bottom: 30px;
        }

        .key-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            padding: 24px;
            border: 1px solid #edf2f7;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .key-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(10, 59, 153, 0.08);
            border-color: rgba(10, 59, 153, 0.15);
        }

        .key-card .label {
            font-size: 11px;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 0.12em;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
        }

        .key-card .value {
            font-size: 30px;
            font-weight: 850;
            color: #0d2640;
            margin-bottom: 6px;
        }

        .key-card .note {
            font-size: 13.5px;
            color: #64748b;
            font-weight: 600;
        }

        .insight-card h3 {
            font-size: 15px;
            margin-bottom: 18px;
            color: #0d2640;
            font-weight: 750;
        }

        .insight-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            transition: all 0.25s ease;
        }

        .insight-item:hover {
            background: #f1f5f9;
            transform: translateX(4px);
            border-color: #cbd5e1;
        }

        .insight-item:last-child {
            margin-bottom: 0;
        }

        .insight-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .insight-meta strong {
            font-size: 14.5px;
            color: #0d2640;
            font-weight: 700;
        }

        .insight-meta small {
            color: #0a3b99;
            font-weight: 700;
            font-size: 13px;
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
            gap: 24px;
        }

        .region-info h2 {
            margin: 0 0 12px;
            font-size: 18px;
            color: #0d2640;
            font-weight: 750;
        }

        .region-info p {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 20px;
            font-size: 14.5px;
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
            border: 1px solid #edf2f7;
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            transition: all 0.25s ease;
        }
        
        .region-list li:hover {
            transform: translateX(4px);
            background: #f1f5f9;
            border-color: #cbd5e1;
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
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
        }

        #map {
            width: 100%;
            height: 480px;
            border-radius: 16px;
        }

        .leaflet-control-attribution {
            font-size: 10px;
            background: rgba(255,255,255,0.85) !important;
        }

        /* Custom Google Maps-style marker */
        .tpi-marker-pin {
            width: 36px;
            height: 36px;
            border-radius: 50% 50% 50% 0;
            background: #ea4335;
            position: absolute;
            transform: rotate(-45deg);
            left: 50%;
            top: 50%;
            margin: -18px 0 0 -18px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.35);
            border: 3px solid #fff;
        }

        .tpi-marker-pin::after {
            content: '';
            width: 16px;
            height: 16px;
            margin: 7px 0 0 7px;
            background: #fff;
            position: absolute;
            border-radius: 50%;
        }

        @keyframes tpi-pulse {
            0%   { box-shadow: 0 0 0 0 rgba(234,67,53,0.5); }
            70%  { box-shadow: 0 0 0 14px rgba(234,67,53,0); }
            100% { box-shadow: 0 0 0 0 rgba(234,67,53,0); }
        }

        .tpi-marker-wrapper {
            width: 36px;
            height: 36px;
            position: relative;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 10px !important;
            box-shadow: 0 4px 18px rgba(0,0,0,0.18) !important;
            border: none !important;
            padding: 0 !important;
            overflow: hidden;
        }

        .leaflet-popup-content {
            margin: 0 !important;
            min-width: 200px;
        }

        .leaflet-popup-tip-container {
            margin-top: -1px;
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
        
        .stat-icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }
        
        .stat-icon-blue {
            background: #e0f2fe;
            color: #0369a1;
        }

        .stat-icon-green {
            background: #dcfce7;
            color: #166534;
        }

        .page-footer {
            text-align: center;
            font-size: 14px;
            color: #777;
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

        /* Header Profile Button */
        .header-profile-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            padding: 2px;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        }

        .header-profile-btn:hover {
            transform: scale(1.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .header-profile-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .header-profile-btn:hover .header-profile-avatar {
            background: white;
            color: #0a3b99;
        }
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <div class="main-content">
        <div class="header">
            <div class="header-right">
                <div class="header-icons">
                    <div class="header-profile-btn" onclick="openProfileModal(event)" title="Profil Saya">
                        <div class="header-profile-avatar">
                            STF
                        </div>
                    </div>
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
            <div class="key-card" style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="label"><i class="fas fa-anchor" style="color: #0a3b99; margin-right: 6px;"></i> TPI Teraktif</div>
                    <div class="value">{{ $tpiTeraktif['nama'] }}</div>
                    <div class="note">{{ $tpiTeraktif['totalLaporan'] }} Laporan Valid</div>
                </div>
                <div class="stat-icon-wrapper stat-icon-blue">
                    <i class="fas fa-anchor"></i>
                </div>
            </div>
            <div class="key-card" style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="label"><i class="fas fa-chart-column" style="color: #166534; margin-right: 6px;"></i> Total Produksi</div>
                    <div class="value">{{ $totalProduksi['totalFormatted'] }} <span
                            style="font-size: 18px; color:#64748b;">{{ $totalProduksi['unit'] }}</span></div>
                    <div class="note">Pertumbuhan +{{ $totalProduksi['growth'] }}%</div>
                </div>
                <div class="stat-icon-wrapper stat-icon-green">
                    <i class="fas fa-chart-column"></i>
                </div>
            </div>
        </div>

        <div class="region-card">
            <div class="region-info">
                <h2>Sebaran Tempat Pelelangan Ikan (TPI)</h2>
                <p>Data lengkap 8 Tempat Pelelangan Ikan di Kabupaten Subang. Pantau aktivitas perikanan secara
                    geografis untuk mengambil keputusan alokasi sumber daya dan logistik.</p>
                <ul class="region-list" style="margin-top: 20px;">
                    <li>
                        <a href="https://maps.app.goo.gl/jE3csyQ4sE2A2xX47" target="_blank" style="text-decoration:none;color:inherit;display:flex;justify-content:space-between;align-items:center;width:100%;">
                            <span><i class="fas fa-map-marker-alt" style="color: #ea4335; margin-right: 8px;"></i> Patimban</span>
                            <span style="font-size:11px;color:#0a3b99;font-weight:700;"><i class="fas fa-external-link-alt"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.google.com/maps?q=-6.2125,107.8468" target="_blank" style="text-decoration:none;color:inherit;display:flex;justify-content:space-between;align-items:center;width:100%;">
                            <span><i class="fas fa-map-marker-alt" style="color: #ea4335; margin-right: 8px;"></i> Genteng</span>
                            <span style="font-size:11px;color:#0a3b99;font-weight:700;"><i class="fas fa-external-link-alt"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.google.com/maps?q=-6.1968,107.7962" target="_blank" style="text-decoration:none;color:inherit;display:flex;justify-content:space-between;align-items:center;width:100%;">
                            <span><i class="fas fa-map-marker-alt" style="color: #ea4335; margin-right: 8px;"></i> Mayangan</span>
                            <span style="font-size:11px;color:#0a3b99;font-weight:700;"><i class="fas fa-external-link-alt"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.google.com/maps?q=-6.1811,107.8320" target="_blank" style="text-decoration:none;color:inherit;display:flex;justify-content:space-between;align-items:center;width:100%;">
                            <span><i class="fas fa-map-marker-alt" style="color: #ea4335; margin-right: 8px;"></i> Cirewang</span>
                            <span style="font-size:11px;color:#0a3b99;font-weight:700;"><i class="fas fa-external-link-alt"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.google.com/maps?q=-6.2178,107.7125" target="_blank" style="text-decoration:none;color:inherit;display:flex;justify-content:space-between;align-items:center;width:100%;">
                            <span><i class="fas fa-map-marker-alt" style="color: #ea4335; margin-right: 8px;"></i> Muara Ciasem</span>
                            <span style="font-size:11px;color:#0a3b99;font-weight:700;"><i class="fas fa-external-link-alt"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.google.com/maps?q=-6.2548,107.6598" target="_blank" style="text-decoration:none;color:inherit;display:flex;justify-content:space-between;align-items:center;width:100%;">
                            <span><i class="fas fa-map-marker-alt" style="color: #ea4335; margin-right: 8px;"></i> Blanakan</span>
                            <span style="font-size:11px;color:#0a3b99;font-weight:700;"><i class="fas fa-external-link-alt"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.google.com/maps?q=-6.2315,107.6418" target="_blank" style="text-decoration:none;color:inherit;display:flex;justify-content:space-between;align-items:center;width:100%;">
                            <span><i class="fas fa-map-marker-alt" style="color: #ea4335; margin-right: 8px;"></i> Rawameneng</span>
                            <span style="font-size:11px;color:#0a3b99;font-weight:700;"><i class="fas fa-external-link-alt"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.google.com/maps?q=-6.2088,107.6145" target="_blank" style="text-decoration:none;color:inherit;display:flex;justify-content:space-between;align-items:center;width:100%;">
                            <span><i class="fas fa-map-marker-alt" style="color: #ea4335; margin-right: 8px;"></i> Cilamaya Girang</span>
                            <span style="font-size:11px;color:#0a3b99;font-weight:700;"><i class="fas fa-external-link-alt"></i></span>
                        </a>
                    </li>
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
                
                // Create a beautiful linear gradient fill
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(10, 59, 153, 0.24)');
                gradient.addColorStop(1, 'rgba(10, 59, 153, 0.00)');

                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Produksi (Ton)',
                            data: values,
                            borderColor: '#0a3b99',
                            backgroundColor: gradient,
                            borderWidth: 4,
                            fill: true,
                            tension: 0.45,
                            pointBackgroundColor: '#0a3b99',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: '#1d65d0',
                            pointHoverBorderColor: '#ffffff',
                            pointHoverBorderWidth: 3,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true,
                                backgroundColor: 'rgba(10, 59, 153, 0.92)',
                                titleColor: '#ffffff',
                                bodyColor: '#e0f0ff',
                                titleFont: {
                                    size: 13,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13,
                                    weight: '600'
                                },
                                padding: 14,
                                cornerRadius: 10,
                                displayColors: false,
                                borderColor: 'rgba(255,255,255,0.2)',
                                borderWidth: 1,
                                callbacks: {
                                    title: function(items) {
                                        return items[0].label;
                                    },
                                    label: function(context) {
                                        var val = context.parsed.y;
                                        return '🐟 Produksi: ' + val.toFixed(2) + ' Ton';
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
                // =============================================
                // PETA SEBARAN TPI KABUPATEN SUBANG
                // Tile: CartoDB Voyager (tampilan Google Maps)
                // =============================================

                const map = L.map('map', {
                    zoomControl: true,
                    scrollWheelZoom: true
                }).setView([-6.235, 107.775], 11);

                // CartoDB Voyager — tampilan identik Google Maps
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors © <a href="https://carto.com/">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 20
                }).addTo(map);

                // =============================================
                // DATA TPI — Koordinat Real Kabupaten Subang
                // Sumber: GPS / Google Maps verified
                // =============================================
                const tpiLocations = [
                    {
                        name: 'TPI Patimban',
                        kecamatan: 'Kec. Pusakanagara',
                        lat: -6.2499579,
                        lng: 107.9193405,
                        color: '#ea4335',
                        mapsUrl: 'https://maps.app.goo.gl/jE3csyQ4sE2A2xX47'
                    },
                    {
                        name: 'TPI Genteng',
                        kecamatan: 'Kec. Legonkulon',
                        lat: -6.2125,
                        lng: 107.8468,
                        color: '#ea4335',
                        mapsUrl: 'https://www.google.com/maps?q=-6.2125,107.8468&query=TPI+Genteng+Subang'
                    },
                    {
                        name: 'TPI Mayangan',
                        kecamatan: 'Kec. Legonkulon',
                        lat: -6.1968,
                        lng: 107.7962,
                        color: '#ea4335',
                        mapsUrl: 'https://www.google.com/maps?q=-6.1968,107.7962&query=TPI+Mayangan+Subang'
                    },
                    {
                        name: 'TPI Cirewang',
                        kecamatan: 'Kec. Legonkulon',
                        lat: -6.1811,
                        lng: 107.8320,
                        color: '#ea4335',
                        mapsUrl: 'https://www.google.com/maps?q=-6.1811,107.8320&query=TPI+Cirewang+Subang'
                    },
                    {
                        name: 'TPI Muara Ciasem',
                        kecamatan: 'Kec. Ciasem',
                        lat: -6.2178,
                        lng: 107.7125,
                        color: '#ea4335',
                        mapsUrl: 'https://www.google.com/maps?q=-6.2178,107.7125&query=TPI+Muara+Ciasem+Subang'
                    },
                    {
                        name: 'TPI Blanakan',
                        kecamatan: 'Kec. Blanakan',
                        lat: -6.2548,
                        lng: 107.6598,
                        color: '#ea4335',
                        mapsUrl: 'https://www.google.com/maps?q=-6.2548,107.6598&query=TPI+Blanakan+Subang'
                    },
                    {
                        name: 'TPI Rawameneng',
                        kecamatan: 'Kec. Blanakan',
                        lat: -6.2315,
                        lng: 107.6418,
                        color: '#ea4335',
                        mapsUrl: 'https://www.google.com/maps?q=-6.2315,107.6418&query=TPI+Rawameneng+Subang'
                    },
                    {
                        name: 'TPI Cilamaya Girang',
                        kecamatan: 'Kec. Cilamaya Wetan',
                        lat: -6.2088,
                        lng: 107.6145,
                        color: '#ea4335',
                        mapsUrl: 'https://www.google.com/maps?q=-6.2088,107.6145&query=TPI+Cilamaya+Girang+Subang'
                    }
                ];

                // =============================================
                // Custom Google Maps-style pin icon
                // =============================================
                function createGooglePin(color) {
                    var svgIcon = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="42" viewBox="0 0 32 42">
                            <path d="M16 0C7.163 0 0 7.163 0 16c0 11 16 26 16 26s16-15 16-26C32 7.163 24.837 0 16 0z"
                                fill="${color}" stroke="#fff" stroke-width="2"/>
                            <circle cx="16" cy="16" r="7" fill="#fff"/>
                            <circle cx="16" cy="16" r="4" fill="${color}"/>
                        </svg>`;
                    return L.divIcon({
                        html: svgIcon,
                        className: '',
                        iconSize: [32, 42],
                        iconAnchor: [16, 42],
                        popupAnchor: [0, -44]
                    });
                }

                // =============================================
                // Pasang marker + popup informatif
                // =============================================
                tpiLocations.forEach(function(tpi, idx) {
                    var marker = L.marker([tpi.lat, tpi.lng], {
                        icon: createGooglePin(tpi.color),
                        title: tpi.name
                    });

                    var popupHtml = `
                        <div style="font-family:'Segoe UI',sans-serif; min-width:220px;">
                            <div style="background:linear-gradient(135deg,#0a3b99,#1d65d0);
                                        padding:12px 16px; color:#fff;">
                                <div style="font-size:13px;font-weight:700;margin-bottom:2px;">${tpi.name}</div>
                                <div style="font-size:11px;opacity:0.85;">📍 ${tpi.kecamatan}</div>
                            </div>
                            <div style="padding:12px 16px;">
                                <div style="font-size:11px;color:#64748b;margin-bottom:4px;">Koordinat GPS</div>
                                <div style="font-size:12px;color:#0d2640;font-weight:600;margin-bottom:10px;">${tpi.lat.toFixed(4)}, ${tpi.lng.toFixed(4)}</div>
                                <div style="display:flex;gap:8px;align-items:center;padding-top:10px;border-top:1px solid #f0f0f0;">
                                    <span style="background:#eff6ff;color:#0a3b99;font-size:11px;font-weight:700;
                                                 padding:4px 10px;border-radius:999px;flex:1;text-align:center;">
                                        ⚓ Aktif
                                    </span>
                                    <a href="${tpi.mapsUrl}" target="_blank"
                                       style="display:inline-flex;align-items:center;gap:6px;
                                              background:#ea4335;color:#fff;font-size:11px;font-weight:700;
                                              padding:5px 12px;border-radius:999px;text-decoration:none;
                                              flex:2;justify-content:center;transition:all 0.2s;"
                                       onmouseover="this.style.background='#c5221f'"
                                       onmouseout="this.style.background='#ea4335'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                        </svg>
                                        Buka di Maps
                                    </a>
                                </div>
                            </div>
                        </div>`;

                    marker.bindPopup(popupHtml, {
                        maxWidth: 260,
                        className: 'tpi-popup'
                    });

                    // Klik marker → buka popup (default)
                    // Double klik marker → langsung buka Google Maps
                    marker.on('dblclick', function() {
                        window.open(tpi.mapsUrl, '_blank');
                    });

                    marker.addTo(map);
                });

                // Fit map ke semua marker
                var bounds = tpiLocations.map(t => [t.lat, t.lng]);
                map.fitBounds(bounds, { padding: [40, 40] });
            </script>
        </div>

        <div class="page-footer">
            &copy; 2026 Dinas Perikanan Kabupaten Subang | Neutron Tech Solutions
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

    <!-- Profile Modal -->
    <div id="profileModal" class="profile-modal">
        <div class="profile-modal-content">
            <div class="profile-modal-header">
                <button class="profile-modal-close" onclick="closeProfileModal()">&times;</button>
                <div class="profile-avatar">
                    STF</div>
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
            <div class="modal-footer" style="margin: 0 30px 30px; display: flex; justify-content: center; border-top: 1px solid #eee; padding-top: 20px;">
                <button type="button" onclick="closeProfileModal()" style="width: 100%; text-align: center; padding: 10px 20px; border: 1px solid #ddd; background: white; color: #666; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s ease;" onmouseover="this.style.background='#f5f5f5'; this.style.borderColor='#bbb';" onmouseout="this.style.background='white'; this.style.borderColor='#ddd';">Tutup</button>
            </div>
        </div>
    </div>
</body>

</html>
