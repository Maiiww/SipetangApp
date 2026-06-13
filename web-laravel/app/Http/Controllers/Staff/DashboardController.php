<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tangkapan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * Show the staff dashboard
     */
    public function index()
    {
        // Get current month date range
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Count total Juru Rekap users
        $totalJuruRekap = User::where('role', 'juruRekap')->orWhere('role', 'juru_rekap')->count();

        // Count total Tangkapan (Laporan Masuk)
        $totalTangkapan = Tangkapan::count();

        // Count Tangkapan with status "Menunggu Validasi" (Validasi Tertunda)
        $validasiTertunda = Tangkapan::where('status', 'Menunggu Validasi')->count();

        // Sum total production (berat) for current month — hanya yang sudah Divalidasi
        // (konsisten dengan StatistikController yang juga hanya hitung status "Divalidasi")
        $produksiBulan = Tangkapan::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Divalidasi')
            ->sum('berat');

        // Count validated records
        $validasiSelesai = Tangkapan::where('status', 'Divalidasi')->count();

        // Calculate validation percentage
        $persentaseValidasi = $totalTangkapan > 0 ? round(($validasiSelesai / $totalTangkapan) * 100) : 0;

        // Count anomalies (records with unusual weight > 100 kg or status issues)
        $anomaliDetected = Tangkapan::where('status', 'Ditolak')->count();

        $statistik = [
            'totalUser' => $totalJuruRekap,
            'produksiBulan' => round($produksiBulan / 1000, 2), // Convert to ton
            'totalLaporan' => $totalTangkapan,
            'validasiTertunda' => $validasiTertunda,
            'persentaseValidasi' => $persentaseValidasi,
            'anomaliDetected' => $anomaliDetected,
        ];

        // Data Aktivitas Terbaru (5 tangkapan/laporan terakhir dari juru rekap)
        $tangkapanTerbaru = Tangkapan::with('user')
            ->whereIn('status', ['Menunggu Validasi', 'Divalidasi', 'Ditolak', 'Draft'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $aktivitasTerbaru = [];
        $avatarColors = ['#dbeafe', '#fef3c7', '#dcfce7', '#fee2e2', '#f3e8ff'];
        $counter = 0;

        foreach ($tangkapanTerbaru as $tangkapan) {
            $aktivitasTerbaru[] = [
                'id'       => $tangkapan->id,
                'nama'     => $tangkapan->user->nama ?? $tangkapan->user->username ?? 'Juru Rekap',
                'lokasi'   => optional($tangkapan->user)->wilayah ?? '-',
                'status'   => $tangkapan->status,
                'waktu'    => $tangkapan->created_at,
                'jenis'    => $tangkapan->jenis_ikan,
                'berat'    => $tangkapan->berat,
                'avatar'   => $this->getInitials($tangkapan->user->nama ?? $tangkapan->user->username ?? 'JR'),
                'avatarBg' => $avatarColors[$counter % 5],
            ];
            $counter++;
        }

        return view('Staff.dashboard', [
            'statistik' => $statistik,
            'aktivitas' => collect($aktivitasTerbaru),
            'user'      => auth()->user(),
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
