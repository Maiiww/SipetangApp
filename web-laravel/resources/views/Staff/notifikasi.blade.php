<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan - SIPETANG</title>
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

        .date-selector {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: #f5f5f5;
            border-radius: 6px;
            font-size: 13px;
            color: #333;
        }

        .btn-input {
            background: #0d2640;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: background 0.3s;
        }

        .btn-input:hover {
            background: #1a4d7d;
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

        .page-title {
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 600;
            color: #1a4d7d;
            margin-bottom: 5px;
        }

        .page-title p {
            font-size: 14px;
            color: #666;
        }

        .notif-panel {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 1.5rem;
        }

        .notif-card,
        .notif-tile {
            border-radius: 1.5rem;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            background: white;
        }

        .notif-card {
            padding: 1.5rem;
        }

        .notif-card small {
            display: inline-block;
            margin-top: 0.75rem;
            color: #94a3b8;
            font-weight: 700;
            background: #f8fafc;
            padding: 0.5rem 0.9rem;
            border-radius: 999px;
        }

        .notif-list {
            display: grid;
            gap: 1rem;
        }

        .notif-tile {
            padding: 1.5rem;
        }

        .notif-tile .tile-title {
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
        }

        .notif-tile .tile-text {
            color: #475569;
            margin-bottom: 1rem;
            line-height: 1.7;
        }

        .notif-tile .tile-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
            color: #94a3b8;
            font-size: 0.88rem;
        }

        .notif-tile .tile-meta .badge-dot {
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            background: #dc2626;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .notif-tile .tile-actions {
            margin-top: 1.15rem;
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .notif-tile .btn-secondary {
            background: #e2e8f0;
            color: #0f172a;
            border: none;
            border-radius: 0.9rem;
            padding: 0.75rem 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.25s ease;
        }

        .notif-tile .btn-secondary:hover {
            background: #cbd5e1;
        }

        .notif-tile .btn-danger {
            background: #dc2626;
            border: none;
            border-radius: 0.9rem;
            padding: 0.75rem 1.1rem;
            color: #ffffff;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.25s ease;
        }

        .notif-tile .btn-danger:hover {
            background: #b91c1c;
        }

        .notif-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .notif-actions .btn {
            min-width: 180px;
            border-radius: 0.9rem;
            padding: 0.8rem 1.2rem;
            font-weight: 700;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .notif-actions .btn-primary {
            background: #0d2640;
            color: white;
        }

        .notif-actions .btn-primary:hover {
            background: #1a4d7d;
        }

        .notif-actions .btn-outline-primary {
            color: #0f172a;
            border: 1px solid #e2e8f0;
            background: #ffffff;
        }

        .notif-actions .btn-outline-primary:hover {
            background: #f8fafc;
        }

        .dashboard-footer {
            text-align: center;
            font-size: 11px;
            color: #999;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        @media (max-width: 1024px) {
            .notif-panel {
                grid-template-columns: 1fr;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                flex-direction: row;
                padding: 20px;
            }

            .sidebar-menu {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .sidebar-menu li {
                margin-bottom: 0;
            }

            .sidebar-logout {
                margin-top: 20px;
                border-top: none;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }

            .header-right {
                width: 100%;
                justify-content: space-between;
                flex-wrap: wrap;
            }

            .search-box {
                max-width: 100%;
            }

            .notif-card,
            .notif-tile {
                padding: 20px;
            }

            .date-selector,
            .btn-input {
                width: 100%;
            }

            .header-icons {
                justify-content: flex-end;
                width: 100%;
            }

            .notif-actions .btn {
                min-width: auto;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <div class="main-content">
        <div class="header">
            <div class="header-right">
                <div class="date-selector">
                    <i class="fas fa-calendar"></i>
                    <span>Mei 2026</span>
                </div>
                <button class="btn-input"><i class="fas fa-filter"></i> Filter</button>
                <div class="header-icons">
                    <div class="header-icon"><i class="fas fa-bell" style="color: #1a4d7d;"></i></div>
                    <div class="header-icon"><i class="fas fa-cog" style="color: #1a4d7d;"></i></div>
                    <div class="header-icon"><i class="fas fa-user" style="color: #1a4d7d;"></i></div>
                </div>
            </div>
        </div>

        <div class="page-title">
            <h1>Pemberitahuan Sistem</h1>
            <p>Semua aktivitas terbaru dan status validasi laporan akan ditampilkan di sini.</p>
        </div>

        <div class="notif-panel">
            <div class="notif-card">
                <div class="mb-4">
                    <span
                        style="text-transform: uppercase; font-size: 0.75rem; font-weight: 700; color: #94a3b8;">Kategori</span>
                    <h5
                        style="margin-top: 0.5rem; margin-bottom: 1rem; font-size: 1.1rem; font-weight: 700; color: #0f172a;">
                        Semua Pemberitahuan</h5>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #f8fafc; border-radius: 0.9rem;">
                        <div>
                            <strong style="color: #0f172a;">Semua Pemberitahuan</strong>
                            <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem; color: #64748b;">Ringkasan semua
                                notifikasi.</p>
                        </div>
                        <span
                            style="background: #0f172a; color: white; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.85rem; font-weight: 700;">12</span>
                    </div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: white; border: 1px solid #e2e8f0; border-radius: 0.9rem;">
                        <div>
                            <strong style="color: #0f172a;">Validasi</strong>
                            <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem; color: #64748b;">Laporan validasi baru.
                            </p>
                        </div>
                        <span
                            style="background: #3b82f6; color: white; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.85rem; font-weight: 700;">8</span>
                    </div>
                </div>
            </div>

            <div class="notif-list">
                <div class="notif-tile">
                    <div
                        style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <div>
                            <p
                                style="text-transform: uppercase; font-size: 0.75rem; color: #d97706; font-weight: 700; margin-bottom: 0.5rem;">
                                Laporan Baru</p>
                            <h5 class="tile-title">TPI Blanakan</h5>
                        </div>
                        <span class="badge-dot"
                            style="width: 0.75rem; height: 0.75rem; border-radius: 50%; background: #dc2626;"></span>
                    </div>
                    <p class="tile-text">Juru Rekap <strong>Budi Santoso</strong> telah menginputkan data produksi pada
                        15 April 2026. Jenis Ikan Tongkol, Total berat 7 Kg.</p>
                    <div class="tile-meta">
                        <span>2 menit lalu</span>
                        <span style="color: #d97706; font-weight: 700;">Butuh Validasi</span>
                    </div>
                    <div class="tile-actions">
                        <button class="btn-danger">Validasi</button>
                        <button class="btn-secondary">Lihat Detail</button>
                    </div>
                </div>

                <div class="notif-tile">
                    <div
                        style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <div>
                            <p
                                style="text-transform: uppercase; font-size: 0.75rem; color: #475569; font-weight: 700; margin-bottom: 0.5rem;">
                                Validasi Berhasil</p>
                            <h5 class="tile-title">TPI Patimban</h5>
                        </div>
                        <span
                            style="background: #10b981; color: white; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.85rem; font-weight: 700;">Selesai</span>
                    </div>
                    <p class="tile-text">Laporan TPI Patimban pada 10 April telah divalidasi dan masuk database
                        statistik oleh Admin Sutisna.</p>
                    <div class="tile-meta">
                        <span>1 jam lalu</span>
                        <span style="color: #10b981; font-weight: 700;">Divalidasi oleh Admin: Sutisna</span>
                    </div>
                </div>

                <div style="text-align: center; padding: 1.5rem 0;">
                    <a href="#"
                        style="color: #64748b; text-decoration: none; font-size: 0.85rem; font-weight: 700;">Muat
                        notifikasi lama</a>
                </div>
            </div>
        </div>

        <div class="dashboard-footer">
            SISTEM INFORMASI PENCATATAN HASIL TANGKAP
        </div>
    </div>
</body>

</html>
