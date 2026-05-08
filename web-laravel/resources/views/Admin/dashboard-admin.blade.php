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
            width: 200px;
            background: linear-gradient(180deg, #0d2640 0%, #1a4d7d 100%);
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

        .sidebar-menu i {
            width: 20px;
            text-align: center;
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
            outline: none;
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
        }

        .content-header p {
            color: #666;
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
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-info h4 {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .stat-info span {
            font-size: 24px;
            font-weight: 700;
            color: #0d2640;
        }

        .stat-icon {
            font-size: 20px;
            padding: 12px;
            border-radius: 10px;
        }

        .bg-blue { background: #e3f2fd; color: #1976d2; }
        .bg-green { background: #e8f5e9; color: #2e7d32; }
        .bg-orange { background: #fff3e0; color: #ef6c00; }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
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

        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-success { background: #d4edda; color: #155724; }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin-right: 5px;
        }

        .btn-check { background: #2e7d32; color: white; }
        .btn-detail { background: #1a4d7d; color: white; }

        @media (max-width: 768px) {
            .sidebar { width: 60px; padding: 20px 10px; }
            .sidebar-logo-text, .sidebar-menu span, .sidebar-logout span { display: none; }
            .main-content { margin-left: 60px; }
        }
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <div class="main-content">
        <div class="header">
            <div class="header-search">
                <div class="search-box">
                    <i class="fas fa-search" style="color: #999;"></i>
                    <input type="text" placeholder="Cari data laporan...">
                </div>
            </div>
            <div class="header-right">
                <div class="header-icon"><i class="fas fa-bell"></i></div>
                <div class="header-icon"><i class="fas fa-user"></i></div>
            </div>
        </div>

        <div class="content-header">
            <h2>Validasi Laporan</h2>
            <p>Verifikasi data hasil tangkapan dari TPI wilayah Subang.</p>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-info">
                    <h4>Menunggu</h4>
                    <span>24</span>
                </div>
                <div class="stat-icon bg-orange">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h4>Tervalidasi</h4>
                    <span>142</span>
                </div>
                <div class="stat-icon bg-green">
                    <i class="fas fa-check-double"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h4>Total Volume</h4>
                    <span>8.4 Ton</span>
                </div>
                <div class="stat-icon bg-blue">
                    <i class="fas fa-anchor"></i>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3>Antrean Laporan</h3>
                <button class="btn-action btn-detail" style="padding: 10px 20px;">
                    <i class="fas fa-file-export"></i> Ekspor Data
                </button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>TPI / Lokasi</th>
                        <th>Komoditas</th>
                        <th>Volume</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>24 Okt 2025</td>
                        <td><strong>TPI Mayangan</strong><br><small>Subang Utara</small></td>
                        <td>Tongkol</td>
                        <td>1,250 KG</td>
                        <td><span class="badge badge-pending">TERTUNDA</span></td>
                        <td>
                            <button class="btn-action btn-check"><i class="fas fa-check"></i></button>
                            <button class="btn-action btn-detail"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>24 Okt 2025</td>
                        <td><strong>TPI Blanakan</strong><br><small>Subang Barat</small></td>
                        <td>Kembung</td>
                        <td>840 KG</td>
                        <td><span class="badge badge-pending">TERTUNDA</span></td>
                        <td>
                            <button class="btn-action btn-check"><i class="fas fa-check"></i></button>
                            <button class="btn-action btn-detail"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>23 Okt 2025</td>
                        <td><strong>TPI Ciasem</strong><br><small>Subang Timur</small></td>
                        <td>Layur</td>
                        <td>2,180 KG</td>
                        <td><span class="badge badge-success">TERIMA</span></td>
                        <td>
                            <button class="btn-action btn-detail"><i class="fas fa-info-circle"></i> Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>