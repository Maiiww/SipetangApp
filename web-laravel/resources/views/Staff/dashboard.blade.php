<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Operasional - SIPETANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            font-weight: 700;
        }

        .content-header p {
            color: #64748b;
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
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #edf2f7;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(10, 59, 153, 0.08);
            border-color: rgba(10, 59, 153, 0.15);
        }

        .stat-info h4 {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .stat-info span {
            font-size: 26px;
            font-weight: 800;
            color: #0d2640;
        }

        .stat-icon {
            font-size: 20px;
            padding: 12px;
            border-radius: 12px;
        }

        .bg-blue {
            background: #e0f2fe;
            color: #0369a1;
        }

        .bg-green {
            background: #dcfce7;
            color: #166534;
        }

        .bg-orange {
            background: #fee2e2;
            color: #991b1b;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 24px;
        }

        .stat-card-large {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card-large:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(10, 59, 153, 0.08);
            border-color: rgba(10, 59, 153, 0.15);
        }

        .stat-card-large h4 {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .stat-card-large .number {
            font-size: 32px;
            font-weight: 800;
            color: #0d2640;
        }

        .stat-card-dark {
            background: linear-gradient(135deg, #0d2640 0%, #1a4d7d 100%);
            color: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card-dark:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(10, 59, 153, 0.18);
        }

        .stat-card-dark h4 {
            font-size: 11px;
            opacity: 0.8;
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .stat-card-dark .number {
            font-size: 32px;
            font-weight: 800;
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

        .stat-icon-white {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            backdrop-filter: blur(4px);
        }

        .stat-icon-green {
            background: #dcfce7;
            color: #166534;
        }
        
        .stat-icon-orange {
            background: #fee2e2;
            color: #991b1b;
        }

        .real-time-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 700;
            color: #10b981;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }

        .real-time-badge::before {
            content: '';
            width: 7px;
            height: 7px;
            background: #10b981;
            border-radius: 50%;
            animation: pulse 1.2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.4;
                transform: scale(1.15);
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
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .small-stat:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(10, 59, 153, 0.08);
            border-color: rgba(10, 59, 153, 0.15);
        }

        .small-stat label {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .small-stat .value {
            font-size: 24px;
            font-weight: 800;
            color: #0d2640;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            margin-top: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #10b981;
            border-radius: 4px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .progress-stat-card {
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
            border-left: 4px solid #10b981;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .progress-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(10, 59, 153, 0.08);
            border-color: rgba(10, 59, 153, 0.15);
            border-left-color: #10b981;
        }

        .sidebar-right {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
            height: fit-content;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-right:hover {
            box-shadow: 0 8px 24px rgba(10, 59, 153, 0.04);
        }

        .sidebar-right-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .sidebar-right-header h3 {
            font-size: 15px;
            color: #0d2640;
            font-weight: 750;
        }

        .sidebar-right-header a {
            color: #0a3b99;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .sidebar-right-header a:hover {
            color: #1d65d0;
        }

        .activity-item {
            display: flex;
            gap: 14px;
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s ease;
        }

        .activity-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .activity-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .activity-content {
            flex: 1;
            font-size: 13px;
        }

        .activity-name {
            font-weight: 700;
            color: #0d2640;
            font-size: 13.5px;
        }

        .activity-location {
            color: #64748b;
            font-size: 11.5px;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .activity-status {
            padding: 3px 10px;
            border-radius: 30px;
            font-size: 10.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 6px;
        }

        .activity-status.verified {
            background: #dcfce7;
            color: #155724;
            border: 1px solid #bbf7d0;
        }

        .activity-status.pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffe0b2;
        }

        .activity-status.rejected {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .activity-time {
            color: #94a3bb;
            font-size: 11px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
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
            font-weight: 700;
        }

        .content-header-left p {
            color: #64748b;
            font-size: 14px;
        }

        .content-header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .date-selector {
            padding: 10px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: white;
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .date-selector:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .btn-input {
            padding: 10px 20px;
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(10, 59, 153, 0.15);
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
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .profile-status.active {
            background: #dcfce7;
            color: #166534;
        }

        .profile-status.inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .profile-status::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
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
            font-size: 14px;
            color: #777;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <div class="main-content">
        <div class="header">
            <div class="header-right">
                <div class="header-profile-btn" onclick="openProfileModal(event)" title="Profil Saya">
                    <div class="header-profile-avatar">
                        STF
                    </div>
                </div>
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
                    <span id="currentMonth">
                        <?php
                        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        $now = \Carbon\Carbon::now();
                        echo $bulan[$now->month - 1] . ' ' . $now->year;
                        ?>
                    </span>
                </div>
                <a href="{{ route('staff.validasi') }}" class="btn-input"
                    style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;"><i class="fas fa-eye"></i>
                    Lihat Laporan</a>
            </div>
        </div>

        <div class="dashboard-container">
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div class="stats-grid">
                    <div class="stat-card-large">
                        <div class="stat-info">
                            <h4>TOTAL DATA USER</h4>
                            <div class="number">{{ $statistik['totalUser'] }}</div>
                        </div>
                        <div class="stat-icon-wrapper stat-icon-blue">
                            <i class="fas fa-users-cog"></i>
                        </div>
                    </div>
                    <div class="stat-card-dark" style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="stat-info">
                            <h4 style="margin-bottom: 5px;">DATA PRODUKSI (BULAN)</h4>
                            <div class="number">{{ $statistik['produksiBulan'] }} <span
                                    style="font-size: 18px; color:#ffffff;">(ton)</span></div>
                            <div class="real-time-badge">REAL-TIME MONITOR</div>
                        </div>
                        <div class="stat-icon-wrapper stat-icon-white">
                            <i class="fas fa-chart-column"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="small-stat">
                        <div class="stat-info">
                            <label>Laporan Masuk</label>
                            <div class="value">{{ $statistik['totalLaporan'] }}</div>
                        </div>
                        <div class="stat-icon-wrapper stat-icon-green" style="width: 44px; height: 44px; font-size: 18px;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                    <div class="small-stat">
                        <div class="stat-info">
                            <label>Validasi Tertunda</label>
                            <div class="value">{{ $statistik['validasiTertunda'] }}</div>
                        </div>
                        <div class="stat-icon-wrapper stat-icon-orange" style="width: 44px; height: 44px; font-size: 18px;">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                </div>

                <div class="progress-stat-card">
                    <label style="font-size: 11px; color: #888; text-transform: uppercase; display: block; margin-bottom: 5px; font-weight: 700;">Data Statistik Terkini</label>
                    <div style="margin-top: 10px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span style="font-size: 12px; color: #0d2640; font-weight: 600;">Persentase Validasi Berhasil</span>
                            <span
                                style="font-size: 12px; font-weight: 700; color: #0d2640;">{{ $statistik['persentaseValidasi'] }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $statistik['persentaseValidasi'] }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar-right">
                <div class="sidebar-right-header">
                    <h3>Aktivitas Terbaru</h3>
                    <a href="{{ route('staff.validasi') }}">Lihat Semua</a>
                </div>

                @forelse ($aktivitas as $item)
                    <div class="activity-item">
                        <div class="activity-avatar"
                            style="background-color: {{ $item['avatarBg'] }}; color: #0d2640;">
                            {{ $item['avatar'] }}
                        </div>
                        <div class="activity-content">
                            <div class="activity-name">{{ $item['nama'] }}</div>
                            <div class="activity-location">
                                <i class="fas fa-map-marker-alt" style="font-size:10px;"></i>
                                {{ $item['lokasi'] }}
                            </div>
                            <div style="font-size:11px; color:#555; margin-top:3px;">
                                {{ $item['jenis'] }} &bull; {{ number_format($item['berat'], 1) }} kg
                            </div>
                            @php
                                $statusMap = [
                                    'Menunggu Validasi' => ['class' => 'pending',  'label' => 'Menunggu'],
                                    'Draft'             => ['class' => 'pending',  'label' => 'Draft'],
                                    'Divalidasi'        => ['class' => 'verified', 'label' => 'Divalidasi'],
                                    'Ditolak'           => ['class' => 'rejected', 'label' => 'Ditolak'],
                                ];
                                $statusInfo = $statusMap[$item['status']] ?? ['class' => 'pending', 'label' => $item['status']];
                            @endphp
                            <span class="activity-status {{ $statusInfo['class'] }}">
                                {{ $statusInfo['label'] }}
                            </span>
                            <div class="activity-time">
                                <i class="fas fa-clock" style="font-size:9px;"></i>
                                {{ \Carbon\Carbon::parse($item['waktu'])->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding: 30px 0; color: #aaa;">
                        <i class="fas fa-inbox" style="font-size:28px; margin-bottom:8px; display:block;"></i>
                        <span style="font-size:13px;">Belum ada laporan masuk</span>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="page-footer">
            &copy; 2026 Dinas Perikanan Kabupaten Subang | Neutron Tech Solutions
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="profile-modal">
        <div class="profile-modal-content">
            <div class="profile-modal-header">
                <button class="profile-modal-close" onclick="closeProfileModal()">&times;</button>
                <div class="profile-avatar">STF</div>
                <div class="profile-name">{{ $user->nama ?? $user->username }}</div>
                <div class="profile-role">{{ ucfirst($user->role) }}</div>
            </div>
            <div class="profile-modal-body">
                <div class="profile-item">
                    <div class="profile-item-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="profile-item-content">
                        <div class="profile-item-label">Lokasi Penempatan</div>
                        <div class="profile-item-value">{{ $user->wilayah ?? '-' }}</div>
                    </div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-icon">
                        <i class="fas fa-venus-mars"></i>
                    </div>
                    <div class="profile-item-content">
                        <div class="profile-item-label">Jenis Kelamin</div>
                        <div class="profile-item-value">{{ $user->jenis_kelamin ?? '-' }}</div>
                    </div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="profile-item-content">
                        <div class="profile-item-label">No. Telepon</div>
                        <div class="profile-item-value">{{ $user->no_telepon ?? '-' }}</div>
                    </div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-icon">
                        <i class="fas fa-map-pin"></i>
                    </div>
                    <div class="profile-item-content">
                        <div class="profile-item-label">Alamat</div>
                        <div class="profile-item-value">{{ $user->alamat ?? '-' }}</div>
                    </div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="profile-item-content">
                        <div class="profile-item-label">Status</div>
                        @if ($user->is_active ?? true)
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

    <script>
        function openProfileModal(event) {
            event.preventDefault();
            document.getElementById('profileModal').classList.add('active');
        }

        function closeProfileModal() {
            document.getElementById('profileModal').classList.remove('active');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('profileModal');
            if (event.target === modal) {
                closeProfileModal();
            }
        }
    </script>

    @if (session('welcome'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Masuk',
                    text: "Selamat datang Staff Dinas",
                    confirmButtonColor: '#0a3b99',
                    confirmButtonText: 'Lanjutkan'
                });
            });
        </script>
    @endif
</body>

</html>
