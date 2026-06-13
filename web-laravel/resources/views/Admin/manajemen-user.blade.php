<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen User - SIPETANG</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            /* Warna sudah disamakan dengan Dashboard Admin & Staff */
            background: linear-gradient(180deg, #0a3b99 0%, #1d65d0 100%);
            color: white;
            padding: 40px 25px;
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
            justify-content: center;
            gap: 15px;
            margin-bottom: 50px;
            font-weight: 700;
            flex-direction: column;
            text-align: center;
        }

        .sidebar-logo-box {
            background: white;
            width: 70px;
            height: 70px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0d2640;
            font-size: 40px;
        }

        .sidebar-logo-text h3 {
            font-size: 18px;
            margin: 0;
            letter-spacing: 1px;
        }

        .sidebar-logo-text p {
            font-size: 11px;
            opacity: 0.8;
            margin: 0;
            line-height: 1.4;
        }

        .sidebar-menu {
            flex: 1;
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 25px;
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 12px 15px;
            border-radius: 8px;
            transition: background 0.2s ease, transform 0.1s ease;
            font-size: 15px;
            font-weight: 500;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.15);
        }

        .sidebar-menu a:active {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0.98);
        }

        .sidebar-menu i {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }

        .sidebar-logout {
            margin-top: auto;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-logout-button {
            color: white;
            background: #1a4d7d;
            border-radius: 25px;
            padding: 12px 25px;
            width: 100%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 15px;
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
            font-size: 18px;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 280px;
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
            font-size: 12px;
            color: #0d2640;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .form-group-modal input,
        .form-group-modal select,
        .form-group-modal textarea {
            padding: 11px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13.5px;
            font-family: inherit;
            background: #f8fafc;
            transition: all 0.25s ease;
            color: #334155;
        }

        .form-group-modal input:focus,
        .form-group-modal select:focus,
        .form-group-modal textarea:focus {
            outline: none;
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
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <div class="main-content">
        <div class="header">
            <div style="flex: 1;"></div>
            <div class="header-right">
                <div class="profile-icon-btn" onclick="openAdminProfileModal()" title="Profil Saya">
                    <div class="profile-avatar" style="font-size: 14px; font-weight: 700; letter-spacing: 0.5px;">
                        {{ strtoupper(substr(Auth::user()->nama ?? Auth::user()->username ?? 'ADM', 0, 3)) }}
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
                <h2>{{ count($users) }}</h2>
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
                    @forelse($users as $user)
                        <tr data-username="{{ strtolower($user->nama ?? $user->username) }}"
                            data-id="{{ strtolower($user->no_induk ?? '') }}" data-role="{{ $user->role ?? '' }}"
                            data-gender="{{ $user->jenis_kelamin ?? '' }}">
                            <td>
                                <div class="user-info">
                                    <div class="avatar"
                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                        {{ strtoupper(substr($user->nama ?? $user->username, 0, 2)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $user->nama ?? $user->username }}</strong>
                                        <br>
                                        <small style="color: #999;">{{ $user->no_induk ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="tpi-badge">{{ $user->wilayah ?? 'Umum' }}</span></td>
                            <td>{{ $user->jenis_kelamin ?? '-' }}</td>
                            <td>{{ $user->no_telepon ?? '-' }}</td>
                            <td>{{ $user->alamat ?? '-' }}</td>
                            <td>
                                @if ($user->is_active ?? true)
                                    <span class="status-badge status-aktif">
                                        <i class="fas fa-circle-check"></i> Aktif
                                    </span>
                                @else
                                    <span class="status-badge status-nonaktif">
                                        <i class="fas fa-circle-xmark"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center; position: relative;">
                                @if ($user->role !== 'admin')
                                    <button class="btn-aksi-menu" onclick="toggleMenu(event, this)">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="action-dropdown" style="display: none;">
                                        @if ($user->is_active ?? true)
                                            <button type="button" class="dropdown-item"
                                                onclick="deactivateUser({{ $user->id }}, '{{ $user->nama ?? $user->username }}')">
                                                <i class="fas fa-ban"></i> Nonaktifkan
                                            </button>
                                        @else
                                            <button type="button" class="dropdown-item"
                                                onclick="activateUser({{ $user->id }}, '{{ $user->nama ?? $user->username }}')">
                                                <i class="fas fa-check-circle"></i> Aktifkan
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <span style="color: #999; font-size: 12px;">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #999; padding: 30px;">Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                <p class="page-info">
                    {{ count($users) > 0 ? 'Menampilkan ' . count($users) . ' data' : 'Tidak ada data' }}</p>
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

            <form id="formTambahUser" action="{{ route('admin.user.store') }}" method="POST">
                @csrf
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

                    fetch(`{{ route('admin.user.update-status') }}`, {
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

                    fetch(`{{ route('admin.user.update-status') }}`, {
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
            const profileModal = document.getElementById('adminProfileModal');
            if (event.target == modal) {
                closeModal();
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
    </script>

    @if (session('welcome'))
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
    @endif
    <!-- Modal Profil Admin -->
    <div id="adminProfileModal" class="modal">
        <div class="modal-content" style="max-width: 450px; padding: 30px; position: relative;">
            <div class="profile-modal-header-bg">
                <button class="modal-close" onclick="closeAdminProfileModal()" style="position: absolute; right: 15px; top: 15px; color: white;">&times;</button>
            </div>
            
            <div class="profile-modal-avatar-container">
                <div class="profile-modal-avatar" style="font-size: 32px; font-weight: 800; letter-spacing: 0.5px;">
                    {{ strtoupper(substr(Auth::user()->nama ?? Auth::user()->username ?? 'ADM', 0, 3)) }}
                </div>
                <h3 class="profile-modal-name">{{ Auth::user()->nama ?? Auth::user()->username }}</h3>
                <span class="profile-modal-badge">{{ Auth::user()->role ?? 'Admin' }}</span>
            </div>

            <div class="profile-details-grid">
                <div class="profile-detail-card">
                    <div class="profile-detail-label">No. Induk / ID</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-id-badge"></i> {{ Auth::user()->no_induk ?? '-' }}
                    </div>
                </div>
                
                <div class="profile-detail-card">
                    <div class="profile-detail-label">Username</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-user"></i> {{ Auth::user()->username ?? '-' }}
                    </div>
                </div>

                <div class="profile-detail-card">
                    <div class="profile-detail-label">Jenis Kelamin</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-venus-mars"></i> {{ Auth::user()->jenis_kelamin ?? '-' }}
                    </div>
                </div>

                <div class="profile-detail-card">
                    <div class="profile-detail-label">No. Telepon</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-phone"></i> {{ Auth::user()->no_telepon ?? '-' }}
                    </div>
                </div>

                <div class="profile-detail-card full-width">
                    <div class="profile-detail-label">Wilayah Tugas</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-map-marker-alt"></i> {{ Auth::user()->wilayah ?? 'Dinas Pusat (Subang)' }}
                    </div>
                </div>

                <div class="profile-detail-card full-width">
                    <div class="profile-detail-label">Alamat</div>
                    <div class="profile-detail-value">
                        <i class="fas fa-home"></i> {{ Auth::user()->alamat ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
                <button type="button" class="btn-cancel" onclick="closeAdminProfileModal()" style="width: 100%; text-align: center;">Tutup</button>
            </div>
        </div>
    </div>
</body>

</html>
