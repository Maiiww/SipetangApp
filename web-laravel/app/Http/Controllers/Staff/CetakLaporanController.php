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

        // Apply TPI filter (berdasarkan wilayah)
        if (!empty($tpiFilter)) {
            $query->whereHas('user', function ($q) use ($tpiFilter) {
                $q->where('wilayah', $tpiFilter);
            });
        }

        // Apply date range filter atau filter bulan/tahun
        if (!empty($bulan)) {
            $tahunVal = !empty($tahun) ? $tahun : date('Y');
            $query->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahunVal);
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

        // Get list of TPI (users with role 'juruRekap') - get unique users by wilayah
        $tpiList = \App\Models\User::whereIn('role', ['juruRekap', 'juru_rekap'])
            ->orderBy('wilayah', 'asc')
            ->select('id', 'nama', 'wilayah')
            ->where('wilayah', '!=', null)
            ->distinct('wilayah')
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
     * Get HTML preview of the report (paper layout)
     */
    public function previewHTML(Request $request)
    {
        try {
            $validated = $request->validate([
                'laporan_id' => 'nullable|integer',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'tpi' => 'nullable|integer',
                'jenis_laporan' => 'nullable|in:harian,bulanan,tahunan',
                'bulan' => 'nullable|integer|between:1,12',
                'tahun' => 'nullable|integer',
            ]);

            if (!empty($validated['laporan_id'])) {
                $query = Tangkapan::where('id', $validated['laporan_id'])
                    ->where('status', 'Divalidasi');
            } else {
                $query = Tangkapan::where('status', 'Divalidasi');

                // Apply TPI filter
                if (!empty($validated['tpi'])) {
                    $query->whereHas('user', function ($q) use ($validated) {
                        $q->where('id', $validated['tpi']);
                    });
                }

                // Apply date filters based on jenis_laporan
                if (!empty($validated['jenis_laporan'])) {
                    $jenisLaporan = $validated['jenis_laporan'];

                    if ($jenisLaporan === 'harian') {
                        if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
                            $query->whereBetween('created_at', [
                                $validated['start_date'] . ' 00:00:00',
                                $validated['end_date'] . ' 23:59:59'
                            ]);
                        } elseif (!empty($validated['start_date'])) {
                            $query->whereDate('created_at', '>=', $validated['start_date']);
                        } elseif (!empty($validated['end_date'])) {
                            $query->whereDate('created_at', '<=', $validated['end_date']);
                        }
                    } elseif ($jenisLaporan === 'bulanan') {
                        if (!empty($validated['bulan'])) {
                            $tahunVal = !empty($validated['tahun']) ? $validated['tahun'] : date('Y');
                            $query->whereMonth('created_at', $validated['bulan'])
                                  ->whereYear('created_at', $tahunVal);
                        }
                    } elseif ($jenisLaporan === 'tahunan') {
                        if (!empty($validated['tahun'])) {
                            $query->whereYear('created_at', $validated['tahun']);
                        }
                    }
                }
            }

            $laporan = $query->orderBy('created_at', 'desc')->get();

            if ($laporan->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data laporan'
                ], 200);
            }

            $html = $this->generateHTML($laporan, $validated['jenis_laporan'] ?? null, $validated['bulan'] ?? null, $validated['tahun'] ?? null);

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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
                'jenis_laporan' => 'nullable|in:harian,bulanan,tahunan',
                'bulan' => 'nullable|integer|between:1,12',
                'tahun' => 'nullable|integer',
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

                // Apply date filters based on jenis_laporan
                if (!empty($validated['jenis_laporan'])) {
                    $jenisLaporan = $validated['jenis_laporan'];

                    if ($jenisLaporan === 'harian') {
                        // Untuk laporan harian, gunakan date range
                        if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
                            $query->whereBetween('created_at', [
                                $validated['start_date'] . ' 00:00:00',
                                $validated['end_date'] . ' 23:59:59'
                            ]);
                        } elseif (!empty($validated['start_date'])) {
                            $query->whereDate('created_at', '>=', $validated['start_date']);
                        } elseif (!empty($validated['end_date'])) {
                            $query->whereDate('created_at', '<=', $validated['end_date']);
                        }
                    } elseif ($jenisLaporan === 'bulanan') {
                        // Untuk laporan bulanan, gunakan bulan dan tahun (default ke tahun sekarang jika tidak dipilih)
                        if (!empty($validated['bulan'])) {
                            $tahunVal = !empty($validated['tahun']) ? $validated['tahun'] : date('Y');
                            $query->whereMonth('created_at', $validated['bulan'])
                                ->whereYear('created_at', $tahunVal);
                        }
                    } elseif ($jenisLaporan === 'tahunan') {
                        // Untuk laporan tahunan, gunakan tahun saja
                        if (!empty($validated['tahun'])) {
                            $query->whereYear('created_at', $validated['tahun']);
                        }
                    }
                } else {
                    // Default: gunakan date range jika tersedia
                    if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
                        $query->whereBetween('created_at', [
                            $validated['start_date'] . ' 00:00:00',
                            $validated['end_date'] . ' 23:59:59'
                        ]);
                    }
                }

                $laporan = $query->orderBy('created_at', 'desc')->get();

                if ($laporan->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada data laporan'
                    ], 200);
                }
            }

            // Generate file berdasarkan format
            if ($validated['format'] === 'pdf') {
                return $this->generatePDF($laporan, $validated['jenis_laporan'] ?? null, $validated['bulan'] ?? null, $validated['tahun'] ?? null);
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
    private function generatePDF($laporan, $jenisLaporan = null, $bulan = null, $tahun = null)
    {
        $fileName = 'Laporan_' . now()->format('YmdHis') . '.pdf';
        $html = $this->generateHTML($laporan, $jenisLaporan, $bulan, $tahun);

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($fileName);
    }

    private function generateExcel($laporan)
    {
        $fileName = 'Laporan_' . now()->format('YmdHis') . '.xlsx';

        // Create simple Excel with data using Spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'LAPORAN HASIL TANGKAP - SIPETANG');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A2', 'Tanggal Cetak: ' . now()->format('d/m/Y H:i'));
        $sheet->mergeCells('A2:C2');

        // Column headers
        $headers = ['Jenis Ikan', 'Berat (kg)', 'Harga Jual'];
        $col = 'A';
        $row = 4;
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFD3D3D3');
            $col++;
        }

        // Group by jenis_ikan (normalized to Title Case) and sum berat and harga_jual
        $groupedLaporan = $laporan->groupBy(function ($item) {
            return ucwords(strtolower(trim($item->jenis_ikan)));
        })->map(function ($items, $jenisIkan) {
            return (object) [
                'jenis_ikan' => $jenisIkan,
                'berat' => $items->sum('berat'),
                'harga_jual' => $items->sum('harga_jual'),
            ];
        });

        // Data rows
        $row = 5;
        foreach ($groupedLaporan as $item) {
            $sheet->setCellValue('A' . $row, $item->jenis_ikan);
            $sheet->setCellValue('B' . $row, $item->berat);
            $sheet->setCellValue('C' . $row, 'Rp ' . number_format($item->harga_jual, 0, ',', '.'));
            $row++;
        }

        // Add TOTAL row at the bottom
        $sheet->setCellValue('A' . $row, 'TOTAL:');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('B' . $row, $groupedLaporan->sum('berat'));
        $sheet->getStyle('B' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('C' . $row, 'Rp ' . number_format($groupedLaporan->sum('harga_jual'), 0, ',', '.'));
        $sheet->getStyle('C' . $row)->getFont()->setBold(true);

        // Auto fit columns
        foreach (range('A', 'C') as $col) {
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
     * Get filtered laporan data via AJAX
     */
    public function getFilteredData(Request $request)
    {
        try {
            \Log::info('AJAX Request Params: ' . json_encode($request->all()));
            $validated = $request->validate([
                'tpi' => 'nullable|integer',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'jenis_laporan' => 'nullable|in:harian,bulanan,tahunan',
                'bulan' => 'nullable|integer|between:1,12',
                'tahun' => 'nullable|integer',
                'page' => 'nullable|integer|min:1',
            ]);

            // Build query untuk laporan yang sudah divalidasi
            $query = Tangkapan::where('status', 'Divalidasi');

            // Apply TPI filter (berdasarkan user_id)
            if (!empty($validated['tpi'])) {
                $query->where('user_id', $validated['tpi']);
            }

            // Apply jenis laporan filter
            if (!empty($validated['jenis_laporan'])) {
                $jenisLaporan = $validated['jenis_laporan'];

                if ($jenisLaporan === 'harian') {
                    // Untuk laporan harian, gunakan date range jika ada
                    if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
                        $query->whereBetween('created_at', [
                            $validated['start_date'] . ' 00:00:00',
                            $validated['end_date'] . ' 23:59:59'
                        ]);
                    } elseif (!empty($validated['start_date'])) {
                        $query->whereDate('created_at', '>=', $validated['start_date']);
                    } elseif (!empty($validated['end_date'])) {
                        $query->whereDate('created_at', '<=', $validated['end_date']);
                    }
                } elseif ($jenisLaporan === 'bulanan') {
                    // Untuk laporan bulanan, gunakan bulan dan tahun (default ke tahun sekarang jika tidak dipilih)
                    if (!empty($validated['bulan'])) {
                        $tahunVal = !empty($validated['tahun']) ? $validated['tahun'] : date('Y');
                        $query->whereMonth('created_at', $validated['bulan'])
                            ->whereYear('created_at', $tahunVal);
                    }
                } elseif ($jenisLaporan === 'tahunan') {
                    // Untuk laporan tahunan, gunakan tahun saja
                    if (!empty($validated['tahun'])) {
                        $query->whereYear('created_at', $validated['tahun']);
                    }
                }
            } else {
                // Jika tidak ada jenis_laporan dipilih, gunakan date range default
                if (!empty($validated['bulan'])) {
                    $tahunVal = !empty($validated['tahun']) ? $validated['tahun'] : date('Y');
                    $query->whereMonth('created_at', $validated['bulan'])
                        ->whereYear('created_at', $tahunVal);
                } else {
                    if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
                        $query->whereBetween('created_at', [
                            $validated['start_date'] . ' 00:00:00',
                            $validated['end_date'] . ' 23:59:59'
                        ]);
                    } elseif (!empty($validated['start_date'])) {
                        $query->whereDate('created_at', '>=', $validated['start_date']);
                    } elseif (!empty($validated['end_date'])) {
                        $query->whereDate('created_at', '<=', $validated['end_date']);
                    }
                }
            }

            // Calculate totals using clone of query
            $totalBerat = (float) $query->clone()->sum('berat');
            $totalNilai = (float) $query->clone()->sum('harga_jual');

            // Get paginated data
            $page = $validated['page'] ?? 1;
            $laporans = $query->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'page', $page);

            // Format data untuk response
            $formattedData = $laporans->map(function ($laporan) {
                return [
                    'id' => $laporan->id,
                    'id_laporan' => '#LAP-' . str_pad($laporan->id, 4, '0', STR_PAD_LEFT),
                    'tanggal_dibuat' => $laporan->created_at->format('d M Y, H:i'),
                    'tpi' => $laporan->user ? ($laporan->user->wilayah ?: $laporan->user->nama) : 'N/A',
                    'dibuat_oleh' => $laporan->user ? $laporan->user->nama : 'N/A',
                    'created_at' => $laporan->created_at,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedData,
                'total_berat' => $totalBerat,
                'total_nilai' => $totalNilai,
                'pagination' => [
                    'current_page' => $laporans->currentPage(),
                    'last_page' => $laporans->lastPage(),
                    'per_page' => $laporans->perPage(),
                    'total' => $laporans->total(),
                    'from' => $laporans->firstItem(),
                    'to' => $laporans->lastItem(),
                ],
                'message' => $laporans->count() > 0 ? 'Data ditemukan' : 'Tidak ada data laporan'
            ]);
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

    private function generateHTML($laporan, $jenisLaporan = null, $bulan = null, $tahun = null)
    {
        $totalBerat = $laporan->sum('berat');
        $totalNilai = $laporan->sum('harga_jual');
        $tanggalCetak = now()->format('d/m/Y H:i');

        // Build period label
        $bulanNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $tahunVal = $tahun ?? date('Y');
        if ($jenisLaporan === 'bulanan' && $bulan) {
            $periodeLabel = 'Bulan: ' . ($bulanNames[(int)$bulan] ?? $bulan) . ' ' . $tahunVal;
            $tipeLaporan  = 'Laporan Bulanan';
        } elseif ($jenisLaporan === 'tahunan' && $tahun) {
            $periodeLabel = 'Tahun: ' . $tahun;
            $tipeLaporan  = 'Laporan Tahunan';
        } elseif ($jenisLaporan === 'harian') {
            $periodeLabel = 'Laporan Harian';
            $tipeLaporan  = 'Laporan Harian';
        } else {
            $periodeLabel = null;
            $tipeLaporan  = 'Laporan Hasil Tangkap';
        }

        // Group by jenis_ikan (normalized to Title Case) and sum berat and harga_jual
        $groupedLaporan = $laporan->groupBy(function ($item) {
            return ucwords(strtolower(trim($item->jenis_ikan)));
        })->map(function ($items, $jenisIkan) {
            return (object) [
                'jenis_ikan' => $jenisIkan,
                'berat' => $items->sum('berat'),
                'harga_jual' => $items->sum('harga_jual'),
            ];
        });

        $totalData = $groupedLaporan->count();
        $totalNilaiFormatted = number_format($totalNilai, 0, ',', '.');
        $totalBeratFormatted = number_format($totalBerat, 2, ',', '.');

        $rows = '';
        foreach ($groupedLaporan as $item) {
            $rows .= '<tr>
                <td style="padding: 10px; border: 1px solid #000;">' . $item->jenis_ikan . '</td>
                <td style="padding: 10px; border: 1px solid #000; text-align: right;">' . number_format($item->berat, 2) . '</td>
                <td style="padding: 10px; border: 1px solid #000; text-align: right;">Rp ' . number_format($item->harga_jual, 0, ',', '.') . '</td>
            </tr>';
        }

        // Build period badge HTML
        $periodeBadgeHtml = '';
        if ($periodeLabel) {
            $periodeBadgeHtml = '<div style="display:inline-block; background:#0a3b99; color:white; padding:5px 16px; border-radius:20px; font-size:13px; font-weight:bold; margin-bottom:10px; letter-spacing:0.04em;">' . $periodeLabel . '</div>';
        }

        // Build tipe laporan line
        $tipeLaporanHtml = '<p style="text-align:center; color:#0a3b99; font-size:13px; font-weight:bold; margin-bottom:4px;">' . $tipeLaporan . '</p>';

        $html = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { text-align: center; color: #0a3b99; margin-bottom: 4px; }
                .periode-wrap { text-align: center; margin-bottom: 16px; }
                .info { margin-bottom: 20px; font-size: 12px; background: #f4f8ff; border-left: 4px solid #0a3b99; padding: 10px 14px; border-radius: 4px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background-color: #0a3b99; color: white; padding: 10px; text-align: left; font-size: 11px; }
                .total { font-weight: bold; margin-top: 20px; font-size: 12px; }
                .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ccc; padding-top: 10px; }
            </style>
        </head>
        <body>
            <h1>LAPORAN HASIL TANGKAP</h1>
            $tipeLaporanHtml
            <p style="text-align: center; color: #666; font-size: 12px; margin-bottom: 8px;">Sistem Informasi Pencatatan Hasil Tangkap (SIPETANG)</p>
            <div class="periode-wrap">$periodeBadgeHtml</div>

            <div class="info">
                <p><strong>Tanggal Cetak:</strong> $tanggalCetak</p>
                <p><strong>Total Data:</strong> $totalData jenis ikan</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Jenis Ikan</th>
                        <th style="text-align: right;">Berat (kg)</th>
                        <th style="text-align: right;">Harga Jual</th>
                    </tr>
                </thead>
                <tbody>
                    $rows
                </tbody>
            </table>

            <div class="total">
                <p>Total Berat: <strong>$totalBeratFormatted kg</strong></p>
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
