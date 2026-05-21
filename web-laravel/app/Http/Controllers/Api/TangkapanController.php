<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tangkapan;

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
}
