<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Tangkapan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class CetakLaporanController extends Controller
{
    /**
     * Display cetak laporan page
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $search = $request->input('search', '');
        $statusFilter = $request->input('status', 'Divalidasi');
        $startDate = $request->input('start_date', null);
        $endDate = $request->input('end_date', null);
        $tpiFilter = $request->input('tpi', null);
        $bulan = $request->input('bulan', null);
        $tahun = $request->input('tahun', null);

        // Build query untuk laporan yang sudah divalidasi
        $query = Tangkapan::where('status', 'Divalidasi');

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('nama_pembeli', 'like', '%' . $search . '%')
                    ->orWhere('nama_nelayan', 'like', '%' . $search . '%')
                    ->orWhere('jenis_ikan', 'like', '%' . $search . '%');
            });
        }

        // Apply TPI filter (berdasarkan user_id yang memasukkan data)
        if (!empty($tpiFilter)) {
            $query->where('user_id', $tpiFilter);
        }

        // Apply date range filter atau filter bulan/tahun
        if (!empty($bulan) && !empty($tahun)) {
            // Filter berdasarkan bulan dan tahun
            $query->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun);
        } else {
            // Filter berdasarkan date range
            if (!empty($startDate) && !empty($endDate)) {
                $query->whereBetween('created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59'
                ]);
            } elseif (!empty($startDate)) {
                $query->whereDate('created_at', '>=', $startDate);
            } elseif (!empty($endDate)) {
                $query->whereDate('created_at', '<=', $endDate);
            }
        }

        // Get data with pagination
        $laporans = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get list of TPI (users with role 'juruRekap') - show all available TPIs
        $tpiList = \App\Models\User::whereIn('role', ['juruRekap', 'juru_rekap'])
            ->orderBy('wilayah', 'asc')
            ->select('id', 'nama', 'wilayah')
            ->get();

        // Calculate statistics
        $stats = [
            'total_validated' => Tangkapan::where('status', 'Divalidasi')->count(),
            'total_weight' => Tangkapan::where('status', 'Divalidasi')->sum('berat'),
            'avg_weight' => Tangkapan::where('status', 'Divalidasi')->avg('berat'),
        ];

        return view('Staff.cetak-laporan', compact('laporans', 'stats', 'search', 'startDate', 'endDate', 'tpiList', 'tpiFilter', 'bulan', 'tahun'));
    }

    /**
     * Preview laporan sebelum didownload
     */
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'laporan_id' => 'required|integer',
        ]);

        $laporan = Tangkapan::where('id', $validated['laporan_id'])
            ->where('status', 'Divalidasi')
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $laporan,
        ]);
    }

    /**
     * Download laporan dalam format PDF atau Excel
     */
    public function download(Request $request)
    {
        try {
            $validated = $request->validate([
                'format' => 'required|in:pdf,excel',
                'laporan_id' => 'nullable|integer',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'tpi' => 'nullable|integer',
            ]);

            $laporan = collect();

            // Single laporan download
            if (!empty($validated['laporan_id'])) {
                $item = Tangkapan::where('id', $validated['laporan_id'])
                    ->where('status', 'Divalidasi')
                    ->firstOrFail();
                $laporan = collect([$item]);
            } else {
                // Multiple laporan download
                $query = Tangkapan::where('status', 'Divalidasi');

                // Apply TPI filter
                if (!empty($validated['tpi'])) {
                    $query->where('user_id', $validated['tpi']);
                }

                if ($request->has('start_date') && $request->has('end_date')) {
                    $query->whereBetween('created_at', [
                        $validated['start_date'] . ' 00:00:00',
                        $validated['end_date'] . ' 23:59:59'
                    ]);
                }

                $laporan = $query->orderBy('created_at', 'desc')->get();

                if ($laporan->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada data laporan yang sesuai dengan filter'
                    ], 404);
                }
            }

            // Generate file berdasarkan format
            if ($validated['format'] === 'pdf') {
                return $this->generatePDF($laporan);
            } else {
                return $this->generateExcel($laporan);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate PDF
     */
    private function generatePDF($laporan)
    {
        $fileName = 'Laporan_' . now()->format('YmdHis') . '.pdf';
        $html = $this->generateHTML($laporan);

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($fileName);
    }

    /**
     * Generate Excel
     */
    private function generateExcel($laporan)
    {
        $fileName = 'Laporan_' . now()->format('YmdHis') . '.xlsx';

        // Create simple Excel with data using Spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'LAPORAN HASIL TANGKAP - SIPETANG');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A2', 'Tanggal Cetak: ' . now()->format('d/m/Y H:i'));
        $sheet->mergeCells('A2:H2');

        // Column headers
        $headers = ['ID', 'Nama Nelayan', 'Nama Pembeli', 'Jenis Ikan', 'Berat (kg)', 'Harga Jual', 'Status', 'Tanggal'];
        $col = 'A';
        $row = 4;
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFD3D3D3');
            $col++;
        }

        // Data rows
        $row = 5;
        foreach ($laporan as $item) {
            $sheet->setCellValue('A' . $row, $item->id);
            $sheet->setCellValue('B' . $row, $item->nama_nelayan);
            $sheet->setCellValue('C' . $row, $item->nama_pembeli);
            $sheet->setCellValue('D' . $row, $item->jenis_ikan);
            $sheet->setCellValue('E' . $row, $item->berat);
            $sheet->setCellValue('F' . $row, 'Rp ' . number_format($item->harga_jual, 0, ',', '.'));
            $sheet->setCellValue('G' . $row, $item->status);
            $sheet->setCellValue('H' . $row, $item->created_at->format('d/m/Y'));
            $row++;
        }

        // Auto fit columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Save file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
            ]
        );
    }

    /**
     * Generate HTML untuk preview atau PDF
     */
    private function generateHTML($laporan)
    {
        $totalBerat = $laporan->sum('berat');
        $totalNilai = $laporan->sum('harga_jual');
        $tanggalCetak = now()->format('d/m/Y H:i');
        $totalData = $laporan->count();
        $totalNilaiFormatted = number_format($totalNilai, 0, ',', '.');

        $rows = '';
        foreach ($laporan as $item) {
            $rows .= '<tr>
                <td style="padding: 10px; border: 1px solid #000;">' . $item->id . '</td>
                <td style="padding: 10px; border: 1px solid #000;">' . $item->nama_nelayan . '</td>
                <td style="padding: 10px; border: 1px solid #000;">' . $item->nama_pembeli . '</td>
                <td style="padding: 10px; border: 1px solid #000;">' . $item->jenis_ikan . '</td>
                <td style="padding: 10px; border: 1px solid #000; text-align: right;">' . number_format($item->berat, 2) . '</td>
                <td style="padding: 10px; border: 1px solid #000; text-align: right;">Rp ' . number_format($item->harga_jual, 0, ',', '.') . '</td>
                <td style="padding: 10px; border: 1px solid #000;">' . $item->status . '</td>
                <td style="padding: 10px; border: 1px solid #000;">' . $item->created_at->format('d/m/Y') . '</td>
            </tr>';
        }

        $html = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { text-align: center; color: #0a3b99; }
                .info { margin-bottom: 20px; font-size: 12px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background-color: #0a3b99; color: white; padding: 10px; text-align: left; font-size: 11px; }
                .total { font-weight: bold; margin-top: 20px; font-size: 12px; }
                .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ccc; padding-top: 10px; }
            </style>
        </head>
        <body>
            <h1>LAPORAN HASIL TANGKAP</h1>
            <p style="text-align: center; color: #666; font-size: 12px;">Sistem Informasi Pencatatan Hasil Tangkap (SIPETANG)</p>
            
            <div class="info">
                <p><strong>Tanggal Cetak:</strong> $tanggalCetak</p>
                <p><strong>Total Data:</strong> $totalData</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Nelayan</th>
                        <th>Nama Pembeli</th>
                        <th>Jenis Ikan</th>
                        <th style="text-align: right;">Berat (kg)</th>
                        <th style="text-align: right;">Harga Jual</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    $rows
                </tbody>
            </table>
            
            <div class="total">
                <p>Total Berat: <strong>$totalBerat kg</strong></p>
                <p>Total Nilai: <strong>Rp $totalNilaiFormatted</strong></p>
            </div>

            <div class="footer">
                <p>Laporan ini dicetak secara otomatis dari Sistem SIPETANG</p>
                <p>© 2026 Sistem Informasi Pencatatan Hasil Tangkap</p>
            </div>
        </body>
        </html>
HTML;

        return $html;
    }

    /**
     * Format number helper
     */
    private function formatNumber($number)
    {
        return number_format($number, 0, ',', '.');
    }
}
