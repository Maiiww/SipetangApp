<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Manajemen User - SIPETANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Menggunakan CSS yang Anda berikan sebelumnya */
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
            width: 200px;
            /* Warna sudah disamakan dengan Dashboard Admin & Staff */
            background: linear-gradient(180deg, #0a3b99 0%, #1d65d0 100%);
            color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
            font-weight: 700;
        }

        .sidebar-logo-box {
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0d2640;
        }

        .sidebar-logo-text h3 {
            font-size: 14px;
            margin: 0;
        }

        .sidebar-logo-text p {
            font-size: 9px;
            opacity: 0.7;
            margin: 0;
        }

        .sidebar-menu {
            flex: 1;
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 20px;
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px;
            border-radius: 6px;
            transition: background 0.2s ease, transform 0.1s ease;
            font-size: 14px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu a:active {
            background: rgba(255, 255, 255, 0.16);
            transform: scale(0.98);
        }

        .sidebar-logout {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-logout a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 200px;
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
            margin-bottom: 25px;
        }

        .content-header h2 {
            font-size: 24px;
            color: #0d2640;
        }

        .content-header p {
            color: #666;
            font-size: 14px;
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
            padding: 20px;
            border-radius: 12px;
            min-width: 150px;
        }

        .total-card small {
            font-size: 10px;
            opacity: 0.7;
            text-transform: uppercase;
        }

        .total-card h2 {
            font-size: 32px;
        }

        .filter-form {
            background: white;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            gap: 15px;
            flex: 1;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            color: #888;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .form-group select,
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #eee;
            border-radius: 6px;
            background: #fcfcfc;
            font-size: 13px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-dark {
            background: #0d2640;
            color: white;
        }

        /* Table User */
        .table-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px;
            font-size: 12px;
            color: #888;
            border-bottom: 1px solid #eee;
            text-transform: uppercase;
        }

        th:last-child {
            text-align: center;
        }

        td {
            padding: 15px 12px;
            font-size: 13px;
            border-bottom: 1px solid #eee;
        }

        td:last-child {
            text-align: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 35px;
            height: 35px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 12px;
        }

        .tpi-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-aktif {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .status-nonaktif {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Action Buttons */
        .btn-aksi {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
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
            padding: 6px 10px;
            border: none;
            background: none;
            color: #666;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.2s ease;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .btn-aksi-menu:hover {
            background: #f0f0f0;
            color: #0d2640;
        }

        .action-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 200;
            min-width: 160px;
            overflow: hidden;
            margin-top: 5px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 15px;
            border: none;
            background: none;
            color: #333;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            text-align: left;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f5f5f5;
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
            margin-top: 20px;
        }

        .page-info {
            font-size: 12px;
            color: #888;
        }

        .page-nav {
            display: flex;
            gap: 5px;
        }

        .page-link {
            padding: 5px 10px;
            border: 1px solid #eee;
            border-radius: 4px;
            text-decoration: none;
            color: #334155;
            font-size: 12px;
        }

        .page-link.active {
            background: #0d2640;
            color: white;
            border-color: #0d2640;
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

        /* Modal Styles */
        .modal {
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

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            max-height: 90vh;
            overflow-y: auto;
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
            font-size: 12px;
            color: #0d2640;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .form-group-modal input,
        .form-group-modal select,
        .form-group-modal textarea {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 13px;
            font-family: inherit;
            background: #fcfcfc;
            transition: border-color 0.2s ease;
        }

        .form-group-modal input:focus,
        .form-group-modal select:focus,
        .form-group-modal textarea:focus {
            outline: none;
            border-color: #2563eb;
            background: white;
        }

        .form-group-modal textarea {
            resize: vertical;
            min-height: 80px;
        }

        .modal-footer {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .btn-cancel {
            padding: 10px 20px;
            border: 1px solid #ddd;
            background: white;
            color: #666;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-cancel:hover {
            background: #f5f5f5;
            border-color: #bbb;
        }

        .btn-submit {
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .btn-submit:hover {
            background: #1d4ed8;
        }

        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <?php echo $__env->make('components.sidebar-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content">
        <div class="header">
            <div style="flex: 1;"></div>
            <div class="header-right">
                <i class="fas fa-bell" style="color: #64748b;"></i>
                <i class="fas fa-cog" style="color: #64748b;"></i>
                <div class="user-profile">
                    <div>
                        <p style="font-size: 14px; font-weight: bold;">Admin</p>
                        <small style="color: #888;">DINAS PERIKANAN</small>
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
                        <th>Asal TPI</th>
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
                <div class="form-row">
                    <div class="form-group-modal">
                        <label>NAMA PETUGAS *</label>
                        <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group-modal">
                        <label>NO. ID *</label>
                        <input type="text" name="no_induk" placeholder="Contoh: JR-001" required>
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
                        <input type="password" id="password" name="password" placeholder="Masukkan password"
                            required>
                    </div>
                    <div class="form-group-modal">
                        <label>KONFIRMASI PASSWORD *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Konfirmasi password" required>
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

                <div class="form-row full" id="asal_tpi_field" style="display: none;">
                    <div class="form-group-modal">
                        <label>ASAL TPI (WILAYAH) <span id="wilayah_required" style="display: none;">*</span></label>
                        <input type="text" name="wilayah" id="wilayah_input" placeholder="Contoh: TPI Blanakan">
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
        }

        function deactivateUser(userId, userName) {
            if (confirm(`Nonaktifkan akun "${userName}"?`)) {
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
                            alert('Akun berhasil dinonaktifkan!');
                            location.reload();
                        } else {
                            alert(data.message || 'Gagal menonaktifkan akun!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan: ' + error);
                    });
            }
        }

        function activateUser(userId, userName) {
            if (confirm(`Aktifkan akun "${userName}"?`)) {
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
                            alert('Akun berhasil diaktifkan!');
                            location.reload();
                        } else {
                            alert(data.message || 'Gagal mengaktifkan akun!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan: ' + error);
                    });
            }
        }

        function updateRoleFields() {
            const role = document.getElementById('roleSelect').value;
            const asal_tpi_field = document.getElementById('asal_tpi_field');
            const wilayah_input = document.getElementById('wilayah_input');
            const wilayah_required = document.getElementById('wilayah_required');

            // Show asal TPI field only for juruRekap role
            if (role === 'juruRekap') {
                asal_tpi_field.style.display = 'grid';
                wilayah_input.setAttribute('required', 'required');
                wilayah_required.style.display = 'inline';
            } else {
                asal_tpi_field.style.display = 'none';
                wilayah_input.removeAttribute('required');
                wilayah_required.style.display = 'none';
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
            if (event.target == modal) {
                closeModal();
            }
        }

        // Handle form submission with client-side validation
        document.getElementById('formTambahUser').addEventListener('submit', function(e) {
            e.preventDefault();

            const pwd = document.getElementById('password')?.value || '';
            const pwdConfirm = document.getElementById('password_confirmation')?.value || '';

            if (pwd !== pwdConfirm) {
                alert('Password dan konfirmasi password tidak cocok.');
                document.getElementById('password_confirmation').focus();
                return;
            }

            const submitBtn = document.getElementById('submitTambahUser');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Menyimpan...';

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
                        alert('User berhasil ditambahkan!');
                        closeModal();
                        location.reload();
                    } else {
                        let errorMsg = data.message || 'Gagal menambahkan user';
                        if (data.errors) {
                            errorMsg += '\n\nDetail Error:\n';
                            for (let field in data.errors) {
                                if (Array.isArray(data.errors[field])) {
                                    errorMsg += '• ' + field + ': ' + data.errors[field].join(', ') + '\n';
                                }
                            }
                        }
                        alert(errorMsg);
                        console.error('Validation Errors:', data.errors);
                    }
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Tambah User';
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error);
                });
        });
    </script>
</body>

</html>
<?php /**PATH C:\laragon\www\SipetangApp\web-laravel\resources\views/Admin/manajemen-user.blade.php ENDPATH**/ ?>