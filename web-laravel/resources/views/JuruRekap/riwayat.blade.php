<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat & Revisi - SIPETANG</title>
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

        /* Layout Grid */
        .riwayat-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 30px;
        }

        /* Panel Common */
        .panel {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
            margin-bottom: 25px;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .panel-header h2 {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .panel-header h2 i {
            color: #0a3b99;
        }

        /* Alert styling */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid #cbd5e1;
        }

        .alert-success {
            background: #f0fdf4;
            color: #155724;
            border-color: #bbf7d0;
        }

        /* Revisions Grid */
        .revisions-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .revision-card {
            background: #fffbfa;
            border: 1.5px solid #fee2e2;
            border-radius: 14px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .revision-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.05);
        }

        .revision-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .revision-title {
            font-size: 15px;
            font-weight: 700;
            color: #991b1b;
        }

        .revision-meta {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        .rejection-reason {
            background: #fef2f2;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            color: #991b1b;
            border-left: 3.5px solid #ef4444;
            line-height: 1.5;
        }

        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary {
            background: #0a3b99;
            color: white;
        }

        .btn-primary:hover {
            background: #0d2640;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        /* Timeline / History List */
        .timeline {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .timeline-card {
            background: white;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: background 0.2s ease;
        }

        .timeline-card:hover {
            background: #f8fafc;
        }

        .timeline-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .status-success {
            background: #dcfce7;
            color: #10b981;
        }

        .status-danger {
            background: #fee2e2;
            color: #ef4444;
        }

        .status-pending {
            background: #dbeafe;
            color: #3b82f6;
        }

        .status-draft {
            background: #ffedd5;
            color: #f59e0b;
        }

        .timeline-details {
            flex: 1;
        }

        .timeline-details h4 {
            font-size: 13.5px;
            font-weight: 700;
            color: #1e293b;
        }

        .timeline-details p {
            font-size: 11.5px;
            color: #64748b;
            margin-top: 3px;
        }

        .timeline-time {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 600;
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

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 550px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: modalFadeIn 0.3s ease-out;
            overflow: hidden;
        }

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
        }

        .modal-footer {
            padding: 15px 25px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
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
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <main class="main-content">
        <div style="margin-bottom: 30px;">
            <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Riwayat & Revisi</h1>
            <p style="font-size: 14.5px; color: #64748b;">Periksa riwayat input tangkapan dan lakukan revisi data jika ditolak oleh staf.</p>
        </div>



        <div class="riwayat-grid">
            <!-- Left Column: Revisions needed -->
            <div>
                <div class="panel">
                    <div class="panel-header">
                        <h2><i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i> Antrean Revisi ({{ $revisions->count() }} Laporan)</h2>
                    </div>

                    @if ($revisions->count() > 0)
                        <div class="revisions-list">
                            @foreach ($revisions as $rev)
                                <div class="revision-card">
                                    <div class="revision-card-header">
                                        <div>
                                            <span class="revision-title">Revisi: {{ $rev->jenis_ikan }}</span>
                                            <div class="revision-meta">
                                                <span>Nelayan: {{ $rev->nama_nelayan }}</span> &bull; 
                                                <span>Berat: {{ number_format($rev->berat, 1) }} kg</span>
                                            </div>
                                            <div class="revision-meta" style="margin-top: 2px;">
                                                <span>Ditolak Pada: {{ $rev->rejected_at ? \Carbon\Carbon::parse($rev->rejected_at)->translatedFormat('d M Y H:i') : '-' }}</span>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" onclick="openRevisiModal({{ $rev->id }}, '{{ $rev->jenis_ikan }}', '{{ $rev->nama_nelayan }}', '{{ $rev->nama_pembeli }}', {{ $rev->berat }}, {{ $rev->harga_jual }}, '{{ addslashes($rev->catatan) }}')">
                                            <i class="fas fa-edit"></i> Perbaiki
                                        </button>
                                    </div>

                                    <div class="rejection-reason">
                                        <strong>Alasan Penolakan Staff:</strong><br>
                                        {{ $rev->catatan ?? 'Tidak ada catatan khusus.' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 40px 0; color: #94a3b8;">
                            <i class="fas fa-clipboard-check" style="font-size: 44px; margin-bottom: 12px; opacity: 0.5;"></i>
                            <p style="font-size: 14.5px; font-weight: 600;">Semua aman! Tidak ada laporan yang perlu direvisi.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: History log -->
            <div>
                <div class="panel">
                    <div class="panel-header">
                        <h2><i class="fas fa-history"></i> Riwayat Aktivitas</h2>
                    </div>

                    @if ($history->count() > 0)
                        <div class="timeline">
                            @foreach ($history as $log)
                                @php
                                    $icon = 'fa-check';
                                    $class = 'status-success';
                                    $label = 'Berhasil Input';
                                    $msg = 'Menambahkan ' . $log->jenis_ikan . ' sebesar ' . number_format($log->berat, 1) . ' KG';

                                    if ($log->status === 'Ditolak') {
                                        $icon = 'fa-times';
                                        $class = 'status-danger';
                                        $label = 'Gagal Input';
                                        $msg = 'Gagal menambahkan ' . $log->jenis_ikan . ' sebesar ' . number_format($log->berat, 1) . ' KG';
                                    } elseif ($log->status === 'Menunggu Validasi') {
                                        $icon = 'fa-paper-plane';
                                        $class = 'status-pending';
                                        $label = 'Menunggu Validasi';
                                        $msg = 'Mengirim data ' . $log->jenis_ikan . ' ' . number_format($log->berat, 1) . ' KG';
                                    } elseif ($log->status === 'Draft') {
                                        $icon = 'fa-file-alt';
                                        $class = 'status-draft';
                                        $label = 'Draft Disimpan';
                                        $msg = 'Menyimpan draft ' . $log->jenis_ikan . ' ' . number_format($log->berat, 1) . ' KG';
                                    }
                                @endphp
                                <div class="timeline-card">
                                    <div class="timeline-icon-box {{ $class }}">
                                        <i class="fas {{ $icon }}"></i>
                                    </div>
                                    <div class="timeline-details">
                                        <h4 style="display: flex; justify-content: space-between; align-items: center;">
                                            <span>{{ $label }}</span>
                                            @if ($log->status === 'Ditolak')
                                                <a href="javascript:void(0)" onclick="openRevisiModal({{ $log->id }}, '{{ $log->jenis_ikan }}', '{{ $log->nama_nelayan }}', '{{ $log->nama_pembeli }}', {{ $log->berat }}, {{ $log->harga_jual }}, '{{ addslashes($log->catatan) }}')" style="color: #ef4444; font-size: 11px; text-decoration: none; font-weight: 700; margin-left: 8px;">Perbaiki Sekarang &gt;</a>
                                            @endif
                                        </h4>
                                        <p>{{ $msg }}</p>
                                    </div>
                                    <span class="timeline-time">
                                        {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div style="margin-top: 25px;">
                            {{ $history->links('pagination.custom') }}
                        </div>
                    @else
                        <div style="text-align: center; padding: 40px 0; color: #94a3b8;">
                            <i class="fas fa-folder-open" style="font-size: 40px; margin-bottom: 12px; opacity: 0.5;"></i>
                            <p>Belum ada riwayat aktivitas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Form Revisi -->
    <div id="revisiModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                Revisi Laporan: <span id="revisiJenisIkanTitle"></span>
                <button class="close-btn" onclick="closeRevisiModal()">&times;</button>
            </div>
            
            <div style="background: #fef2f2; padding: 15px 25px; border-bottom: 1px solid #fee2e2; color: #991b1b; font-size: 13.5px;" id="modalRejectionNoteBox">
                <strong>Catatan Penolakan:</strong> <span id="modalRejectionNote"></span>
            </div>

            <form action="" method="POST" id="revisiForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rev_nama_nelayan">Nama Nelayan</label>
                        <input type="text" name="nama_nelayan" id="rev_nama_nelayan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="rev_nama_pembeli">Nama Pembeli</label>
                        <input type="text" name="nama_pembeli" id="rev_nama_pembeli" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="rev_jenis_ikan">Jenis Ikan</label>
                        <select name="jenis_ikan" id="rev_jenis_ikan" class="form-control" required>
                            @foreach ($ikanList as $ikanName)
                                <option value="{{ $ikanName }}">{{ $ikanName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="rev_berat">Jumlah Berat (KG)</label>
                        <input type="number" name="berat" id="rev_berat" step="0.01" min="0.01" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="rev_harga_jual">Harga Jual Total (Rp)</label>
                        <input type="number" name="harga_jual" id="rev_harga_jual" min="0" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeRevisiModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Revisi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRevisiModal(id, jenisIkan, nelayan, pembeli, berat, hargaJual, catatan) {
            document.getElementById('revisiJenisIkanTitle').textContent = jenisIkan;
            document.getElementById('modalRejectionNote').textContent = catatan || 'Tidak ada catatan.';
            
            document.getElementById('rev_nama_nelayan').value = nelayan;
            document.getElementById('rev_nama_pembeli').value = pembeli;
            document.getElementById('rev_jenis_ikan').value = jenisIkan;
            document.getElementById('rev_berat').value = berat;
            document.getElementById('rev_harga_jual').value = hargaJual;
            
            // Set form post action URL dynamically
            document.getElementById('revisiForm').action = '/jururekap/revisi/' + id;
            
            document.getElementById('revisiModal').style.display = 'flex';
        }

        function closeRevisiModal() {
            document.getElementById('revisiModal').style.display = 'none';
        }

        // Close modal when clicking outside content area
        window.onclick = function(event) {
            const modal = document.getElementById('revisiModal');
            if (event.target === modal) {
                closeRevisiModal();
            }
        }

        // Show Premium SweetAlert popups on redirect notifications
        @if (session('success'))
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
                    <div class="swal2-custom-text">{{ session('success') }}</div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Selesai',
                buttonsStyling: false,
                customClass: {
                    popup: 'premium-swal-popup',
                    confirmButton: 'premium-swal-btn'
                }
            });
        @endif

        @if (session('error'))
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
                    <div class="swal2-custom-text">{{ session('error') }}</div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Tutup',
                buttonsStyling: false,
                customClass: {
                    popup: 'premium-swal-popup',
                    confirmButton: 'premium-swal-btn premium-swal-btn-danger'
                }
            });
        @endif

        @if (isset($errors) && $errors->any())
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
                    <div class="swal2-custom-text">{!! implode("<br>", $errors->all()) !!}</div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Perbaiki',
                buttonsStyling: false,
                customClass: {
                    popup: 'premium-swal-popup',
                    confirmButton: 'premium-swal-btn premium-swal-btn-warning'
                }
            });
        @endif
    </script>
</body>

</html>
