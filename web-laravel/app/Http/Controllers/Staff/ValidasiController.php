<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    /**
     * Display validation list - Show all laporans regardless of status
     * Supports search and filter functionality
     */
    public function index(Request $request)
    {
        // Get search and filter parameters
        $search = $request->input('search', '');
        $statusFilter = $request->input('status', 'all');

        // Build query
        $query = Laporan::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('idLaporan', 'like', '%' . $search . '%')
                    ->orWhere('namaTPI', 'like', '%' . $search . '%')
                    ->orWhere('jenisIkan', 'like', '%' . $search . '%');
            });
        }

        // Apply status filter
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        // Get laporans with pagination
        $laporans = $query->orderBy('tanggalInput', 'desc')
            ->paginate(10);

        // Count stats
        $stats = [
            'pending' => Laporan::where('status', 'pending')->count(),
            'validated' => Laporan::where('status', 'validated')
                ->whereDate('tanggalValidasi', today())
                ->count(),
            'totalVolume' => Laporan::where('status', 'validated')
                ->sum('beratTotal'),
            'anomaly' => Laporan::where('status', 'pending')
                ->where('beratTotal', '>', 5)
                ->count(),
        ];

        return view('Staff.validasi-laporan', compact('laporans', 'stats', 'search', 'statusFilter'));
    }

    /**
     * Show detail laporan for validation
     */
    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('Staff.validasi-detail', compact('laporan'));
    }

    /**
     * Validate laporan
     */
    public function validate(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->status !== 'pending') {
            return redirect()->route('staff.validasi')->with('error', 'Laporan sudah diproses sebelumnya');
        }

        $laporan->update([
            'status' => 'validated',
            'tanggalValidasi' => now(),
            'validasiOleh' => Auth::user()->username,
        ]);

        return redirect()->route('staff.validasi')->with('success', 'Laporan berhasil divalidasi');
    }

    /**
     * Reject laporan
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        $laporan = Laporan::findOrFail($id);

        if ($laporan->status !== 'pending') {
            return redirect()->route('staff.validasi')->with('error', 'Laporan sudah diproses sebelumnya');
        }

        $laporan->update([
            'status' => 'rejected',
            'tanggalValidasi' => now(),
            'validasiOleh' => Auth::user()->username,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('staff.validasi')->with('success', 'Laporan berhasil ditolak');
    }
}
