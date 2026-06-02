<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cetak Laporan - SIPETANG</title>
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
            color: #24374a;
            min-height: 100vh;
            display: flex;
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
            margin-bottom: 28px;
        }

        .page-title h1 {
            font-size: 32px;
            color: #102a43;
            margin-bottom: 8px;
        }

        .page-title p {
            max-width: 700px;
            font-size: 14px;
            color: #556a82;
            line-height: 1.7;
        }

        .layout-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 24px;
            margin-bottom: 30px;
            align-items: start;
        }

        .card {
            background: #fff;
            border-radius: 22px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-title h2 {
            font-size: 18px;
            color: #102a43;
            font-weight: 700;
        }

        .section-title span {
            font-size: 13px;
            color: #7a869a;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 22px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-label {
            font-size: 12px;
            color: #7a869a;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
        }

        .form-select,
        .form-input {
            border: 1px solid #dce1e9;
            border-radius: 14px;
            padding: 14px 16px;
            font-size: 14px;
            background: #f8fafc;
            color: #102a43;
            outline: none;
        }

        .form-input {
            width: 100%;
        }

        .form-select {
            appearance: none;
            background: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="%237a869a" d="M5.5 7.5l4.5 4.5 4.5-4.5"/></svg>') no-repeat right 16px center/12px auto;
        }

        .form-select option:disabled {
            color: #7a869a;
        }

        .frequency-card {
            background: #f8fafc;
            border: 1px solid #e6ecf6;
            border-radius: 20px;
            padding: 22px;
            display: grid;
            gap: 16px;
        }

        .frequency-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            border: 1px solid #dce1e9;
            border-radius: 18px;
            padding: 16px;
            transition: border-color 0.3s ease, background-color 0.3s ease;
            cursor: pointer;
        }

        .frequency-option.active-laporan {
            border-color: #0d2640;
            background: #edf2ff;
        }

        .frequency-option:hover {
            border-color: #1a4d7d;
        }

        .frequency-option input {
            margin-right: 12px;
        }

        .frequency-option .option-body {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .option-title {
            font-size: 14px;
            font-weight: 700;
            color: #102a43;
        }

        .option-desc {
            font-size: 12px;
            color: #64748b;
        }

        .output-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 32px;
        }

        .output-label {
            font-size: 13px;
            color: #7a869a;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        .format-buttons {
            display: flex;
            gap: 12px;
        }

        .format-button {
            border: 1px solid #dce1e9;
            border-radius: 12px;
            background: #fff;
            color: #102a43;
            padding: 10px 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .format-button.active {
            background: #0d2640;
            color: #fff;
            border-color: #0d2640;
        }

        .button-primary {
            background: #0d2640;
            color: #fff;
            border: 1px solid #0d2640;
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .button-primary:hover {
            transform: translateY(-1px);
        }

        .metric-card {
            background: #fff;
            border-radius: 24px;
            padding: 26px;
            margin-bottom: 24px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
        }

        .metric-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 22px;
        }

        .metric-top h3 {
            font-size: 14px;
            text-transform: uppercase;
            color: #7a869a;
            letter-spacing: 0.08em;
            margin-bottom: 6px;
        }

        .metric-top .metric-value {
            font-size: 32px;
            color: #102a43;
            font-weight: 800;
        }

        .metric-note {
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
        }

        .report-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .report-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            background: #f8fafc;
            border-radius: 18px;
            padding: 16px 18px;
        }

        .report-item .report-info {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .report-icon {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: #0d2640;
            color: #fff;
            font-size: 16px;
        }

        .report-text {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .report-name {
            font-size: 14px;
            font-weight: 700;
            color: #102a43;
        }

        .report-meta {
            font-size: 12px;
            color: #64748b;
        }

        .report-size {
            font-size: 12px;
            color: #102a43;
        }

        .table-card {
            background: #fff;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            gap: 10px;
        }

        .table-header h2 {
            font-size: 16px;
            color: #102a43;
            font-weight: 700;
        }

        .table-header .info-text {
            font-size: 12px;
            color: #64748b;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 100%;
        }

        .report-table th,
        .report-table td {
            padding: 16px 14px;
            text-align: left;
            border-bottom: 1px solid #e9eef5;
            font-size: 13px;
            color: #24374a;
        }

        .report-table th {
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            font-weight: 700;
            background: transparent;
        }

        .report-table tbody tr:hover {
            background: #f8fafc;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 11px;
            color: #102a43;
            background: #e6f0ff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .action-link {
            color: #0d2640;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
        }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            padding-top: 14px;
        }

        .pagination button {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            border: 1px solid #dce1e9;
            background: #fff;
            color: #102a43;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .pagination button:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }

        .pagination button.active {
            background: #0d2640;
            color: #fff;
            border-color: #0d2640;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
            overflow: hidden;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #1d5aa5 0%, #2b6ab8 100%);
            padding: 20px 24px;
            margin: 0;
            border: none;
        }

        .modal-header h2 {
            font-size: 18px;
            color: #ffffff;
            margin: 0;
            font-weight: 700;
        }

        .modal-header .detail-id {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 4px;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 28px;
            color: #ffffff;
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease;
        }

        .modal-close:hover {
            transform: scale(1.2);
        }

        .modal-body {
            padding: 28px 24px;
            margin-bottom: 0;
        }

        .detail-section {
            margin-bottom: 24px;
        }

        .detail-section:last-child {
            margin-bottom: 0;
        }

        .detail-section-title {
            font-size: 12px;
            text-transform: uppercase;
            color: #7a869a;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 14px;
            display: block;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 16px;
        }

        .detail-grid.full {
            grid-template-columns: 1fr;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .detail-label {
            font-weight: 600;
            color: #7a869a;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .detail-value {
            color: #102a43;
            font-weight: 600;
            font-size: 15px;
        }

        .detail-value.large {
            font-size: 18px;
            font-weight: 700;
            color: #0d2640;
        }

        .detail-badge {
            display: inline-block;
            background: #fff3cd;
            color: #856404;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            width: fit-content;
        }

        .detail-notes {
            background: #f8fafc;
            border: 1px solid #e6ecf6;
            border-radius: 12px;
            padding: 14px;
            margin-top: 12px;
        }

        .detail-notes p {
            font-size: 13px;
            color: #556a82;
            line-height: 1.6;
            margin: 0;
        }

        .modal-footer {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding: 20px 24px;
            background: #f8fafc;
            border-top: 1px solid #e6ecf6;
        }

        .modal-button {
            border: none;
            border-radius: 10px;
            background: #fff;
            color: #102a43;
            padding: 11px 20px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .modal-button.close-btn {
            background: #e6ecf6;
            color: #0d2640;
            border: 1px solid #e6ecf6;
        }

        .modal-button.close-btn:hover {
            background: #dce1e9;
            border-color: #dce1e9;
        }

        .modal-button.pdf-btn {
            background: #dc2626;
            color: #fff;
            border: 1px solid #dc2626;
        }

        .modal-button.pdf-btn:hover {
            background: #b91c1c;
            border-color: #b91c1c;
        }

        .modal-button.excel-btn {
            background: #059669;
            color: #fff;
            border: 1px solid #059669;
        }

        .modal-button.excel-btn:hover {
            background: #047857;
            border-color: #047857;
        }

        .modal-button.word-btn {
            background: #0d47a1;
            color: #fff;
            border: 1px solid #0d47a1;
        }

        .modal-button.word-btn:hover {
            background: #0a3d91;
            border-color: #0a3d91;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 1100px) {
            .layout-grid {
                grid-template-columns: 1fr;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 22px;
            }

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding-bottom: 20px;
            }
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 18px;
            }

            .header,
            .section-title,
            .output-actions,
            .header-right {
                flex-direction: column;
                align-items: stretch;
            }

            .report-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .report-table th,
            .report-table td {
                padding: 14px 10px;
            }
        }
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <main class="main-content">
        <div class="header">
            <div class="header-right">
                <div class="header-icons">
                    <a href="{{ route('staff.profile') }}" style="text-decoration: none; color: inherit;">
                        <div class="header-icon" style="cursor: pointer;"><i class="fas fa-user"
                                style="color: #1a4d7d;"></i></div>
                    </a>
                </div>
            </div>
        </div>

        <section class="page-title">
            <h1>Cetak Laporan</h1>
            <p>Ekspor laporan hasil tangkap yang sudah divalidasi dalam format PDF, Excel, atau Word untuk dokumentasi
                resmi.</p>
        </section>

        <!-- Stats Grid -->
        <div class="stats-grid"
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div class="stat-card"
                style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div
                        style="font-size: 11px; text-transform: uppercase; color: #999; letter-spacing: 0.5px; margin-bottom: 8px; font-weight: 600;">
                        Total Laporan Tervalidasi</div>
                    <div style="font-size: 32px; font-weight: 700; color: #1a4d7d;">{{ $stats['total_validated'] }}
                    </div>
                </div>
                <div
                    style="width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #4caf50;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>

            <div class="stat-card"
                style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div
                        style="font-size: 11px; text-transform: uppercase; color: #999; letter-spacing: 0.5px; margin-bottom: 8px; font-weight: 600;">
                        Total Berat (kg)</div>
                    <div style="font-size: 32px; font-weight: 700; color: #1a4d7d;">
                        {{ number_format($stats['total_weight'], 0, ',', '.') }}</div>
                </div>
                <div
                    style="width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #2196f3;">
                    <i class="fas fa-weight"></i>
                </div>
            </div>

            <div class="stat-card"
                style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div
                        style="font-size: 11px; text-transform: uppercase; color: #999; letter-spacing: 0.5px; margin-bottom: 8px; font-weight: 600;">
                        Rata-rata Berat</div>
                    <div style="font-size: 32px; font-weight: 700; color: #1a4d7d;">
                        {{ number_format($stats['avg_weight'], 2, ',', '.') }}</div>
                </div>
                <div
                    style="width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #ff9800;">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div
            style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); margin-bottom: 25px;">
            <form method="GET" action="{{ route('staff.cetak') }}" style="width: 100%;">
                <div style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 200px;">
                        <label
                            style="font-size: 12px; text-transform: uppercase; color: #7a869a; letter-spacing: 0.5px; margin-bottom: 8px; font-weight: 600; display: block;">Cari
                            Data</label>
                        <input type="text" name="search" value="{{ $search }}"
                            placeholder="Cari nama nelayan, pembeli, atau jenis ikan..."
                            style="width: 100%; border: 1px solid #dce1e9; border-radius: 6px; padding: 10px 14px; font-size: 13px; background: #f8fafc; color: #102a43; outline: none;">
                    </div>
                    <div style="flex: 1; min-width: 150px;">
                        <label
                            style="font-size: 12px; text-transform: uppercase; color: #7a869a; letter-spacing: 0.5px; margin-bottom: 8px; font-weight: 600; display: block;">Dari
                            Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            style="width: 100%; border: 1px solid #dce1e9; border-radius: 6px; padding: 10px 14px; font-size: 13px; background: #f8fafc; color: #102a43; outline: none;">
                    </div>
                    <div style="flex: 1; min-width: 150px;">
                        <label
                            style="font-size: 12px; text-transform: uppercase; color: #7a869a; letter-spacing: 0.5px; margin-bottom: 8px; font-weight: 600; display: block;">Sampai
                            Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            style="width: 100%; border: 1px solid #dce1e9; border-radius: 6px; padding: 10px 14px; font-size: 13px; background: #f8fafc; color: #102a43; outline: none;">
                    </div>
                    <button type="submit"
                        style="background: #0d2640; color: white; border: 1px solid #0d2640; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h2>Data Laporan Tervalidasi</h2>
                <span class="info-text">Total: {{ $laporans->total() }} data</span>
            </div>

            @if ($laporans->count() > 0)
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Nelayan</th>
                            <th>Nama Pembeli</th>
                            <th>Jenis Ikan</th>
                            <th>Berat (kg)</th>
                            <th>Harga Jual</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporans as $laporan)
                            <tr>
                                <td>#{{ $laporan->id }}</td>
                                <td><strong>{{ $laporan->nama_nelayan }}</strong></td>
                                <td>{{ $laporan->nama_pembeli }}</td>
                                <td>{{ $laporan->jenis_ikan }}</td>
                                <td><strong>{{ number_format($laporan->berat, 2) }}</strong></td>
                                <td>Rp {{ number_format($laporan->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <button type="button" class="action-btn btn-download"
                                        data-id="{{ $laporan->id }}"
                                        style="background: #e3f2fd; color: #0d2640; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 11px; font-weight: 600;">
                                        <i class="fas fa-download"></i> Download
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination" style="margin-top: 20px;">
                    {{ $laporans->links('pagination.custom') }}
                </div>
            @else
                <div style="text-align: center; padding: 40px 20px; color: #999;">
                    <i class="fas fa-inbox"
                        style="font-size: 48px; color: #ddd; margin-bottom: 15px; display: block;"></i>
                    <p style="font-size: 14px;">Belum ada data laporan yang tervalidasi</p>
                </div>
            @endif
        </div>
        </tbody>
        </table>
        <div class="pagination">
            <button class="pagination-prev" data-action="prev">&lt;</button>
            <button class="pagination-page active" data-page="1">1</button>
            <button class="pagination-page" data-page="2">2</button>
            <button class="pagination-page" data-page="3">3</button>
            <button class="pagination-next" data-action="next">&gt;</button>
        </div>
        </div>
    </main>

    <script>
        // Download laporan function
        function downloadLaporan(format, laporanId = null) {
            const requestData = {
                format: format,
                laporan_id: laporanId
            };

            // Create form untuk download
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('staff.cetak.download') }}';

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Add form data
            Object.keys(requestData).forEach(key => {
                if (requestData[key] !== null) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = requestData[key];
                    form.appendChild(input);
                }
            });

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        // Event listener untuk tombol download di table
        document.querySelectorAll('.btn-download').forEach(btn => {
            btn.addEventListener('click', function() {
                const laporanId = this.dataset.id;

                // Show format selection
                const format = confirm('Pilih format:\nOK = PDF\nCancel = Excel') ? 'pdf' : 'excel';
                downloadLaporan(format, laporanId);
            });
        });

        // Download all data
        function downloadAllData(format = 'pdf') {
            downloadLaporan(format);
        }
    </script>
</body>

</html>
