<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPETANG - Sistem Informasi Pencatatan Hasil Tangkap</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Leaflet Map CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <!-- Leaflet Map JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background: white;
        }

        /* Navigation */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav .logo {
            font-weight: 700;
            font-size: 24px;
            color: #1a4d7d;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 40px;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #1a7fbb;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.45) 0%, rgba(0, 0, 0, 0.45) 100%),
                url('/images/Container.png') no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 100px 50px;
            text-align: left;
            min-height: 600px;
            display: flex;
            align-items: center;
        }

        .hero-content {
            max-width: 600px;
        }

        .hero h1 {
            font-size: 64px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .hero h2 {
            font-size: 48px;
            font-weight: 300;
            margin-bottom: 40px;
            line-height: 1.2;
            color: #b3d9ff;
        }

        .hero p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 16px;
            display: inline-block;
        }

        .btn-primary {
            background: white;
            color: #1a4d7d;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: white;
            color: #1a4d7d;
        }

        /* Stats Section */
        .stats {
            display: flex;
            justify-content: space-around;
            padding: 40px 50px;
            background: #f8f9fa;
            gap: 20px;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
            flex: 1;
            min-width: 200px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #1a7fbb;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
        }

        /* Section Content */
        .section {
            padding: 60px 50px;
        }

        .section h2 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #1a4d7d;
        }

        .section p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin-bottom: 40px;
        }

        /* Features Grid */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature {
            padding: 30px;
            border-radius: 10px;
            background: #f8f9fa;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 36px;
            color: #1a7fbb;
            margin-bottom: 15px;
        }

        .feature h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #1a4d7d;
        }

        .feature p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }

        /* Coverage Section */
        .coverage {
            background: #1a4d7d;
            color: white;
            padding: 60px 50px;
        }

        .coverage h2 {
            color: white;
            margin-bottom: 40px;
        }

        .coverage-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .coverage-item {
            padding: 20px;
            border-left: 4px solid #1a7fbb;
            padding-left: 20px;
        }

        .coverage-item h4 {
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .coverage-item p {
            font-size: 14px;
            opacity: 0.9;
        }

        .coverage-map {
            padding: 0;
        }

        .coverage-map h4 {
            color: white;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .map-card {
            background: linear-gradient(180deg, #eaf4ff 0%, #ffffff 100%);
            border-radius: 18px;
            min-height: 280px;
            position: relative;
            overflow: hidden;
            box-shadow: inset 0 0 0 1px rgba(15, 23, 42, 0.03);
            height: 280px;
        }

        .map-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 25%, rgba(13, 37, 64, 0.12), transparent 14%),
                radial-gradient(circle at 72% 35%, rgba(59, 130, 246, 0.11), transparent 12%),
                radial-gradient(circle at 50% 70%, rgba(90, 121, 213, 0.14), transparent 18%);
            z-index: 0;
        }

        #mapid {
            height: 100%;
            position: relative;
            z-index: 1;
            border-radius: 18px;
        }

        .map-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            z-index: 1;
        }

        .map-dot {
            position: absolute;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #0d2640;
            box-shadow: 0 0 0 6px rgba(13, 37, 64, 0.12);
        }

        .map-dot.dot-1 {
            top: 32%;
            left: 28%;
        }

        .map-dot.dot-2 {
            top: 54%;
            left: 64%;
        }

        .map-dot.dot-3 {
            top: 68%;
            left: 44%;
        }

        /* CTA Section */
        .cta {
            padding: 80px 50px;
            background: linear-gradient(135deg, #1a4d7d 0%, #1a7fbb 100%);
            color: white;
            text-align: center;
        }

        .cta h2 {
            color: white;
            font-size: 40px;
            margin-bottom: 20px;
        }

        .cta p {
            color: white;
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto 30px;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-light {
            background: white;
            color: #1a4d7d;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 10px 28px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline:hover {
            background: white;
            color: #1a4d7d;
        }

        /* Footer */
        footer {
            background: #0d2640;
            color: white;
            padding: 40px 50px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-section h4 {
            margin-bottom: 15px;
            font-size: 16px;
        }

        .footer-section p {
            font-size: 14px;
            opacity: 0.8;
            line-height: 1.6;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section a {
            color: #b3d9ff;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-section a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            text-align: center;
            font-size: 14px;
            opacity: 0.8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            nav {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            nav ul {
                gap: 20px;
                flex-wrap: wrap;
            }

            .hero {
                padding: 50px 20px;
                min-height: auto;
            }

            .hero h1 {
                font-size: 40px;
            }

            .hero h2 {
                font-size: 28px;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .section {
                padding: 40px 20px;
                padding: 30px 20px;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">SIPETANG</div>
        <ul>
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#layanan">Layanan</a></li>
            <li><a href="#statistik">Statistik</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="hero-content">
            <h1>SIPETANG</h1>
            <h2>Sistem Informasi Pencatatan Hasil Tangkap</h2>
            <p>Sistem Pelaporan Hasil Tangkapan Resmi: Ruang terkurasi untuk dokumentasi data pendaratan ikan secara
                presisi guna menjamin validitas aset produksi perikanan tangkap Kabupaten Subang.</p>
            <div class="hero-buttons">
                <a href="/login" class="btn btn-primary">Akses Portal</a>
                <a href="#layanan" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats">
        <div class="stat-item">
            <div class="stat-number">15,2k</div>
            <div class="stat-label">HASIL TANGKAPAN</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">8</div>
            <div class="stat-label">TPI TERDAFTAR</div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section" id="layanan">
        <h2>Dinas Perikanan Kabupaten Subang</h2>
        <p>SIPETANG hadir sebagai solusi digital terpadu untuk mendukung modernisasi pengelolaan perikanan di Kabupaten Subang secara efektif, transparan, dan berkelanjutan.</p>

        <div class="features">
            <div class="feature">
                <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                <h3>Analisis Statistik Real-time</h3>
                <p>Pantau perkembangan data perikanan secara langsung melalui dashboard statistik interaktif yang cepat, akurat, dan mudah dipahami.</p>
            </div>
            <div class="feature">
                <div class="feature-icon"><i class="fas fa-file-pdf"></i></div>
                <h3>Pelaporan Otomatis</h3>
                <p>Permudah proses administrasi dengan sistem pelaporan otomatis yang terintegrasi dan sesuai standar pelaporan instansi pemerintah.</p>
            </div>
        </div>
    </section>

    <!-- Coverage Section -->
    <section class="coverage" id="statistik">
        <h2>Sebaran TPI</h2>
        <div class="coverage-grid">
            <div>
                <div class="coverage-item">
                    <h4><span style="color: #1a7fbb;">01</span> Blanakan</h4>
                    <p>Lokasi pendaratan ikan terbesar dengan volume produksi perikanan tertinggi.</p>
                </div>
                <div class="coverage-item">
                    <h4><span style="color: #1a7fbb;">02</span> Pondok Bali</h4>
                    <p>Lokasi pandi pemberdayaan teknologi melalui tradisional dan modernisasi pesce.</p>
                </div>
                <div class="coverage-item">
                    <h4><span style="color: #1a7fbb;">03</span> Mayangan</h4>
                    <p>Lokasi dengan distribusi hasil distribusi dasar laut untuk pasar regional jawa barat.</p>
                </div>
            </div>
            <div class="coverage-map">
                <h4>Peta Sebaran TPI</h4>
                <div class="map-card">
                    <div id="mapid"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="kontak">
        <h2>Media Sosial Kami</h2>
        <p>Ikuti media sosial Dinas Perikanan Kabupaten Subang untuk mendapatkan informasi terbaru, layanan bantuan, serta perkembangan data maritim Kabupaten Subang secara cepat dan transparan.</p>
        <div class="cta-buttons">
            <a href="https://wa.me/6282320455264" class="btn-outline"><i class="fab fa-whatsapp"></i> Hubungi
                Helpdesk</a>
            <a href="https://www.instagram.com/dinasperikanansubang?igsh=MWsxcWd5cjdiY2pzcg==" class="btn-outline"><i
                    class="fab fa-instagram"></i> Instagram</a>
            <a href="https://www.youtube.com/@dinasperikanankabupatensub2885" class="btn-outline"><i
                    class="fab fa-youtube"></i> YouTube</a>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>SIPETANG</h4>
                <p>Portal Administrasi Terpadu Dinas Perikanan Kabupaten Subang.</p>
                <p>Menciptakan transparansi data untuk keberlanjutan perikanan tangkap.</p>
            </div>
            <div class="footer-section">
                <h4>KONTAK KAMI</h4>
                <p><i class="fas fa-map-marker-alt"></i> Jl. A. Nata Sukarya No. 28, Subang, Jawa Barat, 41211</p>
                <p><i class="fas fa-phone"></i> (0260) 411325</p>
                <p><i class="fas fa-envelope"></i> kabupatensubangdinasperikanan@gmail.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Dinas Perikanan Kabupaten Subang. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Initialize Leaflet Map - Kabupaten Subang
        const map = L.map('mapid').setView([-6.35, 107.85], 11);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);

        // Define TPI locations in Kabupaten Subang
        const tpiLocations = [{
                name: 'Blanakan',
                lat: -6.27,
                lng: 107.87,
                info: 'Lokasi pendaratan ikan terbesar dengan volume produksi perikanan tertinggi.'
            },
            {
                name: 'Pondok Bali',
                lat: -6.35,
                lng: 107.88,
                info: 'Lokasi pemberdayaan teknologi melalui tradisional dan modernisasi pesce.'
            },
            {
                name: 'Mayangan',
                lat: -6.42,
                lng: 107.82,
                info: 'Lokasi dengan distribusi hasil dasar laut untuk pasar regional jawa barat.'
            }
        ];

        // Add markers for each TPI
        tpiLocations.forEach((location, index) => {
            const marker = L.marker([location.lat, location.lng]).addTo(map);
            marker.bindPopup(`
                <div style="font-weight: bold; color: #1a4d7d; margin-bottom: 5px;">
                    ${index + 1}. ${location.name}
                </div>
                <div style="font-size: 12px; color: #666;">
                    ${location.info}
                </div>
            `);
        });
    </script>
</body>

</html>
