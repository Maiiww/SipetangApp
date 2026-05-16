<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - SIPETANG</title>
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
            color: #24374a;
            min-height: 100vh;
            display: flex;
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
            margin-bottom: 28px;
        }

        .page-title h1 {
            font-size: 32px;
            color: #102a43;
            margin-bottom: 8px;
        }

        .page-title p {
            max-width: 700px;
            font-size: 14px;
            color: #556a82;
            line-height: 1.7;
        }

        .layout-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 24px;
            margin-bottom: 30px;
        }

        .card {
            background: #fff;
            border-radius: 22px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-title h2 {
            font-size: 18px;
            color: #102a43;
            font-weight: 700;
        }

        .section-title span {
            font-size: 13px;
            color: #7a869a;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 22px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-label {
            font-size: 12px;
            color: #7a869a;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
        }

        .form-select,
        .form-input {
            border: 1px solid #dce1e9;
            border-radius: 14px;
            padding: 14px 16px;
            font-size: 14px;
            background: #f8fafc;
            color: #102a43;
            outline: none;
        }

        .form-input {
            width: 100%;
        }

        .form-select {
            appearance: none;
            background: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="%237a869a" d="M5.5 7.5l4.5 4.5 4.5-4.5"/></svg>') no-repeat right 16px center/12px auto;
        }

        .form-select option:disabled {
            color: #7a869a;
        }

        .frequency-card {
            background: #f8fafc;
            border: 1px solid #e6ecf6;
            border-radius: 20px;
            padding: 22px;
            display: grid;
            gap: 16px;
        }

        .frequency-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            border: 1px solid #dce1e9;
            border-radius: 18px;
            padding: 16px;
            transition: border-color 0.3s ease, background-color 0.3s ease;
            cursor: pointer;
        }

        .frequency-option.active-laporan {
            border-color: #0d2640;
            background: #edf2ff;
        }

        .frequency-option:hover {
            border-color: #1a4d7d;
        }

        .frequency-option input {
            margin-right: 12px;
        }

        .frequency-option .option-body {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .option-title {
            font-size: 14px;
            font-weight: 700;
            color: #102a43;
        }

        .option-desc {
            font-size: 12px;
            color: #64748b;
        }

        .output-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .output-label {
            font-size: 13px;
            color: #7a869a;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        .format-buttons {
            display: flex;
            gap: 12px;
        }

        .format-button {
            border: 1px solid #dce1e9;
            border-radius: 12px;
            background: #fff;
            color: #102a43;
            padding: 10px 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .format-button.active {
            background: #0d2640;
            color: #fff;
            border-color: #0d2640;
        }

        .button-primary {
            background: #0d2640;
            color: #fff;
            border: none;
            padding: 14px 26px;
            border-radius: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .button-primary:hover {
            transform: translateY(-1px);
        }

        .metric-card {
            background: #fff;
            border-radius: 24px;
            padding: 26px;
            margin-bottom: 24px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
        }

        .metric-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 22px;
        }

        .metric-top h3 {
            font-size: 14px;
            text-transform: uppercase;
            color: #7a869a;
            letter-spacing: 0.08em;
            margin-bottom: 6px;
        }

        .metric-top .metric-value {
            font-size: 32px;
            color: #102a43;
            font-weight: 800;
        }

        .metric-note {
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
        }

        .report-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .report-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            background: #f8fafc;
            border-radius: 18px;
            padding: 16px 18px;
        }

        .report-item .report-info {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .report-icon {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: #0d2640;
            color: #fff;
            font-size: 16px;
        }

        .report-text {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .report-name {
            font-size: 14px;
            font-weight: 700;
            color: #102a43;
        }

        .report-meta {
            font-size: 12px;
            color: #64748b;
        }

        .report-size {
            font-size: 12px;
            color: #102a43;
        }

        .table-card {
            background: #fff;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            gap: 10px;
        }

        .table-header h2 {
            font-size: 16px;
            color: #102a43;
            font-weight: 700;
        }

        .table-header .info-text {
            font-size: 12px;
            color: #64748b;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 100%;
        }

        .report-table th,
        .report-table td {
            padding: 16px 14px;
            text-align: left;
            border-bottom: 1px solid #e9eef5;
            font-size: 13px;
            color: #24374a;
        }

        .report-table th {
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            font-weight: 700;
            background: transparent;
        }

        .report-table tbody tr:hover {
            background: #f8fafc;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 11px;
            color: #102a43;
            background: #e6f0ff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .action-link {
            color: #0d2640;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
        }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            padding-top: 14px;
        }

        .pagination button {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            border: 1px solid #dce1e9;
            background: #fff;
            color: #102a43;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .pagination button:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }

        .pagination button.active {
            background: #0d2640;
            color: #fff;
            border-color: #0d2640;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 22px;
            padding: 40px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e9eef5;
        }

        .modal-header h2 {
            font-size: 24px;
            color: #102a43;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 28px;
            color: #64748b;
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            color: #102a43;
        }

        .modal-body {
            margin-bottom: 24px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f4f8;
        }

        .detail-label {
            font-weight: 700;
            color: #7a869a;
            font-size: 13px;
            text-transform: uppercase;
        }

        .detail-value {
            color: #102a43;
            font-weight: 600;
        }

        .modal-footer {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .modal-button {
            border: 1px solid #dce1e9;
            border-radius: 12px;
            background: #fff;
            color: #102a43;
            padding: 10px 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .modal-button:hover {
            background: #f8fafc;
        }

        .modal-button.primary {
            background: #0d2640;
            color: #fff;
            border-color: #0d2640;
        }

        .modal-button.primary:hover {
            background: #0a2d35;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 1100px) {
            .layout-grid {
                grid-template-columns: 1fr;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 22px;
            }

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding-bottom: 20px;
            }
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 18px;
            }

            .header,
            .section-title,
            .output-actions,
            .header-right {
                flex-direction: column;
                align-items: stretch;
            }

            .report-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .report-table th,
            .report-table td {
                padding: 14px 10px;
            }
        }
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <main class="main-content">
        <div class="header">
            <div class="header-right">
                <div class="date-selector">
                    <i class="fas fa-calendar"></i>
                    <span>Mei 2026</span>
                </div>
                <div class="header-icons">
                    <div class="header-icon"><i class="fas fa-bell" style="color: #1a4d7d;"></i></div>
                    <div class="header-icon"><i class="fas fa-cog" style="color: #1a4d7d;"></i></div>
                    <div class="header-icon"><i class="fas fa-user" style="color: #1a4d7d;"></i></div>
                </div>
            </div>
        </div>

        <section class="page-title">
            <h1>Cetak Laporan</h1>
            <p>Hasilkan dan ekspor laporan data maritim yang komprehensif. Pilih parameter Anda di bawah ini untuk
                membuat dokumentasi editorial resmi.</p>
        </section>

        <div class="layout-grid">
            <section class="card">
                <div class="section-title">
                    <h2>Konfigurasi Laporan</h2>
                    <span>Atur sumber, periode, dan format output</span>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="asal-tpi">Asal TPI</label>
                        <select id="asal-tpi" class="form-select">
                            <option value="" disabled selected style="color: #7a869a;">Pilih Asal TPI</option>
                            <option>Blanakan</option>
                            <option>Patimban</option>
                            <option>Genteng</option>
                            <option>Mayangan</option>
                            <option>Cirewang</option>
                            <option>Muara Ciasem</option>
                            <option>Rawameneng</option>
                            <option>Cilamaya Girang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="mulai-dari">Mulai Dari</label>
                        <input id="mulai-dari" type="date" class="form-input" placeholder="mm/dd">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="sampai-dengan">Sampai Dengan</label>
                        <input id="sampai-dengan" type="date" class="form-input" placeholder="mm/dd">
                    </div>
                </div>

                <div class="frequency-card">
                    <label class="form-label">Jenis Laporan Berkala</label>
                    <label class="frequency-option" data-laporan="harian">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <input type="radio" name="laporan_type" value="harian">
                            <div class="option-body">
                                <span class="option-title">Laporan Harian</span>
                                <span class="option-desc">Rekapitulasi harian hasil tangkap</span>
                            </div>
                        </div>
                        <i class="fas fa-calendar-day" style="color:#0d2640"></i>
                    </label>
                    <label class="frequency-option" data-laporan="bulanan">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <input type="radio" name="laporan_type" value="bulanan">
                            <div class="option-body">
                                <span class="option-title">Laporan Bulanan</span>
                                <span class="option-desc">Statistik dan produksi</span>
                            </div>
                        </div>
                        <i class="fas fa-calendar-alt" style="color:#0d2640"></i>
                    </label>
                    <label class="frequency-option" data-laporan="tahunan">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <input type="radio" name="laporan_type" value="tahunan">
                            <div class="option-body">
                                <span class="option-title">Laporan Tahunan</span>
                                <span class="option-desc">Statistik tren produksi tahunan</span>
                            </div>
                        </div>
                        <i class="fas fa-calendar" style="color:#0d2640"></i>
                    </label>
                </div>

                <div class="output-actions">
                    <div class="output-label">Format Output:</div>
                    <div class="format-buttons">
                        <button type="button" class="format-button active" id="format-pdf"
                            data-format="pdf">PDF</button>
                        <button type="button" class="format-button" id="format-excel"
                            data-format="excel">EXCEL</button>
                    </div>
                    <button type="button" class="button-primary" id="btn-preview">Lihat Pratinjau</button>
                </div>
            </section>

            <section>
                <div class="metric-card">
                    <div class="metric-top">
                        <div>
                            <h3>Total Laporan</h3>
                            <p class="metric-note">Semua dokumen cetak dan ekspor</p>
                        </div>
                        <div class="metric-value">1,284</div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="section-title" style="margin-bottom: 18px;">
                        <h2>Laporan Terkini</h2>
                    </div>
                    <ul class="report-list">
                        <li class="report-item">
                            <div class="report-info">
                                <div class="report-icon"><i class="fas fa-file-pdf"></i></div>
                                <div class="report-text">
                                    <span class="report-name">Rekap_Blanakan_Jan.pdf</span>
                                    <span class="report-meta">12 menit yang lalu</span>
                                </div>
                            </div>
                            <span class="report-size">4.2 MB</span>
                        </li>
                        <li class="report-item">
                            <div class="report-info">
                                <div class="report-icon" style="background:#0c8f6b;"><i
                                        class="fas fa-file-excel"></i></div>
                                <div class="report-text">
                                    <span class="report-name">Rekap_Pondok_Bali.xlsx</span>
                                    <span class="report-meta">2 jam yang lalu</span>
                                </div>
                            </div>
                            <span class="report-size">12.8 MB</span>
                        </li>
                        <li class="report-item">
                            <div class="report-info">
                                <div class="report-icon" style="background:#0d2640;"><i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="report-text">
                                    <span class="report-name">Rekap_Mayangan_April.pdf</span>
                                    <span class="report-meta">Kemarin</span>
                                </div>
                            </div>
                            <span class="report-size">11 MB</span>
                        </li>
                    </ul>
                    <div style="margin-top: 18px; text-align: right;">
                        <a href="#" class="action-link" id="view-all-history">Lihat Semua Riwayat</a>
                    </div>
                </div>
            </section>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h2>Tabel Arsip Laporan Cetak</h2>
                <span class="info-text">Menampilkan 2 dari 1,284 entri</span>
            </div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>ID Laporan</th>
                        <th>Tanggal Dibuat</th>
                        <th>Cakupan Data</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>#MAR-2601-092</strong></td>
                        <td>24 Jan 2026, 09:12</td>
                        <td><span class="badge">01 JAN - 23 JAN</span></td>
                        <td>TPI Pondok Bali</td>
                        <td><a href="#" class="action-link detail-link" data-id="#MAR-2601-092"
                                data-date="24 Jan 2026, 09:12" data-range="01 JAN - 23 JAN"
                                data-tpi="TPI Pondok Bali">Lihat Detail</a></td>
                    </tr>
                    <tr>
                        <td><strong>#MAR-2601-088</strong></td>
                        <td>22 Jan 2026, 15:45</td>
                        <td><span class="badge">TPI Patimban Only</span></td>
                        <td>TPI Blanakan</td>
                        <td><a href="#" class="action-link detail-link" data-id="#MAR-2601-088"
                                data-date="22 Jan 2026, 15:45" data-range="TPI Patimban Only"
                                data-tpi="TPI Blanakan">Lihat Detail</a></td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination">
                <button class="pagination-prev" data-action="prev">&lt;</button>
                <button class="pagination-page active" data-page="1">1</button>
                <button class="pagination-page" data-page="2">2</button>
                <button class="pagination-page" data-page="3">3</button>
                <button class="pagination-next" data-action="next">&gt;</button>
            </div>
        </div>
    </main>

    <!-- Detail Modal -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detail Laporan</h2>
                <button class="modal-close" onclick="closeDetailModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="detail-row">
                    <span class="detail-label">ID Laporan</span>
                    <span class="detail-value" id="modal-id"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Dibuat</span>
                    <span class="detail-value" id="modal-date"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Cakupan Data</span>
                    <span class="detail-value" id="modal-range"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Dibuat Oleh</span>
                    <span class="detail-value" id="modal-tpi"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-button" onclick="closeDetailModal()">Tutup</button>
                <button class="modal-button primary" id="modal-download">Download Laporan</button>
            </div>
        </div>
    </div>

    <script>
        let selectedFormat = 'pdf';

        // Laporan type selection toggle
        document.querySelectorAll('input[name="laporan_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Hapus class active dari semua frequency-option
                document.querySelectorAll('.frequency-option').forEach(opt => {
                    opt.classList.remove('active-laporan');
                });
                // Tambah class active ke label yang berisi radio yang dipilih
                this.closest('.frequency-option').classList.add('active-laporan');
            });
        });

        // Format button toggle
        document.getElementById('format-pdf').addEventListener('click', function() {
            selectedFormat = 'pdf';
            document.querySelectorAll('.format-button').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });

        document.getElementById('format-excel').addEventListener('click', function() {
            selectedFormat = 'excel';
            document.querySelectorAll('.format-button').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });

        // Pagination functionality
        let currentPage = 1;
        const itemsPerPage = 2;
        const allReportData = [{
                id: '#MAR-2601-092',
                date: '24 Jan 2026, 09:12',
                range: '01 JAN - 23 JAN',
                tpi: 'TPI Pondok Bali'
            },
            {
                id: '#MAR-2601-088',
                date: '22 Jan 2026, 15:45',
                range: 'TPI Patimban Only',
                tpi: 'TPI Blanakan'
            },
            {
                id: '#MAR-2601-085',
                date: '20 Jan 2026, 11:30',
                range: '01 JAN - 19 JAN',
                tpi: 'TPI Genteng'
            },
            {
                id: '#MAR-2601-082',
                date: '18 Jan 2026, 14:20',
                range: 'TPI Mayangan Only',
                tpi: 'TPI Mayangan'
            },
            {
                id: '#MAR-2601-079',
                date: '16 Jan 2026, 10:00',
                range: '01 JAN - 15 JAN',
                tpi: 'TPI Blanakan'
            },
            {
                id: '#MAR-2601-075',
                date: '14 Jan 2026, 13:40',
                range: 'TPI Patimban Only',
                tpi: 'TPI Patimban'
            }
        ];

        const totalPages = Math.ceil(allReportData.length / itemsPerPage);

        function updatePaginationTable(page) {
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageData = allReportData.slice(start, end);

            // Update table content
            const tableBody = document.querySelector('.report-table tbody');
            tableBody.innerHTML = pageData.map(item => `
                <tr>
                    <td><strong>${item.id}</strong></td>
                    <td>${item.date}</td>
                    <td><span class="badge">${item.range}</span></td>
                    <td>${item.tpi}</td>
                    <td><a href="#" class="action-link detail-link" data-id="${item.id}"
                            data-date="${item.date}" data-range="${item.range}"
                            data-tpi="${item.tpi}">Lihat Detail</a></td>
                </tr>
            `).join('');

            // Attach event listeners to new detail links
            attachDetailLinkListeners();

            // Update info text
            const startNum = start + 1;
            const endNum = Math.min(end, allReportData.length);
            document.querySelector('.table-header .info-text').textContent =
                `Menampilkan ${startNum} - ${endNum} dari ${allReportData.length} entri`;

            // Update pagination buttons
            updatePaginationButtons(page);

            currentPage = page;
        }

        function updatePaginationButtons(page) {
            // Update prev button
            const prevBtn = document.querySelector('.pagination-prev');
            prevBtn.disabled = page === 1;

            // Update next button
            const nextBtn = document.querySelector('.pagination-next');
            nextBtn.disabled = page === totalPages;

            // Update page buttons
            document.querySelectorAll('.pagination-page').forEach(btn => {
                const pageNum = parseInt(btn.getAttribute('data-page'));
                btn.classList.toggle('active', pageNum === page);
            });
        }

        // Pagination button click handlers
        function attachPaginationListeners() {
            // Previous button
            const prevBtn = document.querySelector('.pagination-prev');
            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    if (currentPage > 1) {
                        updatePaginationTable(currentPage - 1);
                    }
                });
            }

            // Next button
            const nextBtn = document.querySelector('.pagination-next');
            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    if (currentPage < totalPages) {
                        updatePaginationTable(currentPage + 1);
                    }
                });
            }

            // Page number buttons
            document.querySelectorAll('.pagination-page').forEach(btn => {
                btn.addEventListener('click', function() {
                    const pageNum = parseInt(this.getAttribute('data-page'));
                    if (pageNum <= totalPages) {
                        updatePaginationTable(pageNum);
                    }
                });
            });
        }

        attachPaginationListeners();

        function attachDetailLinkListeners() {
            document.querySelectorAll('.detail-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const date = this.dataset.date;
                    const range = this.dataset.range;
                    const tpi = this.dataset.tpi;

                    // Populate modal with data
                    document.getElementById('modal-id').textContent = id;
                    document.getElementById('modal-date').textContent = date;
                    document.getElementById('modal-range').textContent = range;
                    document.getElementById('modal-tpi').textContent = tpi;

                    // Show modal
                    document.getElementById('detailModal').classList.add('show');
                });
            });
        }

        // Initialize detail link listeners
        attachDetailLinkListeners();

        // Preview button
        document.getElementById('btn-preview').addEventListener('click', function() {
            const asalTpi = document.getElementById('asal-tpi').value;
            const mulaiDari = document.getElementById('mulai-dari').value;
            const sampaiDengan = document.getElementById('sampai-dengan').value;
            const laporanType = document.querySelector('input[name="laporan_type"]:checked')?.value;

            // Validasi input
            if (!asalTpi) {
                alert('Silakan pilih Asal TPI');
                return;
            }
            if (!mulaiDari) {
                alert('Silakan masukkan tanggal mulai');
                return;
            }
            if (!sampaiDengan) {
                alert('Silakan masukkan tanggal akhir');
                return;
            }
            if (!laporanType) {
                alert('Silakan pilih jenis laporan');
                return;
            }

            // Generate preview/download
            const params = new URLSearchParams({
                tpi: asalTpi,
                tanggal_mulai: mulaiDari,
                tanggal_akhir: sampaiDengan,
                jenis_laporan: laporanType,
                format: selectedFormat
            });

            const url = `/laporan/generate?${params.toString()}`;

            if (selectedFormat === 'pdf') {
                // Buka preview PDF di tab baru
                window.open(url, '_blank');
            } else if (selectedFormat === 'excel') {
                // Download Excel
                const link = document.createElement('a');
                link.href = url;
                link.download = `Laporan_${asalTpi}_${mulaiDari}.xlsx`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        });

        // Close modal function
        function closeDetailModal() {
            document.getElementById('detailModal').classList.remove('show');
        }

        // Close modal when clicking outside content
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });

        // Download button handler
        document.getElementById('modal-download').addEventListener('click', function() {
            const id = document.getElementById('modal-id').textContent;
            // Trigger download dengan ID laporan
            const downloadUrl = `/laporan/download?id=${encodeURIComponent(id)}`;
            window.location.href = downloadUrl;
        });

        // View all history functionality
        document.getElementById('view-all-history').addEventListener('click', function(e) {
            e.preventDefault();

            // Get the report list container
            const reportList = document.querySelector('.report-list');
            const viewAllLink = document.getElementById('view-all-history').parentElement;

            // Define all history data
            const allHistoryData = [{
                    name: 'Rekap_Blanakan_Jan.pdf',
                    meta: '12 menit yang lalu',
                    size: '4.2 MB',
                    icon: 'fa-file-pdf',
                    bgColor: '#0d2640'
                },
                {
                    name: 'Rekap_Pondok_Bali.xlsx',
                    meta: '2 jam yang lalu',
                    size: '12.8 MB',
                    icon: 'fa-file-excel',
                    bgColor: '#0c8f6b'
                },
                {
                    name: 'Rekap_Mayangan_April.pdf',
                    meta: 'Kemarin',
                    size: '11 MB',
                    icon: 'fa-file-pdf',
                    bgColor: '#0d2640'
                },
                {
                    name: 'Laporan_Genteng_Mei.pdf',
                    meta: '3 hari yang lalu',
                    size: '8.5 MB',
                    icon: 'fa-file-pdf',
                    bgColor: '#0d2640'
                },
                {
                    name: 'Rekap_Cirewang_Feb.xlsx',
                    meta: '1 minggu yang lalu',
                    size: '15.3 MB',
                    icon: 'fa-file-excel',
                    bgColor: '#0c8f6b'
                },
                {
                    name: 'Laporan_Patimban_Mar.pdf',
                    meta: '2 minggu yang lalu',
                    size: '9.2 MB',
                    icon: 'fa-file-pdf',
                    bgColor: '#0d2640'
                }
            ];

            // Check if already showing all
            if (reportList.dataset.showAll === 'true') {
                // Toggle back to showing 3 items
                reportList.innerHTML = allHistoryData.slice(0, 3).map(item => `
                    <li class="report-item">
                        <div class="report-info">
                            <div class="report-icon" style="background:${item.bgColor};"><i class="fas ${item.icon}"></i></div>
                            <div class="report-text">
                                <span class="report-name">${item.name}</span>
                                <span class="report-meta">${item.meta}</span>
                            </div>
                        </div>
                        <span class="report-size">${item.size}</span>
                    </li>
                `).join('');

                reportList.dataset.showAll = 'false';
                document.getElementById('view-all-history').textContent = 'Lihat Semua Riwayat';
            } else {
                // Show all items
                reportList.innerHTML = allHistoryData.map(item => `
                    <li class="report-item">
                        <div class="report-info">
                            <div class="report-icon" style="background:${item.bgColor};"><i class="fas ${item.icon}"></i></div>
                            <div class="report-text">
                                <span class="report-name">${item.name}</span>
                                <span class="report-meta">${item.meta}</span>
                            </div>
                        </div>
                        <span class="report-size">${item.size}</span>
                    </li>
                `).join('');

                reportList.dataset.showAll = 'true';
                document.getElementById('view-all-history').textContent = 'Sembunyikan';
            }
        });
    </script>
</body>

</html>
