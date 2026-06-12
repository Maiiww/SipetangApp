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
        }
        
        .container {
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0D2640;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            color: #0D2640;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 12px;
            color: #666;
        }
        
        .summary {
            margin-bottom: 25px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 5px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 12px;
        }
        
        .summary-item label {
            font-weight: bold;
            color: #0D2640;
        }
        
        .summary-item span {
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table thead {
            background: #0D2640;
            color: white;
        }
        
        table th {
            padding: 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            border: 1px solid #0D2640;
        }
        
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        
        table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        table tbody tr:hover {
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
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN DATA MARITIM SIPETANG</h1>
            <p>Sistem Informasi Pengelolaan Data Tangkapan Ikan</p>
        </div>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-item">
                <label>Tipe Laporan:</label>
                <span>{{ ucfirst(str_replace('_', ' ', $laporan_type)) }}</span>
            </div>
            <div class="summary-item">
                <label>Total Record:</label>
                <span>{{ $total_records }} laporan</span>
            </div>
            <div class="summary-item">
                <label>Total Berat:</label>
                <span>{{ number_format($total_berat, 2, ',', '.') }} kg</span>
            </div>
            <div class="summary-item">
                <label>Tanggal Generate:</label>
                <span>{{ $generated_date }}</span>
            </div>
        </div>

        <!-- Data Table -->
        @php
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
        @endphp
        <table>
            <thead>
                <tr>
                    <th>Jenis Ikan</th>
                    <th class="text-right">Berat (kg)</th>
                    <th class="text-right">Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groupedLaporan as $item)
                <tr>
                    <td>{{ $item->jenisIkan }}</td>
                    <td class="text-right">{{ number_format($item->beratTotal, 2, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data laporan</td>
                </tr>
                @endforelse

                @if($groupedLaporan->count() > 0)
                <tr class="total-row">
                    <td class="text-right"><strong>TOTAL:</strong></td>
                    <td class="text-right"><strong>{{ number_format($total_berat, 2, ',', '.') }} kg</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($groupedLaporan->sum('harga_jual'), 0, ',', '.') }}</strong></td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Document generated by SIPETANG System on {{ $generated_date }}</p>
        </div>
    </div>
</body>
</html>
