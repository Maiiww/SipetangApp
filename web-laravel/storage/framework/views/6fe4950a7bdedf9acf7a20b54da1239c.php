<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Maritim</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.4;
        }
        
        .container {
            padding: 10px 20px;
        }
        
        /* Kop Surat Styles */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        
        .kop-table td {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
            vertical-align: middle;
        }
        
        .kop-logo-left {
            width: 12%;
            text-align: left;
        }
        
        .kop-logo-left img {
            height: 75px;
            width: auto;
        }
        
        .kop-logo-right {
            width: 12%;
            text-align: right;
        }
        
        .kop-logo-right img {
            height: 75px;
            width: auto;
        }
        
        .kop-text {
            width: 76%;
            text-align: center;
        }
        
        .kop-pemda {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
        }
        
        .kop-dinas {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }
        
        .kop-alamat {
            font-size: 10px;
            color: #333;
            margin-bottom: 2px;
        }
        
        .kop-kontak {
            font-size: 10px;
            color: #333;
        }
        
        .double-line {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin-top: 6px;
            margin-bottom: 20px;
        }
        
        .report-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #0A3B99;
            text-transform: uppercase;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }
        
        /* Metadata Styles */
        .metadata-table {
            width: auto;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        .metadata-table td {
            border: none !important;
            padding: 3px 5px !important;
            background: transparent !important;
        }
        
        .meta-label {
            width: 100px;
            color: #333;
            font-weight: normal;
        }
        
        .meta-colon {
            width: 10px;
            text-align: center;
            color: #333;
        }
        
        .meta-value {
            color: #333;
            font-weight: normal;
        }
        
        /* Data Table Styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .data-table thead {
            background: #0D2640;
            color: white;
        }
        
        .data-table th {
            padding: 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            border: 1px solid #0D2640;
        }
        
        .data-table td {
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        
        .data-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .data-table tbody tr:hover {
            background: #e6f0ff;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            background: #e6f0ff;
            color: #0D2640;
        }
        
        .total-row {
            background: #f0f4f8 !important;
            font-weight: bold;
        }
        
        .total-row td {
            border-top: 2px solid #0D2640;
        }
    </style>
</head>
<body>
    <?php
        $logoSubangPath = public_path('kabupaten-subang-logo.png');
        $logoDinasPath = public_path('images/logo.png');

        $logoSubangBase64 = '';
        $logoDinasBase64 = '';

        if (file_exists($logoSubangPath)) {
            $logoSubangData = file_get_contents($logoSubangPath);
            $logoSubangBase64 = 'data:image/png;base64,' . base64_encode($logoSubangData);
        }

        if (file_exists($logoDinasPath)) {
            $logoDinasData = file_get_contents($logoDinasPath);
            $logoDinasBase64 = 'data:image/png;base64,' . base64_encode($logoDinasData);
        }

        // Determine Asal TPI
        $tpiList = $laporan->map(function($item) {
            if (isset($item->user) && isset($item->user->wilayah)) {
                return $item->user->wilayah;
            }
            return $item->namaTPI ?? $item->nama_tpi ?? null;
        })->filter()->unique();

        $asalTpi = $tpiList->count() === 1 ? $tpiList->first() : 'Semua TPI';

        // Determine Jenis Laporan
        $tipeLaporanLabel = match($laporan_type ?? '') {
            'daily', 'harian'   => 'Laporan Harian',
            'monthly', 'bulanan' => 'Laporan Bulanan',
            'tahunan'           => 'Laporan Tahunan',
            'custom'            => 'Laporan Kustom',
            default             => ucfirst(str_replace('_', ' ', $laporan_type ?? ''))
        };

        // Determine Periode Label Only
        $periodeLabelOnly = $periode_label ?? '';
        $periodeLabelOnly = preg_replace('/^(Bulan|Tanggal|Tahun|Periode):\s*/i', '', $periodeLabelOnly);
        
        if (empty($periodeLabelOnly)) {
            if (($laporan_type === 'monthly' || $laporan_type === 'bulanan') && isset($bulan)) {
                $bulanNames = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                $periodeLabelOnly = ($bulanNames[(int)$bulan] ?? $bulan) . ' ' . ($tahun ?? date('Y'));
            } elseif ($laporan_type === 'tahunan' && isset($tahun)) {
                $periodeLabelOnly = $tahun;
            } elseif ($laporan_type === 'daily' || $laporan_type === 'harian') {
                $periodeLabelOnly = now()->format('d/m/Y');
            } else {
                $periodeLabelOnly = $tahun ?? now()->year;
            }
        }

        // Format Tanggal Cetak
        $generated_date_short = isset($generated_date) ? explode(' ', $generated_date)[0] : now()->format('d/m/Y');
    ?>

    <div class="container">
        <!-- Kop Surat -->
        <table class="kop-table">
            <tr>
                <td class="kop-logo-left">
                    <?php if(!empty($logoSubangBase64)): ?>
                        <img src="<?php echo e($logoSubangBase64); ?>" alt="Logo Subang">
                    <?php endif; ?>
                </td>
                <td class="kop-text">
                    <div class="kop-pemda">PEMERINTAH KABUPATEN SUBANG</div>
                    <div class="kop-dinas">DINAS KELAUTAN DAN PERIKANAN</div>
                    <div class="kop-alamat">Jl. A. Nata Sukarya No. 28, Kabupaten Subang, 41211</div>
                    <div class="kop-kontak">Telepon: (0260) 411325 | Email: dinasperikanan@gmail.com</div>
                </td>
                <td class="kop-logo-right">
                    <?php if(!empty($logoDinasBase64)): ?>
                        <img src="<?php echo e($logoDinasBase64); ?>" alt="Logo Dinas">
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        
        <div class="double-line"></div>

        <!-- Title -->
        <div class="report-title">LAPORAN HASIL TANGKAP</div>

        <!-- Metadata -->
        <table class="metadata-table">
            <tr>
                <td class="meta-label">Asal TPI</td>
                <td class="meta-colon">:</td>
                <td class="meta-value"><?php echo e($asalTpi); ?></td>
            </tr>
            <tr>
                <td class="meta-label">Jenis Laporan</td>
                <td class="meta-colon">:</td>
                <td class="meta-value"><?php echo e($tipeLaporanLabel); ?></td>
            </tr>
            <tr>
                <td class="meta-label">
                    <?php if($laporan_type === 'daily' || $laporan_type === 'harian'): ?>
                        Tanggal
                    <?php elseif($laporan_type === 'monthly' || $laporan_type === 'bulanan'): ?>
                        Bulan/Tahun
                    <?php elseif($laporan_type === 'custom'): ?>
                        Periode
                    <?php else: ?>
                        Tahun
                    <?php endif; ?>
                </td>
                <td class="meta-colon">:</td>
                <td class="meta-value"><?php echo e($periodeLabelOnly); ?></td>
            </tr>
            <tr>
                <td class="meta-label">Tanggal Cetak</td>
                <td class="meta-colon">:</td>
                <td class="meta-value"><?php echo e($generated_date_short); ?></td>
            </tr>
        </table>

        <!-- Data Table -->
        <?php
            $groupedLaporan = $laporan->groupBy(function($item) {
                return ucwords(strtolower(trim($item->jenisIkan ?? $item->jenis_ikan)));
            })->map(function($items, $jenisIkan) {
                return (object) [
                    'jenisIkan' => $jenisIkan,
                    'jenis_ikan' => $jenisIkan,
                    'beratTotal' => $items->sum(function($i) { return $i->beratTotal ?? $i->berat; }),
                    'berat' => $items->sum(function($i) { return $i->beratTotal ?? $i->berat; }),
                    'harga_jual' => $items->sum('harga_jual'),
                ];
            });
        ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Jenis Ikan</th>
                    <th class="text-right">Berat (kg)</th>
                    <th class="text-right">Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $groupedLaporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($item->jenisIkan); ?></td>
                    <td class="text-right"><?php echo e(number_format($item->beratTotal, 2, ',', '.')); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($item->harga_jual, 0, ',', '.')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data laporan</td>
                </tr>
                <?php endif; ?>

                <?php if($groupedLaporan->count() > 0): ?>
                <tr class="total-row">
                    <td class="text-right"><strong>TOTAL:</strong></td>
                    <td class="text-right"><strong><?php echo e(number_format($total_berat, 2, ',', '.')); ?> kg</strong></td>
                    <td class="text-right"><strong>Rp <?php echo e(number_format($groupedLaporan->sum('harga_jual'), 0, ',', '.')); ?></strong></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Document generated by SIPETANG System on <?php echo e($generated_date); ?></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\SipetangApp\web-laravel\resources\views/exports/laporan-pdf.blade.php ENDPATH**/ ?>