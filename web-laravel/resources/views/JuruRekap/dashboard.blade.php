<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Juru Rekap - SIPETANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js for premium visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #0a3b99 0%, #1a4d7d 100%);
            color: white;
            border-radius: 20px;
            padding: 35px 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(10, 59, 153, 0.15);
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            filter: blur(20px);
        }

        .welcome-banner h1 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .welcome-banner p {
            font-size: 15px;
            opacity: 0.9;
            line-height: 1.6;
            max-width: 600px;
        }

        /* Dashboard Grid Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .dashboard-left {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        /* Stats Cards Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(10, 59, 153, 0.06);
            border-color: rgba(10, 59, 153, 0.1);
        }

        .stat-details h3 {
            font-size: 12px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .stat-details .value {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
        }

        .stat-details .unit {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
            margin-left: 3px;
        }

        .stat-details .subtext {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 5px;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .icon-blue {
            background: #eff6ff;
            color: #0a3b99;
        }

        .icon-orange {
            background: #fff7ed;
            color: #f16301;
        }

        .icon-green {
            background: #f0fdf4;
            color: #10b981;
        }

        /* Card Panels */
        .panel {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid #edf2f7;
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

        /* Weather Section */
        .weather-card {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border: none;
        }

        .weather-card .panel-header {
            border-bottom-color: rgba(255, 255, 255, 0.15);
        }

        .weather-card .panel-header h2,
        .weather-card .panel-header h2 i {
            color: white;
        }

        .weather-main {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .weather-temp {
            font-size: 42px;
            font-weight: 800;
            display: flex;
            align-items: flex-start;
        }

        .weather-info {
            text-align: right;
        }

        .weather-desc {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .weather-wind {
            font-size: 13px;
            opacity: 0.85;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }

        .weather-warning {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 12px;
            line-height: 1.4;
            backdrop-filter: blur(8px);
        }

        .weather-warning.alert-active {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.3);
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        .weather-warning i {
            font-size: 18px;
        }

        /* Activity Table */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            transition: transform 0.2s ease;
        }

        .activity-item:hover {
            transform: translateX(4px);
            background: #f1f5f9;
        }

        .activity-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .fish-avatar {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #e2e8f0;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
        }

        .activity-info h4 {
            font-size: 13.5px;
            font-weight: 700;
            color: #1e293b;
        }

        .activity-info p {
            font-size: 11.5px;
            color: #64748b;
            margin-top: 2px;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
        }

        .badge-draft {
            background: #ffedd5;
            color: #d97706;
        }

        .badge-pending {
            background: #dbeafe;
            color: #2563eb;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .toast-welcome {
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <main class="main-content">
        <!-- Toast Welcome -->
        @if (session('welcome'))
            <div class="welcome-banner toast-welcome" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); margin-bottom: 20px; padding: 20px 30px;">
                <h2 style="font-size: 18px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-check-circle"></i>
                    {{ session('welcome') }}
                </h2>
            </div>
        @endif

        <div class="welcome-banner">
            <h1>Selamat Datang, {{ Auth::user()->nama }}</h1>
            <p>Di Sistem Informasi Pencatatan Hasil Tangkap (SIPETANG). Mewujudkan tata kelola data perikanan Kabupaten Subang yang akurat, transparan, dan realtime.</p>
        </div>

        <div class="stats-row" style="margin-bottom: 30px;">
            <div class="stat-card">
                <div class="stat-details">
                    <h3>Total Produksi Anda</h3>
                    <div class="value">{{ $userTotalTon }}<span class="unit">TON</span></div>
                    <div class="subtext">Akumulasi seluruh hasil tangkap</div>
                </div>
                <div class="stat-icon icon-blue">
                    <i class="fas fa-ship"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-details">
                    <h3>Jumlah Input Data</h3>
                    <div class="value">{{ $userCount }}<span class="unit">Laporan</span></div>
                    <div class="subtext">Catatan hasil tangkap terdaftar</div>
                </div>
                <div class="stat-icon icon-orange">
                    <i class="fas fa-file-invoice"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-details">
                    <h3>Wilayah Kerja</h3>
                    <div class="value" style="font-size: 20px; font-weight: 800; color: #1e293b; margin-top: 8px;">{{ Auth::user()->wilayah ?? 'TPI Blanakan' }}</div>
                    <div class="subtext">Lokasi pencatatan Anda</div>
                </div>
                <div class="stat-icon icon-green">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-left">
                <!-- Trend Panel -->
                <div class="panel">
                    <div class="panel-header">
                        <h2><i class="fas fa-chart-line"></i> Tren Produksi TPI Anda (6 Bulan Terakhir)</h2>
                    </div>
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <!-- Recent Activities Panel -->
                <div class="panel">
                    <div class="panel-header">
                        <h2><i class="fas fa-history"></i> Catatan Terbaru</h2>
                        <a href="{{ route('jururekap.kelola') }}" style="color: #0a3b99; text-decoration: none; font-size: 13px; font-weight: 700;">Kelola Semua <i class="fas fa-arrow-right"></i></a>
                    </div>

                    @if ($recentCatches->count() > 0)
                        <div class="activity-list">
                            @foreach ($recentCatches as $catch)
                                @php
                                    $initials = strtoupper(substr($catch->jenis_ikan, 0, 2));
                                    $statusClass = 'badge-draft';
                                    $statusLabel = 'Draft';
                                    if ($catch->status === 'Menunggu Validasi') {
                                        $statusClass = 'badge-pending';
                                        $statusLabel = 'Menunggu';
                                    } elseif ($catch->status === 'Divalidasi') {
                                        $statusClass = 'badge-success';
                                        $statusLabel = 'Divalidasi';
                                    } elseif ($catch->status === 'Ditolak') {
                                        $statusClass = 'badge-danger';
                                        $statusLabel = 'Ditolak';
                                    }
                                @endphp
                                <div class="activity-item">
                                    <div class="activity-left">
                                        <div class="fish-avatar">{{ $initials }}</div>
                                        <div class="activity-info">
                                            <h4>{{ $catch->jenis_ikan }} - {{ number_format($catch->berat, 1) }} kg</h4>
                                            <p>Nelayan: {{ $catch->nama_nelayan }} | Tanggal: {{ \Carbon\Carbon::parse($catch->created_at)->translatedFormat('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 40px 0; color: #94a3b8;">
                            <i class="fas fa-folder-open" style="font-size: 40px; margin-bottom: 12px; opacity: 0.5;"></i>
                            <p>Belum ada data pencatatan hasil tangkap</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <!-- Weather Panel -->
                <div class="panel weather-card">
                    <div class="panel-header">
                        <h2><i class="fas fa-cloud-sun-rain"></i> Informasi Cuaca Subang</h2>
                    </div>
                    <div class="weather-main">
                        <div class="weather-temp">
                            <span>{{ $cuacaData['suhu'] ?? '30°C' }}</span>
                        </div>
                        <div class="weather-info">
                            <div class="weather-desc">{{ $cuacaData['cuaca'] ?? 'Cerah' }}</div>
                            <div class="weather-wind">
                                <i class="fas fa-wind"></i> {{ $cuacaData['kecepatan_angin'] ?? '10 km/jam' }} ({{ $cuacaData['arah_angin'] ?? 'Utara' }})
                            </div>
                        </div>
                    </div>

                    @php
                        $isWeatherWarning = false;
                        if (isset($cuacaData['peringatan']) && str_contains(strtolower($cuacaData['peringatan']), 'gelombang')) {
                            $isWeatherWarning = true;
                        }
                    @endphp

                    <div class="weather-warning {{ $isWeatherWarning ? 'alert-active' : '' }}">
                        <i class="fas {{ $isWeatherWarning ? 'fa-exclamation-triangle' : 'fa-info-circle' }}"></i>
                        <div>
                            <strong>Peringatan Cuaca:</strong><br>
                            {{ $cuacaData['peringatan'] ?? 'Wilayah Utara Subang Kondisi Aman' }}
                        </div>
                    </div>
                </div>

                <!-- Global stats panel -->
                <div class="panel" style="margin-top: 30px;">
                    <div class="panel-header">
                        <h2><i class="fas fa-globe"></i> Statistik Kabupaten</h2>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div>
                            <span style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Total Produksi Bulan Ini</span>
                            <div style="font-size: 24px; font-weight: 800; color: #0a3b99; margin-top: 4px;">{{ $globalTon }} TON</div>
                        </div>
                        <div style="border-top: 1px solid #f1f5f9; padding-top: 15px;">
                            <span style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Update Terakhir</span>
                            <div style="font-size: 13px; font-weight: 600; color: #334155; margin-top: 4px;">{{ $formattedLastUpdate }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Setup Chart.js for the catch trend visualization
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('trendChart').getContext('2d');
            
            const labels = {!! json_encode($trendLabels) !!};
            const values = {!! json_encode($trendValues) !!};

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Produksi (Ton)',
                        data: values,
                        borderColor: '#0a3b99',
                        backgroundColor: 'rgba(10, 59, 153, 0.05)',
                        borderWidth: 3,
                        pointBackgroundColor: '#f16301',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [5, 5],
                                color: '#e2e8f0'
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    weight: '600'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    weight: '600'
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
