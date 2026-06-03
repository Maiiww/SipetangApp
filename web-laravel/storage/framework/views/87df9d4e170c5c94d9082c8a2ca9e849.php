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
                    <a href="<?php echo e(route('staff.profile')); ?>" style="text-decoration: none; color: inherit;">
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
                    <div class="stat-value"><?php echo e($stats['pending']); ?></div>
                </div>
                <div class="stat-icon-box stat-icon-pending">
                    <img src="<?php echo e(asset('images/file.png')); ?>" alt="Menunggu"
                        style="width: 50px; height: 50px; object-fit: contain;">
                </div>
            </div>

            <div class="stat-card">
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
                    <div class="stat-label"><i class="fas fa-weight"></i> Total Volume (Ton)</div>
                    <div class="stat-value"><?php echo e(number_format($stats['totalVolume'], 1)); ?></div>
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
                        value="<?php echo e($search); ?>"
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

                <!-- TPI Filter -->
                <div style="min-width: 200px;">
                    <select name="tpi" id="tpiFilter"
                        style="width: 100%; padding: 10px 15px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 13px; background-color: white; max-height: 200px; overflow-y: auto;">
                        <option value="">Pilih Asal TPI</option>
                        <option value="mayangan">Patimban</option>
                        <option value="blanakan">Genteng</option>
                        <option value="pondok-bali">Mayangan</option>
                        <option value="patimban">Cirewang</option>
                        <option value="pelabuhan-ratu">Muara Ciasem</option>
                        <option value="muara-cimanuk">Blanakan</option>
                        <option value="eretan-wetan">Rawameneng</option>
                        <option value="panjunan">Cilamaya Girang</option>
                    </select>
                </div>

                <!-- Date Filter -->
                <div style="min-width: 180px;">
                    <input type="date" name="date" id="dateFilter"
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
            <div class="table-title">
                Antrean Laporan
            </div>

            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
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
                            <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                                <i class="fas fa-inbox"
                                    style="font-size: 32px; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                                Tidak ada data untuk ditampilkan
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php echo e($laporans->links('pagination.custom')); ?>

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

            // Notification dropdown toggle and behavior
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

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const dd = document.getElementById('notificationDropdown');
                const btn = document.getElementById('notificationToggle');
                if (!dd || !btn) return;
                if (!dd.contains(e.target) && !btn.contains(e.target)) {
                    closeNotificationDropdown();
                }
            });

            // Show pending reports on the same page by setting filter and submitting
            function showPending() {
                const statusInput = document.getElementById('statusInput');
                if (!statusInput) return;
                statusInput.value = 'pending';
                document.getElementById('filterForm').submit();
            }
        </script>

        <div class="page-footer">
            SISTEM INFORMASI PENCATATAN HASIL TANGKAP
        </div>
    </div>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\SipetangApp\web-laravel\resources\views/Staff/validasi-laporan.blade.php ENDPATH**/ ?>