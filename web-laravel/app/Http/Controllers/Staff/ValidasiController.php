<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Tangkapan;
use App\Models\Notification;
use App\Models\User;
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
        $search = $request->input('search', '');
        $statusFilter = $request->input('status', '');
        $tpiFilter = $request->input('tpi', '');

        // Daftar 8 TPI yang tersedia
        $tpiOptions = ['Patimban', 'Genteng', 'Mayangan', 'Cirewang', 'Muara Ciasem', 'Blanakan', 'Rawameneng', 'Cilamaya Girang'];

        // Build query
        $query = Tangkapan::query();
        $currentUser = Auth::user();

        // Filter berdasarkan pilihan TPI dari dropdown
        if (!empty($tpiFilter) && in_array($tpiFilter, $tpiOptions)) {
            // Filter berdasarkan wilayah user yang memasukkan data
            $query->whereHas('user', function ($q) use ($tpiFilter) {
                $q->where('wilayah', $tpiFilter);
            });
        } elseif ($currentUser->role === 'staff' && !empty($currentUser->wilayah)) {
            // Staff default: tampilkan data dari TPI mereka saja
            $query->whereHas('user', function ($q) use ($currentUser) {
                $q->where('wilayah', $currentUser->wilayah);
            });
        }

        // Filter by validation status
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

        // Count stats based on filtered data
        $statQuery = Tangkapan::query();
        if (!empty($tpiFilter) && in_array($tpiFilter, $tpiOptions)) {
            $statQuery->whereHas('user', function ($q) use ($tpiFilter) {
                $q->where('wilayah', $tpiFilter);
            });
        } elseif ($currentUser->role === 'staff' && !empty($currentUser->wilayah)) {
            $statQuery->whereHas('user', function ($q) use ($currentUser) {
                $q->where('wilayah', $currentUser->wilayah);
            });
        }

        $stats = [
            'pending' => $statQuery->clone()->whereIn('status', ['Draft', 'Menunggu Validasi'])->count(),
            'validated' => $statQuery->clone()->where('status', 'Divalidasi')
                ->whereDate('updated_at', '=', today())
                ->count(),
            'totalVolume' => $statQuery->clone()->where('status', 'Divalidasi')
                ->sum('berat'),
            'anomaly' => $statQuery->clone()->whereIn('status', ['Draft', 'Menunggu Validasi'])
                ->where('berat', '>', 5)
                ->count(),
        ];

        return view('Staff.validasi-laporan', compact('laporans', 'stats', 'search', 'statusFilter', 'tpiFilter', 'tpiOptions', 'currentUser'));
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

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        $tangkapan = Tangkapan::findOrFail($id);

        if (!in_array($tangkapan->status, ['Draft', 'Menunggu Validasi', 'Revisi'])) {
            return redirect()->route('staff.validasi')->with('error', 'Data sudah diproses sebelumnya');
        }


        $tangkapan->update([
            'status' => 'Ditolak',
            'catatan' => $request->catatan,
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'revision_needed' => true,
        ]);

        Notification::create([
            'user_id' => $tangkapan->user_id,
            'tangkapan_id' => $tangkapan->id,
            'type' => 'rejection',
            'message' => 'Data hasil tangkap Anda untuk ' . $tangkapan->jenis_ikan . ' (' . $tangkapan->berat . ' kg) ditolak oleh staff validasi. Alasan: ' . $request->catatan . '. Silakan lakukan revisi.',
            'read' => false,
        ]);

        return redirect()->route('staff.validasi')->with('success', 'Data berhasil ditolak dan notifikasi telah dikirim ke juru rekap');
    }

    public function bulkValidate(Request $request)
    {
        $request->validate([
            'tangkapan_ids' => 'required|array',
            'tangkapan_ids.*' => 'exists:tangkapan,id'
        ]);

        Tangkapan::whereIn('id', $request->tangkapan_ids)
            ->update(['status' => 'Divalidasi']);

        return redirect()->route('staff.validasi')->with('success', 'Data terpilih berhasil divalidasi massal');
    }
}
