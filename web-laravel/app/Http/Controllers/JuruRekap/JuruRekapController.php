<?php

namespace App\Http\Controllers\JuruRekap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Tangkapan;
use App\Models\Ikan;
use Carbon\Carbon;

class JuruRekapController extends Controller
{
    /**
     * Show Juru Rekap Dashboard
     */
    public function dashboard()
    {
        $userId = Auth::id();
        
        // Month stats
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // User stats
        $userTotalKg = Tangkapan::where('user_id', $userId)->sum('berat');
        $userTotalTon = round($userTotalKg / 1000, 1);
        $userCount = Tangkapan::where('user_id', $userId)->count();

        // Global stats (Monthly) for Sipetang overall info card
        $globalKg = Tangkapan::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->sum('berat');
        $globalTon = round($globalKg / 1000, 1);

        $lastUpdate = Tangkapan::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->max('created_at');
        $formattedLastUpdate = $lastUpdate ? Carbon::parse($lastUpdate)->translatedFormat('d F Y') : 'Belum ada data';

        // Retrieve weather data securely
        $cuacaData = [
            'cuaca' => 'Cerah Berawan',
            'peringatan' => 'Wilayah Utara Kondisi Aman',
            'suhu' => '30°C',
            'kecepatan_angin' => '10 km/jam',
            'arah_angin' => 'Utara',
            'prakiraan_hourly' => []
        ];

        try {
            $cuacaController = new \App\Http\Controllers\Api\CuacaController();
            $response = $cuacaController->getCuaca();
            if ($response instanceof \Illuminate\Http\JsonResponse) {
                $responseData = $response->getData(true);
                if (($responseData['status'] ?? '') === 'success') {
                    $cuacaData = $responseData['data'];
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to load weather: ' . $e->getMessage());
        }

        // Catch trend for the current user (last 6 months)
        $trendLabels = [];
        $trendValues = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $trendLabels[] = $date->translatedFormat('M');
            
            $totalKg = Tangkapan::where('user_id', $userId)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('berat');
            $trendValues[] = round($totalKg / 1000, 1);
        }

        // Recent catches (latest 5)
        $recentCatches = Tangkapan::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('JuruRekap.dashboard', compact(
            'userTotalTon',
            'userCount',
            'globalTon',
            'formattedLastUpdate',
            'cuacaData',
            'trendLabels',
            'trendValues',
            'recentCatches'
        ));
    }

    /**
     * Show Manage Catch page
     */
    public function kelola(Request $request)
    {
        $userId = Auth::id();
        $ikanList = Ikan::pluck('nama_ikan');

        // Filter parameters
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $jenisIkan = $request->input('jenis_ikan', '');

        // Query catches
        $query = Tangkapan::where('user_id', $userId)
            ->whereDate('created_at', $tanggal);

        if (!empty($jenisIkan)) {
            $query->where('jenis_ikan', $jenisIkan);
        }

        // Total weight & count for today based on filters
        $totalBerat = Tangkapan::where('user_id', $userId)
            ->whereDate('created_at', $tanggal)
            ->sum('berat');
        
        $totalProduksi = Tangkapan::where('user_id', $userId)
            ->whereDate('created_at', $tanggal)
            ->count();

        $catches = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Check if there are any Draft records on this date for this user
        $hasDrafts = Tangkapan::where('user_id', $userId)
            ->whereDate('created_at', $tanggal)
            ->where('status', 'Draft')
            ->exists();

        return view('JuruRekap.kelola', compact(
            'ikanList',
            'tanggal',
            'jenisIkan',
            'catches',
            'totalBerat',
            'totalProduksi',
            'hasDrafts'
        ));
    }

    /**
     * Store new catch record (Default status: Draft)
     */
    public function storeCatch(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'nama_nelayan' => 'required|string|max:255',
            'jenis_ikan' => 'required|string|max:255',
            'berat' => 'required|numeric|min:0.01',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        Tangkapan::create([
            'user_id' => Auth::id(),
            'nama_pembeli' => $request->nama_pembeli,
            'nama_nelayan' => $request->nama_nelayan,
            'jenis_ikan' => $request->jenis_ikan,
            'berat' => $request->berat,
            'harga_jual' => $request->harga_jual,
            'status' => 'Draft',
        ]);

        return redirect()->route('jururekap.kelola')->with('success', 'Data hasil tangkap berhasil disimpan sebagai Draft!');
    }

    /**
     * Submit all Draft catches of a date to Staff validation
     */
    public function sendToStaff(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date'
        ]);

