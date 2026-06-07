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

            main>div:nth-child(3) {
                grid-template-columns: 1fr !important;
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
                    <a href="#" style="text-decoration: none; color: inherit;" onclick="openProfileModal(event)">
                        <div class="header-icon" style="cursor: pointer;"><i class="fas fa-user"
                                style="color: #1a4d7d;"></i></div>
                    </a>
                </div>
            </div>
        </div>

        <section class="page-title">
            <h1>Cetak Laporan</h1>
            <p>Hasilkan dan ekspor laporan hasil tangkap yang komprehensif. Pilih parameter Anda di bawah ini untuk
                menciptakan laporan</p>
        </section>

        <!-- Main Content Grid -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 30px; margin-bottom: 30px;">
            <!-- Form Laporan -->
            <div
                style="background: white; padding: 28px; border-radius: 14px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06); height: fit-content;">

                <form id="filterForm" method="GET" action="{{ route('staff.cetak') }}">
                    <!-- Asal TPI -->
                    <div style="margin-bottom: 20px;">
                        <label
                            style="font-size: 12px; font-weight: 600; color: #7a869a; text-transform: uppercase; display: block; margin-bottom: 8px;">Asal
                            TPI</label>
                        <select id="filterTpi" name="tpi" onchange="triggerFilter()"
                            style="width: 100%; border: 1px solid #dce1e9; border-radius: 8px; padding: 11px 14px; font-size: 13px; background: #f8fafc; color: #102a43; outline: none; appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22><path fill=%22%237a869a%22 d=%22M5.5 7.5l4.5 4.5 4.5-4.5%22/></svg>'); background-repeat: no-repeat; background-position: right 12px center; background-size: 12px; padding-right: 36px;">
                            <option value="">Semua TPI</option>
                            @foreach ($tpiList as $tpi)
                                <option value="{{ $tpi->id }}" @if ($tpiFilter == $tpi->id) selected @endif>
                                    {{ $tpi->wilayah }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div style="margin-bottom: 20px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label
                                    style="font-size: 12px; font-weight: 600; color: #7a869a; text-transform: uppercase; display: block; margin-bottom: 8px;">Mulai
                                    Dari</label>
                                <input type="date" id="filterStartDate" name="start_date" onchange="triggerFilter()"
                                    value="{{ $startDate }}"
                                    style="width: 100%; border: 1px solid #dce1e9; border-radius: 8px; padding: 11px 12px; font-size: 12px; background: #f8fafc; color: #102a43; outline: none;">
                            </div>
                            <div>
                                <label
                                    style="font-size: 12px; font-weight: 600; color: #7a869a; text-transform: uppercase; display: block; margin-bottom: 8px;">Sampai
                                    Dengan</label>
                                <input type="date" id="filterEndDate" name="end_date" onchange="triggerFilter()"
                                    value="{{ $endDate }}"
                                    style="width: 100%; border: 1px solid #dce1e9; border-radius: 8px; padding: 11px 12px; font-size: 12px; background: #f8fafc; color: #102a43; outline: none;">
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Laporan -->
                    <div style="margin-bottom: 22px;">
                        <label
                            style="font-size: 12px; font-weight: 600; color: #7a869a; text-transform: uppercase; display: block; margin-bottom: 12px;">Jenis
                            Laporan Berkala</label>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <label
                                style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #f8fafc; border: 1px solid #dce1e9; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                <input type="radio" id="jenisLaporanHarian" name="jenis_laporan" value="harian"
                                    onchange="triggerFilter()" style="cursor: pointer;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #102a43; font-size: 13px;">Laporan Harian</div>
                                </div>
                            </label>
                            <label
                                style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #f8fafc; border: 1px solid #dce1e9; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                <input type="radio" id="jenisLaporanBulanan" name="jenis_laporan" value="bulanan"
                                    onchange="triggerFilter()" style="cursor: pointer;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #102a43; font-size: 13px;">Laporan Bulanan
                                    </div>
                                </div>
                            </label>
                            <label
                                style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #f8fafc; border: 1px solid #dce1e9; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                <input type="radio" id="jenisLaporanTahunan" name="jenis_laporan" value="tahunan"
                                    onchange="triggerFilter()" style="cursor: pointer;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #102a43; font-size: 13px;">Laporan Tahunan
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Pilih Bulan (hanya untuk Laporan Bulanan) -->
                    <div id="bulanan-section" style="margin-bottom: 22px; display: none;">
                        <div style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                            <div>
                                <label
                                    style="font-size: 12px; font-weight: 600; color: #7a869a; text-transform: uppercase; display: block; margin-bottom: 8px;">Pilih
                                    Bulan</label>
                                <select id="filterBulan" name="bulan" onchange="triggerFilter()"
                                    style="width: 100%; border: 1px solid #dce1e9; border-radius: 8px; padding: 11px 14px; font-size: 13px; background: #f8fafc; color: #102a43; outline: none; appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22><path fill=%22%237a869a%22 d=%22M5.5 7.5l4.5 4.5 4.5-4.5%22/></svg>'); background-repeat: no-repeat; background-position: right 12px center; background-size: 12px; padding-right: 36px;">
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Pilih Tahun (hanya untuk Laporan Tahunan) -->
                    <div id="tahunan-section" style="margin-bottom: 22px; display: none;">
                        <div style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                            <div>
                                <label
                                    style="font-size: 12px; font-weight: 600; color: #7a869a; text-transform: uppercase; display: block; margin-bottom: 8px;">Pilih
                                    Tahun</label>
                                <select id="filterTahun" name="tahun" onchange="triggerFilter()"
                                    style="width: 100%; border: 1px solid #dce1e9; border-radius: 8px; padding: 11px 14px; font-size: 13px; background: #f8fafc; color: #102a43; outline: none; appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22><path fill=%22%237a869a%22 d=%22M5.5 7.5l4.5 4.5 4.5-4.5%22/></svg>'); background-repeat: no-repeat; background-position: right 12px center; background-size: 12px; padding-right: 36px;">
                                    <option value="">-- Pilih Tahun --</option>
                                    @php
                                        $currentYear = date('Y');
                                        for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                            echo '<option value="' . $year . '">' . $year . '</option>';
                                        }
                                    @endphp
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Format Output -->
                    <div style="margin-bottom: 22px;">
                        <label
                            style="font-size: 12px; font-weight: 600; color: #7a869a; text-transform: uppercase; display: block; margin-bottom: 12px;">Format
                            Output</label>
                        <div style="display: flex; gap: 10px;">
                            <button type="button" id="btnFormatPdf" onclick="selectFormat('pdf')"
                                ondblclick="toggleFormatSelection('pdf')"
                                style="flex: 1; padding: 10px; border: 1px solid #dce1e9; background: white; color: #102a43; border-radius: 8px; font-weight: 600; font-size: 12px; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.background='#fef2f2'; this.style.borderColor='#dc2626';"
                                onmouseout="this.style.background='white'; this.style.borderColor='#dce1e9';">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                            <button type="button" id="btnFormatExcel" onclick="selectFormat('excel')"
                                ondblclick="toggleFormatSelection('excel')"
                                style="flex: 1; padding: 10px; border: 1px solid #dce1e9; background: white; color: #102a43; border-radius: 8px; font-weight: 600; font-size: 12px; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.background='#f0fdf4'; this.style.borderColor='#16a34a';"
                                onmouseout="this.style.background='white'; this.style.borderColor='#dce1e9';">
                                <i class="fas fa-file-excel"></i> EXCEL
                            </button>
                        </div>
                    </div>

                    <!-- Preview Button -->
                    <div style="display: flex; gap: 10px;">
                        <button type="button" onclick="resetFilters()"
                            style="flex: 1; padding: 12px; background: #f0f0f0; color: #102a43; border: 1px solid #dce1e9; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='#e0e0e0';"
                            onmouseout="this.style.background='#f0f0f0';">
                            <i class="fas fa-redo"></i> Reset Filter
                        </button>
                        <button type="button" onclick="triggerDownload()"
                            style="flex: 1; padding: 12px; background: #0a1f3b; color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='#132d4f';"
                            onmouseout="this.style.background='#0a1f3b';">
                            <i class="fas fa-download"></i> Download Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-card" id="laporan-tabel">
            <div class="table-header">
                <h2 style="font-size: 18px; font-weight: 700; color: #102a43;">Tabel Arsip Laporan Cetak</h2>
                <div id="filterStatus" style="font-size: 12px; color: #64748b; display: none;">Hasil Filter: <span
                        id="filterCount">0</span> data</div>
            </div>

            <!-- Loading Indicator -->
            <div id="loadingIndicator" style="display: none; text-align: center; padding: 40px; color: #999;">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 15px; display: block;"></i>
                <p style="font-size: 14px;">Memuat data...</p>
            </div>

            <!-- Empty State -->
            <div id="emptyState" style="display: none; text-align: center; padding: 60px 20px; color: #999;">
                <i class="fas fa-inbox"
                    style="font-size: 48px; color: #ddd; margin-bottom: 15px; display: block;"></i>
                <p style="font-size: 14px;">Belum ada data laporan yang tervalidasi</p>
            </div>

            <!-- Table Container -->
            <div id="tableContainer">
                @if ($laporans->count() > 0)
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>ID LAPORAN</th>
                                <th>TANGGAL DIBUAT</th>
                                <th>CAKUPAN DATA</th>
                                <th>DIBUAT OLEH</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="laporanTableBody">
                            @foreach ($laporans as $laporan)
                                <tr>
                                    <td><strong>#LAP-{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                    <td>{{ $laporan->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <span
                                            style="background: #e3f2fd; color: #0d2640; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;">
                                            @if ($laporan->user)
                                                TPI {{ $laporan->user->wilayah ?: $laporan->user->nama }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ $laporan->user ? $laporan->user->nama : 'N/A' }}</td>
                                    <td>
                                        <button type="button" class="action-btn btn-download"
                                            data-id="{{ $laporan->id }}"
                                            style="background: #e3f2fd; color: #0d2640; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 11px; font-weight: 600; transition: all 0.2s;"
                                            onmouseover="this.style.background='#0d2640'; this.style.color='white';"
                                            onmouseout="this.style.background='#e3f2fd'; this.style.color='#0d2640';">
                                            <i class="fas fa-download"></i> Download
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div style="margin-top: 20px; display: flex; justify-content: flex-end;" id="paginationContainer">
                        {{ $laporans->links('pagination.custom') }}
                    </div>
                @else
                    <div style="text-align: center; padding: 60px 20px; color: #999;">
                        <i class="fas fa-inbox"
                            style="font-size: 48px; color: #ddd; margin-bottom: 15px; display: block;"></i>
                        <p style="font-size: 14px;">Belum ada data laporan yang tervalidasi</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        // === GLOBAL VARIABLES ===
        let selectedFormat = null; // No default format selected

        // === AJAX FILTERING LOGIC ===

        // Debounce function untuk mencegah multiple AJAX calls
        let filterTimeout;

        function triggerFilter() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(() => {
                fetchFilteredData();
            }, 300); // 300ms delay
        }

        // Fetch filtered data via AJAX
        function fetchFilteredData() {
            const tpi = document.getElementById('filterTpi').value;
            const startDate = document.getElementById('filterStartDate').value;
            const endDate = document.getElementById('filterEndDate').value;
            const jenisLaporan = document.querySelector('input[name="jenis_laporan"]:checked')?.value || '';
            const bulan = document.getElementById('filterBulan').value;
            const tahun = document.getElementById('filterTahun').value;

            // Show loading indicator
            const loadingIndicator = document.getElementById('loadingIndicator');
            const tableContainer = document.getElementById('tableContainer');
            loadingIndicator.style.display = 'block';
            tableContainer.style.opacity = '0.5';

            // Build query parameters
            const params = new URLSearchParams();
            if (tpi) params.append('tpi', tpi);
            if (startDate) params.append('start_date', startDate);
            if (endDate) params.append('end_date', endDate);
            if (jenisLaporan) params.append('jenis_laporan', jenisLaporan);
            if (bulan) params.append('bulan', bulan);
            if (tahun) params.append('tahun', tahun);
            params.append('page', 1);

            // AJAX request
            fetch(`{{ route('staff.cetak.filter') }}?${params.toString()}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loadingIndicator.style.display = 'none';
                    tableContainer.style.opacity = '1';

                    if (data.success) {
                        updateTable(data.data, data.pagination);
                    } else {
                        showEmptyState(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingIndicator.style.display = 'none';
                    tableContainer.style.opacity = '1';
                    alert('Terjadi kesalahan saat mengambil data');
                });
        }

        // Update table with filtered data
        function updateTable(data, pagination) {
            const tbody = document.getElementById('laporanTableBody');
            const tableContainer = document.getElementById('tableContainer');
            const filterStatus = document.getElementById('filterStatus');
            const paginationContainer = document.getElementById('paginationContainer');

            if (data.length === 0) {
                showEmptyState('Tidak ada data yang sesuai dengan filter');
                return;
            }

            // Build table rows
            let html = '';
            data.forEach(laporan => {
                html += `
                    <tr>
                        <td><strong>${laporan.id_laporan}</strong></td>
                        <td>${laporan.tanggal_dibuat}</td>
                        <td>
                            <span style="background: #e3f2fd; color: #0d2640; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;">
                                TPI ${laporan.tpi}
                            </span>
                        </td>
                        <td>${laporan.dibuat_oleh}</td>
                        <td>
                            <button type="button" class="action-btn btn-download"
                                data-id="${laporan.id}"
                                style="background: #e3f2fd; color: #0d2640; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 11px; font-weight: 600; transition: all 0.2s;"
                                onmouseover="this.style.background='#0d2640'; this.style.color='white';"
                                onmouseout="this.style.background='#e3f2fd'; this.style.color='#0d2640';">
                                <i class="fas fa-download"></i> Download
                            </button>
                        </td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;

            // Show filter status
            filterStatus.style.display = 'block';
            document.getElementById('filterCount').textContent = pagination.total;

            // Update pagination
            if (pagination.last_page > 1) {
                let paginationHtml = '<div style="display: flex; gap: 5px; justify-content: center;">';

                // Previous button
                if (pagination.current_page > 1) {
                    paginationHtml +=
                        `<button onclick="goToPage(${pagination.current_page - 1})" style="padding: 8px 12px; border: 1px solid #dce1e9; background: white; cursor: pointer; border-radius: 4px;">← Prev</button>`;
                }

                // Page numbers
                const maxPages = 5;
                let startPage = Math.max(1, pagination.current_page - Math.floor(maxPages / 2));
                let endPage = Math.min(pagination.last_page, startPage + maxPages - 1);

                if (endPage - startPage < maxPages - 1) {
                    startPage = Math.max(1, endPage - maxPages + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    if (i === pagination.current_page) {
                        paginationHtml +=
                            `<button style="padding: 8px 12px; border: 1px solid #0d2640; background: #0d2640; color: white; cursor: pointer; border-radius: 4px;">${i}</button>`;
                    } else {
                        paginationHtml +=
                            `<button onclick="goToPage(${i})" style="padding: 8px 12px; border: 1px solid #dce1e9; background: white; cursor: pointer; border-radius: 4px;">${i}</button>`;
                    }
                }

                // Next button
                if (pagination.current_page < pagination.last_page) {
                    paginationHtml +=
                        `<button onclick="goToPage(${pagination.current_page + 1})" style="padding: 8px 12px; border: 1px solid #dce1e9; background: white; cursor: pointer; border-radius: 4px;">Next →</button>`;
                }

                paginationHtml += '</div>';
                paginationContainer.innerHTML = paginationHtml;
            } else {
                paginationContainer.innerHTML = '';
            }

            // Re-attach download button listeners
            attachDownloadListeners();
        }

        // Show empty state
        function showEmptyState(message) {
            const tableContainer = document.getElementById('tableContainer');
            const tbody = document.getElementById('laporanTableBody');
            const filterStatus = document.getElementById('filterStatus');
            const paginationContainer = document.getElementById('paginationContainer');

            if (tbody) {
                tbody.innerHTML = '';
            }

            filterStatus.style.display = 'none';
            paginationContainer.innerHTML = '';

            tableContainer.innerHTML = `
                <div style="text-align: center; padding: 60px 20px; color: #999;">
                    <i class="fas fa-inbox" style="font-size: 48px; color: #ddd; margin-bottom: 15px; display: block;"></i>
                    <p style="font-size: 14px;">${message}</p>
                </div>
            `;
        }

        // Go to specific page
        function goToPage(page) {
            const tpi = document.getElementById('filterTpi').value;
            const startDate = document.getElementById('filterStartDate').value;
            const endDate = document.getElementById('filterEndDate').value;
            const jenisLaporan = document.querySelector('input[name="jenis_laporan"]:checked')?.value || '';
            const bulan = document.getElementById('filterBulan').value;
            const tahun = document.getElementById('filterTahun').value;

            const params = new URLSearchParams();
            if (tpi) params.append('tpi', tpi);
            if (startDate) params.append('start_date', startDate);
            if (endDate) params.append('end_date', endDate);
            if (jenisLaporan) params.append('jenis_laporan', jenisLaporan);
            if (bulan) params.append('bulan', bulan);
            if (tahun) params.append('tahun', tahun);
            params.append('page', page);

            fetch(`{{ route('staff.cetak.filter') }}?${params.toString()}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateTable(data.data, data.pagination);
                    }
                });
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('filterForm').reset();
            document.getElementById('bulanan-section').style.display = 'none';
            document.getElementById('tahunan-section').style.display = 'none';
            document.getElementById('filterStatus').style.display = 'none';

            // Reset table to initial state
            location.reload();
        }

        // Download laporan function
        function triggerDownload() {
            if (!selectedFormat) {
                alert('Pilih format (PDF atau EXCEL) terlebih dahulu!');
                return;
            }
            downloadLaporan(selectedFormat);
        }

        function downloadLaporan(format, laporanId = null) {
            const requestData = {
                format: format,
                laporan_id: laporanId
            };

            // Get filter values dari form
            const tpiFilter = document.querySelector('select[name="tpi"]')?.value;
            const startDate = document.querySelector('input[name="start_date"]')?.value;
            const endDate = document.querySelector('input[name="end_date"]')?.value;
            const jenisLaporan = document.querySelector('input[name="jenis_laporan"]:checked')?.value || 'bulanan';
            const bulan = document.querySelector('select[name="bulan"]')?.value;
            const tahun = document.querySelector('select[name="tahun"]')?.value;

            // Validasi untuk laporan bulanan
            if (jenisLaporan === 'bulanan' && !laporanId) {
                if (!bulan) {
                    alert('Silakan pilih bulan untuk laporan bulanan!');
                    return;
                }
            }

            // Validasi untuk laporan tahunan
            if (jenisLaporan === 'tahunan' && !laporanId) {
                if (!tahun) {
                    alert('Silakan pilih tahun untuk laporan tahunan!');
                    return;
                }
            }

            // Add filter data jika ada
            if (tpiFilter) {
                requestData.tpi = tpiFilter;
            }

            // Untuk laporan bulanan, kirim bulan; untuk tahunan kirim tahun; untuk yang lain kirim date range
            if (jenisLaporan === 'bulanan' && !laporanId) {
                requestData.bulan = bulan;
            } else if (jenisLaporan === 'tahunan' && !laporanId) {
                requestData.tahun = tahun;
            } else {
                if (startDate && !laporanId) {
                    requestData.start_date = startDate;
                }
                if (endDate && !laporanId) {
                    requestData.end_date = endDate;
                }
            }

            if (!laporanId) {
                requestData.jenis_laporan = jenisLaporan;
            }

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
                if (requestData[key] !== null && requestData[key] !== '') {
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

        // Attach download button listeners
        function attachDownloadListeners() {
            document.querySelectorAll('.btn-download').forEach(btn => {
                btn.removeEventListener('click', handleDownloadClick);
                btn.addEventListener('click', handleDownloadClick);
            });
        }

        function handleDownloadClick(e) {
            const laporanId = e.currentTarget.dataset.id;
            if (!selectedFormat) {
                alert('Pilih format (PDF atau EXCEL) terlebih dahulu!');
                return;
            }
            downloadLaporan(selectedFormat, laporanId);
        }

        // Select format function
        function selectFormat(format) {
            selectedFormat = format;

            // Update button styles
            const btnPdf = document.getElementById('btnFormatPdf');
            const btnExcel = document.getElementById('btnFormatExcel');

            if (format === 'pdf') {
                btnPdf.style.background = '#fee';
                btnPdf.style.border = '2px solid #dc2626';
                btnPdf.style.color = '#dc2626';
                btnPdf.dataset.selected = 'true';

                btnExcel.style.background = 'white';
                btnExcel.style.border = '1px solid #dce1e9';
                btnExcel.style.color = '#102a43';
                btnExcel.dataset.selected = 'false';

                // Override mouseout for PDF to keep color
                btnPdf.onmouseout = function() {
                    if (selectedFormat === 'pdf') {
                        this.style.background = '#fee';
                        this.style.borderColor = '#dc2626';
                    } else {
                        this.style.background = 'white';
                        this.style.borderColor = '#dce1e9';
                    }
                };

                // Reset mouseout for EXCEL
                btnExcel.onmouseout = function() {
                    this.style.background = 'white';
                    this.style.borderColor = '#dce1e9';
                };
            } else {
                btnPdf.style.background = 'white';
                btnPdf.style.border = '1px solid #dce1e9';
                btnPdf.style.color = '#102a43';
                btnPdf.dataset.selected = 'false';

                btnExcel.style.background = '#f0fdf4';
                btnExcel.style.border = '2px solid #16a34a';
                btnExcel.style.color = '#16a34a';
                btnExcel.dataset.selected = 'true';

                // Reset mouseout for PDF
                btnPdf.onmouseout = function() {
                    this.style.background = 'white';
                    this.style.borderColor = '#dce1e9';
                };

                // Override mouseout for EXCEL to keep color
                btnExcel.onmouseout = function() {
                    if (selectedFormat === 'excel') {
                        this.style.background = '#f0fdf4';
                        this.style.borderColor = '#16a34a';
                    } else {
                        this.style.background = 'white';
                        this.style.borderColor = '#dce1e9';
                    }
                };
            }
        }

        // Toggle format selection on double click
        function toggleFormatSelection(format) {
            if (selectedFormat === format) {
                // Deselect - remove all colors
                const btnPdf = document.getElementById('btnFormatPdf');
                const btnExcel = document.getElementById('btnFormatExcel');

                selectedFormat = null;

                btnPdf.style.background = 'white';
                btnPdf.style.border = '1px solid #dce1e9';
                btnPdf.style.color = '#102a43';
                btnPdf.dataset.selected = 'false';

                btnExcel.style.background = 'white';
                btnExcel.style.border = '1px solid #dce1e9';
                btnExcel.style.color = '#102a43';
                btnExcel.dataset.selected = 'false';

                // Reset mouseout handlers - plain reset without checking selectedFormat
                btnPdf.onmouseout = function() {
                    this.style.background = 'white';
                    this.style.borderColor = '#dce1e9';
                };
                btnExcel.onmouseout = function() {
                    this.style.background = 'white';
                    this.style.borderColor = '#dce1e9';
                };
            } else {
                // Select normally
                selectFormat(format);
            }
        }

        // Handle jenis laporan radio button styling dan tampilkan/sembunyikan field
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="jenis_laporan"]');
            const bulananSection = document.getElementById('bulanan-section');
            const tahunanSection = document.getElementById('tahunan-section');
            let lastSelected = null;

            radioButtons.forEach(radio => {
                const label = radio.closest('label');

                radio.addEventListener('change', function() {
                    // Reset all labels to default style
                    radioButtons.forEach(rb => {
                        const lbl = rb.closest('label');
                        lbl.style.background = '#f8fafc';
                        lbl.style.border = '1px solid #dce1e9';
                    });

                    // Style the selected label
                    if (this.checked) {
                        label.style.background = '#edf2ff';
                        label.style.border = '2px solid #0d2640';
                        lastSelected = this.value;

                        // Tampilkan/sembunyikan section berdasarkan jenis laporan
                        if (this.value === 'bulanan') {
                            bulananSection.style.display = 'block';
                            tahunanSection.style.display = 'none';
                        } else if (this.value === 'tahunan') {
                            bulananSection.style.display = 'none';
                            tahunanSection.style.display = 'block';
                        } else {
                            bulananSection.style.display = 'none';
                            tahunanSection.style.display = 'none';
                        }
                    }
                });

                // Add click handler for toggle behavior
                radio.addEventListener('click', function(e) {
                    if (lastSelected === this.value && this.checked) {
                        // If clicking the same option, uncheck it
                        this.checked = false;
                        label.style.background = '#f8fafc';
                        label.style.border = '1px solid #dce1e9';
                        lastSelected = null;
                        bulananSection.style.display = 'none';
                        tahunanSection.style.display = 'none';
                    }
                });
            });

            // Attach initial download button listeners
            attachDownloadListeners();
        });

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
</body>

</html>
