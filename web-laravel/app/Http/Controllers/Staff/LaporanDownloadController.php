<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanDownloadController extends Controller
{
    /**
     * Download laporan dalam format PDF atau Excel
     */
    public function download(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'format' => 'required|in:pdf,excel,word',
                'laporan_id' => 'nullable|string',
                'laporan_type' => 'nullable|in:daily,monthly,custom',
                'tpi_id' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
            ]);

            // Jika download berdasarkan laporan_id, ambil satu laporan saja
            if (!empty($validated['laporan_id'])) {
                $laporanItem = Laporan::where('idLaporan', $validated['laporan_id'])
                    ->where('status', 'validated')
                    ->first();

                if (!$laporanItem) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Laporan tidak ditemukan atau belum divalidasi'
                    ], 404);
                }

                $laporan = collect([$laporanItem]);
                $validated['laporan_type'] = 'single';
            } else {
                $validated['laporan_type'] = $validated['laporan_type'] ?? 'daily';

                // Get laporan berdasarkan filter
                $query = Laporan::query();

                // Filter berdasarkan tipe laporan
                if ($validated['laporan_type'] === 'daily') {
                    $query->whereDate('tanggalInput', today());
                } elseif ($validated['laporan_type'] === 'monthly') {
                    $query->whereMonth('tanggalInput', now()->month)
                        ->whereYear('tanggalInput', now()->year);
                } elseif ($validated['laporan_type'] === 'custom') {
                    if ($request->has('start_date') && $request->has('end_date')) {
                        $query->whereBetween('tanggalInput', [
                            $validated['start_date'],
                            $validated['end_date']
                        ]);
                    }
                }

                // Filter berdasarkan TPI jika ada
                if ($request->has('tpi_id') && !empty($validated['tpi_id'])) {
                    $query->where('namaTPI', $validated['tpi_id']);
                }

                // Filter hanya laporan yang sudah validated
                $query->where('status', 'validated');

                // Ordering
                $laporan = $query->orderBy('tanggalInput', 'desc')
                    ->orderBy('idLaporan', 'asc')
                    ->get();

                if ($laporan->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada data laporan yang sesuai dengan filter'
                    ], 404);
                }
            }

            // Generate file berdasarkan format
            if ($validated['format'] === 'pdf') {
                return $this->generatePDF($laporan, $validated);
            } elseif ($validated['format'] === 'excel') {
                return $this->generateExcel($laporan, $validated);
            }

            return $this->generateWord($laporan, $validated);
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
     * Generate PDF file
     */
    private function generatePDF($laporan, $validated)
    {
        $fileName = 'Laporan_' . $validated['laporan_type'] . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        $data = [
            'laporan' => $laporan,
            'laporan_type' => $validated['laporan_type'],
            'generated_date' => now()->format('d/m/Y H:i:s'),
            'total_records' => $laporan->count(),
            'total_berat' => $laporan->sum('beratTotal'),
        ];

        $pdf = Pdf::loadView('exports.laporan-pdf', $data)
            ->setOption('margin-top', 15)
            ->setOption('margin-bottom', 15)
            ->setOption('margin-left', 15)
            ->setOption('margin-right', 15);

        return $pdf->download($fileName);
    }

    /**
     * Generate Excel file
     */
    private function generateExcel($laporan, $validated)
    {
        $fileName = 'Laporan_' . $validated['laporan_type'] . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new LaporanExport($laporan, $validated),
            $fileName
        );
    }

    private function generateWord($laporan, $validated)
    {
        $fileName = 'Laporan_' . $validated['laporan_type'] . '_' . now()->format('Y-m-d_H-i-s') . '.doc';
        $data = [
            'laporan' => $laporan,
            'laporan_type' => $validated['laporan_type'],
            'generated_date' => now()->format('d/m/Y H:i:s'),
            'total_records' => $laporan->count(),
            'total_berat' => $laporan->sum('beratTotal'),
        ];

        $html = view('exports.laporan-pdf', $data)->render();

        return response($html, 200, [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * Get preview data untuk modal
     */
    public function preview(Request $request)
    {
        try {
            $validated = $request->validate([
                'laporan_type' => 'required|in:daily,monthly,custom',
                'tpi_id' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
            ]);

            $query = Laporan::query();

            if ($validated['laporan_type'] === 'daily') {
                $query->whereDate('tanggalInput', today());
            } elseif ($validated['laporan_type'] === 'monthly') {
                $query->whereMonth('tanggalInput', now()->month)
                    ->whereYear('tanggalInput', now()->year);
            } elseif ($validated['laporan_type'] === 'custom') {
                if ($request->has('start_date') && $request->has('end_date')) {
                    $query->whereBetween('tanggalInput', [
                        $validated['start_date'],
                        $validated['end_date']
                    ]);
                }
            }

            if ($request->has('tpi_id') && !empty($validated['tpi_id'])) {
                $query->where('namaTPI', $validated['tpi_id']);
            }

            $query->where('status', 'validated');

            $laporan = $query->orderBy('tanggalInput', 'desc')
                ->orderBy('idLaporan', 'asc')
                ->take(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_records' => $query->count(),
                    'preview_records' => $laporan->count(),
                    'total_berat' => $query->sum('beratTotal'),
                    'records' => $laporan->map(function ($item) {
                        return [
                            'idLaporan' => $item->idLaporan,
                            'namaTPI' => $item->namaTPI,
                            'jenisIkan' => $item->jenisIkan,
                            'beratTotal' => $item->beratTotal,
                            'tanggalTangkap' => $item->tanggalTangkap->format('d/m/Y'),
                            'tanggalInput' => $item->tanggalInput->format('d/m/Y H:i'),
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