        $userId = Auth::id();
        $tanggal = $request->tanggal;

        $drafts = Tangkapan::where('user_id', $userId)
            ->whereDate('created_at', $tanggal)
            ->where('status', 'Draft')
            ->get();

        if ($drafts->isEmpty()) {
            return back()->with('error', 'Tidak ada data Draft pada tanggal ini yang bisa dikirim.');
        }

        // Update status for all draft records of this date
        Tangkapan::where('user_id', $userId)
            ->whereDate('created_at', $tanggal)
            ->where('status', 'Draft')
            ->update([
                'status' => 'Menunggu Validasi',
                'revision_needed' => false
            ]);

        // Create notification for staff validation
        $user = Auth::user();
        $tpiName = $user->wilayah ?? 'TPI';

        foreach ($drafts as $draft) {
            \App\Models\Notification::create([
                'user_id' => $userId,
                'tangkapan_id' => $draft->id,
                'type' => 'submission',
                'message' => 'Data hasil tangkap (' . $draft->jenis_ikan . ' - ' . $draft->berat . ' kg) dari ' . $tpiName . ' telah dikirim untuk validasi.',
                'read' => false,
            ]);
        }

        return back()->with('success', 'Berhasil mengirim ' . $drafts->count() . ' data ke Staf Dinas untuk divalidasi!');
    }

    /**
     * Show History and Revisions page
     */
    public function riwayat()
    {
        $userId = Auth::id();
        $ikanList = Ikan::pluck('nama_ikan');

        // Get rejected data that needs revision
        $revisions = Tangkapan::where('user_id', $userId)
            ->where('status', 'Ditolak')
            ->orderBy('rejected_at', 'desc')
            ->get();

        // Get all catch history
        $history = Tangkapan::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('JuruRekap.riwayat', compact('revisions', 'history', 'ikanList'));
    }

    /**
     * Submit revised catch data
     */
    public function submitRevisi(Request $request, $id)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'nama_nelayan' => 'required|string|max:255',
            'jenis_ikan' => 'required|string|max:255',
            'berat' => 'required|numeric|min:0.01',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        $tangkapan = Tangkapan::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'Ditolak')
            ->firstOrFail();

        $tangkapan->update([
            'nama_pembeli' => $request->nama_pembeli,
            'nama_nelayan' => $request->nama_nelayan,
            'jenis_ikan' => $request->jenis_ikan,
            'berat' => $request->berat,
            'harga_jual' => $request->harga_jual,
            'status' => 'Menunggu Validasi',
            'revision_needed' => false
        ]);

        // Mark associated notifications as read
        \App\Models\Notification::where('tangkapan_id', $id)
            ->where('user_id', Auth::id())
            ->update(['read' => true]);

        return redirect()->route('jururekap.riwayat')->with('success', 'Data revisi berhasil dikirim untuk divalidasi ulang!');
    }

    /**
     * Show Juru Rekap Profile
     */
    public function profile()
    {
        return view('JuruRekap.profile');
    }

    /**
     * Update Profile Photo
     */
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'profil_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store file to public disk (profil folder)
            $file->storeAs('profil', $filename, 'public');

            // Delete previous photo if it exists
            if ($user->foto_profil && Storage::disk('public')->exists('profil/' . $user->foto_profil)) {
                Storage::disk('public')->delete('profil/' . $user->foto_profil);
            }

            $user->foto_profil = $filename;
            $user->save();

            return back()->with('success', 'Foto profil Anda berhasil diperbarui!');
        }

        return back()->with('error', 'Gagal memperbarui foto profil. File tidak ditemukan.');
    }
}
