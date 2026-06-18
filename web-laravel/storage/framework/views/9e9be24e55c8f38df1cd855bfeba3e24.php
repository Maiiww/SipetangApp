<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Manajemen User - SIPETANG</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Menggunakan CSS yang Anda berikan sebelumnya */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
            min-height: 100vh;
            color: #1e293b;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 30px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .search-box {
            display: flex;
            align-items: center;
            padding: 0 15px;
            background: #f5f5f5;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            width: 300px;
        }

        .search-box input {
            border: none;
            background: none;
            width: 100%;
            font-size: 14px;
            padding: 10px 0;
            outline: none;
            margin-left: 10px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            text-align: right;
        }

        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 6px;
        }

        /* Content Components */
        .content-header {
            margin-bottom: 30px;
        }

        .content-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: #0d2640;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .content-header p {
            color: #64748b;
            font-size: 14.5px;
            font-weight: 500;
        }

        /* Filter Row */
        .filter-row {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            align-items: flex-end;
        }

        .total-card {
            background: #0d2640;
            color: white;
            padding: 22px 26px;
            border-radius: 16px;
            min-width: 170px;
            box-shadow: 0 10px 25px -5px rgba(13, 38, 64, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .total-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(13, 38, 64, 0.35);
        }

        .total-card small {
            font-size: 11px;
            opacity: 0.85;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
            margin-bottom: 6px;
            display: block;
        }

        .total-card h2 {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .filter-form {
            background: white;
            padding: 22px 26px;
            border-radius: 16px;
            display: flex;
            gap: 18px;
            flex: 1;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02), 0 1px 0 rgba(255,255,255,0.8) inset;
            border: 1px solid rgba(226, 232, 240, 0.8);
            align-items: flex-end;
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.05em;
        }

        .form-group select,
        .form-group input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #f8fafc;
            font-size: 13.5px;
            color: #1e293b;
            outline: none;
            transition: all 0.25s ease;
            font-family: inherit;
        }

        .form-group select:focus,
        .form-group input:focus {
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .btn {
            padding: 12px 22px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 700;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-dark {
            background: #0d2640;
            color: white;
            box-shadow: 0 4px 12px rgba(13, 38, 64, 0.15);
        }

        .btn-dark:hover {
            background: #0a1c30;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(13, 38, 64, 0.25);
        }

        .btn-dark:active {
            transform: translateY(0);
        }

        /* Table User */
        .table-container {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04), 0 1px 0 rgba(255,255,255,0.8) inset;
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 16px 14px;
            font-size: 11px;
            color: #64748b;
            border-bottom: 1.5px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
        }

        th:last-child {
            text-align: center;
        }

        td {
            padding: 16px 14px;
            font-size: 13.5px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }

        td:last-child {
            text-align: center;
        }

        tr {
            transition: background-color 0.2s ease;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            letter-spacing: 0.05em;
        }

        .tpi-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.02em;
            display: inline-block;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .status-aktif {
            background: #dcfce7;
            color: #166534;
            border: 1.5px solid rgba(22, 163, 74, 0.15);
        }

        .status-aktif i {
            font-size: 10px;
        }

        .status-nonaktif {
            background: #fee2e2;
            color: #991b1b;
            border: 1.5px solid rgba(220, 38, 38, 0.15);
        }

        .status-nonaktif i {
            font-size: 10px;
        }

        /* Action Buttons */
        .btn-aksi {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-nonaktif {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .btn-nonaktif:hover {
            background: #fecaca;
            border-color: #f87171;
        }

        .btn-aktif {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .btn-aktif:hover {
            background: #bbf7d0;
            border-color: #6ee7b7;
        }

        /* Action Menu with Ellipsis */
        .btn-aksi-menu {
            width: 34px;
            height: 34px;
            border: none;
            background: none;
            color: #64748b;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.25s ease;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .btn-aksi-menu:hover {
            background: #f1f5f9;
            color: #0d2640;
        }

        .action-dropdown {
            position: absolute;
            top: calc(100% - 5px);
            right: 15px;
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            z-index: 200;
            min-width: 160px;
            overflow: hidden;
            margin-top: 5px;
            animation: dropdownFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 16px;
            border: none;
            background: none;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-align: left;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f8fafc;
            color: #0d2640;
        }

        .dropdown-item i {
            width: 16px;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 24px;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }

        .page-info {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        .page-nav {
            display: flex;
            gap: 6px;
        }

        .page-link {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            text-decoration: none;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
            background: white;
        }

        .page-link:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
            color: #0f172a;
        }

        .page-link.active {
            background: #0d2640;
            color: white;
            border-color: #0d2640;
            box-shadow: 0 4px 12px rgba(13, 38, 64, 0.2);
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100% !important;
                position: relative !important;
                height: auto !important;
                padding: 20px 15px !important;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100%;
                padding: 18px;
            }

            .header,
            .header-right {
                flex-direction: column;
                align-items: stretch;
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            overflow: auto;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalScaleUp {
            from { transform: scale(0.92); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
            animation: modalFadeIn 0.25s ease-out forwards;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal.active .modal-content {
            animation: modalScaleUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .modal-header h2 {
            font-size: 20px;
            color: #0d2640;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #888;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            color: #0d2640;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .form-group-modal {
            display: flex;
            flex-direction: column;
        }

        .form-group-modal label {
            font-size: 11px;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-group-modal input,
        .form-group-modal select,
        .form-group-modal textarea {
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13.5px;
            font-family: inherit;
            background: #f8fafc;
            transition: all 0.25s ease;
            color: #1e293b;
            outline: none;
        }

        .form-group-modal input:focus,
        .form-group-modal select:focus,
        .form-group-modal textarea:focus {
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .form-group-modal textarea {
            resize: vertical;
            min-height: 80px;
        }

        .modal-footer {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }

        .btn-cancel {
            padding: 11px 20px;
            border: 1.5px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 10px;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-cancel:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #334155;
        }

        .btn-submit {
            padding: 11px 22px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 700;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-submit:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }

        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* Profile Button Header */
        .profile-icon-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            padding: 2px;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        }

        .profile-icon-btn:hover {
            transform: scale(1.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .profile-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .profile-icon-btn:hover .profile-avatar {
            background: white;
            color: #0a3b99;
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
            margin-right: 10px;
        }

        .dark-mode-toggle:hover {
            transform: scale(1.08) rotate(15deg);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: #e2e8f0;
            color: #0f172a;
        }

        /* Profile Modal Specific Styles */
        .profile-modal-header-bg {
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            height: 100px;
            border-radius: 12px 12px 0 0;
            margin: -30px -30px 0 -30px;
            position: relative;
        }

        .profile-modal-avatar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: -50px;
            margin-bottom: 20px;
            position: relative;
            z-index: 10;
        }

        .profile-modal-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: white;
            border: 4px solid white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0a3b99;
            font-size: 44px;
            margin-bottom: 12px;
        }

        .profile-modal-name {
            font-size: 22px;
            font-weight: 700;
            color: #0d2640;
            margin: 0 0 5px 0;
            text-align: center;
        }

        .profile-modal-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(3, 105, 161, 0.08);
        }

        .profile-details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 10px;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }

        .profile-detail-card {
            background: #f8fafc;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }

        .profile-detail-card:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
        }

        .profile-detail-card.full-width {
            grid-column: span 2;
        }

        .profile-detail-label {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .profile-detail-value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .profile-detail-value i {
            margin-right: 6px;
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

        /* DARK MODE STYLES & VARIABLES */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar, .header, .search-box, .total-card, .filter-form, .table-container, .btn-primary, .btn-dark, .modal-content, .modal-footer, input, select, textarea {
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease, color 0.3s ease;
        }

        body.dark-mode {
            background: #0f172a; /* Slate 900 */
            color: #f1f5f9; /* Slate 100 */
        }

        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #020617 0%, #0b1e3f 100%) !important;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.4) !important;
        }

        body.dark-mode .header {
            background: #1e293b; /* Slate 800 */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            border-color: #334155;
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

        body.dark-mode .search-box {
            background: #334155;
            border-color: #475569;
        }

        body.dark-mode .search-box input {
            color: #f8fafc;
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

        body.dark-mode .content-header h2,
        body.dark-mode .total-card h2,
        body.dark-mode .profile-item-value,
        body.dark-mode td,
        body.dark-mode .modal-title,
        body.dark-mode .user-info-name {
            color: #f8fafc !important;
        }

        body.dark-mode .content-header p,
        body.dark-mode .total-card small,
        body.dark-mode .form-group label,
        body.dark-mode .profile-item-label,
        body.dark-mode th,
        body.dark-mode .user-info-username,
        body.dark-mode .detail-label,
        body.dark-mode .modal-body label {
            color: #94a3bb !important;
        }

        body.dark-mode .total-card {
            background: #020617;
            border-color: #334155;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
        }

        body.dark-mode .total-card:hover {
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.5);
        }

        body.dark-mode .filter-form,
        body.dark-mode .table-container,
        body.dark-mode .profile-modal-content,
        body.dark-mode .modal-content {
            background: #1e293b; /* Slate 800 */
            border-color: #334155;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        body.dark-mode .modal-footer {
            background: #0f172a;
            border-color: #334155;
        }

        body.dark-mode .reports-table thead,
        body.dark-mode th {
            border-bottom-color: #334155;
        }

        body.dark-mode tbody tr:hover,
        body.dark-mode td {
            border-bottom-color: #334155;
        }

        body.dark-mode tbody tr:hover {
            background: #273549;
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
            background-color: #1e293b !important;
        }

        body.dark-mode .btn-dark {
            background: #020617;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        body.dark-mode .btn-dark:hover {
            background: #0b1329;
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

        body.dark-mode .user-menu-dropdown {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
        }
        
        body.dark-mode .user-menu-dropdown a {
            color: #f8fafc !important;
        }
        
        body.dark-mode .user-menu-dropdown a:hover {
            background-color: #334155 !important;
        }
    </style>
</head>

<body>
    <script>
        if (localStorage.getItem('adminDarkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
    </script>
    <?php echo $__env->make('components.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content">
        <div class="header">
            <div style="flex: 1;"></div>
            <div class="header-right" style="display: flex; align-items: center; gap: 10px;">
                <!-- Dark Mode Toggle Button -->
                <div class="dark-mode-toggle" id="darkModeToggle" title="Ubah Tema" onclick="toggleDarkMode()">
                    <i class="fas fa-moon dark-icon"></i>
                    <i class="fas fa-sun light-icon" style="display: none;"></i>
                </div>

                <div class="profile-icon-btn" onclick="openAdminProfileModal()" title="Profil Saya">
                    <div class="profile-avatar" style="font-size: 14px; font-weight: 700; letter-spacing: 0.5px;">
                        <?php echo e(strtoupper(substr(Auth::user()->nama ?? Auth::user()->username ?? 'ADM', 0, 3))); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="content-header">
            <h2>Kelola Data Pengguna</h2>
            <p>Kelola seluruh data Juru Rekap</p>
        </div>

        <div class="filter-row">
            <div class="total-card">
                <small>TOTAL DATA USER</small>
                <h2><?php echo e(count($users)); ?></h2>
            </div>
            <div class="filter-form">
                <div class="form-group">
                    <label>CARI DATA PETUGAS</label>
                    <input type="text" id="filterSearch" placeholder="Ketik nama atau ID...">
                </div>
                <div class="form-group">
                    <label>ROLE</label>
                    <select id="filterRole">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="juruRekap">Juru Rekap</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select id="filterGender">
                        <option value="">Semua</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" onclick="applyFilter()">Terapkan</button>
            </div>
            <button class="btn btn-dark" onclick="openModal()"><i class="fas fa-user-plus"></i> Tambah Pengguna</button>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nama Petugas</th>
                        <th>Lokasi Penempatan</th>
                        <th>Jenis Kelamin</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr data-username="<?php echo e(strtolower($user->nama ?? $user->username)); ?>"
                            data-id="<?php echo e(strtolower($user->no_induk ?? '')); ?>" data-role="<?php echo e($user->role ?? ''); ?>"
                            data-gender="<?php echo e($user->jenis_kelamin ?? ''); ?>">
                            <td>
                                <div class="user-info">
                                    <div class="avatar"
                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                        <?php echo e(strtoupper(substr($user->nama ?? $user->username, 0, 2))); ?>

                                    </div>
                                    <div>
                                        <strong><?php echo e($user->nama ?? $user->username); ?></strong>
                                        <br>
                                        <small style="color: #999;"><?php echo e($user->no_induk ?? '-'); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="tpi-badge"><?php echo e($user->wilayah ?? 'Umum'); ?></span></td>
                            <td><?php echo e($user->jenis_kelamin ?? '-'); ?></td>
                            <td><?php echo e($user->no_telepon ?? '-'); ?></td>
                            <td><?php echo e($user->alamat ?? '-'); ?></td>
                            <td>
                                <?php if($user->is_active ?? true): ?>
                                    <span class="status-badge status-aktif">
                                        <i class="fas fa-circle-check"></i> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge status-nonaktif">
                                        <i class="fas fa-circle-xmark"></i> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; position: relative;">
                                <?php if($user->role !== 'admin'): ?>
                                    <button class="btn-aksi-menu" onclick="toggleMenu(event, this)">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="action-dropdown" style="display: none;">
                                            <button type="button" class="dropdown-item"
                                                onclick="openEditModal(this)"
                                                data-id="<?php echo e($user->id); ?>"
                                                data-nama="<?php echo e($user->nama ?? $user->username); ?>"
                                                data-no-induk="<?php echo e($user->no_induk ?? ''); ?>"
                                                data-username="<?php echo e($user->username); ?>"
                                                data-role="<?php echo e($user->role); ?>"
                                                data-jenis-kelamin="<?php echo e($user->jenis_kelamin ?? ''); ?>"
                                                data-no-telepon="<?php echo e($user->no_telepon ?? ''); ?>"
                                                data-alamat="<?php echo e($user->alamat ?? ''); ?>"
                                                data-wilayah="<?php echo e($user->wilayah ?? ''); ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        <?php if($user->is_active ?? true): ?>
                                            <button type="button" class="dropdown-item"
                                                onclick="deactivateUser(<?php echo e($user->id); ?>, '<?php echo e($user->nama ?? $user->username); ?>')">
                                                <i class="fas fa-ban"></i> Nonaktifkan
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="dropdown-item"
                                                onclick="activateUser(<?php echo e($user->id); ?>, '<?php echo e($user->nama ?? $user->username); ?>')">
                                                <i class="fas fa-check-circle"></i> Aktifkan
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <span style="color: #999; font-size: 12px;">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: #999; padding: 30px;">Tidak ada data
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="pagination">
                <p class="page-info">
                    <?php echo e(count($users) > 0 ? 'Menampilkan ' . count($users) . ' data' : 'Tidak ada data'); ?></p>
                <div class="page-nav">
                    <a href="#" class="page-link"><i class="fas fa-chevron-left"></i></a>
                    <a href="#" class="page-link active">1</a>
                    <a href="#" class="page-link"><i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <div class="page-footer">
            &copy; 2026 Dinas Perikanan Kabupaten Subang | Neutron Tech Solutions
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div id="tambahUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tambah User Baru</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>

            <form id="formTambahUser" action="<?php echo e(route('admin.user.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-row full">
                    <div class="form-group-modal">
                        <label>NAMA PETUGAS *</label>
                        <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group-modal">
                        <label>USERNAME *</label>
                        <input type="text" name="username" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-modal">
                        <label>PASSWORD *</label>
                        <div class="password-input-wrapper" style="position: relative; display: flex; align-items: center;">
                            <input type="password" id="password" name="password" placeholder="Masukkan password" required style="width: 100%; padding-right: 40px;">
                            <span class="password-toggle-icon" id="togglePassword" style="position: absolute; right: 12px; cursor: pointer; color: #94a3bb; transition: color 0.3s;" onclick="toggleFieldVisibility('password', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group-modal">
                        <label>KONFIRMASI PASSWORD *</label>
                        <div class="password-input-wrapper" style="position: relative; display: flex; align-items: center;">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" required style="width: 100%; padding-right: 40px;">
                            <span class="password-toggle-icon" id="togglePasswordConfirm" style="position: absolute; right: 12px; cursor: pointer; color: #94a3bb; transition: color 0.3s;" onclick="toggleFieldVisibility('password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-modal">
                        <label>ROLE *</label>
                        <select name="role" id="roleSelect" required onchange="updateRoleFields()">
                            <option value="">Pilih Role</option>
                            <option value="staff">Staff</option>
                            <option value="juruRekap">Juru Rekap</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group-modal">
                        <label>JENIS KELAMIN *</label>
                        <select name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <!-- NO. ID Field (Hidden initially) -->
                <div class="form-row full" id="no_id_field" style="display: none;">
                    <div class="form-group-modal">
                        <label>NO. ID *</label>
                        <input type="text" id="no_induk_input" name="no_induk" placeholder="Otomatis terisi" required readonly>
                    </div>
                </div>

                <div class="form-row full" id="asal_tpi_field" style="display: none;">
                    <div class="form-group-modal">
                        <label>WILAYAH <span id="wilayah_required" style="display: none;">*</span></label>
                        <input type="text" name="wilayah" id="wilayah_input"
                            placeholder="Contoh: TPI Blanakan atau Dinas Pusat">
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group-modal">
                        <label>NO. TELEPON *</label>
                        <input type="tel" name="no_telepon" placeholder="Contoh: +62 812-3456-7890" required>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group-modal">
                        <label>ALAMAT *</label>
                        <textarea name="alamat" placeholder="Masukkan alamat lengkap" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" id="submitTambahUser" class="btn-submit">Tambah User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Data User</h2>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>

            <form id="formEditUser" action="<?php echo e(route('admin.user.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="user_id" id="edit_user_id">
                
                <div class="form-row full">
                    <div class="form-group-modal">
                        <label>NAMA PETUGAS *</label>
                        <input type="text" name="nama" id="edit_nama" placeholder="Masukkan nama lengkap" required>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group-modal">
                        <label>USERNAME *</label>
                        <input type="text" name="username" id="edit_username" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-modal">
                        <label>PASSWORD</label>
                        <div class="password-input-wrapper" style="position: relative; display: flex; align-items: center;">
                            <input type="password" id="edit_password" name="password" placeholder="Kosongkan jika tidak diubah" style="width: 100%; padding-right: 40px;">
                            <span class="password-toggle-icon" id="toggleEditPassword" style="position: absolute; right: 12px; cursor: pointer; color: #94a3bb; transition: color 0.3s;" onclick="toggleFieldVisibility('edit_password', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group-modal">
                        <label>KONFIRMASI PASSWORD</label>
                        <div class="password-input-wrapper" style="position: relative; display: flex; align-items: center;">
                            <input type="password" id="edit_password_confirmation" name="password_confirmation" placeholder="Kosongkan jika tidak diubah" style="width: 100%; padding-right: 40px;">
                            <span class="password-toggle-icon" id="toggleEditPasswordConfirm" style="position: absolute; right: 12px; cursor: pointer; color: #94a3bb; transition: color 0.3s;" onclick="toggleFieldVisibility('edit_password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-modal">
                        <label>ROLE *</label>
                        <select name="role" id="edit_roleSelect" required onchange="updateEditRoleFields()">
                            <option value="">Pilih Role</option>
                            <option value="staff">Staff</option>
                            <option value="juruRekap">Juru Rekap</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group-modal">
                        <label>JENIS KELAMIN *</label>
                        <select name="jenis_kelamin" id="edit_jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <!-- NO. ID Field (Hidden initially) -->
                <div class="form-row full" id="edit_no_id_field" style="display: none;">
                    <div class="form-group-modal">
                        <label>NO. ID *</label>
                        <input type="text" id="edit_no_induk_input" name="no_induk" placeholder="Otomatis terisi" required readonly>
                    </div>
                </div>

                <div class="form-row full" id="edit_asal_tpi_field" style="display: none;">
                    <div class="form-group-modal">
                        <label>WILAYAH <span id="edit_wilayah_required" style="display: none;">*</span></label>
                        <input type="text" name="wilayah" id="edit_wilayah_input" placeholder="Contoh: TPI Blanakan atau Dinas Pusat">
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group-modal">
                        <label>NO. TELEPON *</label>
                        <input type="tel" name="no_telepon" id="edit_no_telepon" placeholder="Contoh: +62 812-3456-7890" required>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group-modal">
                        <label>ALAMAT *</label>
                        <textarea name="alamat" id="edit_alamat" placeholder="Masukkan alamat lengkap" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                    <button type="submit" id="submitEditUser" class="btn-submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function normalizeGender(value) {
            if (!value) return '';
            const normalized = value.toLowerCase().trim().replace(/\s+/g, '');
            // Handle various formats
            if (normalized.startsWith('l') || normalized === 'm' || normalized === 'male') return 'laki-laki';
            if (normalized.startsWith('p') || normalized === 'f' || normalized === 'female') return 'perempuan';
            return normalized;
        }

        function applyFilter() {
            const searchValue = document.getElementById('filterSearch').value.toLowerCase().trim();
            const roleValue = document.getElementById('filterRole').value.toLowerCase().trim();
            const genderFilterValue = document.getElementById('filterGender').value.toLowerCase().trim();
            const genderValue = normalizeGender(genderFilterValue);
            const tableBody = document.querySelector('table tbody');
            const rows = tableBody.querySelectorAll('tr');
            let visibleCount = 0;

            console.log('Filter values:', {
                searchValue,
                roleValue,
                genderFilterValue,
                genderNormalized: genderValue
            });

            rows.forEach((row, index) => {
                // Skip empty row
                if (row.querySelector('td[colspan]')) {
                    return;
                }

                const username = (row.getAttribute('data-username') || '').toLowerCase().trim();
                const id = (row.getAttribute('data-id') || '').toLowerCase().trim();
                const role = (row.getAttribute('data-role') || '').toLowerCase().trim();
                const genderRaw = (row.getAttribute('data-gender') || '').trim();
                const gender = normalizeGender(genderRaw);

                console.log(`Row ${index}:`, {
                    username,
                    id,
                    role,
                    genderRaw,
                    genderNormalized: gender
                });

                // Check if row matches all filters
                const matchSearch = !searchValue || username.includes(searchValue) || id.includes(searchValue);
                const matchRole = !roleValue || role === roleValue;
                const matchGender = !genderValue || gender === genderValue;

                console.log(`Row ${index} match:`, {
                    matchSearch,
                    matchRole,
                    matchGender
                });

                if (matchSearch && matchRole && matchGender) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update page info
            if (visibleCount === 0) {
                document.querySelector('.page-info').textContent = 'Tidak ada data';
            } else {
                document.querySelector('.page-info').textContent = `Menampilkan ${visibleCount} data`;
            }
        }

        function openModal() {
            document.getElementById('tambahUserModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('tambahUserModal').classList.remove('active');
            document.getElementById('formTambahUser').reset();
            document.getElementById('asal_tpi_field').style.display = 'none';
            document.getElementById('no_id_field').style.display = 'none';
        }

        function deactivateUser(userId, userName) {
            Swal.fire({
                title: 'Konfirmasi Nonaktifkan',
                text: `Apakah Anda yakin ingin menonaktifkan akun "${userName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#0a3b99',
                confirmButtonText: 'Ya, Nonaktifkan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang menonaktifkan akun',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`<?php echo e(route('admin.user.update-status')); ?>`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            body: JSON.stringify({
                                user_id: userId,
                                is_active: false
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Akun berhasil dinonaktifkan!',
                                    confirmButtonColor: '#0a3b99'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message || 'Gagal menonaktifkan akun!',
                                    confirmButtonColor: '#0a3b99'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Terjadi kesalahan: ' + error,
                                confirmButtonColor: '#0a3b99'
                            });
                        });
                }
            });
        }

        function activateUser(userId, userName) {
            Swal.fire({
                title: 'Konfirmasi Aktifkan',
                text: `Apakah Anda yakin ingin mengaktifkan kembali akun "${userName}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#0a3b99',
                confirmButtonText: 'Ya, Aktifkan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang mengaktifkan akun',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`<?php echo e(route('admin.user.update-status')); ?>`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            body: JSON.stringify({
                                user_id: userId,
                                is_active: true
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Akun berhasil diaktifkan!',
                                    confirmButtonColor: '#0a3b99'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message || 'Gagal mengaktifkan akun!',
                                    confirmButtonColor: '#0a3b99'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Terjadi kesalahan: ' + error,
                                confirmButtonColor: '#0a3b99'
                            });
                        });
                }
            });
        }

        function updateRoleFields() {
            const role = document.getElementById('roleSelect').value;
            const asal_tpi_field = document.getElementById('asal_tpi_field');
            const wilayah_input = document.getElementById('wilayah_input');
            const wilayah_required = document.getElementById('wilayah_required');
            const noIndukInput = document.getElementById('no_induk_input');
            const no_id_field = document.getElementById('no_id_field');

            // Show/hide NO. ID field container
            if (role) {
                no_id_field.style.display = 'grid';
            } else {
                no_id_field.style.display = 'none';
            }

            // Show asal TPI field for staff, juruRekap, and admin roles
            if (role === 'juruRekap' || role === 'staff' || role === 'admin') {
                asal_tpi_field.style.display = 'grid';
                wilayah_input.setAttribute('required', 'required');
                wilayah_required.style.display = 'inline';
            } else {
                asal_tpi_field.style.display = 'none';
                wilayah_input.removeAttribute('required');
                wilayah_required.style.display = 'none';
            }

            if (role) {
                // Fetch next ID
                noIndukInput.value = '';
                noIndukInput.placeholder = 'Memuat NO. ID...';
                fetch(`/admin/user/next-id?role=${role}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            noIndukInput.value = data.next_id;
                        } else {
                            noIndukInput.value = '';
                            noIndukInput.placeholder = 'Gagal memuat NO. ID';
                        }
                    })
                    .catch(err => {
                        console.error('Error fetching next ID:', err);
                        noIndukInput.value = '';
                        noIndukInput.placeholder = 'Gagal memuat NO. ID';
                    });
            } else {
                noIndukInput.value = '';
                noIndukInput.placeholder = 'Otomatis terisi';
            }
        }

        function toggleMenu(event, button) {
            event.stopPropagation();
            const dropdown = button.nextElementSibling;

            // Close all other dropdowns
            document.querySelectorAll('.action-dropdown').forEach(menu => {
                if (menu !== dropdown) {
                    menu.style.display = 'none';
                }
            });

            // Toggle current dropdown
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.action-dropdown').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
        });

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('tambahUserModal');
            const editModal = document.getElementById('editUserModal');
            const profileModal = document.getElementById('adminProfileModal');
            if (event.target == modal) {
                closeModal();
            }
            if (event.target == editModal) {
                closeEditModal();
            }
            if (event.target == profileModal) {
                closeAdminProfileModal();
            }
        }

        function openAdminProfileModal() {
            document.getElementById('adminProfileModal').classList.add('active');
        }

        function closeAdminProfileModal() {
            document.getElementById('adminProfileModal').classList.remove('active');
        }

        function toggleFieldVisibility(fieldId, element) {
            const input = document.getElementById(fieldId);
            const icon = element.querySelector('i');
            if (input && icon) {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                    element.style.color = '#0a3b99';
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                    element.style.color = '#94a3bb';
                }
            }
        }

        // Handle form submission with client-side validation
        document.getElementById('formTambahUser').addEventListener('submit', function(e) {
            e.preventDefault();

            const pwd = document.getElementById('password')?.value || '';
            const pwdConfirm = document.getElementById('password_confirmation')?.value || '';

            if (pwd !== pwdConfirm) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Cocok',
                    text: 'Password dan konfirmasi password tidak cocok.',
                    confirmButtonColor: '#0a3b99',
                    confirmButtonText: 'OK'
                }).then(() => {
                    document.getElementById('password_confirmation').focus();
                });
                return;
            }

            const submitBtn = document.getElementById('submitTambahUser');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Menyimpan...';

            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang menyimpan data user baru',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Tambah User';

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'User berhasil ditambahkan!',
                            confirmButtonColor: '#0a3b99',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            closeModal();
                            location.reload();
                        });
                    } else {
                        let errorMsg = data.message || 'Gagal menambahkan user';
                        let htmlContent = '';
                        if (data.errors) {
                            htmlContent = '<div style="text-align: left; margin-top: 10px; padding: 10px; background: #fee2e2; border-radius: 8px; border: 1px solid #fca5a5;">';
                            for (let field in data.errors) {
                                if (Array.isArray(data.errors[field])) {
                                    htmlContent += '<div style="margin-bottom: 5px; color: #991b1b; font-size: 13px; font-weight: 500;">• ' + data.errors[field].join(', ') + '</div>';
                                }
                            }
                            htmlContent += '</div>';
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menambah User',
                            text: data.errors ? undefined : errorMsg,
                            html: data.errors ? `<div style="font-weight: 600; margin-bottom: 10px;">${errorMsg}</div>${htmlContent}` : undefined,
                            confirmButtonColor: '#0a3b99',
                            confirmButtonText: 'OK'
                        });
                        console.error('Validation Errors:', data.errors);
                    }
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Tambah User';
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat menyimpan data: ' + error,
                        confirmButtonColor: '#0a3b99',
                        confirmButtonText: 'OK'
                    });
                });
        });

        function openEditModal(button) {
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const noInduk = button.getAttribute('data-no-induk');
            const username = button.getAttribute('data-username');
            const role = button.getAttribute('data-role');
            const jenisKelamin = button.getAttribute('data-jenis-kelamin');
            const noTelepon = button.getAttribute('data-no-telepon');
            const alamat = button.getAttribute('data-alamat');
            const wilayah = button.getAttribute('data-wilayah');

            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_no_induk_input').value = noInduk;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_roleSelect').value = role;
            document.getElementById('edit_jenis_kelamin').value = jenisKelamin;
            document.getElementById('edit_no_telepon').value = noTelepon;
            document.getElementById('edit_alamat').value = alamat;
            document.getElementById('edit_wilayah_input').value = wilayah || '';

            // Dynamic visibility check for Edit Modal
            updateEditRoleFields();

            document.getElementById('editUserModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editUserModal').classList.remove('active');
            document.getElementById('formEditUser').reset();
            document.getElementById('edit_asal_tpi_field').style.display = 'none';
            document.getElementById('edit_no_id_field').style.display = 'none';
        }

        function updateEditRoleFields() {
            const role = document.getElementById('edit_roleSelect').value;
            const asal_tpi_field = document.getElementById('edit_asal_tpi_field');
            const wilayah_input = document.getElementById('edit_wilayah_input');
            const wilayah_required = document.getElementById('edit_wilayah_required');
            const no_id_field = document.getElementById('edit_no_id_field');

            // Show/hide NO. ID field container
            if (role) {
                no_id_field.style.display = 'grid';
            } else {
                no_id_field.style.display = 'none';
            }

            // Show asal TPI field for staff, juruRekap, and admin roles
            if (role === 'juruRekap' || role === 'staff' || role === 'admin') {
                asal_tpi_field.style.display = 'grid';
                wilayah_input.setAttribute('required', 'required');
                wilayah_required.style.display = 'inline';
            } else {
                asal_tpi_field.style.display = 'none';
                wilayah_input.removeAttribute('required');
                wilayah_required.style.display = 'none';
            }
        }

        document.getElementById('formEditUser').addEventListener('submit', function(e) {
            e.preventDefault();

            const pwd = document.getElementById('edit_password')?.value || '';
            const pwdConfirm = document.getElementById('edit_password_confirmation')?.value || '';

            if (pwd && pwd !== pwdConfirm) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Cocok',
                    text: 'Password dan konfirmasi password tidak cocok.',
                    confirmButtonColor: '#0a3b99',
                    confirmButtonText: 'OK'
                }).then(() => {
                    document.getElementById('edit_password_confirmation').focus();
                });
                return;
            }

            const submitBtn = document.getElementById('submitEditUser');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Menyimpan...';

            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang menyimpan perubahan data user',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Simpan Perubahan';

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data user berhasil diperbarui!',
                            confirmButtonColor: '#0a3b99',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            closeEditModal();
                            location.reload();
                        });
                    } else {
                        let errorMsg = data.message || 'Gagal memperbarui data user';
                        let htmlContent = '';
                        if (data.errors) {
                            htmlContent = '<div style="text-align: left; margin-top: 10px; padding: 10px; background: #fee2e2; border-radius: 8px; border: 1px solid #fca5a5;">';
                            for (let field in data.errors) {
                                if (Array.isArray(data.errors[field])) {
                                    htmlContent += '<div style="margin-bottom: 5px; color: #991b1b; font-size: 13px; font-weight: 500;">• ' + data.errors[field].join(', ') + '</div>';
                                }
                            }
                            htmlContent += '</div>';
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Memperbarui User',
                            text: data.errors ? undefined : errorMsg,
                            html: data.errors ? `<div style="font-weight: 600; margin-bottom: 10px;">${errorMsg}</div>${htmlContent}` : undefined,
                            confirmButtonColor: '#0a3b99',
                            confirmButtonText: 'OK'
                        });
                        console.error('Validation Errors:', data.errors);
                    }
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Simpan Perubahan';
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat menyimpan data: ' + error,
                        confirmButtonColor: '#0a3b99',
                        confirmButtonText: 'OK'
                    });
                });
        });
    </script>

    <?php if(session('welcome')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Masuk',
                    text: "Selamat datang Admin Dinas",
                    confirmButtonColor: '#0a3b99',
                    confirmButtonText: 'Lanjutkan'
                });
            });
        </script>
    <?php endif; ?>
    <!-- Modal Profil Admin -->
    <div id="adminProfileModal" class="modal">
        <div class="modal-content" style="max-width: 450px; padding: 30px; position: relative;">
            <div class="profile-modal-header-bg">
                <button class="modal-close" onclick="closeAdminProfileModal()" style="position: absolute; right: 15px; top: 15px; color: white;">&times;</button>
            </div>
            
            <div class="profile-modal-avatar-container">
                <div class="profile-modal-avatar" style="font-size: 32px; font-weight: 800; letter-spacing: 0.5px;">
                    <?php echo e(strtoupper(substr(Auth::user()->nama ?? Auth::user()->username ?? 'ADM', 0, 3))); ?>

                </div>
                <h3 class="profile-modal-name"><?php echo e(Auth::user()->nama ?? Auth::user()->username); ?></h3>
                <span class="profile-modal-badge"><?php echo e(Auth::user()->role ?? 'Admin'); ?></span>
            </div>

            <div class="profile-details-grid">
                <div class="profile-detail-card">
                    <div class="profile-detail-label">No. Induk / ID</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-id-badge"></i> <?php echo e(Auth::user()->no_induk ?? '-'); ?>

                    </div>
                </div>
                
                <div class="profile-detail-card">
                    <div class="profile-detail-label">Username</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-user"></i> <?php echo e(Auth::user()->username ?? '-'); ?>

                    </div>
                </div>

                <div class="profile-detail-card">
                    <div class="profile-detail-label">Jenis Kelamin</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-venus-mars"></i> <?php echo e(Auth::user()->jenis_kelamin ?? '-'); ?>

                    </div>
                </div>

                <div class="profile-detail-card">
                    <div class="profile-detail-label">No. Telepon</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-phone"></i> <?php echo e(Auth::user()->no_telepon ?? '-'); ?>

                    </div>
                </div>

                <div class="profile-detail-card full-width">
                    <div class="profile-detail-label">Wilayah Tugas</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-map-marker-alt"></i> <?php echo e(Auth::user()->wilayah ?? 'Dinas Pusat (Subang)'); ?>

                    </div>
                </div>

                <div class="profile-detail-card full-width">
                    <div class="profile-detail-label">Alamat</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-home"></i> <?php echo e(Auth::user()->alamat ?? '-'); ?>

                    </div>
                </div>
            </div>

            <div class="modal-footer" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
                <button type="button" class="btn-cancel" onclick="closeAdminProfileModal()" style="width: 100%; text-align: center;">Tutup</button>
            </div>
        </div>
    </div>
    <!-- Dark Mode Initializer and Toggle Script -->
    <script>
        function toggleDarkMode() {
            const body = document.body;
            const toggleBtn = document.getElementById('darkModeToggle');
            const darkIcon = toggleBtn.querySelector('.dark-icon');
            const lightIcon = toggleBtn.querySelector('.light-icon');

            if (body.classList.contains('dark-mode')) {
                body.classList.remove('dark-mode');
                darkIcon.style.display = 'block';
                lightIcon.style.display = 'none';
                localStorage.setItem('adminDarkMode', 'disabled');
            } else {
                body.classList.add('dark-mode');
                darkIcon.style.display = 'none';
                lightIcon.style.display = 'block';
                localStorage.setItem('adminDarkMode', 'enabled');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const darkModeSetting = localStorage.getItem('adminDarkMode');
            const body = document.body;
            const toggleBtn = document.getElementById('darkModeToggle');
            
            if (toggleBtn) {
                const darkIcon = toggleBtn.querySelector('.dark-icon');
                const lightIcon = toggleBtn.querySelector('.light-icon');

                if (darkModeSetting === 'enabled') {
                    body.classList.add('dark-mode');
                    darkIcon.style.display = 'none';
                    lightIcon.style.display = 'block';
                } else {
                    body.classList.remove('dark-mode');
                    darkIcon.style.display = 'block';
                    lightIcon.style.display = 'none';
                }
            }
        });
    </script>
</body>

</html>
<?php /**PATH C:\laragon\www\SipetangApp\web-laravel\resources\views/Admin/manajemen-user.blade.php ENDPATH**/ ?>