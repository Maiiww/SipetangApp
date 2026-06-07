<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Tangkapan;
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
            $total = Tangkapan::whereYear('created_at', substr($month['full'], 0, 4))
                ->whereMonth('created_at', substr($month['full'], 5, 2))
                ->where('status', 'Divalidasi')
                ->sum('berat');

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
        $total = Tangkapan::where('status', 'Divalidasi')->sum('berat');

        // Hitung pertumbuhan dibanding bulan lalu
        $thisMonthTotal = Tangkapan::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('status', 'Divalidasi')
            ->sum('berat');

        $lastMonthTotal = Tangkapan::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->where('status', 'Divalidasi')
            ->sum('berat');

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
        $tpi = Tangkapan::select(DB::raw('users.wilayah as tpi_name'), DB::raw('COUNT(*) as total_laporan'), DB::raw('SUM(berat) as total_berat'))
            ->join('users', 'hasil_tangkap.user_id', '=', 'users.id')
            ->where('hasil_tangkap.status', 'Divalidasi')
            ->groupBy('users.wilayah')
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
            'nama' => $tpi->tpi_name,
            'totalLaporan' => $tpi->total_laporan,
            'totalBerat' => round($tpi->total_berat, 2),
        ];
    }

    /**
     * Ambil komoditas teratas
     */
    private function getKomoditasTop()
    {
        $komoditas = Tangkapan::select('jenis_ikan', DB::raw('SUM(berat) as total_berat'), DB::raw('COUNT(*) as jumlah'))
            ->where('status', 'Divalidasi')
            ->groupBy('jenis_ikan')
            ->orderBy('total_berat', 'desc')
            ->limit(5)
            ->get();

        // Hitung total untuk persentase
        $totalKeseluruhan = $komoditas->sum('total_berat');

        $result = [];
        foreach ($komoditas as $item) {
            $percentage = $totalKeseluruhan > 0 ? round(($item->total_berat / $totalKeseluruhan) * 100) : 0;
            $result[] = [
                'nama' => $item->jenis_ikan,
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
        $tpiList = Tangkapan::select(DB::raw('users.wilayah as tpi_name'), DB::raw('COUNT(*) as total_laporan'), DB::raw('SUM(berat) as total_berat'))
            ->join('users', 'hasil_tangkap.user_id', '=', 'users.id')
            ->where('hasil_tangkap.status', 'Divalidasi')
            ->groupBy('users.wilayah')
            ->orderBy('total_laporan', 'desc')
            ->get();

        return $tpiList->map(function ($item) {
            return [
                'nama' => $item->tpi_name,
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
