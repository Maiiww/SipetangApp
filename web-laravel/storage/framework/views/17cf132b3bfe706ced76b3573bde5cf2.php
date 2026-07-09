<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Tangkapan - SIPETANG</title>
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
            background: #f5f7fb;
            display: flex;
            min-height: 100vh;
            color: #334155;
        }

        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 35px;
            max-width: calc(100% - 260px);
        }

        /* Stats Cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px; padding: 28px 24px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04); border: 1px solid rgba(255, 255, 255, 0.8); display: flex; align-items: center; justify-content: space-between; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0) 100%); z-index: 0; pointer-events: none; }
        .stat-card > * { position: relative; z-index: 1; }

        .stat-details h3 {
            font-size: 12px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .stat-details .value {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
        }

        .stat-details .unit {
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
            margin-left: 4px;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .icon-blue {
            background: #eff6ff;
            color: #0a3b99;
        }

        .icon-orange {
            background: #fff7ed;
            color: #f16301;
        }

        /* Filter Panel */
        .filter-panel { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border-radius: 20px; padding: 25px 30px; margin-bottom: 30px; border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 10px 35px rgba(0, 0, 0, 0.03); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; transition: box-shadow 0.3s ease; }
        .filter-panel:hover { box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05); }

        .filter-form {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-group label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
        }

        .filter-input {
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 13.5px;
            color: #334155;
            background: #f8fafc;
            min-width: 180px;
            font-family: inherit;
        }

        .filter-input:focus {
            outline: none;
            border-color: #0a3b99;
            background: white;
        }

        .btn {
            padding: 11px 20px;
            border: none;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(10, 59, 153, 0.15);
        }

        .btn-primary:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 20px rgba(10, 59, 153, 0.3); }

        .btn-orange {
            background: #f16301;
            color: white;
            box-shadow: 0 4px 12px rgba(241, 99, 1, 0.15);
        }

        .btn-orange:hover { background: #d95401; transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 20px rgba(241, 99, 1, 0.3); }

        .btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        /* Table container */
        .table-panel { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border-radius: 24px; padding: 30px; border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 12px 35px rgba(0, 0, 0, 0.04); }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-header h2 {
            font-size: 17px;
            color: #0f172a;
            font-weight: 700;
        }

        .reports-table {
            width: 100%;
            border-collapse: collapse;
        }

        .reports-table th {
            text-align: left;
            padding: 14px 12px;
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            border-bottom: 1.5px solid #e2e8f0;
            background: #f8fafc;
        }

        .reports-table td {
            padding: 16px 12px;
            font-size: 13.5px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .reports-table tbody tr:hover {
            background: #f8fafc;
        }

        /* Status Badges */
        .badge {
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
        }

        .badge-draft {
            background: #ffedd5;
            color: #d97706;
        }

        .badge-pending {
            background: #dbeafe;
            color: #2563eb;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content { background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(15px); border-radius: 24px; width: 100%; max-width: 550px; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15); animation: modalFadeIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); overflow: hidden; border: 1px solid rgba(255,255,255,0.5); }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            background: linear-gradient(135deg, #0a3b99 0%, #1a4d7d 100%);
            color: white;
            padding: 20px 25px;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            opacity: 0.8;
        }

        .modal-header .close-btn:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 14px;
            color: #334155;
            background: #f8fafc;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #0a3b99;
            background: white;
            box-shadow: 0 0 0 3px rgba(10, 59, 153, 0.1);
        }

        .modal-footer {
            padding: 15px 25px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            line-height: 1.5;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #f0fdf4;
            color: #155724;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #721c24;
            border: 1px solid #fca5a5;
        }

        /* =========================================
           PREMIUM SWEETALERT CUSTOM STYLING
           ========================================= */
        .premium-swal-popup {
            border-radius: 24px !important;
            padding: 30px !important;
            box-shadow: 0 20px 50px rgba(10, 59, 153, 0.12) !important;
            border: 1px solid rgba(10, 59, 153, 0.08) !important;
            background: #ffffff !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        .swal2-custom-title {
            font-size: 22px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            margin-top: 20px !important;
            margin-bottom: 8px !important;
            letter-spacing: -0.5px !important;
        }

        .swal2-custom-text {
            font-size: 14.5px !important;
            color: #64748b !important;
            line-height: 1.6 !important;
            margin-bottom: 24px !important;
        }

        /* Success SVG Checkmark Animation */
        .swal-animation-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 15px 0 10px 0;
        }

        .swal-checkmark-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(10, 59, 153, 0.08);
            position: relative;
        }

        .swal-checkmark {
            width: 50px;
            height: 50px;
            stroke-width: 4;
            stroke: #0a3b99;
            stroke-miterlimit: 10;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .swal-checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 4;
            stroke: #0a3b99;
            fill: none;
            animation: swal-stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .swal-checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: swal-stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.5s forwards;
        }

        /* Error SVG Crossmark Animation */
        .swal-crossmark-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #fef2f2;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.08);
            position: relative;
        }

        .swal-crossmark {
            width: 44px;
            height: 44px;
            stroke-width: 4;
            stroke: #dc3545;
            stroke-miterlimit: 10;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .swal-crossmark__check {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: swal-stroke 0.4s cubic-bezier(0.65, 0, 0.45, 1) 0.3s forwards;
        }

        /* Warning SVG Animation */
        .swal-warningmark-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #fff7ed;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(241, 99, 1, 0.08);
            position: relative;
        }

        .swal-warningmark {
            width: 44px;
            height: 44px;
            stroke-width: 4;
            stroke: #f16301;
            stroke-miterlimit: 10;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .swal-warningmark__check {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: swal-stroke 0.4s cubic-bezier(0.65, 0, 0.45, 1) 0.3s forwards;
        }

        /* Confirmation / Question SVG Animation */
        .swal-questionmark-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.08);
            position: relative;
        }

        .swal-questionmark {
            width: 44px;
            height: 44px;
            stroke-width: 4;
            stroke: #2563eb;
            stroke-miterlimit: 10;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .swal-questionmark__check {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: swal-stroke 0.4s cubic-bezier(0.65, 0, 0.45, 1) 0.3s forwards;
        }

        @keyframes swal-stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }

        /* Premium Buttons */
        .premium-swal-btn {
            background: linear-gradient(135deg, #0a3b99 0%, #1d65d0 100%) !important;
            color: white !important;
            border: none !important;
            padding: 12px 35px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            cursor: pointer !important;
            box-shadow: 0 4px 15px rgba(10, 59, 153, 0.2) !important;
            transition: all 0.3s ease !important;
            outline: none !important;
            min-width: 120px;
            margin: 0 5px !important;
        }

        .premium-swal-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(10, 59, 153, 0.3) !important;
        }

        .premium-swal-btn:active {
            transform: translateY(0) !important;
        }

        .premium-swal-btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e4606d 100%) !important;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2) !important;
        }

        .premium-swal-btn-danger:hover {
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3) !important;
        }

        .premium-swal-btn-warning {
            background: linear-gradient(135deg, #f16301 0%, #ff8838 100%) !important;
            box-shadow: 0 4px 15px rgba(241, 99, 1, 0.2) !important;
        }

        .premium-swal-btn-warning:hover {
            box-shadow: 0 6px 20px rgba(241, 99, 1, 0.3) !important;
        }

        .premium-swal-btn-secondary {
            background: #e2e8f0 !important;
            color: #475569 !important;
            box-shadow: none !important;
        }

        .premium-swal-btn-secondary:hover {
            background: #cbd5e1 !important;
            box-shadow: none !important;
            transform: translateY(-2px) !important;
        }
    </style>
</head>

<body>
    <?php echo $__env->make('components.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="main-content">
        <div style="margin-bottom: 30px;">
            <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Kelola Data Hasil Tangkap</h1>
            <p style="font-size: 14.5px; color: #64748b;">Catat data operasional harian perikanan dan kirimkan ke staf dinas untuk divalidasi.</p>
        </div>



        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-details">
                    <h3>Total Berat Hari Ini</h3>
                    <div class="value"><?php echo e(number_format($totalBerat, 1)); ?><span class="unit">KG</span></div>
                </div>
                <div class="stat-icon icon-blue">
                    <i class="fas fa-weight"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-details">
                    <h3>Produksi Hari Ini</h3>
                    <div class="value"><?php echo e($totalProduksi); ?><span class="unit">Laporan</span></div>
                </div>
                <div class="stat-icon icon-orange">
                    <i class="fas fa-calculator"></i>
                </div>
            </div>
        </div>

        <div class="filter-panel">
            <form action="<?php echo e(route('jururekap.kelola')); ?>" method="GET" class="filter-form" id="filterForm">
                <div class="input-group">
                    <label>Pilih Tanggal</label>
                    <input type="date" name="tanggal" value="<?php echo e($tanggal); ?>" class="filter-input" onchange="this.form.submit()">
                </div>

                <div class="input-group">
                    <label>Jenis Ikan</label>
                    <select name="jenis_ikan" class="filter-input" onchange="this.form.submit()">
                        <option value="">Semua Ikan</option>
                        <?php $__currentLoopData = $ikanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ikanName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($ikanName); ?>" <?php echo e($jenisIkan === $ikanName ? 'selected' : ''); ?>><?php echo e($ikanName); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </form>

            <button class="btn btn-primary" onclick="openInputModal()">
                <i class="fas fa-plus"></i> Input Hasil Tangkap
            </button>
        </div>

        <div class="table-panel">
            <div class="table-header">
                <h2>Daftar Catatan Tangkapan Tanggal <?php echo e(\Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y')); ?></h2>
                
                <form id="kirimStafForm" action="<?php echo e(route('jururekap.kirim')); ?>" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="tanggal" value="<?php echo e($tanggal); ?>">
                    <button type="button" onclick="confirmKirimStaf(event)" class="btn btn-orange" <?php echo e(!$hasDrafts ? 'disabled style=opacity:0.6;cursor:not-allowed;box-shadow:none;' : ''); ?> title="<?php echo e(!$hasDrafts ? 'Tidak ada data draft untuk dikirim pada tanggal ini' : 'Kirim semua data draft hari ini ke staf dinas'); ?>">
                        <i class="fas fa-paper-plane"></i> Kirim ke Staf Dinas
                    </button>
                </form>
            </div>

            <?php if($catches->count() > 0): ?>
                <div style="overflow-x: auto;">
                    <table class="reports-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nelayan</th>
                                <th>Pembeli</th>
                                <th>Jenis Ikan</th>
                                <th>Berat (Kg)</th>
                                <th>Total (Rp)</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $catches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $catch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $statusClass = 'badge-draft';
                                    $statusLabel = 'Draft';
                                    if ($catch->status === 'Menunggu Validasi') {
                                        $statusClass = 'badge-pending';
                                        $statusLabel = 'Menunggu';
                                    } elseif ($catch->status === 'Divalidasi') {
                                        $statusClass = 'badge-success';
                                        $statusLabel = 'Divalidasi';
                                    } elseif ($catch->status === 'Ditolak') {
                                        $statusClass = 'badge-danger';
                                        $statusLabel = 'Ditolak';
                                    }
                                ?>
                                <tr>
                                    <td><?php echo e($catches->firstItem() + $index); ?></td>
                                    <td><strong><?php echo e($catch->nama_nelayan); ?></strong></td>
                                    <td><?php echo e($catch->nama_pembeli); ?></td>
                                    <td><?php echo e($catch->jenis_ikan); ?></td>
                                    <td><?php echo e(number_format($catch->berat, 2)); ?> kg</td>
                                    <td>Rp <?php echo e(number_format($catch->harga_jual, 0, ',', '.')); ?></td>
                                    <td><span class="badge <?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span></td>
                                    <td>
                                        <?php if($catch->status === 'Ditolak'): ?>
                                            <span style="color: #991b1b; font-size: 12px; font-weight: 600;">
                                                <i class="fas fa-exclamation-triangle"></i> <?php echo e($catch->catatan ?? 'Perlu direvisi'); ?>

                                            </span>
                                        <?php elseif($catch->status === 'Draft'): ?>
                                            <small style="color: #64748b; font-weight: 600;">Belum dikirim ke staff</small>
                                        <?php else: ?>
                                            <span style="color: #64748b;">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <div style="margin-top: 25px;">
                    <?php echo e($catches->links('pagination.custom')); ?>

                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 60px 0; color: #94a3b8;">
                    <i class="fas fa-inbox" style="font-size: 50px; margin-bottom: 15px; opacity: 0.5;"></i>
                    <p style="font-size: 15px; font-weight: 600;">Tidak ada catatan data hasil tangkap pada tanggal ini</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Modal Form Input Catch Data -->
    <div id="inputModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                Input Hasil Tangkapan Baru
                <button class="close-btn" onclick="closeInputModal()">&times;</button>
            </div>
            <form action="<?php echo e(route('jururekap.input.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_nelayan">Nama Nelayan</label>
                        <input type="text" name="nama_nelayan" id="nama_nelayan" class="form-control" placeholder="Masukkan nama nelayan" required>
                    </div>

                    <div class="form-group">
                        <label for="nama_pembeli">Nama Pembeli</label>
                        <input type="text" name="nama_pembeli" id="nama_pembeli" class="form-control" placeholder="Masukkan nama pembeli" required>
                    </div>

                    <div class="form-group">
                        <label for="jenis_ikan">Jenis Ikan</label>
                        <select name="jenis_ikan" id="jenis_ikan" class="form-control" required>
                            <option value="">Pilih jenis ikan</option>
                            <?php $__currentLoopData = $ikanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ikanName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ikanName); ?>"><?php echo e($ikanName); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="berat">Jumlah Berat (KG)</label>
                        <input type="number" name="berat" id="berat" step="0.01" min="0.01" class="form-control" placeholder="0" required>
                    </div>

                    <div class="form-group">
                        <label for="harga_jual">Harga Jual Total (Rp)</label>
                        <input type="number" name="harga_jual" id="harga_jual" min="0" class="form-control" placeholder="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeInputModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openInputModal() {
            document.getElementById('inputModal').style.display = 'flex';
        }

        // Intercept form submit and add confirmation alert when sending to staff
        function confirmKirimStaf(event) {
            event.preventDefault();
            Swal.fire({
                html: `
                    <div class="swal-animation-container">
                        <div class="swal-questionmark-circle">
                            <svg class="swal-questionmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="swal-checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                <path class="swal-questionmark__check" fill="none" d="M26 12 Q26 22 26 26 T26 32 M26 38h.01"/>
                            </svg>
                        </div>
                    </div>
                    <div class="swal2-custom-title">Kirim ke Staf Dinas</div>
                    <div class="swal2-custom-text">Apakah Anda yakin ingin mengirim semua data draft tanggal ini ke Staf Dinas? Data draft akan dikunci untuk divalidasi.</div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'premium-swal-popup',
                    confirmButton: 'premium-swal-btn premium-swal-btn-warning',
                    cancelButton: 'premium-swal-btn premium-swal-btn-secondary'
                },
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('kirimStafForm').submit();
                }
            });
        }

        function closeInputModal() {
            document.getElementById('inputModal').style.display = 'none';
        }

        // Close modal when clicking outside content area
        window.onclick = function(event) {
            const modal = document.getElementById('inputModal');
            if (event.target === modal) {
                closeInputModal();
            }
        }

        // Show Premium SweetAlert popups on redirect notifications
        <?php if(session('success')): ?>
            Swal.fire({
                html: `
                    <div class="swal-animation-container">
                        <div class="swal-checkmark-circle">
                            <svg class="swal-checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="swal-checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                <path class="swal-checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>
                    </div>
                    <div class="swal2-custom-title">Berhasil!</div>
                    <div class="swal2-custom-text"><?php echo e(session('success')); ?></div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Selesai',
                buttonsStyling: false,
                customClass: {
                    popup: 'premium-swal-popup',
                    confirmButton: 'premium-swal-btn'
                }
            });
        <?php endif; ?>

        <?php if(session('error')): ?>
            Swal.fire({
                html: `
                    <div class="swal-animation-container">
                        <div class="swal-crossmark-circle">
                            <svg class="swal-crossmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="swal-checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                <path class="swal-crossmark__check" fill="none" d="M16 16 36 36 M36 16 16 36"/>
                            </svg>
                        </div>
                    </div>
                    <div class="swal2-custom-title">Gagal!</div>
                    <div class="swal2-custom-text"><?php echo e(session('error')); ?></div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Tutup',
                buttonsStyling: false,
                customClass: {
                    popup: 'premium-swal-popup',
                    confirmButton: 'premium-swal-btn premium-swal-btn-danger'
                }
            });
        <?php endif; ?>

        <?php if(isset($errors) && $errors->any()): ?>
            Swal.fire({
                html: `
                    <div class="swal-animation-container">
                        <div class="swal-warningmark-circle">
                            <svg class="swal-warningmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="swal-checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                <path class="swal-warningmark__check" fill="none" d="M26 12v20 M26 38h.01"/>
                            </svg>
                        </div>
                    </div>
                    <div class="swal2-custom-title">Terjadi Kesalahan!</div>
                    <div class="swal2-custom-text"><?php echo implode("<br>", $errors->all()); ?></div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Perbaiki',
                buttonsStyling: false,
                customClass: {
                    popup: 'premium-swal-popup',
                    confirmButton: 'premium-swal-btn premium-swal-btn-warning'
                }
            });
        <?php endif; ?>
    </script>
</body>

</html>
<?php /**PATH C:\laragon\www\SipetangApp\web-laravel\resources\views/JuruRekap/kelola.blade.php ENDPATH**/ ?>