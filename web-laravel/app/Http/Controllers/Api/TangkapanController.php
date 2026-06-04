<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tangkapan;
use Carbon\Carbon;

class TangkapanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->query('tanggal', date('Y-m-d'));

        $userId = $request->query('user_id');

        $totalBerat = Tangkapan::whereDate('created_at', $tanggal)
                               ->where('user_id', $userId)
                               ->sum('berat');
                               
        $totalProduksi = Tangkapan::whereDate('created_at', $tanggal)
                                  ->where('user_id', $userId)
                                  ->count();

        $tangkapan = Tangkapan::whereDate('created_at', $tanggal)
                              ->where('user_id', $userId)
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);

        return response()->json([
            'status' => 'success',
            'statistik' => [
                'total_berat' => $totalBerat,
                'total_produksi' => $totalProduksi,
                'tanggal' => $tanggal
            ],
            'data' => $tangkapan
        ], 200);
    }

    public function totalProduksi()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalKg = Tangkapan::whereMonth('created_at', $bulanIni)
                        ->whereYear('created_at', $tahunIni)
                        ->sum('berat');

        $totalTon = $totalKg / 1000;

        $lastUpdate = Tangkapan::whereMonth('created_at', $bulanIni)
                           ->whereYear('created_at', $tahunIni)
                           ->max('created_at');

        $formattedDate = $lastUpdate ? Carbon::parse($lastUpdate)->translatedFormat('d F Y') : 'Belum ada data bulan ini';

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_ton' => round($totalTon, 1),
                'last_update' => $formattedDate
            ]
        ]);                   
    }

    public function sendToStaff(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'user_id' => 'required|integer'
        ]);

        $updated = Tangkapan::whereDate('created_at', $request->tanggal)
            ->where('user_id', $request->user_id)
            ->where('status', 'Draft')
            ->update(['status' => 'Menunggu Validasi']);

        if ($updated > 0) {
            return response()->json([
                'status' => 'success',
                'message' => "Berhasil mengirim $updated data ke Staf Dinas!"
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Tidak ada data Draft pada tanggal ini yang bisa dikirim.'
        ], 404);
    }

    public function countRevisi(Request $request)
    {
        $userId = $request->query('user_id');

        $jumlah = Tangkapan::where('user_id', $userId)
                           ->where('status', 'Ditolak')
                           ->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'jumlah_revisi' => $jumlah
            ]
        ], 200);
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer', 
            'nama_pembeli' => 'required|string',
            'nama_nelayan' => 'required|string',
            'jenis_ikan' => 'required|string',
            'berat' => 'required|numeric',
            'harga_jual' => 'required|numeric'
        ]);

        $tangkapan = Tangkapan::create([
            'user_id' => $request->user_id,
            'nama_pembeli' => $request->nama_pembeli,
            'nama_nelayan' => $request->nama_nelayan,
            'jenis_ikan' => $request->jenis_ikan,
            'berat' => $request->berat,
            'harga_jual' => $request->harga_jual,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan!',
            'data' => $tangkapan
        ], 201);
    }

    public function riwayat(Request $request)
    {
        $userId = $request->query('user_id');

        $perluRevisi = Tangkapan::where('user_id', $userId)
            ->where('status', 'Ditolak')
            ->orderBy('updated_at', 'desc')
            ->get();

        $semuaRiwayat = Tangkapan::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'perlu_revisi' => $perluRevisi,
                'semua_riwayat' => $semuaRiwayat
            ]
        ], 200);
    }
}
