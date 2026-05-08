<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik Dashboard
        $totalUser = User::count();
        $totalLaporan = Laporan::count();
        $validasiTertunda = Laporan::where('status', 'pending')->count();

        // Produksi bulan ini
        $bulanIni = Carbon::now()->startOfMonth();
        $produksiBulan = Laporan::whereDate('tanggalInput', '>=', $bulanIni)
            ->sum('beratTotal');

        // Persentase validasi berhasil
        $totalValidasi = Laporan::whereIn('status', ['validated', 'rejected'])->count();
        $persentaseValidasi = $totalValidasi > 0 ? round(Laporan::where('status', 'validated')->count() / $totalValidasi * 100) : 0;

        // Anomali terdeteksi (laporan dengan berat tidak wajar > 100 ton)
        $anomaliDetected = Laporan::where('beratTotal', '>', 100)->count();

        $statistik = [
            'totalUser' => $totalUser,
            'totalLaporan' => $totalLaporan,
            'produksiBulan' => number_format($produksiBulan, 2),
            'validasiTertunda' => $validasiTertunda,
            'persentaseValidasi' => $persentaseValidasi,
            'anomaliDetected' => $anomaliDetected,
        ];

        // Aktivitas terbaru (ambil 5 laporan terakhir)
        $laporanTerbaru = Laporan::with('user')
            ->orderBy('tanggalInput', 'desc')
            ->take(5)
            ->get();

        $aktivitas = [];
        $avatarColors = ['e0f2fe', 'f0fdf4', 'fef3c7'];
        $counter = 0;

        foreach ($laporanTerbaru as $laporan) {
            $status = $laporan->status === 'validated' ? 'validated' : 'pending';

            $aktivitas[] = [
                'nama' => $laporan->user->username ?? 'Unknown',
                'lokasi' => $laporan->namaTPI,
                'status' => $status,
                'waktu' => $laporan->tanggalInput,
                'avatar' => strtoupper(substr($laporan->user->username ?? 'U', 0, 1)),
                'avatarBg' => $avatarColors[$counter % 3],
            ];
            $counter++;
        }

        return view('Staff.dashboard', compact('statistik', 'aktivitas'));
    }
}
