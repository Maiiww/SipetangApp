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
            font-size: 16px;
            color: #1a4d7d;
            position: relative;
        }

        .header-icon:hover {
            background: #e0e0e0;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            font-size: 0.7rem;
            font-weight: 700;
            line-height: 18px;
            border-radius: 50%;
            color: #ffffff;
            background: #dc3545;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 2px #ffffff;
        }

        /* Page Title */
        .page-title {
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #0d2640;
            margin-bottom: 8px;
        }

        .page-title p {
            font-size: 14.5px;
            color: #64748b;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #edf2f7;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(10, 59, 153, 0.08);
            border-color: rgba(10, 59, 153, 0.15);
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 800;
            color: #0d2640;
        }

        .stat-icon-box {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover .stat-icon-box {
            transform: scale(1.08);
        }

        .stat-icon-pending {
            background: #fff8e1;
        }

        .stat-icon-validated {
            background: #e8f5e9;
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
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
            flex-wrap: wrap;
            gap: 20px;
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
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: #0a3b99;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-filter:hover {
            background: #f8fafc;
            border-color: #0a3b99;
            color: #0a3b99;
            transform: translateY(-1px);
        }

        .btn-filter.active {
            background: #0a3b99;
            color: white;
            border-color: #0a3b99;
            box-shadow: 0 4px 12px rgba(10, 59, 153, 0.18);
        }

        .btn-accept-all {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #0d2640;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-accept-all:hover {
            background: #1a4d7d;
            transform: translateY(-1px);
        }

        /* Table Section */
        .table-section {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
            margin-bottom: 30px;
        }

        .table-title {
            font-size: 15px;
            font-weight: 750;
            color: #0d2640;
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
            background: #f8fafc;
        }

        .reports-table tr {
            height: 52px;
            transition: background 0.2s ease;
        }
        
        .reports-table tbody tr:hover {
            background: #fdfdfd;
        }

        .reports-table th {
            padding: 16px 12px;
            text-align: left;
            font-size: 11.5px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            border-bottom: 2px solid #edf2f7;
            vertical-align: middle;
        }

        .reports-table td {
            padding: 16px 12px;
            border-bottom: 1px solid #edf2f7;
            font-size: 13.5px;
            color: #334155;
            vertical-align: middle;
        }

        .reports-table td div,
        .reports-table td span {
            margin: 0;
            line-height: 1.3;
            display: inline-flex;
            align-items: center;
        }

        .date-cell {
            font-weight: 700;
            color: #0a3b99;
        }

        .tpi-name {
            font-weight: 700;
            color: #0d2640;
            margin: 0;
        }

        .tpi-location {
            font-size: 11px;
            color: #64748b;
        }

        .fish-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            background: #e0f2fe;
            color: #0369a1;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 700;
            border: 1px solid #bae6fd;
        }

        .volume-cell {
            font-weight: 750;
            color: #0d2640;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 1;
            flex-shrink: 0;
        }

        .status-badge.status-menunggu-validasi, .status-badge.status-revisi {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffe0b2;
        }

        .status-badge.status-divalidasi, .status-badge.status-tervalidasi {
            background: #dcfce7;
            color: #155724;
            border: 1px solid #bbf7d0;
        }

        .status-badge.status-ditolak {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .status-badge.status-draft {
            background: #e2e8f0;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .action-cell {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 11.5px;
            font-weight: 700;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            height: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .action-cell form {
            display: inline-flex !important;
            margin: 0 !important;
            align-items: center;
        }

        .action-validate {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .action-validate:hover {
            background: #bbf7d0;
            color: #14532d;
            border-color: #86efac;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(22, 101, 52, 0.1);
        }

        .action-reject {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .action-reject:hover {
            background: #fecaca;
            color: #7f1d1d;
            border-color: #f87171;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(153, 27, 27, 0.1);
        }

        /* Pagination */
        .pagination-section {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 24px;
        }

        .pagination-btn {
            width: 34px;
            height: 34px;
            border: 1px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #334155;
        }

        .pagination-btn:hover:not(:disabled) {
            border-color: #0a3b99;
            color: #0a3b99;
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .pagination-btn.active {
            background: #0d2640;
            color: white;
            border-color: #0d2640;
            box-shadow: 0 4px 12px rgba(13, 38, 64, 0.15);
        }

        .pagination-btn:disabled {
            cursor: not-allowed;
            opacity: 0.5;
            background: #f8fafc;
            color: #94a3bb;
            border-color: #e2e8f0;
        }

        .pagination-info {
            font-size: 12.5px;
            color: #64748b;
            margin: 0 10px;
            font-weight: 500;
        }

        .pagination-btn i {
            font-size: 12px;
        }

        /* Trend Section */
        .trend-section {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
        }

        .trend-title {
            font-size: 15px;
            font-weight: 750;
            color: #0d2640;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .trend-description {
            font-size: 13.5px;
            color: #64748b;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .trend-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-bottom: 0;
        }

        .trend-stat {
            background: #f8fafc;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #edf2f7;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .trend-stat:hover {
            transform: translateY(-3px);
            background: #f1f5f9;
        }

        .trend-stat-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .trend-stat-value {
            font-size: 28px;
            font-weight: 850;
            color: #0d2640;
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

        /* DARK MODE STYLES & VARIABLES */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .sidebar, .header, .stat-card, .filters-section, .table-section, .page-footer, .date-selector, input, select, textarea, .trend-stat, .trend-section {
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode Toggle Button Styling */
        .dark-mode-toggle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1.15rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .dark-mode-toggle:hover {
            transform: scale(1.08) rotate(15deg);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: #e2e8f0;
            color: #0f172a;
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

        body.dark-mode .dark-mode-toggle {
            background: #334155;
            color: #fbbf24; /* Amber-400 */
            border-color: #475569;
        }

        body.dark-mode .dark-mode-toggle:hover {
            background: #475569;
            color: #f59e0b; /* Amber-500 */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        body.dark-mode .page-title h1,
        body.dark-mode .stat-value,
        body.dark-mode .table-title,
        body.dark-mode .volume-cell,
        body.dark-mode .tpi-name,
        body.dark-mode .profile-item-value,
        body.dark-mode td,
        body.dark-mode .trend-stat-value,
        body.dark-mode #rejectModal div h3 {
            color: #f8fafc !important;
        }

        body.dark-mode .page-title p,
        body.dark-mode .stat-label,
        body.dark-mode .profile-item-label,
        body.dark-mode th,
        body.dark-mode .trend-stat-label,
        body.dark-mode .trend-description {
            color: #94a3bb !important;
        }

        body.dark-mode .stat-card,
        body.dark-mode .filters-section,
        body.dark-mode .table-section,
        body.dark-mode .profile-modal-content,
        body.dark-mode #rejectModal > div,
        body.dark-mode .trend-stat,
        body.dark-mode .trend-section {
            background: #1e293b; /* Slate 800 */
            border-color: #334155;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        body.dark-mode .reports-table thead {
            background: #1e293b;
        }

        body.dark-mode .reports-table tbody tr:hover {
            background: #273549;
        }

        body.dark-mode .btn-filter {
            background: #334155;
            border-color: #475569;
            color: #f1f5f9;
        }

        body.dark-mode .btn-filter:hover {
            background: #475569;
            color: white;
        }

        body.dark-mode .btn-filter.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        body.dark-mode input,
        body.dark-mode select,
        body.dark-mode textarea {
            background-color: #334155 !important;
            border-color: #475569 !important;
            color: #f8fafc !important;
        }

        body.dark-mode input:focus,
        body.dark-mode select:focus,
        body.dark-mode textarea:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3) !important;
        }

        body.dark-mode .activity-item,
        body.dark-mode .profile-item,
        body.dark-mode td,
        body.dark-mode th {
            border-color: #334155 !important;
        }

        body.dark-mode .stat-icon-pending {
            background: #3f2e0b;
        }

        body.dark-mode .stat-icon-validated {
            background: #0b3f1c;
        }

        body.dark-mode .fish-badge {
            background: #0f3e5f;
            color: #38bdf8;
            border-color: #0c4a6e;
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

        body.dark-mode #notificationDropdown {
            background: #1e293b !important;
            border-color: #334155 !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4) !important;
        }
        body.dark-mode #notificationDropdown div {
            border-bottom-color: #334155 !important;
            color: #f1f5f9 !important;
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
        /* === MODAL KONFIRMASI VALIDASI SEMUA === */
        .confirm-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            animation: fadeInOverlay 0.2s ease;
        }
        .confirm-overlay.active {
            display: flex;
        }
        @keyframes fadeInOverlay {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        .confirm-box {
            background: #fff;
            border-radius: 16px;
            padding: 36px 32px 28px;
            width: 90%;
            max-width: 440px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
            text-align: center;
            animation: slideUpBox 0.25s cubic-bezier(0.34,1.56,0.64,1);
        }
        @keyframes slideUpBox {
            from { transform: translateY(30px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }
        .confirm-icon {
            width: 64px;
            height: 64px;
            background: #fff7e6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
            color: #f59e0b;
        }
        .confirm-title {
            font-size: 18px;
            font-weight: 700;
            color: #0d2640;
            margin-bottom: 10px;
        }
        .confirm-desc {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 28px;
        }
        .confirm-desc strong {
            color: #0d2640;
        }
        .confirm-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        .confirm-btn-cancel {
            flex: 1;
            padding: 11px 0;
            border: 1.5px solid #e0e0e0;
            background: #fff;
            color: #555;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .confirm-btn-cancel:hover {
            background: #f5f5f5;
            border-color: #bbb;
        }
        .confirm-btn-ok {
            flex: 1;
            padding: 11px 0;
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .confirm-btn-ok:hover {
            background: linear-gradient(135deg, #218838, #155724);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(40,167,69,0.35);
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
    <script>
        if (localStorage.getItem('staffDarkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
    </script>
    <!-- Sidebar -->
    <?php echo $__env->make('components.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-right">
                <div class="header-icons">
                    <div style="position: relative;">
                        <button type="button" id="notificationToggle" class="header-icon" aria-expanded="false"
                            style="cursor: pointer; border: none; background: transparent;">
                            <i class="fas fa-bell"></i>
                            <?php if(isset($stats['pending']) && $stats['pending'] > 0): ?>
                                <span class="notification-badge"><?php echo e($stats['pending']); ?></span>
                            <?php endif; ?>
                        </button>

                        <div id="notificationDropdown"
                            style="display: none; position: absolute; right: 0; top: 44px; background: #ffffff; width: 300px; border-radius: 8px; box-shadow: 0 6px 30px rgba(0,0,0,0.12); z-index: 1100; overflow: hidden;">
                            <div
                                style="padding: 12px 14px; border-bottom: 1px solid #eee; font-weight: 700; color: #1a4d7d;">
                                Notifikasi</div>
                            <div style="padding: 12px; max-height: 260px; overflow: auto; color: #333;">
                                <?php if(isset($stats['pending']) && $stats['pending'] > 0): ?>
                                    <p style="margin: 0 0 10px;">Terdapat <strong><?php echo e($stats['pending']); ?></strong>
                                        laporan menunggu validasi.</p>
                                    <div style="display:flex; gap:8px;">
                                        <button type="button" onclick="showPending()" class="btn-filter"
                                            style="background:#1a4d7d;color:white;">Tampilkan</button>
                                        <button type="button" onclick="closeNotificationDropdown()" class="btn-filter"
                                            style="background:#e0e0e0;color:#0d2640;">Tutup</button>
                                    </div>
                                <?php else: ?>
                                    <p style="margin:0; color:#666;">Tidak ada notifikasi baru.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="header-profile-btn" onclick="openProfileModal(event)" title="Profil Saya">
                        <div class="header-profile-avatar">
                            STF
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Title -->
        <div class="page-title">
            <h1>Validasi Laporan</h1>
            <p>Otorisasi dan verifikasi data hasil tangkapan laut dari seluruh Tempat Pelelangan Ikan (TPI) wilayah
                Subang.</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card" onclick="setStatusFilter('Menunggu Validasi', this)" style="cursor: pointer;">
                <div class="stat-content">
                    <div class="stat-label"><i class="fas fa-hourglass-half"></i> Menunggu</div>
                    <div class="stat-value"><?php echo e($stats['pending']); ?></div>
                </div>
                <div class="stat-icon-box stat-icon-pending">
                    <img src="<?php echo e(asset('images/file.png')); ?>" alt="Menunggu"
                        style="width: 50px; height: 50px; object-fit: contain;">
                </div>
            </div>

            <div class="stat-card" onclick="setStatusFilter('Divalidasi', this)" style="cursor: pointer;">
                <div class="stat-content">
                    <div class="stat-label"><i class="fas fa-check"></i> Tervalidasi Hari Ini</div>
                    <div class="stat-value"><?php echo e($stats['validated']); ?></div>
                </div>
                <div class="stat-icon-box stat-icon-validated">
                    <img src="<?php echo e(asset('images/list.png')); ?>" alt="Tervalidasi"
                        style="width: 50px; height: 50px; object-fit: contain;">
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-label"><i class="fas fa-weight"></i> Total Volume Tervalidasi</div>
                    <div class="stat-value"><?php echo e(number_format($stats['totalVolume'] / 1000, 2)); ?> <span style="font-size:14px;font-weight:600;color:#64748b;">Ton</span></div>
                    <div style="font-size:11px;color:#94a3b8;margin-top:4px;">= <?php echo e(number_format($stats['totalVolume'], 0)); ?> Kg</div>
                </div>
                <div class="stat-icon-box stat-icon-validated">
                    <img src="<?php echo e(asset('images/bar-graph.png')); ?>" alt="Volume"
                        style="width: 50px; height: 50px; object-fit: contain;">
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <form method="GET" action="<?php echo e(route('staff.validasi')); ?>" id="filterForm"
                style="width: 100%; display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                <!-- Search Box -->
                <div style="flex: 1; min-width: 250px; display: flex; gap: 8px;">
                    <input type="text" name="search" placeholder="Cari nama pembeli, jenis ikan..."
                        value="<?php echo e(request('search')); ?>"
                        style="flex: 1; padding: 10px 15px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                    <button type="submit" class="btn-filter" style="background: #1a4d7d; color: white;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>

                <!-- Status Filter Buttons -->
                <div class="filter-group">
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span style="font-size: 12px; color: #999; font-weight: 600;">Filter:</span>
                        <button type="button" class="btn-filter <?php echo e(empty($statusFilter) ? 'active' : ''); ?>"
                            onclick="setStatusFilter('', this)">
                            <i class="fas fa-list"></i> Semua
                        </button>
                        <button type="button"
                            class="btn-filter <?php echo e($statusFilter === 'Menunggu Validasi' ? 'active' : ''); ?>"
                            onclick="setStatusFilter('Menunggu Validasi', this)">
                            <i class="fas fa-hourglass-half"></i> Menunggu
                        </button>
                        <button type="button" class="btn-filter <?php echo e($statusFilter === 'Divalidasi' ? 'active' : ''); ?>"
                            onclick="setStatusFilter('Divalidasi', this)">
                            <i class="fas fa-check"></i> Divalidasi
                        </button>
                        <button type="button" class="btn-filter <?php echo e($statusFilter === 'Ditolak' ? 'active' : ''); ?>"
                            onclick="setStatusFilter('Ditolak', this)">
                            <i class="fas fa-times"></i> Ditolak
                        </button>
                    </div>
                </div>

                <!-- TPI Filter - Untuk semua user -->
                <div style="min-width: 200px;">
                    <select name="tpi" id="tpiFilter" onchange="document.getElementById('filterForm').submit()"
                        style="width: 100%; padding: 10px 15px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px; background-color: white;">
                        <option value="">Pilih TPI</option>
                        <?php $__currentLoopData = $tpiOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tpi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tpi); ?>" <?php echo e($tpiFilter === $tpi ? 'selected' : ''); ?>>
                                <?php echo e($tpi); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Date Filter -->
                <div style="min-width: 180px;">
                    <input type="date" name="date" id="dateFilter" value="<?php echo e(request('date')); ?>"
                        onchange="document.getElementById('filterForm').submit()"
                        style="width: 100%; padding: 10px 15px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px;">
                </div>

                <!-- Hidden status input -->
                <input type="hidden" name="status" id="statusInput" value="<?php echo e($statusFilter); ?>">
            </form>
        </div>

        <?php if(session('success')): ?>
            <div
                style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-check-circle"></i>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div
                style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo e(session('error')); ?></span>
            </div>
        <?php endif; ?>

        <!-- Table Section -->
        <div class="table-section">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; padding: 18px 20px; background: #fff; border-radius: 10px 10px 0 0; border-bottom: 2px solid #f0f0f0; margin-bottom: 0;">
                <div>
                    <div style="font-size: 16px; font-weight: 700; color: #0d2640; margin-bottom: 3px;">
                        Data Laporan Hasil Tangkap
                    </div>
                    <div style="font-size: 12px; color: #999; margin-top: 2px;">
                        Total <strong style="color: #0d2640;"><?php echo e($laporans->total()); ?></strong> data ditemukan
                    </div>
                </div>

                <!-- Tombol Validasi Massal -->
                <div>
                    <button type="button" id="btnValidasiSemua"
                        style="background: linear-gradient(135deg, #28a745, #1e7e34); color: white; cursor: pointer; border: none; padding: 11px 22px; border-radius: 8px; font-weight: 700; font-size: 13px; display: flex; align-items: center; gap: 9px; transition: all 0.25s; box-shadow: 0 4px 12px rgba(40,167,69,0.25);"
                        onmouseover="this.style.boxShadow='0 6px 18px rgba(40,167,69,0.4)'; this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.boxShadow='0 4px 12px rgba(40,167,69,0.25)'; this.style.transform='translateY(0)'"
                        onclick="confirmBulkValidation()">
                        <i class="fas fa-check-double"></i> Validasi Semua
                    </button>
                </div>
            </div>

            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Asal TPI</th>
                        <th>Nama Pembeli</th>
                        <th>Nama Penjual</th>
                        <th>Jenis Ikan</th>
                        <th>Volume (Kg)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $laporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="date-cell">
                                    <?php echo e($laporan->created_at->format('d M Y')); ?>

                                </div>
                            </td>
                            <td>
                                <?php echo e($laporan->user->wilayah ?? '-'); ?>

                            </td>
                            <td>
                                <div class="tpi-name"><?php echo e($laporan->nama_pembeli); ?></div>
                            </td>
                            <td>
                                <div class="tpi-name"><?php echo e($laporan->nama_nelayan); ?></div>
                            </td>
                            <td>
                                <div class="fish-badge"><?php echo e($laporan->jenis_ikan); ?></div>
                            </td>
                            <td>
                                <div class="volume-cell"><?php echo e(number_format($laporan->berat, 2)); ?> Kg</div>
                            </td>
                            <td>
                                <div
                                    class="status-badge status-<?php echo e(strtolower(str_replace(' ', '-', $laporan->status))); ?>">
                                    <?php echo e($laporan->status === 'Divalidasi' ? 'Tervalidasi' : $laporan->status); ?>

                                </div>
                            </td>
                            <td>
                                <div class="action-cell">
                                    <?php if(in_array($laporan->status, ['Draft', 'Menunggu Validasi', 'Revisi'])): ?>
                                        <form action="<?php echo e(route('staff.validasi.validate', $laporan->id)); ?>"
                                            method="POST" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="action-btn action-validate">
                                                <i class="fas fa-check"></i> validasi
                                            </button>
                                        </form>
                                        <button type="button" class="action-btn action-reject"
                                            onclick="openRejectModal(<?php echo e($laporan->id); ?>, '<?php echo e($laporan->nama_pembeli); ?>')">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    <?php else: ?>
                                        <span style="font-size: 12px; color: #999;"><?php echo e($laporan->status); ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 30px; color: #999;">
                                <i class="fas fa-inbox"
                                    style="font-size: 32px; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                                Tidak ada data untuk ditampilkan
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php echo e($laporans->appends(request()->query())->links('pagination.custom')); ?>

        </div>

        <!-- Reject Modal -->
        <div id="rejectModal"
            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;">
            <div
                style="background: white; padding: 30px; border-radius: 12px; width: 90%; max-width: 500px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
                <h3 style="font-size: 18px; color: #0d2640; margin-bottom: 15px;">Tolak Laporan</h3>
                <p id="rejectModalText" style="color: #666; margin-bottom: 20px;"></p>
                <form id="rejectForm" method="POST" style="margin-bottom: 20px;">
                    <?php echo csrf_field(); ?>
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

        <!-- HIDDEN FORM UNTUK VALIDASI MASSAL -->
        <form id="hiddenBulkForm" action="<?php echo e(route('staff.validasi.bulk')); ?>" method="POST"
            style="display: none;">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="validate_all" id="validateAllInput" value="0">
        </form>

        <!-- Modal Konfirmasi Validasi Semua -->
        <div id="confirmValidasiModal" class="confirm-overlay">
            <div class="confirm-box">
                <div class="confirm-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="confirm-title">Konfirmasi Validasi</div>
                <div class="confirm-desc" id="confirmValidasiDesc">
                    Apakah Anda yakin ingin memvalidasi semua laporan?<br>
                    Tindakan ini <strong>tidak dapat dibatalkan</strong>.
                </div>
                <div class="confirm-actions">
                    <button type="button" class="confirm-btn-cancel" onclick="closeConfirmModal()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="button" class="confirm-btn-ok" id="confirmValidasiOkBtn" onclick="submitBulkValidation()">
                        <i class="fas fa-check-double"></i> Ya, Validasi!
                    </button>
                </div>
            </div>
        </div>

        <script>
            // === STATUS FILTER ===
            function setStatusFilter(status, btn) {
                const statusInput = document.getElementById('statusInput');
                if (statusInput) {
                    statusInput.value = status;
                    document.getElementById('filterForm').submit();
                }
            }

            // === NOTIFICATION DROPDOWN ===
            function closeNotificationDropdown() {
                const dd = document.getElementById('notificationDropdown');
                const btn = document.getElementById('notificationToggle');
                if (dd) dd.style.display = 'none';
                if (btn) btn.setAttribute('aria-expanded', 'false');
            }

            document.getElementById('notificationToggle')?.addEventListener('click', function(e) {
                e.stopPropagation();
                const dd = document.getElementById('notificationDropdown');
                if (!dd) return;
                const isOpen = dd.style.display === 'block';
                dd.style.display = isOpen ? 'none' : 'block';
                this.setAttribute('aria-expanded', String(!isOpen));
            });

            document.addEventListener('click', function(e) {
                const dd = document.getElementById('notificationDropdown');
                const btn = document.getElementById('notificationToggle');
                if (!dd || !btn) return;
                if (!dd.contains(e.target) && !btn.contains(e.target)) {
                    closeNotificationDropdown();
                }
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

            // === LOGIC VALIDASI MASSAL ===
            function confirmBulkValidation() {
                const total = <?php echo e($stats['pending']); ?>;
                if (total === 0) {
                    alert('Tidak ada laporan yang perlu divalidasi saat ini.');
                    return;
                }
                // Set mode validate semua halaman
                document.getElementById('validateAllInput').value = '1';
                document.querySelectorAll('#hiddenBulkForm input[name="tangkapan_ids[]"]').forEach(el => el.remove());
                // Tampilkan modal konfirmasi
                document.getElementById('confirmValidasiDesc').innerHTML =
                    'Anda akan memvalidasi <strong>' + total + ' laporan</strong> yang belum divalidasi.<br><br>' +
                    'Tindakan ini <strong>tidak dapat dibatalkan</strong>.';
                document.getElementById('confirmValidasiModal').classList.add('active');
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

            function showPending() {
                const statusInput = document.getElementById('statusInput');
                if (!statusInput) return;
                statusInput.value = 'pending';
                document.getElementById('filterForm').submit();
            }

            function submitBulkValidation() {
                closeConfirmModal();
                document.getElementById('hiddenBulkForm').submit();
            }

            function closeConfirmModal() {
                document.getElementById('confirmValidasiModal').classList.remove('active');
            }

            // Tutup modal saat klik luar
            document.getElementById('confirmValidasiModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeConfirmModal();
            });

            document.getElementById('rejectModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeRejectModal();
                }
            });
        </script>

        <div class="page-footer">
            &copy; 2026 Dinas Perikanan Kabupaten Subang | Neutron Tech Solutions
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="profile-modal">
        <div class="profile-modal-content">
            <div class="profile-modal-header">
                <button class="profile-modal-close" onclick="closeProfileModal()">&times;</button>
                <div class="profile-avatar">
                    STF</div>
                <div class="profile-name"><?php echo e($currentUser->nama ?? $currentUser->username); ?></div>
                <div class="profile-role"><?php echo e(ucfirst($currentUser->role)); ?></div>
            </div>
            <div class="profile-modal-body">
                <div class="profile-item">
                    <div class="profile-item-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="profile-item-content">
                        <div class="profile-item-label">Lokasi Penempatan</div>
                        <div class="profile-item-value"><?php echo e($currentUser->wilayah ?? '-'); ?></div>
                    </div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-icon">
                        <i class="fas fa-venus-mars"></i>
                    </div>
                    <div class="profile-item-content">
                        <div class="profile-item-label">Jenis Kelamin</div>
                        <div class="profile-item-value"><?php echo e($currentUser->jenis_kelamin ?? '-'); ?></div>
                    </div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="profile-item-content">
                        <div class="profile-item-label">No. Telepon</div>
                        <div class="profile-item-value"><?php echo e($currentUser->no_telepon ?? '-'); ?></div>
                    </div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-icon">
                        <i class="fas fa-map-pin"></i>
                    </div>
                    <div class="profile-item-content">
                        <div class="profile-item-label">Alamat</div>
                        <div class="profile-item-value"><?php echo e($currentUser->alamat ?? '-'); ?></div>
                    </div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="profile-item-content">
                        <div class="profile-item-label">Status</div>
                        <?php if($currentUser->is_active ?? true): ?>
                            <span class="profile-status active">Aktif</span>
                        <?php else: ?>
                            <span class="profile-status inactive">Nonaktif</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="margin: 0 30px 30px; display: flex; justify-content: center; border-top: 1px solid #eee; padding-top: 20px;">
                <button type="button" onclick="closeProfileModal()" style="width: 100%; text-align: center; padding: 10px 20px; border: 1px solid #ddd; background: white; color: #666; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s ease;" onmouseover="this.style.background='#f5f5f5'; this.style.borderColor='#bbb';" onmouseout="this.style.background='white'; this.style.borderColor='#ddd';">Tutup</button>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- REAL-TIME NOTIFICATION SYSTEM                                 -->
    <!-- ============================================================ -->
    <style>
        /* Live Notification Toast */
        #liveToast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            min-width: 330px;
            max-width: 400px;
            background: linear-gradient(135deg, #0a3b99 0%, #1a5ec8 100%);
            color: white;
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(10,59,153,0.35), 0 0 0 2px rgba(255,255,255,0.12);
            padding: 0;
            overflow: hidden;
            transform: translateY(120px);
            opacity: 0;
            transition: transform 0.45s cubic-bezier(0.34,1.56,0.64,1), opacity 0.35s ease;
            pointer-events: none;
        }
        #liveToast.show {
            transform: translateY(0);
            opacity: 1;
            pointer-events: all;
        }
        .toast-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }
        .toast-bell {
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.18);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
            animation: bellRing 0.6s ease 0.2s;
        }
        @keyframes bellRing {
            0%   { transform: rotate(0); }
            20%  { transform: rotate(-18deg); }
            40%  { transform: rotate(18deg); }
            60%  { transform: rotate(-10deg); }
            80%  { transform: rotate(8deg); }
            100% { transform: rotate(0); }
        }
        .toast-title {
            font-weight: 800;
            font-size: 14px;
            flex: 1;
        }
        .toast-close {
            background: none;
            border: none;
            color: rgba(255,255,255,0.7);
            font-size: 18px;
            cursor: pointer;
            line-height: 1;
            padding: 0 4px;
            transition: color 0.2s;
        }
        .toast-close:hover { color: white; }
        .toast-body {
            padding: 12px 18px 16px;
            font-size: 13px;
        }
        .toast-count {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 4px;
        }
        .toast-sub {
            font-size: 12px;
            opacity: 0.85;
            margin-bottom: 12px;
        }
        .toast-items {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 14px;
        }
        .toast-item {
            background: rgba(255,255,255,0.12);
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .toast-item-icon { opacity: 0.75; }
        .toast-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: white;
            color: #0a3b99;
            border: none;
            border-radius: 10px;
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }
        .toast-btn:hover {
            background: #e8f0fe;
            transform: translateY(-1px);
        }
        /* Pulse badge animation */
        @keyframes pulseBadge {
            0%   { box-shadow: 0 0 0 0 rgba(220,53,69,0.7); }
            70%  { box-shadow: 0 0 0 8px rgba(220,53,69,0); }
            100% { box-shadow: 0 0 0 0 rgba(220,53,69,0); }
        }
        .notification-badge.pulse {
            animation: pulseBadge 1.2s ease infinite;
        }
    </style>

    <!-- Toast Element -->
    <div id="liveToast">
        <div class="toast-header">
            <div class="toast-bell"><i class="fas fa-bell"></i></div>
            <div class="toast-title">Laporan Masuk!</div>
            <button class="toast-close" onclick="dismissToast()">&#x2715;</button>
        </div>
        <div class="toast-body">
            <div class="toast-count" id="toastCount">0 Laporan Baru</div>
            <div class="toast-sub" id="toastSub">Menunggu validasi dari juru rekap</div>
            <div class="toast-items" id="toastItems"></div>
            <button class="toast-btn" onclick="window.location.href='<?php echo e(route('staff.validasi')); ?>'">
                <i class="fas fa-clipboard-check"></i>&nbsp; Lihat & Validasi Sekarang
            </button>
        </div>
    </div>

    <script>
    // =====================================================
    // REAL-TIME POLLING NOTIFICATION SYSTEM
    // =====================================================
    (function () {
        const POLL_URL      = '<?php echo e(route("staff.validasi.poll")); ?>';
        const POLL_INTERVAL = 10000; // 10 seconds
        let lastKnownId     = <?php echo e(\App\Models\Tangkapan::whereIn('status', ['Draft','Menunggu Validasi'])->max('id') ?? 0); ?>;
        let lastPending     = <?php echo e($stats['pending']); ?>;
        let toastTimer      = null;
        let audioCtx        = null;

        // --- Web Audio notification beep ---
        function playNotificationSound() {
            try {
                if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();

                // Three-tone ascending beep: pleasant, professional
                const tones = [
                    { freq: 523.25, start: 0,    dur: 0.14 }, // C5
                    { freq: 659.25, start: 0.15,  dur: 0.14 }, // E5
                    { freq: 783.99, start: 0.30,  dur: 0.22 }, // G5
                ];

                tones.forEach(({ freq, start, dur }) => {
                    const osc  = audioCtx.createOscillator();
                    const gain = audioCtx.createGain();
                    osc.connect(gain);
                    gain.connect(audioCtx.destination);
                    osc.type      = 'sine';
                    osc.frequency.value = freq;
                    const t = audioCtx.currentTime + start;
                    gain.gain.setValueAtTime(0, t);
                    gain.gain.linearRampToValueAtTime(0.35, t + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.001, t + dur);
                    osc.start(t);
                    osc.stop(t + dur + 0.05);
                });
            } catch (e) {
                console.warn('Audio not available:', e);
            }
        }

        // --- Show toast notification ---
        function showToast(pending, newCount, recent) {
            const toast = document.getElementById('liveToast');
            document.getElementById('toastCount').textContent =
                newCount + ' Laporan Baru Masuk';
            document.getElementById('toastSub').textContent =
                'Total ' + pending + ' laporan menunggu validasi Anda';

            // Render recent items
            const itemsEl = document.getElementById('toastItems');
            itemsEl.innerHTML = '';
            if (recent && recent.length > 0) {
                recent.forEach(function (r) {
                    const div = document.createElement('div');
                    div.className = 'toast-item';
                    div.innerHTML =
                        '<span class="toast-item-icon"><i class="fas fa-fish"></i></span>' +
                        '<span><strong>' + (r.jenis_ikan || '-') + '</strong> &bull; ' +
                        (r.berat || 0) + ' kg &bull; <em>' + (r.waktu || '-') + '</em></span>';
                    itemsEl.appendChild(div);
                });
            }

            // Auto-dismiss after 12 seconds
            if (toastTimer) clearTimeout(toastTimer);
            toast.classList.add('show');
            toastTimer = setTimeout(dismissToast, 12000);
        }

        function dismissToast() {
            document.getElementById('liveToast').classList.remove('show');
            if (toastTimer) { clearTimeout(toastTimer); toastTimer = null; }
        }

        // --- Update notification badge ---
        function updateBadge(pending) {
            // Header bell badge
            let badge = document.querySelector('#notificationToggle .notification-badge');
            if (pending > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'notification-badge pulse';
                    document.getElementById('notificationToggle').appendChild(badge);
                }
                badge.textContent = pending;
                badge.classList.add('pulse');
            } else if (badge) {
                badge.remove();
            }

            // Sidebar badge (inside <li> for staff.validasi)
            const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
            sidebarLinks.forEach(function (link) {
                if (link.href && link.href.includes('validasi-laporan')) {
                    let sbBadge = link.querySelector('span[data-notif]');
                    if (pending > 0) {
                        if (!sbBadge) {
                            sbBadge = document.createElement('span');
                            sbBadge.setAttribute('data-notif', '1');
                            sbBadge.style.cssText =
                                'margin-left:auto;background:#dc3545;color:#fff;font-size:0.72rem;' +
                                'min-width:20px;height:20px;display:inline-flex;align-items:center;' +
                                'justify-content:center;border-radius:999px;padding:0 5px;' +
                                'position:absolute;right:12px;top:50%;transform:translateY(-50%);font-weight:700;';
                            link.appendChild(sbBadge);
                        }
                        sbBadge.textContent = pending;
                    } else if (sbBadge) {
                        sbBadge.remove();
                    }
                }
            });

            // Update dropdown text
            const dropdownContent = document.querySelector('#notificationDropdown > div:last-child');
            if (dropdownContent) {
                if (pending > 0) {
                    dropdownContent.innerHTML =
                        '<p style="margin:0 0 10px;">Terdapat <strong>' + pending + '</strong> laporan menunggu validasi.</p>' +
                        '<div style="display:flex;gap:8px;">' +
                        '<button type="button" onclick="showPending()" class="btn-filter" style="background:#1a4d7d;color:white;">Tampilkan</button>' +
                        '<button type="button" onclick="closeNotificationDropdown()" class="btn-filter" style="background:#e0e0e0;color:#0d2640;">Tutup</button>' +
                        '</div>';
                } else {
                    dropdownContent.innerHTML = '<p style="margin:0;color:#666;">Tidak ada notifikasi baru.</p>';
                }
            }
        }

        // --- Main poll function ---
        function poll() {
            fetch(POLL_URL, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                const newLatestId = data.latest_id || 0;
                const pending     = data.pending   || 0;

                // Detect new laporan: latest_id increased
                if (newLatestId > lastKnownId && lastKnownId > 0) {
                    const newCount = pending - lastPending;
                    playNotificationSound();
                    showToast(pending, Math.max(newCount, 1), data.recent || []);
                }

                // Always update badge with current pending count
                updateBadge(pending);

                lastKnownId  = newLatestId;
                lastPending  = pending;
            })
            .catch(function (e) {
                console.warn('Poll error:', e);
            });
        }

        // Start polling after 3s delay (give page time to settle)
        setTimeout(function () {
            poll(); // First immediate poll
            setInterval(poll, POLL_INTERVAL);
        }, 3000);
    })();
    </script>

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
<?php /**PATH C:\laragon\www\SipetangApp\web-laravel\resources\views/Staff/validasi-laporan.blade.php ENDPATH**/ ?>