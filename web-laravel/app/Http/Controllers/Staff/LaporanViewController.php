<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class LaporanViewController extends Controller
{
    /**
     * Display laporan list
     */
    public function index()
    {
        $laporans = Laporan::where('idUser', Auth::id())
            ->orderBy('tanggalInput', 'desc')
            ->paginate(10);

        return view('Staff.laporan', compact('laporans'));
    }

    /**
     * Show detail laporan
     */
    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Ensure user can only view their own reports
        if ($laporan->idUser != Auth::id()) {
            abort(403);
        }

        return view('Staff.laporan-detail', compact('laporan'));
    }
}
