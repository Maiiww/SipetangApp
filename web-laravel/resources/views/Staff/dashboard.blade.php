<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Operasional - SIPETANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        }

        /* Sidebar */
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

        /* Header */
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

        .header-icon {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #1a4d7d;
        }

        /* UPDATED MAIN CONTENT COMPONENTS */
        .content-header {
            margin-bottom: 25px;
        }

        .content-header h2 {
            font-size: 24px;
            color: #0d2640;
            margin-bottom: 5px;
        }

        .content-header p {
            color: #666;
            font-size: 14px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-info h4 {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .stat-info span {
            font-size: 24px;
            font-weight: 700;
            color: #0d2640;
        }

        .stat-icon {
            font-size: 20px;
            padding: 12px;
            border-radius: 10px;
        }

        .bg-blue {
            background: #e3f2fd;
            color: #1976d2;
        }

        .bg-green {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .bg-orange {
            background: #fff3e0;
            color: #ef6c00;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 20px;
        }

        .stat-card-large {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            margin-bottom: 20px;
        }

        .stat-card-large h4 {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .stat-card-large .number {
            font-size: 32px;
            font-weight: 700;
            color: #0d2640;
        }

        .stat-card-dark {
            background: linear-gradient(135deg, #0d2640 0%, #1a4d7d 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .stat-card-dark h4 {
            font-size: 11px;
            opacity: 0.8;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .stat-card-dark .number {
            font-size: 36px;
            font-weight: 700;
        }

        .real-time-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 10px;
            color: #10b981;
            margin-top: 10px;
        }

        .real-time-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #10b981;
            border-radius: 50%;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .small-stat {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .small-stat label {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            display: block;
            margin-bottom: 5px;
        }

        .small-stat .value {
            font-size: 20px;
            font-weight: 700;
            color: #0d2640;
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: #eee;
            border-radius: 3px;
            margin-top: 8px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #10b981;
            width: 88%;
        }

        .anomaly-alert {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            border-left: 4px solid #ef4444;
        }

        .anomaly-alert label {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            display: block;
            margin-bottom: 5px;
        }

        .anomaly-alert .value {
            font-size: 20px;
            font-weight: 700;
            color: #ef4444;
        }

        .sidebar-right {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            height: fit-content;
        }

        .sidebar-right-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .sidebar-right-header h3 {
            font-size: 14px;
            color: #0d2640;
            font-weight: 700;
        }

        .sidebar-right-header a {
            color: #2563eb;
            font-size: 12px;
            text-decoration: none;
        }

        .activity-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-avatar {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
            font-size: 12px;
        }

        .activity-name {
            font-weight: 600;
            color: #0d2640;
        }

        .activity-location {
            color: #888;
            font-size: 11px;
        }

        .activity-status {
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
            margin-top: 4px;
        }

        .activity-status.verified {
            background: #d4edda;
            color: #155724;
        }

        .activity-status.pending {
            background: #fff3cd;
            color: #856404;
        }

        .activity-time {
            color: #888;
            font-size: 11px;
            margin-top: 4px;
        }

        .content-header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .content-header-left h2 {
            font-size: 24px;
            color: #0d2640;
            margin-bottom: 5px;
        }

        .content-header-left p {
            color: #666;
            font-size: 14px;
        }

        .content-header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .date-selector {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: white;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-input {
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h3 {
            font-size: 18px;
            color: #0d2640;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px;
            font-size: 13px;
            color: #888;
            border-bottom: 1px solid #eee;
        }

        td {
            padding: 15px 12px;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin-right: 5px;
        }

        .btn-check {
            background: #2e7d32;
            color: white;
        }

        .btn-detail {
            background: #1a4d7d;
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                padding: 20px 10px;
            }

            .sidebar-logo-text,
            .sidebar-menu span,
            .sidebar-logout span {
                display: none;
            }

            .main-content {
                margin-left: 60px;
            }
        }
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <div class="main-content">
        <div class="header">
            <div class="header-right">
                <div class="header-icon"><i class="fas fa-bell"></i></div>
                <div class="header-icon"><i class="fas fa-user"></i></div>
            </div>
        </div>

        <div class="content-header-top">
            <div class="content-header-left">
                <h2>Dashboard Staff</h2>
                <p>Selamat datang kembali di Sistem Informasi Pencatatan Hasil Tangkap</p>
            </div>
            <div class="content-header-right">
                <div class="date-selector">
                    <i class="fas fa-calendar"></i>
                    <span>Mei 2026</span>
                </div>
                <a href="{{ route('staff.validasi') }}" class="btn-input"
                    style="text-decoration: none; display: inline-flex; align-items: center;"><i class="fas fa-eye"></i>
                    Lihat Laporan</a>
            </div>
        </div>

        <div class="dashboard-container">
            <div>
                <div class="stats-grid">
                    <div class="stat-card-large">
                        <h4>TOTAL DATA USER</h4>
                        <div class="number">{{ $statistik['totalUser'] }}</div>
                    </div>
                    <div class="stat-card-dark">
                        <h4>DATA PRODUKSI (BULAN)</h4>
                        <div class="number">{{ $statistik['produksiBulan'] }} <span
                                style="font-size: 18px; color:#ffffff;">(ton)</span></div>
                        <div class="real-time-badge">REAL-TIME MONITOR</div>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="small-stat">
                        <label>Laporan Masuk</label>
                        <div class="value">{{ $statistik['totalLaporan'] }}</div>
                    </div>
                    <div class="small-stat">
                        <label>Validasi Tertunda</label>
                        <div class="value">{{ $statistik['validasiTertunda'] }}</div>
                    </div>
                </div>

                <div class="anomaly-alert">
                    <label>Data Statistik Terkini</label>
                    <div style="margin-top: 10px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span style="font-size: 12px; color: #0d2640;">Validasi Berhasil</span>
                            <span
                                style="font-size: 12px; font-weight: 700; color: #0d2640;">{{ $statistik['persentaseValidasi'] }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $statistik['persentaseValidasi'] }}%;"></div>
                        </div>
                    </div>
                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #f0f0f0;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 12px; color: #666;">Anomali Terdeteksi</span>
                            <span
                                style="font-size: 18px; font-weight: 700; color: #ef4444;">{{ str_pad($statistik['anomaliDetected'], 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar-right">
                <div class="sidebar-right-header">
                    <h3>Aktivitas Terbaru</h3>
                    <a href="{{ route('staff.validasi') }}">Lihat Semua</a>
                </div>

                @forelse($aktivitas as $activity)
                    <div class="activity-item">
                        <div class="activity-avatar"
                            style="background: #{{ $activity['avatarBg'] }}; color: #{{ $activity['avatarBg'] === 'e0f2fe' ? '0369a1' : ($activity['avatarBg'] === 'f0fdf4' ? '166534' : '1f2937') }};">
                            {{ $activity['avatar'] }}
                        </div>
                        <div class="activity-content">
                            <div class="activity-name">{{ $activity['nama'] }}</div>
                            <div class="activity-location">{{ $activity['lokasi'] }}</div>
                            <span
                                class="activity-status {{ $activity['status'] === 'validated' ? 'verified' : 'pending' }}">
                                {{ strtoupper($activity['status'] === 'validated' ? 'TERVALIDASI' : 'PENDING') }}
                            </span>
                            <div class="activity-time">{{ $activity['waktu']->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 20px; color: #888;">
                        <p>Tidak ada aktivitas terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>

</html>
