<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SIPETANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Profile Card */
        .profile-container {
            width: 100%;
            max-width: 650px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
            overflow: hidden;
            margin-top: 20px;
        }

        .profile-banner {
            background: linear-gradient(135deg, #0a3b99 0%, #1a4d7d 100%);
            height: 140px;
            position: relative;
        }

        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: -70px;
            padding-bottom: 25px;
            border-bottom: 1px solid #f1f5f9;
            position: relative;
            z-index: 10;
        }

        .avatar-container {
            position: relative;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background: #f8fafc;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
        }

        .profile-role {
            font-size: 12.5px;
            font-weight: 700;
            text-transform: uppercase;
            color: #2563eb;
            background: #eff6ff;
            padding: 4px 12px;
            border-radius: 20px;
            margin-top: 8px;
            letter-spacing: 0.8px;
        }

        /* Profile details list */
        .profile-body {
            padding: 35px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            padding: 18px 20px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 14px;
            margin-bottom: 15px;
            gap: 20px;
            transition: all 0.2s ease;
        }

        .detail-item:hover {
            border-color: #cbd5e1;
            background: #f1f5f9;
        }

        .detail-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #eff6ff;
            color: #0a3b99;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 14.5px;
            font-weight: 600;
            color: #1e293b;
            margin-top: 3px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            display: inline-block;
            margin-right: 6px;
        }

        /* Action Buttons */
        .action-section {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-orange {
            background: #f16301;
            color: white;
            box-shadow: 0 4px 14px rgba(241, 99, 1, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-orange:hover {
            background: #d95401;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(241, 99, 1, 0.28);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        /* Photo upload form styling */
        .upload-form {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            padding: 15px;
            border-radius: 14px;
        }

        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }

        .alert {
            width: 100%;
            max-width: 650px;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
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

        .alert-error {
            background: #fef2f2;
            color: #721c24;
            border-color: #fca5a5;
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @include('components.sidebar-menu')

    <main class="main-content">
        <div style="margin-bottom: 20px; text-align: center;">
            <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Profil Saya</h1>
            <p style="font-size: 14.5px; color: #64748b;">Informasi data keanggotaan Juru Rekap Anda pada sistem SIPETANG.</p>
        </div>

        <div class="profile-container">
            <div class="profile-banner"></div>
            
            <div class="profile-header">
                <div class="avatar-container">
                    @php
                        $user = Auth::user();
                        if ($user->foto_profil) {
                            $avatarUrl = asset('storage/profil/' . $user->foto_profil);
                        } else {
                            $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($user->nama) . '&background=002D62&color=fff&size=128';
                        }
                    @endphp
                    <img src="{{ $avatarUrl }}" alt="Foto Profil" class="avatar-img">
                </div>
                <div class="profile-name">{{ $user->nama }}</div>
                <div class="profile-role">Juru Rekap</div>
            </div>

            <div class="profile-body">
                <!-- Photo Upload Form -->
                <form action="{{ route('jururekap.profile.update_foto') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                    @csrf
                    <div style="flex: 1;">
                        <span style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">UBAH FOTO PROFIL</span>
                        <span style="font-size: 11px; color: #94a3b8; display: block;">Format JPEG, PNG, JPG (Maks. 2MB)</span>
                    </div>
                    <div class="upload-btn-wrapper">
                        <button type="button" class="btn btn-secondary" style="padding: 8px 15px; font-size: 12px; width: auto; gap: 4px;">
                            <i class="fas fa-camera"></i> Pilih Foto
                        </button>
                        <input type="file" name="foto" accept="image/*" onchange="this.form.submit()">
                    </div>
                </form>

                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">ID Juru Rekap</div>
                        <div class="detail-value">{{ $user->no_induk ?? '-' }}</div>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Nomor Telepon</div>
                        <div class="detail-value">{{ $user->no_telepon ?? '-' }}</div>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Wilayah Tugas</div>
                        <div class="detail-value">{{ $user->wilayah ?? '-' }}</div>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Status Akun</div>
                        <div class="detail-value" style="display: flex; align-items: center;">
                            @php
                                $status = $user->status_akun ?? ($user->is_active ? 'Aktif' : 'Nonaktif');
                            @endphp
                            <span class="status-dot" style="background: {{ strtolower($status) === 'aktif' ? '#10b981' : '#ef4444' }};"></span>
                            Status: {{ $status }}
                        </div>
                    </div>
                </div>

                <div class="action-section">
                    <form id="profile-logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="button" class="btn btn-orange" onclick="confirmProfileLogout(event)">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        function confirmProfileLogout(event) {
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
                    <div class="swal2-custom-title">Konfirmasi Keluar</div>
                    <div class="swal2-custom-text">Apakah Anda yakin ingin keluar dari akun SIPETANG?</div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'premium-swal-popup',
                    confirmButton: 'premium-swal-btn premium-swal-btn-danger',
                    cancelButton: 'premium-swal-btn premium-swal-btn-secondary'
                },
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('profile-logout-form').submit();
                }
            });
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
