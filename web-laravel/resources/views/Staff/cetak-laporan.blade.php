<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cetak Laporan - SIPETANG</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #eef2ff 0%, #f0f9ff 50%, #f5f3ff 100%);
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
            margin-bottom: 28px;
        }

        .page-title h1 {
            font-size: 32px;
            font-weight: 800;
            color: #0d2640;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .page-title p {
            max-width: 700px;
            font-size: 14px;
            color: #556a82;
            line-height: 1.7;
        }

        .page-title-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, rgba(10, 59, 153, 0.08) 0%, rgba(29, 101, 208, 0.12) 100%);
            border: 1px solid rgba(10, 59, 153, 0.15);
            color: #0a3b99;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 999px;
            margin-bottom: 12px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .layout-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 24px;
            margin-bottom: 30px;
            align-items: start;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 22px;
            padding: 28px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08), 0 1px 0 rgba(255,255,255,0.8) inset;
            border: 1px solid rgba(255, 255, 255, 0.7);
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
            background: linear-gradient(135deg, #f8fafc 0%, #f0f4ff 100%);
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
            border: 1.5px solid #dce1e9;
            border-radius: 18px;
            padding: 16px;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }

        .frequency-option.active-laporan {
            border-color: #0d2640;
            background: linear-gradient(135deg, #edf2ff 0%, #e8f0fe 100%);
            box-shadow: 0 4px 16px rgba(10, 59, 153, 0.12);
        }

        .frequency-option:hover {
            border-color: #1a4d7d;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(10, 59, 153, 0.1);
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
            border: 1.5px solid #dce1e9;
            border-radius: 12px;
            background: #fff;
            color: #102a43;
            padding: 10px 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }

        .format-button.active {
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(10, 59, 153, 0.3);
        }

        .button-primary {
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(10, 59, 153, 0.25);
        }

        .button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(10, 59, 153, 0.35);
        }

        .metric-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 26px;
            margin-bottom: 24px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08), 0 1px 0 rgba(255,255,255,0.8) inset;
            border: 1px solid rgba(255,255,255,0.7);
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
            background: linear-gradient(135deg, #f8fafc 0%, #f0f4ff 100%);
            border-radius: 18px;
            padding: 16px 18px;
            border: 1px solid rgba(220, 225, 233, 0.5);
            transition: all 0.25s ease;
        }

        .report-item:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 16px rgba(10, 59, 153, 0.08);
            border-color: rgba(29, 101, 208, 0.2);
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
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            color: #fff;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(10, 59, 153, 0.2);
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
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 0;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08), 0 1px 0 rgba(255,255,255,0.8) inset;
            border: 1px solid rgba(255, 255, 255, 0.7);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 22px 26px 18px;
            gap: 10px;
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 60%, #3b82f6 100%);
            position: relative;
            overflow: hidden;
        }

        .table-header::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 120px;
            height: 120px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }

        .table-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 40%;
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .table-header h2 {
            font-size: 17px;
            color: #ffffff;
            font-weight: 700;
            letter-spacing: -0.2px;
        }

        .table-header .info-text {
            font-size: 12px;
            color: rgba(255,255,255,0.75);
        }

        .table-header-icon {
            width: 38px;
            height: 38px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            margin-right: 12px;
        }

        .table-header-title {
            display: flex;
            align-items: center;
        }

        .table-body-wrapper {
            padding: 20px 24px 24px;
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

        .report-table tbody tr {
            transition: all 0.2s ease;
        }

        .report-table tbody tr:hover {
            background: linear-gradient(135deg, #f0f4ff 0%, #f8fafc 100%);
            transform: scale(1.001);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 11px;
            color: #1e40af;
            background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border: 1px solid rgba(59, 130, 246, 0.15);
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
            border: 1.5px solid #dce1e9;
            background: #fff;
            color: #102a43;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }

        .pagination button:hover:not(:disabled) {
            border-color: #1d65d0;
            color: #1d65d0;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(29, 101, 208, 0.15);
        }

        .pagination button:disabled {
            cursor: not-allowed;
            opacity: 0.4;
        }

        .pagination button.active {
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(10, 59, 153, 0.3);
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

        /* Footer */
        .page-footer {
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
            margin-top: 30px;
            padding: 20px 0;
            border-top: 1px solid rgba(220, 225, 233, 0.6);
        }

        /* Form card enhanced */
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 28px;
            border-radius: 22px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08), 0 1px 0 rgba(255,255,255,0.8) inset;
            border: 1px solid rgba(255, 255, 255, 0.7);
            height: fit-content;
        }

        .form-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 26px;
            padding-bottom: 18px;
            border-bottom: 1px solid #f0f4ff;
        }

        .form-card-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            box-shadow: 0 6px 16px rgba(10, 59, 153, 0.25);
            flex-shrink: 0;
        }

        .form-card-title {
            font-size: 17px;
            font-weight: 700;
            color: #102a43;
            letter-spacing: -0.2px;
        }

        .form-card-subtitle {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .form-section-label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-section-label::before {
            content: '';
            width: 3px;
            height: 12px;
            background: linear-gradient(180deg, #0a3b99 0%, #1d65d0 100%);
            border-radius: 2px;
            display: inline-block;
        }

        .form-input-styled {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13.5px;
            background: #f8fafc;
            color: #102a43;
            outline: none;
            transition: all 0.25s ease;
            font-family: inherit;
        }

        .form-input-styled:focus {
            border-color: #1d65d0;
            background: white;
            box-shadow: 0 0 0 3px rgba(29, 101, 208, 0.1);
        }

        .form-select-styled {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 40px 12px 16px;
            font-size: 13.5px;
            background-color: #f8fafc;
            color: #102a43;
            outline: none;
            appearance: none;
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="%231d65d0" d="M5.5 7.5l4.5 4.5 4.5-4.5"/></svg>');
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 14px;
            transition: all 0.25s ease;
            cursor: pointer;
            font-family: inherit;
        }

        .form-select-styled:focus {
            border-color: #1d65d0;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(29, 101, 208, 0.1);
        }

        .radio-option-styled {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            background: white;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.25s ease;
            margin-bottom: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        }

        .radio-option-styled:hover {
            border-color: #1d65d0;
            background: #f0f4ff;
            transform: translateX(3px);
            box-shadow: 0 4px 12px rgba(29, 101, 208, 0.1);
        }

        .radio-option-styled.selected {
            border-color: #0a3b99;
            background: linear-gradient(135deg, #edf2ff 0%, #e8f0fe 100%);
            box-shadow: 0 4px 14px rgba(10, 59, 153, 0.12);
        }

        .radio-option-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .radio-harian .radio-option-icon {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #d97706;
        }

        .radio-bulanan .radio-option-icon {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #059669;
        }

        .radio-tahunan .radio-option-icon {
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            color: #7c3aed;
        }

        .radio-option-text .title {
            font-size: 13.5px;
            font-weight: 700;
            color: #102a43;
        }

        .radio-option-text .desc {
            font-size: 11.5px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .format-btn-pdf {
            flex: 1;
            padding: 13px;
            border: 1.5px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 12px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        }

        .format-btn-pdf:hover {
            border-color: #dc2626;
            color: #dc2626;
            background: #fef2f2;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.12);
        }

        .format-btn-pdf.selected {
            border-color: #dc2626;
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.2);
        }

        .format-btn-excel {
            flex: 1;
            padding: 13px;
            border: 1.5px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 12px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        }

        .format-btn-excel:hover {
            border-color: #16a34a;
            color: #16a34a;
            background: #f0fdf4;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(22, 163, 74, 0.12);
        }

        .format-btn-excel.selected {
            border-color: #16a34a;
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #16a34a;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.2);
        }

        .btn-reset {
            flex: 1;
            padding: 13px;
            background: #f1f5f9;
            color: #64748b;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-reset:hover {
            background: #e2e8f0;
            color: #475569;
            transform: translateY(-1px);
        }

        .btn-download-main {
            flex: 1;
            padding: 13px;
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 16px rgba(10, 59, 153, 0.3);
        }

        .btn-download-main:hover {
            background: linear-gradient(135deg, #0d2640 0%, #0a3b99 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(10, 59, 153, 0.4);
        }

        .btn-download-main:active {
            transform: translateY(0);
        }

        .sub-section-card {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%);
            border: 1.5px solid rgba(29, 101, 208, 0.15);
            border-radius: 14px;
            padding: 16px;
            margin-top: 6px;
        }

        .sub-section-card .btn-preview {
            width: 100%;
            padding: 12px;
            background: white;
            color: #0a3b99;
            border: 1.5px solid rgba(29, 101, 208, 0.2);
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(29, 101, 208, 0.08);
            margin-top: 10px;
        }

        .sub-section-card .btn-preview:hover {
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(10, 59, 153, 0.25);
        }

        /* Loading state */
        .loading-state {
            text-align: center;
            padding: 50px 20px;
        }

        .loading-state .spinner {
            width: 48px;
            height: 48px;
            border: 4px solid #e2e8f0;
            border-top-color: #1d65d0;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 16px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 32px;
            color: #cbd5e1;
        }

        /* Action buttons in table */
        .tbl-btn-detail {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%);
            color: #1d65d0;
            padding: 7px 14px;
            border: 1.5px solid rgba(29, 101, 208, 0.2);
            border-radius: 8px;
            cursor: pointer;
            font-size: 11.5px;
            font-weight: 700;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .tbl-btn-detail:hover {
            background: linear-gradient(135deg, #1d65d0 0%, #0a3b99 100%);
            color: white;
            border-color: transparent;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(29, 101, 208, 0.25);
        }

        .tbl-btn-download {
            background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
            color: #0a3b99;
            padding: 7px 14px;
            border: 1.5px solid rgba(10, 59, 153, 0.15);
            border-radius: 8px;
            cursor: pointer;
            font-size: 11.5px;
            font-weight: 700;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .tbl-btn-download:hover {
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            color: white;
            border-color: transparent;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(10, 59, 153, 0.25);
        }

        /* Keyframes */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeSlideIn 0.4s ease forwards;
        }

        /* DARK MODE STYLES & VARIABLES */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar, .header, .card, .metric-card, .table-card, .frequency-card, .frequency-option, .report-item, .modal-content, .modal-footer, .form-input-styled, .form-select-styled, .radio-option-styled, .format-button, .btn-reset, input, select {
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease, color 0.3s ease;
        }

        body.dark-mode {
            background: #0f172a; /* Slate 900 */
            color: #f1f5f9; /* Slate 100 */
        }

        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #020617 0%, #0b1e3f 100%);
            box-shadow: 4px 0 36px rgba(0, 0, 0, 0.4);
        }

        body.dark-mode .header {
            background: #1e293b; /* Slate 800 */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            border-color: #334155;
        }

        body.dark-mode .header-icon {
            background: #334155;
            color: #f1f5f9;
        }

        body.dark-mode .header-icon:hover {
            background: #475569;
        }

        body.dark-mode .header-profile-btn {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
        }

        body.dark-mode .header-profile-avatar {
            border-color: #1e293b;
        }

        body.dark-mode .page-title h1,
        body.dark-mode .section-title h2,
        body.dark-mode .metric-top .metric-value,
        body.dark-mode .report-name,
        body.dark-mode .report-size,
        body.dark-mode .option-title,
        body.dark-mode .profile-item-value,
        body.dark-mode td,
        body.dark-mode .detail-value.large,
        body.dark-mode .detail-value {
            color: #f8fafc !important;
        }

        body.dark-mode .page-title p,
        body.dark-mode .section-title span,
        body.dark-mode .metric-top h3,
        body.dark-mode .metric-note,
        body.dark-mode .report-meta,
        body.dark-mode .option-desc,
        body.dark-mode .form-label,
        body.dark-mode .form-section-label,
        body.dark-mode .profile-item-label,
        body.dark-mode th,
        body.dark-mode .detail-label,
        body.dark-mode .detail-section-title,
        body.dark-mode .detail-notes p {
            color: #94a3bb !important;
        }

        body.dark-mode .card,
        body.dark-mode .metric-card,
        body.dark-mode .table-card,
        body.dark-mode .frequency-option,
        body.dark-mode .report-item,
        body.dark-mode .profile-modal-content,
        body.dark-mode .detail-notes,
        body.dark-mode .modal-content {
            background: #1e293b; /* Slate 800 */
            border-color: #334155;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        body.dark-mode .frequency-card,
        body.dark-mode .modal-footer {
            background: #0f172a;
            border-color: #334155;
        }

        body.dark-mode .frequency-option.active-laporan {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            border-color: #3b82f6;
        }

        body.dark-mode .reports-table thead,
        body.dark-mode .report-table th {
            background: #1e293b;
        }

        body.dark-mode .report-table tbody tr:hover {
            background: #273549;
        }

        body.dark-mode .form-input-styled,
        body.dark-mode .form-select-styled,
        body.dark-mode .radio-option-styled,
        body.dark-mode .format-button,
        body.dark-mode .btn-reset,
        body.dark-mode .modal-button.close-btn {
            background-color: #334155 !important;
            border-color: #475569 !important;
            color: #f8fafc !important;
        }

        body.dark-mode .form-input-styled:focus,
        body.dark-mode .form-select-styled:focus {
            border-color: #3b82f6 !important;
            background-color: #1e293b !important;
        }

        body.dark-mode .format-button.active {
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            border-color: transparent !important;
            color: white !important;
        }

        body.dark-mode .report-item {
            border-color: #334155;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }

        body.dark-mode .report-icon {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);
        }

        body.dark-mode .report-table td,
        body.dark-mode .report-table th,
        body.dark-mode .profile-item,
        body.dark-mode .frequency-option {
            border-color: #334155 !important;
        }

        body.dark-mode .profile-modal-header {
            background: linear-gradient(135deg, #020617 0%, #0b1e3f 100%);
        }

        body.dark-mode .profile-item-icon {
            background: #0b1e3f;
            color: #38bdf8;
        }

        body.dark-mode .page-footer {
            border-top-color: #334155;
            color: #64748b;
        }
    </style>
</head>

<body>
    <script>
        if (localStorage.getItem('staffDarkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
    </script>
    @include('components.sidebar-menu')

    <main class="main-content">
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

        <section class="page-title">
            <h1>Cetak Laporan</h1>
            <p>Hasilkan dan ekspor laporan hasil tangkap yang komprehensif. Pilih parameter Anda di bawah ini untuk
                menciptakan laporan</p>
        </section>

        <!-- Main Content Grid -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 30px; margin-bottom: 30px;">
            <!-- Form Laporan -->
            <div class="form-card animate-in">

                <div class="form-card-header">
                    <div class="form-card-icon">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <div>
                        <div class="form-card-title">Parameter Laporan</div>
                        <div class="form-card-subtitle">Atur filter untuk menghasilkan laporan</div>
                    </div>
                </div>

                <form id="filterForm" method="GET" action="{{ route('staff.cetak') }}">
                    <!-- Asal TPI -->
                    <div style="margin-bottom: 20px;">
                        <div class="form-section-label">Asal TPI</div>
                        <select id="filterTpi" name="tpi" onchange="triggerFilter()" class="form-select-styled">
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
                        <div class="form-section-label">Rentang Tanggal</div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.06em; display: block; margin-bottom: 6px;">Mulai Dari</label>
                                <input type="date" id="filterStartDate" name="start_date" onchange="triggerFilter()"
                                    value="{{ $startDate }}" class="form-input-styled">
                            </div>
                            <div>
                                <label style="font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.06em; display: block; margin-bottom: 6px;">Sampai Dengan</label>
                                <input type="date" id="filterEndDate" name="end_date" onchange="triggerFilter()"
                                    value="{{ $endDate }}" class="form-input-styled">
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Laporan -->
                    <div style="margin-bottom: 22px;">
                        <div class="form-section-label">Jenis Laporan Berkala</div>
                        <label class="radio-option-styled radio-harian">
                            <input type="radio" id="jenisLaporanHarian" name="jenis_laporan" value="harian"
                                onchange="triggerFilter()" style="cursor: pointer; accent-color: #0a3b99;">
                            <div class="radio-option-icon">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="radio-option-text">
                                <div class="title">Laporan Harian</div>
                                <div class="desc">Data per hari berdasarkan rentang tanggal</div>
                            </div>
                        </label>
                        <label class="radio-option-styled radio-bulanan">
                            <input type="radio" id="jenisLaporanBulanan" name="jenis_laporan" value="bulanan"
                                onchange="triggerFilter()" style="cursor: pointer; accent-color: #0a3b99;">
                            <div class="radio-option-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="radio-option-text">
                                <div class="title">Laporan Bulanan</div>
                                <div class="desc">Rekap total dalam satu bulan penuh</div>
                            </div>
                        </label>
                        <label class="radio-option-styled radio-tahunan" style="margin-bottom: 0;">
                            <input type="radio" id="jenisLaporanTahunan" name="jenis_laporan" value="tahunan"
                                onchange="triggerFilter()" style="cursor: pointer; accent-color: #0a3b99;">
                            <div class="radio-option-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="radio-option-text">
                                <div class="title">Laporan Tahunan</div>
                                <div class="desc">Rangkuman data sepanjang satu tahun</div>
                            </div>
                        </label>
                    </div>

                    <!-- Laporan Harian Detail (hanya untuk Laporan Harian) -->
                    <div id="harian-section" style="margin-bottom: 22px; display: none;">
                        <div class="sub-section-card">
                            <button type="button" onclick="triggerPaperPreview('harian')" class="btn-preview">
                                <i class="fas fa-eye"></i> Lihat Detail Laporan
                            </button>
                        </div>
                    </div>

                    <!-- Pilih Bulan (hanya untuk Laporan Bulanan) -->
                    <div id="bulanan-section" style="margin-bottom: 22px; display: none;">
                        <div class="sub-section-card">
                            <div class="form-section-label" style="margin-bottom: 8px;">Pilih Bulan</div>
                            <select id="filterBulan" name="bulan" onchange="triggerFilter()" class="form-select-styled">
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
                            <button type="button" onclick="triggerPaperPreview('bulanan')" class="btn-preview">
                                <i class="fas fa-eye"></i> Lihat Detail Laporan
                            </button>
                        </div>
                    </div>

                    <!-- Pilih Tahun (hanya untuk Laporan Tahunan) -->
                    <div id="tahunan-section" style="margin-bottom: 22px; display: none;">
                        <div class="sub-section-card">
                            <div class="form-section-label" style="margin-bottom: 8px;">Pilih Tahun</div>
                            <select id="filterTahun" name="tahun" onchange="triggerFilter()" class="form-select-styled">
                                <option value="">-- Pilih Tahun --</option>
                                @php
                                    $currentYear = date('Y');
                                    for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                        echo '<option value="' . $year . '">' . $year . '</option>';
                                    }
                                @endphp
                            </select>
                            <button type="button" onclick="triggerPaperPreview('tahunan')" class="btn-preview">
                                <i class="fas fa-eye"></i> Lihat Detail Laporan
                            </button>
                        </div>
                    </div>

                    <!-- Format Output -->
                    <div style="margin-bottom: 22px;">
                        <div class="form-section-label">Format Output</div>
                        <div style="display: flex; gap: 10px;">
                            <button type="button" id="btnFormatPdf" onclick="selectFormat('pdf')" class="format-btn-pdf">
                                <i class="fas fa-file-pdf" style="font-size: 16px;"></i> PDF
                            </button>
                            <button type="button" id="btnFormatExcel" onclick="selectFormat('excel')" class="format-btn-excel">
                                <i class="fas fa-file-excel" style="font-size: 16px;"></i> EXCEL
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 10px;">
                        <button type="button" onclick="resetFilters()" class="btn-reset">
                            <i class="fas fa-rotate-left"></i> Reset Filter
                        </button>
                        <button type="button" onclick="triggerDownload()" class="btn-download-main">
                            <i class="fas fa-cloud-arrow-down"></i> Download Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-card animate-in" id="laporan-tabel" style="animation-delay: 0.1s;">
            <div class="table-header">
                <div class="table-header-title">
                    <div class="table-header-icon">
                        <i class="fas fa-table-list"></i>
                    </div>
                    <div>
                        <h2>Tabel Arsip Laporan Cetak</h2>
                        <div class="info-text">Riwayat semua laporan yang telah tervalidasi</div>
                    </div>
                </div>
                <div id="filterStatus" style="display: none;">
                    <span style="background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); color: white; font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 999px; letter-spacing: 0.04em;">
                        <i class="fas fa-filter" style="margin-right: 5px;"></i>
                        <span id="filterCount">0</span> data ditemukan
                    </span>
                </div>
            </div>

            <div class="table-body-wrapper">
                <!-- Loading Indicator -->
                <div id="loadingIndicator" style="display: none;">
                    <div class="loading-state">
                        <div class="spinner"></div>
                        <p style="font-size: 14px; color: #64748b; font-weight: 600;">Memuat data...</p>
                    </div>
                </div>

                <!-- Table Container -->
                <div id="tableContainer">
                    @if ($laporans->count() > 0)
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>ID Laporan</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Cakupan Data</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="laporanTableBody">
                                @foreach ($laporans as $laporan)
                                    <tr>
                                        <td>
                                            <span style="background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%); color: white; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 700; letter-spacing: 0.03em;">
                                                #LAP-{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </td>
                                        <td style="color: #64748b; font-size: 13px;">{{ $laporan->created_at->format('d M Y, H:i') }}</td>
                                        <td>
                                            <span class="badge">
                                                <i class="fas fa-map-marker-alt" style="font-size: 10px;"></i>
                                                @if ($laporan->user)
                                                    TPI {{ $laporan->user->wilayah ?: $laporan->user->nama }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </td>
                                        <td style="font-weight: 600; color: #334155; font-size: 13px;">{{ $laporan->user ? $laporan->user->nama : 'N/A' }}</td>
                                        <td>
                                            <div style="display: flex; gap: 8px; align-items: center;">
                                                <button type="button" class="action-btn btn-detail tbl-btn-detail"
                                                    data-id="{{ $laporan->id }}">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                                <button type="button" class="action-btn btn-download tbl-btn-download"
                                                    data-id="{{ $laporan->id }}">
                                                    <i class="fas fa-cloud-arrow-down"></i> Download
                                                </button>
                                            </div>
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
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <p style="font-size: 15px; font-weight: 700; color: #64748b; margin-bottom: 6px;">Belum Ada Laporan</p>
                            <p style="font-size: 13px; color: #94a3b8;">Data laporan yang tervalidasi akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="page-footer">
            &copy; 2026 Dinas Perikanan Kabupaten Subang | Neutron Tech Solutions
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
                 .then(response => {
                     if (!response.ok) {
                         if (response.status === 401 || response.status === 419) {
                             window.location.reload();
                             return;
                         }
                         throw new Error('Network response was not ok');
                     }
                     return response.json();
                 })
                 .then(data => {
                     if (!data) return;
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
                     Swal.fire({
                         icon: 'error',
                         title: 'Terjadi Kesalahan',
                         text: 'Terjadi kesalahan saat mengambil data laporan. Silakan muat ulang halaman.',
                         confirmButtonColor: '#dc3545',
                         confirmButtonText: 'Tutup'
                     });
                 });
         }

        // Update table with filtered data
        function updateTable(data, pagination) {
            const tbody = document.getElementById('laporanTableBody');
            const tableContainer = document.getElementById('tableContainer');
            const filterStatus = document.getElementById('filterStatus');
            const paginationContainer = document.getElementById('paginationContainer');

            if (data.length === 0) {
                showEmptyState('Tidak ada data laporan');
                return;
            }

            // Build table rows
            let html = '';
            data.forEach(laporan => {
                html += `
                    <tr>
                        <td>
                            <span style="background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%); color: white; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 700; letter-spacing: 0.03em;">
                                ${laporan.id_laporan}
                            </span>
                        </td>
                        <td style="color: #64748b; font-size: 13px;">${laporan.tanggal_dibuat}</td>
                        <td>
                            <span class="badge">
                                <i class="fas fa-map-marker-alt" style="font-size: 10px;"></i>
                                TPI ${laporan.tpi}
                            </span>
                        </td>
                        <td style="font-weight: 600; color: #334155; font-size: 13px;">${laporan.dibuat_oleh}</td>
                        <td>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <button type="button" class="action-btn btn-detail tbl-btn-detail"
                                    data-id="${laporan.id}">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                                <button type="button" class="action-btn btn-download tbl-btn-download"
                                    data-id="${laporan.id}">
                                    <i class="fas fa-cloud-arrow-down"></i> Download
                                </button>
                            </div>
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
                let paginationHtml = '<div style="display: flex; justify-content: flex-end; align-items: center; gap: 8px; margin-top: 20px;">';

                // Previous Page Link
                if (pagination.current_page === 1) {
                    paginationHtml += `
                        <button disabled
                            style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: #f5f5f5; border-radius: 4px; cursor: not-allowed; opacity: 0.5; color: #999; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                            <i class="fas fa-chevron-left" style="font-size: 12px;"></i>
                        </button>
                    `;
                } else {
                    paginationHtml += `
                        <button onclick="goToPage(${pagination.current_page - 1})"
                            style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: white; border-radius: 4px; cursor: pointer; color: #1a4d7d; display: flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.3s;"
                            onmouseover="this.style.borderColor='#1a4d7d'; this.style.background='#f5f5f5';"
                            onmouseout="this.style.borderColor='#e0e0e0'; this.style.background='white';">
                            <i class="fas fa-chevron-left" style="font-size: 12px;"></i>
                        </button>
                    `;
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
                        paginationHtml += `
                            <button disabled
                                style="width: 32px; height: 32px; border: 1px solid #0d2640; background: #0d2640; border-radius: 4px; cursor: default; color: white; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600;">
                                ${i}
                            </button>
                        `;
                    } else {
                        paginationHtml += `
                            <button onclick="goToPage(${i})"
                                style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: white; border-radius: 4px; cursor: pointer; color: #1a4d7d; display: flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s; font-weight: 600;"
                                onmouseover="this.style.background='#f5f5f5'; this.style.borderColor='#1a4d7d';"
                                onmouseout="this.style.background='white'; this.style.borderColor='#e0e0e0';">
                                ${i}
                            </button>
                        `;
                    }
                }

                // Next Page Link
                if (pagination.current_page < pagination.last_page) {
                    paginationHtml += `
                        <button onclick="goToPage(${pagination.current_page + 1})"
                            style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: white; border-radius: 4px; cursor: pointer; color: #1a4d7d; display: flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.3s;"
                            onmouseover="this.style.borderColor='#1a4d7d'; this.style.background='#f5f5f5';"
                            onmouseout="this.style.borderColor='#e0e0e0'; this.style.background='white';">
                            <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
                        </button>
                    `;
                } else {
                    paginationHtml += `
                        <button disabled
                            style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: #f5f5f5; border-radius: 4px; cursor: not-allowed; opacity: 0.5; color: #999; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                            <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
                        </button>
                    `;
                }

                // Page Info
                paginationHtml += `
                    <span style="font-size: 12px; color: #999; margin-left: 10px;">
                        Halaman ${pagination.current_page} dan ${pagination.last_page}
                    </span>
                `;

                paginationHtml += '</div>';
                paginationContainer.innerHTML = paginationHtml;
            } else {
                paginationContainer.innerHTML = '';
            }

            // Re-attach action button listeners
            attachActionListeners();
        }

        // Show empty state
        function showEmptyState(message) {
            const tbody = document.getElementById('laporanTableBody');
            const filterStatus = document.getElementById('filterStatus');
            const paginationContainer = document.getElementById('paginationContainer');

            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <p style="font-size: 15px; font-weight: 700; color: #64748b; margin-bottom: 6px;">Tidak Ada Data</p>
                                <p style="font-size: 13px; color: #94a3b8;">${message}</p>
                            </div>
                        </td>
                    </tr>
                `;
            }

            if (filterStatus) filterStatus.style.display = 'none';
            if (paginationContainer) paginationContainer.innerHTML = '';
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
            document.getElementById('harian-section').style.display = 'none';
            document.getElementById('bulanan-section').style.display = 'none';
            document.getElementById('tahunan-section').style.display = 'none';
            document.getElementById('filterStatus').style.display = 'none';

            // Reset table to initial state
            location.reload();
        }

        // Preview collective report HTML (printable paper format)
        function triggerPaperPreview(jenisLaporan) {
            const tpi = document.getElementById('filterTpi').value;
            const startDate = document.getElementById('filterStartDate').value;
            const endDate = document.getElementById('filterEndDate').value;
            const bulan = document.getElementById('filterBulan').value;
            const tahun = document.getElementById('filterTahun').value;

            // Validate
            if (jenisLaporan === 'bulanan' && !bulan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Bulan Belum Dipilih',
                    text: 'Silakan pilih bulan terlebih dahulu!',
                    confirmButtonColor: '#0a3b99',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }
            if (jenisLaporan === 'tahunan' && !tahun) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tahun Belum Dipilih',
                    text: 'Silakan pilih tahun terlebih dahulu!',
                    confirmButtonColor: '#0a3b99',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }

            let tahunVal = tahun;
            if (jenisLaporan === 'bulanan' && !tahunVal) {
                tahunVal = new Date().getFullYear();
            }

            // Show loading
            Swal.fire({
                title: 'Menyiapkan Pratinjau Kertas...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch HTML preview
            fetch('{{ route('staff.cetak.preview_html') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    jenis_laporan: jenisLaporan,
                    tpi: tpi,
                    start_date: startDate,
                    end_date: endDate,
                    bulan: bulan,
                    tahun: tahunVal
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show in SweetAlert2 as iframe
                    Swal.fire({
                        title: `<span style="font-size: 20px; font-weight: 700; color: #102a43;">Pratinjau Cetak Laporan</span>`,
                        html: `
                            <div style="margin-top: 15px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; background: #f8fafc; padding: 10px;">
                                <iframe id="previewIframe" style="width: 100%; height: 500px; border: none; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 4px;"></iframe>
                            </div>
                        `,
                        width: '80%',
                        showCancelButton: true,
                        showDenyButton: true,
                        confirmButtonText: '<i class="fas fa-file-pdf"></i> Download PDF',
                        denyButtonText: '<i class="fas fa-file-excel"></i> Download Excel',
                        cancelButtonText: 'Tutup',
                        confirmButtonColor: '#dc2626', // Red for PDF
                        denyButtonColor: '#16a34a', // Green for Excel
                        cancelButtonColor: '#6e7881',
                        didOpen: () => {
                            const iframe = document.getElementById('previewIframe');
                            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                            iframeDoc.open();
                            iframeDoc.write(data.html);
                            iframeDoc.close();
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectFormat('pdf');
                            downloadLaporan('pdf');
                        } else if (result.isDenied) {
                            selectFormat('excel');
                            downloadLaporan('excel');
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak Ada Data',
                        text: data.message || 'Gagal memuat pratinjau laporan.',
                        confirmButtonColor: '#0a3b99'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Terjadi kesalahan saat memproses pratinjau.',
                    confirmButtonColor: '#dc3545'
                });
            });
        }


        // Download laporan function
        function triggerDownload() {
            if (!selectedFormat) {
                Swal.fire({
                    title: 'Pilih Format Output',
                    text: 'Silakan pilih format laporan yang ingin diunduh:',
                    icon: 'question',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-file-pdf"></i> PDF',
                    denyButtonText: '<i class="fas fa-file-excel"></i> EXCEL',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#dc2626',
                    denyButtonColor: '#16a34a',
                    cancelButtonColor: '#6e7881'
                }).then((result) => {
                    if (result.isConfirmed) {
                        selectFormat('pdf');
                        downloadLaporan('pdf');
                    } else if (result.isDenied) {
                        selectFormat('excel');
                        downloadLaporan('excel');
                    }
                });
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
                    Swal.fire({
                        icon: 'warning',
                        title: 'Bulan Belum Dipilih',
                        text: 'Silakan pilih bulan untuk laporan bulanan!',
                        confirmButtonColor: '#0a3b99',
                        confirmButtonText: 'Mengerti'
                    });
                    return;
                }
            }

            // Validasi untuk laporan tahunan
            if (jenisLaporan === 'tahunan' && !laporanId) {
                if (!tahun) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tahun Belum Dipilih',
                        text: 'Silakan pilih tahun untuk laporan tahunan!',
                        confirmButtonColor: '#0a3b99',
                        confirmButtonText: 'Mengerti'
                    });
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

            // Tampilkan popup sukses mengunduh
            Swal.fire({
                title: 'Memulai Unduhan',
                html: `Menyiapkan berkas <strong>${format.toUpperCase()}</strong> Anda.<br>Mohon tunggu sebentar...`,
                icon: 'success',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

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

        // Attach action button listeners
        function attachActionListeners() {
            document.querySelectorAll('.btn-download').forEach(btn => {
                btn.removeEventListener('click', handleDownloadClick);
                btn.addEventListener('click', handleDownloadClick);
            });
            document.querySelectorAll('.btn-detail').forEach(btn => {
                btn.removeEventListener('click', handleDetailClick);
                btn.addEventListener('click', handleDetailClick);
            });
        }

        function handleDownloadClick(e) {
            const laporanId = e.currentTarget.dataset.id;
            if (!selectedFormat) {
                Swal.fire({
                    title: 'Pilih Format Output',
                    text: 'Silakan pilih format laporan yang ingin diunduh:',
                    icon: 'question',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-file-pdf"></i> PDF',
                    denyButtonText: '<i class="fas fa-file-excel"></i> EXCEL',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#dc2626', // Red for PDF
                    denyButtonColor: '#16a34a', // Green for Excel
                    cancelButtonColor: '#6e7881'
                }).then((result) => {
                    if (result.isConfirmed) {
                        selectFormat('pdf');
                        downloadLaporan('pdf', laporanId);
                    } else if (result.isDenied) {
                        selectFormat('excel');
                        downloadLaporan('excel', laporanId);
                    }
                });
                return;
            }
            downloadLaporan(selectedFormat, laporanId);
        }

        function handleDetailClick(e) {
            const laporanId = e.currentTarget.dataset.id;
            
            // Show loading popup
            Swal.fire({
                title: 'Menyiapkan Pratinjau Kertas...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // AJAX request to preview HTML
            fetch('{{ route('staff.cetak.preview_html') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ laporan_id: laporanId })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show in SweetAlert2 as iframe
                    Swal.fire({
                        title: `<span style="font-size: 20px; font-weight: 700; color: #102a43;">Pratinjau Cetak Laporan</span>`,
                        html: `
                            <div style="margin-top: 15px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; background: #f8fafc; padding: 10px;">
                                <iframe id="previewIframe" style="width: 100%; height: 500px; border: none; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 4px;"></iframe>
                            </div>
                        `,
                        width: '80%',
                        showCancelButton: true,
                        showDenyButton: true,
                        confirmButtonText: '<i class="fas fa-file-pdf"></i> Download PDF',
                        denyButtonText: '<i class="fas fa-file-excel"></i> Download Excel',
                        cancelButtonText: 'Tutup',
                        confirmButtonColor: '#dc2626', // Red for PDF
                        denyButtonColor: '#16a34a', // Green for Excel
                        cancelButtonColor: '#6e7881',
                        didOpen: () => {
                            const iframe = document.getElementById('previewIframe');
                            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                            iframeDoc.open();
                            iframeDoc.write(data.html);
                            iframeDoc.close();
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectFormat('pdf');
                            downloadLaporan('pdf', laporanId);
                        } else if (result.isDenied) {
                            selectFormat('excel');
                            downloadLaporan('excel', laporanId);
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak Ada Data',
                        text: data.message || 'Gagal memuat pratinjau laporan.',
                        confirmButtonColor: '#0a3b99'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Terjadi kesalahan saat memproses pratinjau.',
                    confirmButtonColor: '#dc3545'
                });
            });
        }

        // Select format function
        function selectFormat(format) {
            const btnPdf = document.getElementById('btnFormatPdf');
            const btnExcel = document.getElementById('btnFormatExcel');

            // Toggle selection if clicked again
            if (selectedFormat === format) {
                selectedFormat = null;
                btnPdf.classList.remove('selected');
                btnExcel.classList.remove('selected');
                return;
            }

            selectedFormat = format;

            if (format === 'pdf') {
                btnPdf.classList.add('selected');
                btnExcel.classList.remove('selected');
            } else {
                btnPdf.classList.remove('selected');
                btnExcel.classList.add('selected');
            }
        }

        // Handle jenis laporan radio button styling dan tampilkan/sembunyikan field
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="jenis_laporan"]');
            const harianSection = document.getElementById('harian-section');
            const bulananSection = document.getElementById('bulanan-section');
            const tahunanSection = document.getElementById('tahunan-section');
            let lastSelected = null;

            radioButtons.forEach(radio => {
                const label = radio.closest('label');

                radio.addEventListener('change', function() {
                    // Reset all labels to default style
                    radioButtons.forEach(rb => {
                        const lbl = rb.closest('label');
                        lbl.classList.remove('selected');
                    });

                    // Style the selected label
                    if (this.checked) {
                        label.classList.add('selected');
                        lastSelected = this.value;

                        // Tampilkan/sembunyikan section berdasarkan jenis laporan
                        if (this.value === 'harian') {
                            harianSection.style.display = 'block';
                            bulananSection.style.display = 'none';
                            tahunanSection.style.display = 'none';
                            document.getElementById('filterBulan').value = '';
                            document.getElementById('filterTahun').value = '';
                        } else if (this.value === 'bulanan') {
                            harianSection.style.display = 'none';
                            bulananSection.style.display = 'block';
                            tahunanSection.style.display = 'none';
                            document.getElementById('filterTahun').value = '';
                        } else if (this.value === 'tahunan') {
                            harianSection.style.display = 'none';
                            bulananSection.style.display = 'none';
                            tahunanSection.style.display = 'block';
                            document.getElementById('filterBulan').value = '';
                        } else {
                            harianSection.style.display = 'none';
                            bulananSection.style.display = 'none';
                            tahunanSection.style.display = 'none';
                            document.getElementById('filterBulan').value = '';
                            document.getElementById('filterTahun').value = '';
                        }
                    }
                });

                // Add click handler for toggle behavior
                radio.addEventListener('click', function(e) {
                    if (lastSelected === this.value && this.checked) {
                        // If clicking the same option, uncheck it
                        this.checked = false;
                        label.classList.remove('selected');
                        lastSelected = null;
                        harianSection.style.display = 'none';
                        bulananSection.style.display = 'none';
                        tahunanSection.style.display = 'none';
                        document.getElementById('filterBulan').value = '';
                        document.getElementById('filterTahun').value = '';
                        triggerFilter();
                    }
                });
            });

            // Attach initial action button listeners
            attachActionListeners();
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
    <!-- Dark Mode Initializer Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeSetting = localStorage.getItem('staffDarkMode');
            if (darkModeSetting === 'enabled') {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }
        });
    </script>
</body>

</html>
