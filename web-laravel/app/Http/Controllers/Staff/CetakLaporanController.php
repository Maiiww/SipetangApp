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

            $jenisLaporan = !empty($validated['laporan_id']) ? 'harian' : ($validated['jenis_laporan'] ?? null);
            $html = $this->generateHTML($laporan, $jenisLaporan, $validated['bulan'] ?? null, $validated['tahun'] ?? null);

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
            $jenisLaporan = !empty($validated['laporan_id']) ? 'harian' : ($validated['jenis_laporan'] ?? null);
            if ($validated['format'] === 'pdf') {
                return $this->generatePDF($laporan, $jenisLaporan, $validated['bulan'] ?? null, $validated['tahun'] ?? null);
            } else {
                return $this->generateExcel($laporan, $jenisLaporan, $validated['bulan'] ?? null, $validated['tahun'] ?? null);
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
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download($fileName);
    }

    private function generateExcel($laporan, $jenisLaporan = null, $bulan = null, $tahun = null)
    {
        $fileName = 'Laporan_' . now()->format('YmdHis') . '.xlsx';

        // Create Excel with data using Spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Calculate metadata
        $bulanNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Determine Asal TPI
        $tpiList = $laporan->map(function($item) {
            if (isset($item->user) && isset($item->user->wilayah)) {
                return $item->user->wilayah;
            }
            return $item->namaTPI ?? $item->nama_tpi ?? null;
        })->filter()->unique();
        $asalTpi = $tpiList->count() === 1 ? $tpiList->first() : 'Semua TPI';

        // Determine Jenis Laporan
        $tipeLaporanLabel = match($jenisLaporan ?? '') {
            'daily', 'harian'   => 'Laporan Harian',
            'monthly', 'bulanan' => 'Laporan Bulanan',
            'tahunan'           => 'Laporan Tahunan',
            'custom'            => 'Laporan Kustom',
            default             => ucfirst(str_replace('_', ' ', $jenisLaporan ?? ''))
        };

        // Determine Periode Label
        $tahunVal = $tahun ?? date('Y');
        $periodeLabelOnly = '';
        if ($jenisLaporan === 'bulanan' && $bulan) {
            $periodeLabelOnly = ($bulanNames[(int)$bulan] ?? $bulan) . ' ' . $tahunVal;
        } elseif ($jenisLaporan === 'tahunan' && $tahun) {
            $periodeLabelOnly = $tahun;
        } elseif ($jenisLaporan === 'harian') {
            if ($laporan->isNotEmpty()) {
                $dates = $laporan->map(function($item) {
                    return $item->created_at->format('d/m/Y');
                })->unique();
                if ($dates->count() === 1) {
                    $periodeLabelOnly = $dates->first();
                } else {
                    $sortedDates = $laporan->pluck('created_at')->sort();
                    $startDate = $sortedDates->first()->format('d/m/Y');
                    $endDate = $sortedDates->last()->format('d/m/Y');
                    $periodeLabelOnly = $startDate . ' s/d ' . $endDate;
                }
            } else {
                $periodeLabelOnly = now()->format('d/m/Y');
            }
        } else {
            $periodeLabelOnly = $tahunVal;
        }

        $tanggalCetak = now()->format('d/m/Y');

        // --- RENDER HEADER (KOP SURAT) ---
        $sheet->setCellValue('A1', 'PEMERINTAH KABUPATEN SUBANG');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'DINAS KELAUTAN DAN PERIKANAN');
        $sheet->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Jl. A. Nata Sukarya No. 28, Kabupaten Subang, 41211');
        $sheet->mergeCells('A3:C3');
        $sheet->getStyle('A3')->getFont()->setSize(9);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A4', 'Telepon: (0260) 411325 | Email: dinasperikanan@gmail.com');
        $sheet->mergeCells('A4:C4');
        $sheet->getStyle('A4')->getFont()->setSize(9);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Double border line separator (under row 4)
        $sheet->getStyle('A4:C4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

        // --- RENDER TITLE ---
        $sheet->setCellValue('A6', 'LAPORAN HASIL TANGKAP');
        $sheet->mergeCells('A6:C6');
        $sheet->getStyle('A6')->getFont()->setBold(true)->setSize(13)->getColor()->setARGB('FF0A3B99');
        $sheet->getStyle('A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // --- RENDER METADATA ---
        $sheet->setCellValue('A8', 'Asal TPI');
        $sheet->setCellValue('B8', ':');
        $sheet->setCellValue('C8', $asalTpi);

        $sheet->setCellValue('A9', 'Jenis Laporan');
        $sheet->setCellValue('B9', ':');
        $sheet->setCellValue('C9', $tipeLaporanLabel);

        $periodLabelName = match($jenisLaporan ?? '') {
            'daily', 'harian'   => 'Tanggal',
            'monthly', 'bulanan' => 'Bulan/Tahun',
            'custom'            => 'Periode',
            default             => 'Tahun'
        };
        $sheet->setCellValue('A10', $periodLabelName);
        $sheet->setCellValue('B10', ':');
        $sheet->setCellValue('C10', $periodeLabelOnly);

        $sheet->setCellValue('A11', 'Tanggal Cetak');
        $sheet->setCellValue('B11', ':');
        $sheet->setCellValue('C11', $tanggalCetak);

        // Styling metadata alignment
        $sheet->getStyle('A8:B11')->getFont()->setBold(true);
        $sheet->getStyle('A8:C11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // --- RENDER DATA TABLE ---
        // Column headers
        $headers = ['Jenis Ikan', 'Berat (kg)', 'Harga Jual'];
        $col = 'A';
        $row = 13;
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $col++;
        }
        
        // Style Table Header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 10,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0D2640'],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ];
        $sheet->getStyle('A13:C13')->applyFromArray($headerStyle);
        $sheet->getStyle('B13:C13')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

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
        $startRow = 14;
        $row = 14;
        foreach ($groupedLaporan as $item) {
            $sheet->setCellValue('A' . $row, $item->jenis_ikan);
            $sheet->setCellValue('B' . $row, $item->berat);
            $sheet->setCellValue('C' . $row, $item->harga_jual);
            
            // Format numbers
            $sheet->getStyle('B' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('C' . $row)->getNumberFormat()->setFormatCode('"Rp " #,##0');
            
            // Zebra striping
            if ($row % 2 === 0) {
                $sheet->getStyle('A' . $row . ':C' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
            }
            
            $row++;
        }

        // Add TOTAL row at the bottom
        $sheet->setCellValue('A' . $row, 'TOTAL:');
        $sheet->setCellValue('B' . $row, '=SUM(B' . $startRow . ':B' . ($row - 1) . ')');
        $sheet->setCellValue('C' . $row, '=SUM(C' . $startRow . ':C' . ($row - 1) . ')');

        // Style TOTAL row
        $totalStyle = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFF0F4F8'],
            ],
        ];
        $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray($totalStyle);
        $sheet->getStyle('B' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('C' . $row)->getNumberFormat()->setFormatCode('"Rp " #,##0');
        
        // Borders for table grid
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FFDDDDDD'],
                ],
            ],
        ];
        $sheet->getStyle('A13:C' . $row)->applyFromArray($borderStyle);
        
        // Custom double border on top of total row
        $sheet->getStyle('A' . $row . ':C' . $row)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

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
        $bulanNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $tahunVal = $tahun ?? date('Y');
        $periodeLabel = null;
        
        if ($jenisLaporan === 'bulanan' && $bulan) {
            $periodeLabel = 'Bulan: ' . ($bulanNames[(int)$bulan] ?? $bulan) . ' ' . $tahunVal;
        } elseif ($jenisLaporan === 'tahunan' && $tahun) {
            $periodeLabel = 'Tahun: ' . $tahun;
        } elseif ($jenisLaporan === 'harian') {
            if ($laporan->isNotEmpty()) {
                $dates = $laporan->map(function($item) {
                    return $item->created_at->format('d/m/Y');
                })->unique();
                if ($dates->count() === 1) {
                    $periodeLabel = 'Tanggal: ' . $dates->first();
                } else {
                    $sortedDates = $laporan->pluck('created_at')->sort();
                    $startDate = $sortedDates->first()->format('d/m/Y');
                    $endDate = $sortedDates->last()->format('d/m/Y');
                    $periodeLabel = 'Periode: ' . $startDate . ' s/d ' . $endDate;
                }
            } else {
                $periodeLabel = 'Tanggal: ' . now()->format('d/m/Y');
            }
        }

        $data = [
            'laporan'        => $laporan,
            'laporan_type'   => $jenisLaporan ?: 'custom',
            'generated_date' => now()->format('d/m/Y H:i:s'),
            'total_records'  => $laporan->count(),
            'total_berat'    => $laporan->sum('berat'),
            'periode_label'  => $periodeLabel,
            'bulan'          => $bulan,
            'tahun'          => $tahun,
        ];

        return view('exports.laporan-pdf', $data)->render();
    }

    /**
     * Format number helper
     */
    private function formatNumber($number)
    {
        return number_format($number, 0, ',', '.');
    }
}
