{{-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - SIPETANG</title>
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
            color: #1f2937;
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
            background: rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 14px 18px;
            width: 100%;
            border: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.25s ease;
        }

        .sidebar-logout-button:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar-logout-button i {
            font-size: 18px;
        }

        /* Main Content */
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

        .header-search {
            display: flex;
            gap: 10px;
            flex: 1;
        }

        .search-box {
            display: flex;
            align-items: center;
            padding: 0 15px;
            background: #f5f5f5;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            flex: 1;
            max-width: 300px;
        }

        .search-box input {
            border: none;
            background: none;
            width: 100%;
            font-size: 14px;
            padding: 10px 0;
        }

        .search-box input::placeholder {
            color: #999;
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
        }

        .header-icon:hover {
            background: #e0e0e0;
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

        /* Management Card */
        .management-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .card-body {
            padding: 25px;
        }

        /* Management Header */
        .management-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .management-header h5 {
            font-size: 16px;
            font-weight: 600;
            color: #1a4d7d;
            margin: 0;
        }

        .management-header p {
            font-size: 13px;
            color: #666;
            margin: 5px 0 0 0;
        }

        /* Filter Group */
        .filter-group {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group-text {
            background: #f5f5f5;
            border: 1px solid #e0e0e0;
            padding: 8px 12px;
            border-radius: 6px 0 0 6px;
            font-size: 13px;
            color: #666;
            font-weight: 600;
        }

        .form-select {
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-left: none;
            border-radius: 0 6px 6px 0;
            font-size: 13px;
            background: white;
            color: #1a4d7d;
            cursor: pointer;
            min-width: 150px;
        }

        .form-select:focus {
            outline: none;
            border-color: #1a4d7d;
        }

        .btn-add {
            background: #0a7ba3;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: background 0.3s;
        }

        .btn-add:hover {
            background: #1a4d7d;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        .management-table {
            width: 100%;
            border-collapse: collapse;
        }

        .management-table thead {
            background: #f5f5f5;
        }

        .management-table th {
            padding: 15px 12px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            font-weight: 600;
            border-bottom: 1px solid #e0e0e0;
        }

        .management-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 13px;
            color: #333;
        }

        .management-table tbody tr:hover {
            background: #f9f9f9;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 48px;
            opacity: 0.3;
            display: block;
            margin-bottom: 16px;
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
        }

        /* Buttons */
        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.3s;
            margin-right: 8px;
        }

        .btn-edit {
            background: #d4edda;
            color: #4caf50;
        }

        .btn-edit:hover {
            background: #c3e6cb;
        }

        .btn-delete {
            background: #f8d7da;
            color: #f44336;
        }

        .btn-delete:hover {
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

        .pagination-info {
            font-size: 12px;
            color: #999;
            margin: 0 10px;
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

            .management-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-group {
                width: 100%;
                flex-direction: column;
            }

            .form-select {
                width: 100%;
            }

            .btn-add {
                width: 100%;
            }

            .management-table {
                font-size: 12px;
            }

            .management-table th,
            .management-table td {
                padding: 10px 8px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    @include('components.sidebar-menu')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-search">
                <div class="search-box">
                    <i class="fas fa-search" style="color: #999;"></i>
                    <input type="text" placeholder="Cari karyawan...">
                </div>
            </div>
            <div class="header-right">
                <div class="header-icons">
                    <div class="header-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="header-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="header-icon">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Title -->
        <div class="page-title">
            <h1>Manajemen User / Data Karyawan TPI</h1>
            <p>Kelola data karyawan TPI dengan tabel, filter, dan aksi cepat.</p>
        </div>

        <!-- Management Card -->
        <div class="management-card">
            <div class="card-body">
                <!-- Header Section -->
                <div class="management-header">
                    <div>
                        <h5>Daftar Karyawan TPI</h5>
                        <p>Kelola dan lihat semua data karyawan yang terdaftar di sistem</p>
                    </div>
                    <button class="btn-add">
                        <i class="fas fa-plus"></i> Tambah Karyawan Baru
                    </button>
                </div>

                <!-- Filter Section -->
                <div class="management-header">
                    <div class="filter-group">
                        <div class="input-group">
                            <span class="input-group-text">Tampilkan</span>
                            <select class="form-select">
                                <option selected>10</option>
                                <option>20</option>
                                <option>50</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">Filter Asal TPI</span>
                            <select class="form-select">
                                <option selected>Semua TPI</option>
                                <option>TPI Mayangan</option>
                                <option>TPI Blanakan</option>
                                <option>TPI Patimban</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table class="management-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Jenis Kelamin</th>
                                <th>Umur</th>
                                <th>Asal TPI</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <p>Belum ada data karyawan yang dimasukkan.</p>
                                        <p style="font-size: 12px; margin-top: 8px;">Klik tombol "Tambah Karyawan Baru" untuk memulai menambahkan data.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-section">
                    <span class="pagination-info">Tampilkan 0 dari 0 entri</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="page-footer">
            SISTEM INFORMASI PENCATATAN HASIL TANGKAP
        </div>
    </div>
</body>

</html> --}}
