<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Laporan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the staff dashboard
     */
    public function index()
    {
        // Total Data User
        $totalUser = User::count();

        // Total Laporan dari database
        $totalLaporan = Laporan::count();

        // Validasi Tertunda (status pending)
        $validasiTertunda = Laporan::where('status', 'pending')->count();

        // Produksi bulan ini
        $bulanIni = Carbon::now()->startOfMonth();
        $produksiBulan = Laporan::where('tanggalInput', '>=', $bulanIni)->sum('beratTotal');

        // Persentase validasi berhasil
        $totalValidasiDone = Laporan::whereIn('status', ['validated', 'rejected'])->count();
        $validasiSuccess = Laporan::where('status', 'validated')->count();
        $persentaseValidasi = $totalValidasiDone > 0 ? round($validasiSuccess / $totalValidasiDone * 100) : 0;

        // Anomali terdeteksi (berat > 100 ton dianggap anomali)
        $anomaliDetected = Laporan::where('beratTotal', '>', 100)->count();

        // Statistik Dashboard
        $statistik = [
            'totalUser' => $totalUser,
            'produksiBulan' => number_format($produksiBulan, 2),
            'totalLaporan' => $totalLaporan,
            'validasiTertunda' => $validasiTertunda,
            'persentaseValidasi' => $persentaseValidasi,
            'anomaliDetected' => $anomaliDetected,
        ];

        // Data Aktivitas Terbaru (5 laporan terakhir dari database)
        $laporanTerbaru = Laporan::with('user')
            ->orderBy('tanggalInput', 'desc')
            ->limit(5)
            ->get();

        $aktivitasTerbaru = [];
        $avatarColors = ['e0f2fe', 'fef3c7', 'f0fdf4'];
        $counter = 0;

        foreach ($laporanTerbaru as $laporan) {
            $aktivitasTerbaru[] = [
                'id' => $laporan->idLaporan,
                'nama' => $laporan->user->username ?? 'Staff',
                'lokasi' => $laporan->namaTPI,
                'status' => $laporan->status,
                'waktu' => $laporan->tanggalInput,
                'jenis' => $laporan->jenisIkan,
                'berat' => $laporan->beratTotal,
                'avatar' => $this->getInitials($laporan->user->username ?? 'XX'),
                'avatarBg' => $avatarColors[$counter % 3]
            ];
            $counter++;
        }

        return view('Staff.dashboard', [
            'statistik' => $statistik,
            'aktivitas' => collect($aktivitasTerbaru),
        ]);
    }

    /**
     * Get initials dari nama user
     */
    private function getInitials($nama)
    {
        $words = explode(' ', trim($nama));
        $initials = '';
        foreach ($words as $word) {
            if (strlen($word) > 0) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        return substr($initials, 0, 2) ?: 'XX';
    }

    /**
     * Get avatar background color berdasarkan status
     */
    private function getAvatarColor($status)
    {
        $colors = [
            'validated' => 'e0f2fe',
            'pending' => 'fef3c7',
            'rejected' => 'fee2e2',
        ];

        return $colors[$status] ?? 'f0fdf4';
    }

    /**
     * Get dashboard stats API (untuk fetch data real-time)
     */
    public function getStats()
    {
        return response()->json([
            'totalUser' => User::count(),
            'produksiBulan' => rand(80, 250) / 10,
            'totalLaporan' => rand(400, 600),
            'validasiTertunda' => rand(5, 20),
            'persentaseValidasi' => rand(75, 95),
            'anomaliDetected' => rand(0, 10),
        ]);
    }

    /**
     * Get recent activities API
     */
    public function getActivities()
    {
        $users = User::limit(15)->get();
        $tpi = ['Blanakan', 'Patimban', 'Pondok Bali', 'Mayangan', 'Legonkulon'];
        $ikan = ['Kembung', 'Tongkol', 'Cumi-cumi', 'Tenggiri', 'Cakalang'];
        $status = ['validated', 'pending', 'validated'];

        $aktivitas = [];
        foreach ($users as $user) {
            $aktivitas[] = [
                'id' => 'LPR' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                'username' => $user->username,
                'lokasi' => $tpi[array_rand($tpi)],
                'status' => $status[array_rand($status)],
                'waktu' => now()->subHours(rand(1, 168)),
                'jenis' => $ikan[array_rand($ikan)],
                'berat' => rand(50, 500) / 10,
            ];
        }

        return response()->json($aktivitas);
    }
}
