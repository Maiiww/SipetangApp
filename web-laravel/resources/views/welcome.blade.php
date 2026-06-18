{{-- 📁 File: resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPETANG - Dinas Perikanan Kabupaten Subang</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --sipetang-navy: #0B2D6E;
            --sipetang-light-blue: #E0E7FF;
            --sipetang-ice-blue: #b3d4fc;
            --sipetang-orange: #F5A623;
            --sipetang-bg: #F8FAFC;
            --sipetang-text: #1E293B;
            --sipetang-muted: #64748B;
        }

        html {
            scroll-behavior: smooth;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--sipetang-bg); 
            color: var(--sipetang-text); 
            overflow-x: hidden;
        }
        
        .section-padding { padding: 100px 0; }

        /* HERO SECTION */
        .hero-section {
            background-image: url('{{ asset("assets/../../images/Container.png") }}');
            background-color: var(--sipetang-navy); 
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover; 
            padding: 120px 0;
            color: white;
            min-height: 85vh;
            display: flex;
            align-items: center;
            position: relative;
        }

        .text-shadow-custom { text-shadow: 2px 2px 8px rgba(0,0,0,0.7); }
        
        /* BENTO CARDS */
        .bento-card { 
            background: white; 
            border-radius: 20px; 
            padding: 2.5rem; 
            height: 100%; 
            border: 1px solid #E2E8F0; 
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.4s; 
        }

        .bento-card:hover { 
            transform: translateY(-6px); 
            box-shadow: 0 20px 40px rgba(11, 45, 110, 0.08); 
            border-color: rgba(11, 45, 110, 0.15);
        }

        .bento-card .rounded-circle i {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .bento-card:hover .rounded-circle i {
            transform: scale(1.2) rotate(6deg);
        }

        .bento-dark { 
            background: var(--sipetang-navy); 
            color: white; 
            border: none; 
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .bento-dark:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px rgba(11, 45, 110, 0.15);
        }
        
        /* TUPOKSI CARD (Elegan & Dinamis) */
        .tupoksi-card {
            background-color: white;
            border-left: 4px solid var(--sipetang-orange);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            height: 100%;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .tupoksi-card:hover {
            background-color: var(--sipetang-light-blue);
            border-left: 4px solid var(--sipetang-navy);
            color: var(--sipetang-text) !important;
            transform: translateX(6px);
            box-shadow: 0 8px 20px rgba(11, 45, 110, 0.06);
        }
        .tupoksi-card:hover h6, .tupoksi-card:hover i { color: var(--sipetang-navy) !important; }
        .tupoksi-card i {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .tupoksi-card:hover i {
            transform: scale(1.25);
        }

        /* TPI AKTIF CARD (Efek Zoom Gambar Premium) */
        .tpi-card {
            background-color: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.4s;
        }
        .tpi-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(11, 45, 110, 0.12);
            border-color: rgba(11, 45, 110, 0.1);
        }
        .tpi-card .tpi-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            display: block;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .tpi-card:hover .tpi-img {
            transform: scale(1.08);
        }
        .tpi-card .tpi-badge {
            display: inline-block;
            background-color: var(--sipetang-light-blue);
            color: var(--sipetang-navy);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 50px;
            margin-bottom: 6px;
            transition: background-color 0.3s, color 0.3s;
        }
        .tpi-card:hover .tpi-badge {
            background-color: var(--sipetang-orange);
            color: white;
        }

        /* FAQ & Accordion Modernization */
        .accordion-item {
            border: 1px solid #E2E8F0 !important;
            margin-bottom: 12px;
            border-radius: 12px !important;
            overflow: hidden;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .accordion-item:hover {
            box-shadow: 0 8px 20px rgba(11, 45, 110, 0.04) !important;
            border-color: rgba(11, 45, 110, 0.15) !important;
        }
        .accordion-button { 
            font-weight: 700; 
            color: var(--sipetang-text); 
            box-shadow: none !important; 
            padding: 1.25rem 1.5rem;
            transition: background-color 0.3s, color 0.3s;
        }
        .accordion-button:not(.collapsed) { 
            color: var(--sipetang-navy); 
            background-color: var(--sipetang-light-blue); 
        }

        /* NAVBAR GLOW EFFECT */
        .navbar-nav .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: var(--sipetang-orange);
            transition: width 0.3s ease, left 0.3s ease;
        }
        .navbar-nav .nav-link:hover::after {
            width: 80%;
            left: 10%;
        }

        /* HERO ELEMENTS ANIMATIONS */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .delay-100 { animation-delay: 0.15s; }
        .delay-200 { animation-delay: 0.3s; }
        .delay-300 { animation-delay: 0.45s; }

        /* BUTTON PREMIUM STATES */
        #btn-masuk-dashboard {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.3s, color 0.3s !important;
        }
        #btn-masuk-dashboard:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 24px rgba(255, 255, 255, 0.15), 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            background-color: #f8fafc !important;
        }
        #btn-pelajari-sistem {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.3s, border-color 0.3s, color 0.3s !important;
        }
        #btn-pelajari-sistem:hover {
            transform: translateY(-3px);
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.8) !important;
            color: #ffffff !important;
        }

        /* SCROLL REVEAL ANIMATION */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
            will-change: opacity, transform;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        /* Stagger helper classes */
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        /* PAGE TRANSITION OVERLAY */
        .transition-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99999;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .transition-overlay .panel {
            position: absolute;
            width: 50%;
            height: 100%;
            background: linear-gradient(135deg, #04255f 0%, #0b3b80 100%);
            transition: transform 0.6s cubic-bezier(0.85, 0, 0.15, 1);
        }

        .transition-overlay .panel-left {
            left: 0;
            transform: translateX(-100%);
        }

        .transition-overlay .panel-right {
            right: 0;
            transform: translateX(100%);
        }

        .transition-overlay.active {
            pointer-events: all;
        }

        .transition-overlay.active .panel-left {
            transform: translateX(0);
        }

        .transition-overlay.active .panel-right {
            transform: translateX(0);
        }

        .transition-content {
            position: relative;
            z-index: 100000;
            opacity: 0;
            transform: scale(0.8);
            transition: opacity 0.4s ease, transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            transition-delay: 0.4s;
            text-align: center;
            color: white;
        }

        .transition-overlay.active .transition-content {
            opacity: 1;
            transform: scale(1);
        }

        .transition-logo-wrapper {
            position: relative;
            width: 110px;
            height: 110px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .transition-logo-circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-top: 3px solid var(--sipetang-orange);
            border-radius: 50%;
            animation: spin-transition 1s linear infinite;
        }

        .transition-logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            background-color: white;
            padding: 4px;
            box-shadow: 0 8px 24px rgba(245, 166, 35, 0.35);
        }

        @keyframes spin-transition {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .transition-text {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 10px;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            color: #ffffff;
        }

        .transition-subtext {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-top: 6px;
            letter-spacing: 1px;
            color: var(--sipetang-light-blue);
        }
    </style>
</head>
<body>

    @include('layouts.header')

    <!-- ── 1. SECTION: BERANDA ── -->
    <section class="hero-section" id="beranda">
        <div class="container relative-z">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Tulisan SIPETANG Putih -->
                    <h1 class="hero-title fw-bold text-shadow-custom text-white animate-fade-in-up" style="font-size: 4.5rem; letter-spacing: 1px; margin-bottom: 0.5rem;">
                        SIPETANG
                    </h1>
                    <!-- Tulisan Kepanjangan Biru Soft -->
                    <h2 class="fw-light text-shadow-custom animate-fade-in-up delay-100" style="font-size: 2.2rem; color: var(--sipetang-ice-blue); margin-bottom: 1.5rem; line-height: 1.3;">
                        Sistem Informasi Pencatatan<br>Hasil Tangkap
                    </h2>
                    <!-- Deskripsi Diperkecil & Transparan -->
                    <p class="hero-subtitle text-shadow-custom fw-normal animate-fade-in-up delay-200" style="font-size: 1rem; margin-bottom: 3rem; max-width: 650px; line-height: 1.7; color: rgba(255, 255, 255, 0.8);">
                        Platform digital untuk pencatatan, pengelolaan, dan pelaporan data hasil tangkap ikan secara akurat dan terintegrasi guna mendukung pengambilan keputusan data perikanan tangkap di Kabupaten Subang.
                    </p>
                    <div class="d-flex gap-3 flex-wrap animate-fade-in-up delay-300">
                        <!-- Button Background Putih -->
                        <a href="{{ url('/login') }}" id="btn-masuk-dashboard" class="btn px-4 py-3 fw-bold border-0 shadow" style="background-color: white; color: var(--sipetang-navy); border-radius: 8px;">
                            <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Dashboard
                        </a>
                        <!-- Button Download APK -->
                        <a href="{{ asset('apk/sipetang-v1.1.0.apk') }}" id="btn-download-apk" class="btn px-4 py-3 fw-bold shadow-sm" style="background-color: #3DDC84; color: white; border: none; border-radius: 8px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='translateY(0)';">
                            <i class="fab fa-android me-2" style="font-size: 1.1rem;"></i> Download APK Android
                        </a>
                        <a href="#faq" id="btn-pelajari-sistem" class="btn px-4 py-3 fw-bold shadow-sm" style="background-color: rgba(0,0,0,0.3); color: white; border: 1px solid rgba(255,255,255,0.4); border-radius: 8px;">
                            Pelajari Sistem
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── 2. SECTION: TENTANG (Deskripsi, Tupoksi & TPI Aktif) ── -->
    <section class="section-padding" id="tentang">
        <div class="container">
            <h2 class="fw-bold mb-5 text-center reveal" style="color: var(--sipetang-navy);">Mengenai Sistem & Instansi</h2>
            
            <!-- Deskripsi Menjurus ke Bidang Tangkap -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10">
                    <!-- .bento-card dihapus untuk mematikan height 100% dan padding berlebih, 
                         diganti dengan p-4 p-md-5 agar kotak pas dengan jumlah teks -->
                    <div class="bento-dark text-center rounded-4 shadow-sm p-4 p-md-5 reveal">
                        <p class="opacity-75 mb-0 fs-5 text-white" style="line-height: 1.8;">
                            Bidang Perikanan Tangkap adalah bagian dari Dinas Perikanan yang bertugas mengelola kegiatan penangkapan ikan dan hasil laut. SIPETANG dirancang untuk dinas perikanan khususnya <strong>Bidang Penangkapan</strong> untuk mengelola, memvalidasi, dan mendokumentasikan setiap alur distribusi data produksi guna menjamin akurasi statistik dan menunjang tata kelola perikanan yang modern dan terpusat.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 7 Poin Tupoksi (Sesuai Peraturan - Fungsi Bidang Perikanan Tangkap) -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h4 class="fw-bold mb-4 reveal" style="color: var(--sipetang-navy);"><i class="fas fa-list-check me-2 text-primary"></i> Tugas Pokok & Fungsi (Tupoksi)</h4>
                    
                    <!-- Menggunakan col-12 secara merata agar tersusun ke bawah (List View) -->
                    <div class="row g-3">
                        <div class="col-12 reveal">
                            <div class="tupoksi-card">
                                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-clipboard-list text-primary me-2"></i> Penyusunan Program Kerja</h6>
                                <p class="text-muted small mb-0">Penyusunan program kerja Bidang Perikanan Tangkap sebagai acuan pelaksanaan kegiatan operasional tahunan.</p>
                            </div>
                        </div>
                        <div class="col-12 reveal reveal-delay-1">
                            <div class="tupoksi-card">
                                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-ship text-primary me-2"></i> Pengelolaan Sarana Penangkapan Ikan</h6>
                                <p class="text-muted small mb-0">Pelaksanaan penyiapan koordinasi, fasilitasi, perumusan, dan pelaksanaan kebijakan pengelolaan sarana penangkapan ikan.</p>
                            </div>
                        </div>
                        <div class="col-12 reveal reveal-delay-2">
                            <div class="tupoksi-card">
                                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-warehouse text-primary me-2"></i> Pengelolaan & Penyelenggaraan TPI</h6>
                                <p class="text-muted small mb-0">Pelaksanaan penyiapan koordinasi, fasilitasi, perumusan, dan pelaksanaan kebijakan pengelolaan serta penyelenggaraan Tempat Pelelangan Ikan (TPI).</p>
                            </div>
                        </div>
                        <div class="col-12 reveal reveal-delay-3">
                            <div class="tupoksi-card">
                                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-users text-primary me-2"></i> Pemberdayaan Nelayan</h6>
                                <p class="text-muted small mb-0">Pelaksanaan penyiapan koordinasi, fasilitasi, perumusan, dan pelaksanaan kebijakan pengelolaan pemberdayaan nelayan.</p>
                            </div>
                        </div>
                        <div class="col-12 reveal reveal-delay-4">
                            <div class="tupoksi-card">
                                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-chart-line text-primary me-2"></i> Monitoring & Evaluasi Kegiatan</h6>
                                <p class="text-muted small mb-0">Pelaksanaan monitoring dan evaluasi pelaksanaan kegiatan di Bidang Perikanan Tangkap.</p>
                            </div>
                        </div>
                        <div class="col-12 reveal">
                            <div class="tupoksi-card">
                                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-file-signature text-primary me-2"></i> Telaahan Staf untuk Kepala Dinas</h6>
                                <p class="text-muted small mb-0">Penyampaian telaahan staf sebagai bahan pertimbangan pengambilan kebijakan Kepala Dinas.</p>
                            </div>
                        </div>
                        <div class="col-12 reveal reveal-delay-1">
                            <div class="tupoksi-card">
                                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-file-alt text-primary me-2"></i> Penyusunan Laporan Pelaksanaan Tugas</h6>
                                <p class="text-muted small mb-0">Penyusunan laporan hasil pelaksanaan tugas di Bidang Perikanan Tangkap secara berkala.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- TPI Aktif yang Terhubung -->
            <div class="row justify-content-center mt-5 pt-4">
                <div class="col-lg-10">
                    <div class="reveal">
                        <h4 class="fw-bold mb-2" style="color: var(--sipetang-navy);"><i class="fas fa-water me-2 text-primary"></i> TPI Aktif yang Terhubung</h4>
                        <p class="text-muted mb-4">Terdapat <strong>8 Tempat Pelelangan Ikan (TPI)</strong> percontohan yang telah terintegrasi dan aktif melaporkan data produksi melalui SIPETANG.</p>
                    </div>

                    <div class="row g-4">
                        <!-- TPI 1 -->
                        <div class="col-md-6 col-lg-3 reveal">
                            <div class="tpi-card h-100">
                                <img src="{{ asset('assets/../../images/patimban.png') }}" alt="TPI Patimban" class="tpi-img">
                                <div class="p-3">
                                    <span class="tpi-badge">KUD Mina Misaya Guna</span>
                                    <h6 class="fw-bold text-dark mb-1">TPI Patimban</h6>
                                    <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt text-primary me-1"></i> Kec. Pusakanagara</p>
                                </div>
                            </div>
                        </div>
                        <!-- TPI 2 -->
                        <div class="col-md-6 col-lg-3 reveal reveal-delay-1">
                            <div class="tpi-card h-100">
                                <img src="{{ asset('assets/../../images/genteng.png') }}"  class="tpi-img" alt="TPI Genteng">
                                <div class="p-3">
                                    <span class="tpi-badge">KUD Mina Tanjung Mataram</span>
                                    <h6 class="fw-bold text-dark mb-1">TPI Genteng</h6>
                                    <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt text-primary me-1"></i> Kec. Pusakanagara</p>
                                </div>
                            </div>
                        </div>
                        <!-- TPI 3 -->
                        <div class="col-md-6 col-lg-3 reveal reveal-delay-2">
                            <div class="tpi-card h-100">
                                <img src="{{ asset('assets/../../images/mayangan.png') }}" class="tpi-img" alt="TPI Mayangan">
                                <div class="p-3">
                                    <span class="tpi-badge">KUD Mina Saluyu Mulya</span>
                                    <h6 class="fw-bold text-dark mb-1">TPI Mayangan</h6>
                                    <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt text-primary me-1"></i> Kec. Legonkulon</p>
                                </div>
                            </div>
                        </div>
                        <!-- TPI 4 -->
                        <div class="col-md-6 col-lg-3 reveal reveal-delay-3">
                            <div class="tpi-card h-100">
                                <img src="{{ asset('assets/../../images/cirewang.png') }}" class="tpi-img" alt="TPI Cirewang">
                                <div class="p-3">
                                    <span class="tpi-badge">KUD Mina Sinar Agung</span>
                                    <h6 class="fw-bold text-dark mb-1">TPI Cirewang</h6>
                                    <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt text-primary me-1"></i> Kec. Legonkulon</p>
                                </div>
                            </div>
                        </div>
                        <!-- TPI 5 -->
                        <div class="col-md-6 col-lg-3 reveal">
                            <div class="tpi-card h-100">
                                <img src="{{ asset('assets/../../images/muaraciasem.png') }}" class="tpi-img" alt="TPI Muara Ciasem">
                                <div class="p-3">
                                    <span class="tpi-badge">KUD Mina Bahari</span>
                                    <h6 class="fw-bold text-dark mb-1">TPI Muara Ciasem</h6>
                                    <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt text-primary me-1"></i> Kec. Blanakan</p>
                                </div>
                            </div>
                        </div>
                        <!-- TPI 6 -->
                        <div class="col-md-6 col-lg-3 reveal reveal-delay-1">
                            <div class="tpi-card h-100">
                                <img src="{{ asset('assets/../../images/blanakan.png') }}" class="tpi-img" alt="TPI Blanakan">
                                <div class="p-3">
                                    <span class="tpi-badge">KUD Mina Fajar Sidik</span>
                                    <h6 class="fw-bold text-dark mb-1">TPI Blanakan</h6>
                                    <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt text-primary me-1"></i> Kec. Blanakan</p>
                                </div>
                            </div>
                        </div>
                        <!-- TPI 7 -->
                        <div class="col-md-6 col-lg-3 reveal reveal-delay-2">
                            <div class="tpi-card h-100">
                                <img src="{{ asset('assets/../../images/rawameneng.png') }}" class="tpi-img" alt="TPI Rawameneng">
                                <div class="p-3">
                                    <span class="tpi-badge">KUD Mina Karya Baru</span>
                                    <h6 class="fw-bold text-dark mb-1">TPI Rawameneng</h6>
                                    <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt text-primary me-1"></i> Kec. Blanakan</p>
                                </div>
                            </div>
                        </div>
                        <!-- TPI 8 -->
                        <div class="col-md-6 col-lg-3 reveal reveal-delay-3">
                            <div class="tpi-card h-100">
                                <img src="{{ asset('assets/../../images/cilamayagirang.png') }}" class="tpi-img" alt="TPI Cilamaya Girang">
                                <div class="p-3">
                                    <span class="tpi-badge">KUD Mina Jaya Laksana</span>
                                    <h6 class="fw-bold text-dark mb-1">TPI Cilamaya Girang</h6>
                                    <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt text-primary me-1"></i> Kec. Blanakan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── 3. SECTION: LAYANAN (Diperluas menjadi 4 Layanan Profesional) ── -->
    <section class="section-padding bg-white" id="layanan">
        <div class="container">
            <h2 class="fw-bold mb-2 text-center reveal" style="color: var(--sipetang-navy);">Layanan Integrasi Sistem</h2>
            <p class="text-muted text-center mb-5 fs-5 reveal">Fasilitas operasional yang tersedia di dalam infrastruktur SIPETANG.</p>
            
            <div class="row justify-content-center g-4">
                <!-- Layanan 1 -->
                <div class="col-md-6 col-lg-5 reveal">
                    <div class="bento-card p-4 d-flex align-items-start gap-4" style="background-color: var(--sipetang-bg);">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary fs-3"><i class="fas fa-check-double"></i></div>
                        <div>
                            <h5 class="fw-bold text-dark mb-2">Validasi Data Berjenjang</h5>
                            <p class="text-muted mb-0 small">Alur persetujuan input laporan hasil tangkap harian laut secara *real-time*, dikontrol dari petugas lapangan hingga verifikator kedinasan.</p>
                        </div>
                    </div>
                </div>
                <!-- Layanan 2 -->
                <div class="col-md-6 col-lg-5 reveal reveal-delay-1">
                    <div class="bento-card p-4 d-flex align-items-start gap-4" style="background-color: var(--sipetang-bg);">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success fs-3"><i class="fas fa-file-pdf"></i></div>
                        <div>
                            <h5 class="fw-bold text-dark mb-2">Cetak Dokumen Otomatis</h5>
                            <p class="text-muted mb-0 small">Ekstraksi rekapitulasi data harian maupun bulanan ke dalam format dokumen legal PDF dan Excel secara instan tanpa rekap manual.</p>
                        </div>
                    </div>
                </div>
                <!-- Layanan 3 -->
                <div class="col-md-6 col-lg-5 reveal reveal-delay-2">
                    <div class="bento-card p-4 d-flex align-items-start gap-4" style="background-color: var(--sipetang-bg);">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning fs-3"><i class="fas fa-map-marked-alt"></i></div>
                        <div>
                            <h5 class="fw-bold text-dark mb-2">Manajemen Basis Data TPI</h5>
                            <p class="text-muted mb-0 small">Pemantauan sentralisasi data produksi perikanan dari 8 lokasi Tempat Pelelangan Ikan (TPI) percontohan di seluruh pesisir Subang.</p>
                        </div>
                    </div>
                </div>
                <!-- Layanan 4 -->
                <div class="col-md-6 col-lg-5 reveal reveal-delay-3">
                    <div class="bento-card p-4 d-flex align-items-start gap-4" style="background-color: var(--sipetang-bg);">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger fs-3"><i class="fas fa-chart-pie"></i></div>
                        <div>
                            <h5 class="fw-bold text-dark mb-2">Dashboard Rekapitulasi Statistik</h5>
                            <p class="text-muted mb-0 small">Visualisasi grafik angka produksi kelautan yang interaktif untuk mempermudah pimpinan dalam mengambil keputusan strategis pemerintahan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── 4. SECTION: FAQ (Judul di Tengah) ── -->
    <section class="section-padding" id="faq">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <h2 class="fw-bold mb-3" style="color: var(--sipetang-navy);">FAQ (Tanya Jawab)</h2>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-3">Pusat Bantuan</span>
                <p class="text-muted fs-5">Kendala saat mengakses sistem atau bingung mengenai operasional? Temukan jawaban cepat di sini sebelum menghubungi IT Support.</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8 reveal">
                    <div class="accordion shadow-sm" id="accordionFAQ">
                        <div class="accordion-item border-0 border-bottom mb-2 rounded">
                            <h2 class="accordion-header">
                                <button class="accordion-button rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Siapa saja yang dapat mengakses aplikasi SIPETANG?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body text-muted">
                                    SIPETANG adalah sistem perangkat lunak tertutup (SaaS Internal). Hak akses aplikasi ini dikontrol dengan sangat ketat dan hanya diberikan kepada Staf Dinas Perikanan (Bidang Tangkap) dan petugas lapangan TPI percontohan yang terdaftar resmi.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom mb-2 rounded">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Bagaimana alur validasi data hasil tangkapan di sistem ini?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body text-muted">
                                    Data awal diinput oleh petugas TPI setempat. Status data tersebut akan menjadi 'Draft' hingga diverifikasi oleh Admin TPI, dan terakhir divalidasi penuh oleh Verifikator Dinas Perikanan sebelum masuk ke laporan rekapitulasi akhir bulanan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 rounded">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Apa yang harus dilakukan jika saya lupa kata sandi (password)?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body text-muted">
                                    Demi keamanan aset data kelautan, fitur reset kata sandi tidak dapat dilakukan secara mandiri. Silakan hubungi IT Helpdesk melalui tombol WhatsApp di bagian Kontak, dengan menyertakan NIP atau identitas petugas Anda untuk proses verifikasi.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── 5. SECTION: KONTAK & PETA (Iframe Google Maps Asli) ── -->
    <section class="section-padding mb-5 pt-0" id="kontak">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <h2 class="fw-bold" style="color: var(--sipetang-navy);">Kontak Resmi</h2>
                <p class="text-muted fs-6">Pusat layanan informasi dan lokasi geografis administrasi instansi.</p>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-lg-10 reveal">
                    <div class="shadow-sm" style="border-radius: 20px; border: 1px solid #E2E8F0; overflow: hidden; height: 450px; width: 100%;">
                        <iframe 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            scrolling="no" 
                            marginheight="0" 
                            marginwidth="0" 
                            src="https://maps.google.com/maps?q=Dinas%20Perikanan%20Kabupaten%20Subang,%20Jl.%20A.%20Nata%20Sukarya%20No.28,%20Pasirkareumbi,%20Subang&t=&z=16&ie=UTF8&iwloc=&output=embed"
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center g-4">
                <div class="col-lg-10">
                    <div class="row g-4 text-center">
                        <div class="col-md-4 reveal">
                            <div class="bento-card p-4 shadow-sm h-100">
                                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-4" style="width: 70px; height: 70px;">
                                    <i class="fas fa-map-marker-alt fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">Lokasi Dinas</h5>
                                <p class="text-muted small mb-0">Jl. A. Nata Sukarya No. 28,<br>Kabupaten Subang, 41211</p>
                            </div>
                        </div>
                        <div class="col-md-4 reveal reveal-delay-1">
                            <div class="bento-card p-4 shadow-sm h-100">
                                <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-4" style="width: 70px; height: 70px;">
                                    <i class="fas fa-headset fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">Outlet / Hotline</h5>
                                <p class="text-muted small mb-0">(0260) 411325<br>Senin - Jumat (08:00 - 16:00)</p>
                            </div>
                        </div>
                        <div class="col-md-4 reveal reveal-delay-2">
                            <div class="bento-card p-4 shadow-sm h-100">
                                <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle mb-4" style="width: 70px; height: 70px;">
                                    <i class="fas fa-envelope fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">Email</h5>
                                <p class="text-muted small mb-0">dinasperikanan@gmail.com<br>info@subang.go.id</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <!-- Page Transition Overlay -->
    <div class="transition-overlay" id="pageTransitionOverlay">
        <div class="panel panel-left"></div>
        <div class="panel panel-right"></div>
        <div class="transition-content">
            <div class="transition-logo-wrapper">
                <div class="transition-logo-circle"></div>
                <img src="{{ asset('assets/../../images/logo.png') }}" alt="SIPETANG" class="transition-logo">
            </div>
            <div class="transition-text">SIPETANG</div>
            <div class="transition-subtext">Menghubungkan ke Dashboard...</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ── SCROLL REVEAL SCRIPT ── -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const revealEls = document.querySelectorAll('.reveal');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15,
                rootMargin: '0px 0px -50px 0px'
            });

            revealEls.forEach((el) => observer.observe(el));
        });
    </script>

    <!-- ── PAGE TRANSITION SCRIPT ── -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginLinks = document.querySelectorAll('a[href$="/login"], a[href*="login"]');
            const overlay = document.getElementById('pageTransitionOverlay');

            if (overlay) {
                loginLinks.forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetUrl = this.getAttribute('href');

                        // Activate overlay to start sliding panels
                        overlay.classList.add('active');

                        // Redirect after animation completes
                        setTimeout(function() {
                            window.location.href = targetUrl;
                        }, 1000); // 1000ms duration (leaves 400ms after text transition starts)
                    });
                });
            }
        });
    </script>
</body>
</html>