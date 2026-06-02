<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Tangkapan;
use App\Models\Notification;
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

        // Filter by validation status - show records for validation (includes Draft as pending)
        $validStatuses = ['Draft', 'Menunggu Validasi', 'Divalidasi', 'Ditolak'];
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

        // Count stats (count Draft as pending for validation)
        $stats = [
            'pending' => Tangkapan::whereIn('status', ['Draft', 'Menunggu Validasi'])->count(),
            'validated' => Tangkapan::where('status', 'Divalidasi')
                ->whereDate('updated_at', '=', today())
                ->count(),
            'totalVolume' => Tangkapan::where('status', 'Divalidasi')
                ->sum('berat'),
            'anomaly' => Tangkapan::whereIn('status', ['Draft', 'Menunggu Validasi'])
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

        if (!in_array($tangkapan->status, ['Draft', 'Menunggu Validasi'])) {
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

        if (!in_array($tangkapan->status, ['Draft', 'Menunggu Validasi', 'Revisi'])) {
            return redirect()->route('staff.validasi')->with('error', 'Data sudah diproses sebelumnya');
        }

        // Update tangkapan dengan status Revisi dan tracking info
        $tangkapan->update([
            'status' => 'Revisi',
            'catatan' => $request->catatan,
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'revision_needed' => true,
        ]);

        // Create notification untuk juru rekap (pembuat data)
        Notification::create([
            'user_id' => $tangkapan->user_id,
            'tangkapan_id' => $tangkapan->id,
            'type' => 'rejection',
            'message' => 'Data hasil tangkap Anda untuk ' . $tangkapan->jenis_ikan . ' (' . $tangkapan->berat . ' kg) ditolak oleh staff validasi. Alasan: ' . $request->catatan . '. Silakan lakukan revisi.',
            'read' => false,
        ]);

        return redirect()->route('staff.validasi')->with('success', 'Data berhasil ditolak dan notifikasi telah dikirim ke juru rekap');
    }
}
