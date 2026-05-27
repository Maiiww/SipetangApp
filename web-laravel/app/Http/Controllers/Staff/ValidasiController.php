<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Tangkapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    /**
     * Display validation list - Show all tangkapan with "Menunggu Validasi" status
     * Supports search and filter functionality
     */
    public function index(Request $request)
    {
        // Get search and filter parameters
        $search = $request->input('search', '');
        $statusFilter = $request->input('status', '');

        // Build query
        $query = Tangkapan::query();

        // Filter by validation status - show records for validation (all statuses for staff review)
        $validStatuses = ['Menunggu Validasi', 'Divalidasi', 'Ditolak'];
        $query->whereIn('status', $validStatuses);

        // If specific status filter selected, apply it
        if (!empty($statusFilter) && in_array($statusFilter, $validStatuses)) {
            $query->where('status', $statusFilter);
        }

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('nama_pembeli', 'like', '%' . $search . '%')
                    ->orWhere('nama_nelayan', 'like', '%' . $search . '%')
                    ->orWhere('jenis_ikan', 'like', '%' . $search . '%');
            });
        }

        // Get tangkapans with pagination
        $laporans = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Count stats
        $stats = [
            'pending' => Tangkapan::where('status', 'Menunggu Validasi')->count(),
            'validated' => Tangkapan::where('status', 'Divalidasi')
                ->whereDate('updated_at', today())
                ->count(),
            'totalVolume' => Tangkapan::where('status', 'Divalidasi')
                ->sum('berat'),
            'anomaly' => Tangkapan::where('status', 'Menunggu Validasi')
                ->where('berat', '>', 5)
                ->count(),
        ];

        return view('Staff.validasi-laporan', compact('laporans', 'stats', 'search', 'statusFilter'));
    }

    /**
     * Show detail tangkapan for validation
     */
    public function show($id)
    {
        $laporan = Tangkapan::findOrFail($id);
        return view('Staff.validasi-detail', compact('laporan'));
    }

    /**
     * Validate tangkapan
     */
    public function validate(Request $request, $id)
    {
        $tangkapan = Tangkapan::findOrFail($id);

        if ($tangkapan->status !== 'Menunggu Validasi') {
            return redirect()->route('staff.validasi')->with('error', 'Data sudah diproses sebelumnya');
        }

        $tangkapan->update([
            'status' => 'Divalidasi',
        ]);

        return redirect()->route('staff.validasi')->with('success', 'Data berhasil divalidasi');
    }

    /**
     * Reject tangkapan
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        $tangkapan = Tangkapan::findOrFail($id);

        if ($tangkapan->status !== 'Menunggu Validasi') {
            return redirect()->route('staff.validasi')->with('error', 'Data sudah diproses sebelumnya');
        }

        $tangkapan->update([
            'status' => 'Ditolak',
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('staff.validasi')->with('success', 'Data berhasil ditolak');
    }
}
