<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Ikan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikController extends Controller
{
    /**
     * Menampilkan halaman statistik dengan data real-time
     */
    public function index()
    {
        // Data Produksi Ikan Bulanan (12 bulan terakhir)
        $produksiBulanan = $this->getProduksiBulanan();

        // Total Produksi keseluruhan
        $totalProduksi = $this->getTotalProduksi();

        // TPI Teraktif (dengan laporan terbanyak)
        $tpiTeraktif = $this->getTpiTeraktif();

        // Komoditas Teratas
        $komoditasTop = $this->getKomoditasTop();

        // Statistik per TPI untuk region list
        $statistikTpi = $this->getStatistikTpi();

        return view('Staff.statistik', compact(
            'produksiBulanan',
            'totalProduksi',
            'tpiTeraktif',
            'komoditasTop',
            'statistikTpi'
        ));
    }

    /**
     * Ambil data produksi ikan bulanan (12 bulan terakhir)
     */
    private function getProduksiBulanan()
    {
        $months = [];
        $data = [];

        // Ambil 12 bulan terakhir
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M'),
                'full' => $date->format('Y-m'),
            ];
        }

        foreach ($months as $month) {
            $total = Laporan::whereYear('tanggalTangkap', substr($month['full'], 0, 4))
                ->whereMonth('tanggalTangkap', substr($month['full'], 5, 2))
                ->where('status', 'tervalidasi')
                ->sum('beratTotal');

            $data[] = [
                'month' => $month['month'],
                'value' => (float) $total ?: 0,
            ];
        }

        return $data;
    }

    /**
     * Ambil total produksi keseluruhan
     */
    private function getTotalProduksi()
    {
        $total = Laporan::where('status', 'tervalidasi')->sum('beratTotal');

        // Hitung pertumbuhan dibanding bulan lalu
        $thisMonthTotal = Laporan::whereYear('tanggalTangkap', Carbon::now()->year)
            ->whereMonth('tanggalTangkap', Carbon::now()->month)
            ->where('status', 'tervalidasi')
            ->sum('beratTotal');

        $lastMonthTotal = Laporan::whereYear('tanggalTangkap', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggalTangkap', Carbon::now()->subMonth()->month)
            ->where('status', 'tervalidasi')
            ->sum('beratTotal');

        $growth = $lastMonthTotal > 0 ? round((($thisMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100) : 0;

        return [
            'total' => round($total, 2),
            'totalFormatted' => $this->formatNumber($total),
            'unit' => 'Ton',
            'growth' => $growth,
            'thisMonth' => round($thisMonthTotal, 2),
            'lastMonth' => round($lastMonthTotal, 2),
        ];
    }

    /**
     * Ambil TPI teraktif (dengan laporan terbanyak)
     */
    private function getTpiTeraktif()
    {
        $tpi = Laporan::select('namaTPI', DB::raw('COUNT(*) as total_laporan'), DB::raw('SUM(beratTotal) as total_berat'))
            ->where('status', 'tervalidasi')
            ->groupBy('namaTPI')
            ->orderBy('total_laporan', 'desc')
            ->first();

        if (!$tpi) {
            return [
                'nama' => 'N/A',
                'totalLaporan' => 0,
                'totalBerat' => 0,
            ];
        }

        return [
            'nama' => $tpi->namaTPI,
            'totalLaporan' => $tpi->total_laporan,
            'totalBerat' => round($tpi->total_berat, 2),
        ];
    }

    /**
     * Ambil komoditas teratas
     */
    private function getKomoditasTop()
    {
        $komoditas = Laporan::select('jenisIkan', DB::raw('SUM(beratTotal) as total_berat'), DB::raw('COUNT(*) as jumlah'))
            ->where('status', 'tervalidasi')
            ->groupBy('jenisIkan')
            ->orderBy('total_berat', 'desc')
            ->limit(5)
            ->get();

        // Hitung total untuk persentase
        $totalKeseluruhan = $komoditas->sum('total_berat');

        $result = [];
        foreach ($komoditas as $item) {
            $percentage = $totalKeseluruhan > 0 ? round(($item->total_berat / $totalKeseluruhan) * 100) : 0;
            $result[] = [
                'nama' => $item->jenisIkan,
                'berat' => round($item->total_berat, 2),
                'persentase' => $percentage,
                'jumlah' => $item->jumlah,
            ];
        }

        return $result;
    }

    /**
     * Ambil statistik per TPI
     */
    private function getStatistikTpi()
    {
        $tpiList = Laporan::select('namaTPI', DB::raw('COUNT(*) as total_laporan'), DB::raw('SUM(beratTotal) as total_berat'))
            ->where('status', 'tervalidasi')
            ->groupBy('namaTPI')
            ->orderBy('total_laporan', 'desc')
            ->get();

        return $tpiList->map(function ($item) {
            return [
                'nama' => $item->namaTPI,
                'laporan' => $item->total_laporan,
                'berat' => round($item->total_berat, 2),
            ];
        });
    }

    /**
     * Format angka dengan K atau M
     */
    private function formatNumber($number)
    {
        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }
        return round($number, 0);
    }
}
