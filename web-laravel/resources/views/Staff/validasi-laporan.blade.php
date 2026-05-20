<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Laporan - SIPETANG</title>
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
            font-size: 16px;
            color: #1a4d7d;
        }

        .header-icon:hover {
            background: #e0e0e0;
        }

        /* Page Title */
        .page-title {
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 600;
            color: #1a4d7d;
            margin-bottom: 8px;
        }

        .page-title p {
            font-size: 14px;
            color: #666;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1a4d7d;
        }

        .stat-icon-box {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-icon-pending {
            color: #ff9800;
        }

        .stat-icon-validated {
            color: #4caf50;
        }

        .stat-icon-anomaly {
            color: #f44336;
        }

        /* Filters Section */
        .filters-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            flex-wrap: wrap;
            gap: 15px;
        }

        .filters-section form {
            width: 100%;
        }

        .filter-group {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn-filter {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: #1a4d7d;
            transition: all 0.3s;
        }

        .btn-filter:hover {
            background: #f5f5f5;
            border-color: #1a4d7d;
        }

        .btn-filter.active {
            background: #1a4d7d;
            color: white;
            border-color: #1a4d7d;
        }

        .btn-accept-all {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #0d2640;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-accept-all:hover {
            background: #1a4d7d;
        }

        /* Table Section */
        .table-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .table-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a4d7d;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .uploadable-info {
            font-size: 11px;
            color: #1a7fbb;
            margin-left: auto;
        }

        .reports-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .reports-table thead {
            background: #f5f5f5;
        }

        .reports-table tr {
            height: 50px;
        }

        .reports-table th {
            padding: 0 12px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            font-weight: 600;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
            line-height: 50px;
        }

        .reports-table td {
            padding: 0 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 13px;
            color: #333;
            vertical-align: middle;
            height: 50px;
            text-align: left;
        }

        .reports-table td div,
        .reports-table td span {
            margin: 0;
            line-height: 1.2;
            display: flex;
            align-items: center;
            height: 100%;
            text-align: left;
        }

        .date-cell {
            font-weight: 600;
            color: #1a4d7d;
            text-align: left;
        }

        .tpi-name {
            font-weight: 600;
            color: #1a4d7d;
            margin: 0;
            line-height: 1.2;
            text-align: left;
        }

        .tpi-location {
            font-size: 11px;
            color: #999;
        }

        .fish-badge {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            padding: 4px 10px;
            background: transparent;
            color: #333;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            height: 24px;
        }

        .volume-cell {
            font-weight: 600;
            color: #1a4d7d;
            text-align: left;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            padding: 4px 12px 4px 0;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            height: 26px;
            line-height: 1;
            flex-shrink: 0;
            background: transparent;
            color: #333;
        }

        .status-pending {
            background: transparent;
            color: #333;
        }

        .status-validated {
            background: transparent;
            color: #333;
        }

        .status-rejected {
            background: transparent;
            color: #333;
        }

        .action-cell {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            height: 100%;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.3s;
            line-height: 1;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .action-cell form {
            display: inline-flex !important;
            margin: 0 !important;
            height: 100%;
            align-items: center;
        }

        .action-validate {
            background: #d4edda;
            color: #4caf50;
        }

        .action-validate:hover {
            background: #c3e6cb;
        }

        .action-reject {
            background: #f8d7da;
            color: #f44336;
        }

        .action-reject:hover {
            background: #f5c6cb;
        }

        /* Pagination */
        .pagination-section {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
        }

        .pagination-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #e0e0e0;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #1a4d7d;
        }

        .pagination-btn:hover:not(:disabled) {
            border-color: #1a4d7d;
            color: #1a4d7d;
            background: #f5f5f5;
        }

        .pagination-btn.active {
            background: #0d2640;
            color: white;
            border-color: #0d2640;
        }

        .pagination-btn:disabled {
            cursor: not-allowed;
            opacity: 0.5;
            background: #f5f5f5;
            color: #999;
        }

        .pagination-info {
            font-size: 12px;
            color: #999;
            margin: 0 10px;
        }

        .pagination-btn i {
            font-size: 12px;
        }

        /* Trend Section */
        .trend-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .trend-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a4d7d;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .trend-description {
            font-size: 13px;
            color: #666;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .trend-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
        }

        .trend-stat {
            background: #f5f5f5;
            padding: 25px;
            border-radius: 8px;
        }

        .trend-stat-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .trend-stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #1a4d7d;
        }

        /* Footer */
        .page-footer {
            text-align: center;
            font-size: 11px;
            color: #999;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                flex-direction: row;
                align-items: center;
                padding: 15px;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .header {
                flex-direction: column;
                gap: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filters-section {
                flex-direction: column;
                gap: 15px;
            }

            .filter-group {
                flex-direction: column;
                width: 100%;
            }

            .reports-table {
                font-size: 12px;
            }

            .reports-table td,
            .reports-table th {
                padding: 10px 8px;
            }

            .trend-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    @include('components.sidebar-menu')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-right">
                <div class="header-icons">
                    <a href="{{ route('staff.profile') }}" style="text-decoration: none; color: inherit;">
                        <div class="header-icon" style="cursor: pointer;">
                            <i class="fas fa-user"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Page Title -->
        <div class="page-title">
            <h1>Validasi Laporan</h1>
            <p>Otorisiasi dan verifikasi data hasil tangkapan laut dari seluruh Tempat Pelelangan Ikan (TPI) wilayah
                Subang.</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-label"><i class="fas fa-hourglass-half"></i> Menunggu</div>
                    <div class="stat-value">{{ $stats['pending'] }}</div>
                </div>
                <div class="stat-icon-box stat-icon-pending">
                    <img src="{{ asset('images/file.png') }}" alt="Menunggu"
                        style="width: 50px; height: 50px; object-fit: contain;">
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-label"><i class="fas fa-check"></i> Tervalidasi Hari Ini</div>
                    <div class="stat-value">{{ $stats['validated'] }}</div>
                </div>
                <div class="stat-icon-box stat-icon-validated">
                    <img src="{{ asset('images/list.png') }}" alt="Tervalidasi"
                        style="width: 50px; height: 50px; object-fit: contain;">
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-label"><i class="fas fa-weight"></i> Total Volume (Ton)</div>
                    <div class="stat-value">{{ number_format($stats['totalVolume'], 1) }}</div>
                </div>
                <div class="stat-icon-box stat-icon-validated">
                    <img src="{{ asset('images/bar-graph.png') }}" alt="Volume"
                        style="width: 50px; height: 50px; object-fit: contain;">
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-label"><i class="fas fa-exclamation-triangle"></i> Anomali Data</div>
                    <div class="stat-value" style="color: #f44336;">{{ $stats['anomaly'] }}</div>
                </div>
                <div class="stat-icon-box stat-icon-anomaly">
                    <img src="{{ asset('images/warning.png') }}" alt="Anomali"
                        style="width: 50px; height: 50px; object-fit: contain;">
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <form method="GET" action="{{ route('staff.validasi') }}" id="filterForm"
                style="width: 100%; display: flex; gap: 15px; align-items: center;">
                <!-- Search Box -->
                <div style="flex: 1; display: flex; gap: 8px;">
                    <input type="text" name="search" placeholder="Cari ID, TPI, atau jenis ikan..."
                        value="{{ $search }}"
                        style="flex: 1; padding: 10px 15px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    <button type="submit" class="btn-filter" style="background: #1a4d7d; color: white;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>

                <!-- Status Filter Buttons -->
                <div class="filter-group">
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span style="font-size: 12px; color: #999; font-weight: 600;">Filter:</span>
                        <button type="button" class="btn-filter {{ $statusFilter === 'all' ? 'active' : '' }}"
                            onclick="setStatusFilter('all', this)">
                            <i class="fas fa-list"></i> Semua
                        </button>
                        <button type="button" class="btn-filter {{ $statusFilter === 'pending' ? 'active' : '' }}"
                            onclick="setStatusFilter('pending', this)">
                            <i class="fas fa-hourglass-half"></i> Pending
                        </button>
                        <button type="button" class="btn-filter {{ $statusFilter === 'validated' ? 'active' : '' }}"
                            onclick="setStatusFilter('validated', this)">
                            <i class="fas fa-check"></i> Validasi
                        </button>
                        <button type="button" class="btn-filter {{ $statusFilter === 'rejected' ? 'active' : '' }}"
                            onclick="setStatusFilter('rejected', this)">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                    </div>
                </div>

                <!-- Clear Filters Button -->
                @if ($search || $statusFilter !== 'all')
                    <a href="{{ route('staff.validasi') }}" class="btn-filter"
                        style="background: #f5f5f5; color: #999;">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                @endif

                <!-- Hidden status input -->
                <input type="hidden" name="status" id="statusInput" value="{{ $statusFilter }}">
            </form>
        </div>

        @if (session('success'))
            <div
                style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div
                style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-title">
                Antrean Laporan
            </div>

            @if ($laporans->count() > 0)
                <table class="reports-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama TPI</th>
                            <th>Jenis Ikan</th>
                            <th>Volume (Kg)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporans as $laporan)
                            <tr>
                                <td class="date-cell">{{ $laporan->tanggalInput->format('d M Y') }}</td>
                                <td>
                                    <div class="tpi-name">{{ $laporan->namaTPI }}</div>
                                </td>
                                <td><span class="fish-badge">{{ $laporan->jenisIkan }}</span></td>
                                <td class="volume-cell">{{ number_format($laporan->beratTotal * 1000, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($laporan->status === 'pending')
                                        <span class="status-badge status-pending">PENDING</span>
                                    @elseif ($laporan->status === 'validated')
                                        <span class="status-badge status-validated">TERVALIDASI</span>
                                    @elseif ($laporan->status === 'rejected')
                                        <span class="status-badge status-rejected">DITOLAK</span>
                                    @endif
                                </td>
                                <td class="action-cell">
                                    @if ($laporan->status === 'pending')
                                        <form method="POST"
                                            action="{{ route('staff.validasi.validate', $laporan->idLaporan) }}"
                                            style="display: inline;"
                                            onsubmit="return confirm('Anda yakin ingin memvalidasi laporan ini?')">
                                            @csrf
                                            <button type="submit"
                                                class="action-btn action-validate">Validasi</button>
                                        </form>
                                        <button type="button" class="action-btn action-reject"
                                            onclick="openRejectModal('{{ $laporan->idLaporan }}', '{{ addslashes($laporan->namaTPI) }}')">Tolak</button>
                                    @else
                                        <span style="font-size: 12px; color: #888;"><i class="fas fa-check"></i> Sudah
                                            diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $laporans->links('pagination.custom') }}
            @else
                <div style="text-align: center; padding: 40px; color: #888;">
                    <i class="fas fa-inbox"
                        style="font-size: 48px; margin-bottom: 16px; opacity: 0.5; display: block;"></i>
                    <p>Belum Ada Antrean Laporan!</p>
                </div>
            @endif
        </div>

        <!-- Reject Modal -->
        <div id="rejectModal"
            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;">
            <div
                style="background: white; padding: 30px; border-radius: 12px; width: 90%; max-width: 500px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
                <h3 style="font-size: 18px; color: #0d2640; margin-bottom: 15px;">Tolak Laporan</h3>
                <p id="rejectModalText" style="color: #666; margin-bottom: 20px;"></p>
                <form id="rejectForm" method="POST" style="margin-bottom: 20px;">
                    @csrf
                    <textarea id="rejectTextarea" name="catatan" placeholder="Alasan penolakan (wajib diisi)"
                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; font-size: 14px; min-height: 100px;"
                        required></textarea>
                </form>
                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                    <button onclick="closeRejectModal()"
                        style="padding: 10px 20px; background: #e0e0e0; color: #0d2640; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Batal</button>
                    <button onclick="submitReject()"
                        style="padding: 10px 20px; background: #f44336; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Tolak
                        Laporan</button>
                </div>
            </div>
        </div>

        <script>
            // Filter function
            function setStatusFilter(status, button) {
                // Update hidden input
                document.getElementById('statusInput').value = status;

                // Update button states
                const filterButtons = document.querySelectorAll('.filter-group .btn-filter');
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                // Submit form
                document.getElementById('filterForm').submit();
            }

            function openRejectModal(id, name) {
                document.getElementById('rejectModal').style.display = 'flex';
                document.getElementById('rejectModalText').textContent = 'Isi alasan penolakan untuk laporan dari ' + name;
                document.getElementById('rejectForm').action = '/staff/validasi-laporan/' + id + '/reject';
                document.getElementById('rejectForm').reset();
                document.getElementById('rejectTextarea').focus();
            }

            function closeRejectModal() {
                document.getElementById('rejectModal').style.display = 'none';
                document.getElementById('rejectForm').reset();
            }

            function submitReject() {
                const textarea = document.getElementById('rejectTextarea');
                if (!textarea.value.trim()) {
                    alert('Alasan penolakan harus diisi!');
                    textarea.focus();
                    return;
                }
                document.getElementById('rejectForm').submit();
            }

            // Close modal when clicking outside
            document.getElementById('rejectModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeRejectModal();
                }
            });
        </script>

        <div class="page-footer">
            SISTEM INFORMASI PENCATATAN HASIL TANGKAP
        </div>
    </div>
</body>

</html>
