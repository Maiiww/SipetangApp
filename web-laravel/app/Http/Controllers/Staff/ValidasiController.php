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
        $dateFilter = $request->input('date', '');

        // Daftar 8 TPI yang tersedia
        $tpiOptions = ['Patimban', 'Genteng', 'Mayangan', 'Cirewang', 'Muara Ciasem', 'Blanakan', 'Rawameneng', 'Cilamaya Girang'];

        // Build query
        $query = Tangkapan::query();
        $currentUser = Auth::user();

        // Semua Staff & Admin bisa melihat seluruh data TPI (Tidak dibatasi wilayah)
        // Boleh memfilter berdasarkan tpiFilter jika ada
        if (!empty($tpiFilter) && in_array($tpiFilter, $tpiOptions)) {
            $query->whereHas('user', function ($q) use ($tpiFilter) {
                $q->where('wilayah', 'LIKE', '%' . $tpiFilter . '%');
            });
        }

        // Filter by validation status (hanya tampil yang valid)
        $validStatuses = ['Draft', 'Menunggu Validasi', 'Divalidasi', 'Ditolak'];
        $query->whereIn('status', $validStatuses);

        // If specific status filter selected, apply it
        if (!empty($statusFilter) && in_array($statusFilter, $validStatuses)) {
            if ($statusFilter === 'Menunggu Validasi') {
                $query->whereIn('status', ['Draft', 'Menunggu Validasi']);
            } else {
                $query->where('status', $statusFilter);
            }
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

        // Apply date filter
        if (!empty($dateFilter)) {
            $query->whereDate('created_at', '=', $dateFilter);
        }

        // Get tangkapans with pagination
        $laporans = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Count stats based on filtered data
        $statQuery = Tangkapan::query();

        // Apply same TPI filter untuk stats
        if (!empty($tpiFilter) && in_array($tpiFilter, $tpiOptions)) {
            $statQuery->whereHas('user', function ($q) use ($tpiFilter) {
                $q->where('wilayah', 'LIKE', '%' . $tpiFilter . '%');
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

        return view('Staff.validasi-laporan', compact('laporans', 'stats', 'search', 'statusFilter', 'tpiFilter', 'dateFilter', 'tpiOptions', 'currentUser'));
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

        // Buat notifikasi untuk juru rekap bahwa laporan telah divalidasi
        Notification::create([
            'user_id' => $tangkapan->user_id,
            'tangkapan_id' => $tangkapan->id,
            'type' => 'validation_approved',
            'message' => 'Data hasil tangkap Anda untuk ' . $tangkapan->jenis_ikan . ' (' . $tangkapan->berat . ' kg) telah berhasil divalidasi oleh staff validasi.',
            'read' => false,
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
        // === Mode Validasi Semua Halaman ===
        if ($request->input('validate_all') == '1') {
            $currentUser = Auth::user();

            $query = Tangkapan::whereIn('status', ['Draft', 'Menunggu Validasi']);

            // Tidak ada filter wilayah, Staff bisa validasi semua TPI
            $tangkapans = $query->get();

            if ($tangkapans->isEmpty()) {
                return redirect()->route('staff.validasi')->with('error', 'Tidak ada laporan yang perlu divalidasi.');
            }

            // Update semua ke Divalidasi
            $ids = $tangkapans->pluck('id')->toArray();
            Tangkapan::whereIn('id', $ids)->update(['status' => 'Divalidasi']);

            // Kirim notifikasi ke setiap juru rekap
            foreach ($tangkapans as $tangkapan) {
                Notification::create([
                    'user_id'      => $tangkapan->user_id,
                    'tangkapan_id' => $tangkapan->id,
                    'type'         => 'validation_approved',
                    'message'      => 'Data hasil tangkap Anda untuk ' . $tangkapan->jenis_ikan . ' (' . $tangkapan->berat . ' kg) telah berhasil divalidasi oleh staff validasi.',
                    'read'         => false,
                ]);
            }

            return redirect()->route('staff.validasi')->with('success', count($ids) . ' laporan dari semua halaman berhasil divalidasi.');
        }

        // === Mode Validasi Per ID (halaman saat ini) ===
        $request->validate([
            'tangkapan_ids'   => 'required|array',
            'tangkapan_ids.*' => 'exists:hasil_tangkap,id'
        ]);

        // Get tangkapan records yang akan divalidasi
        $tangkapans = Tangkapan::whereIn('id', $request->tangkapan_ids)->get();

        // Update status untuk semua
        Tangkapan::whereIn('id', $request->tangkapan_ids)
            ->update(['status' => 'Divalidasi']);

        // Create notifications untuk juru rekap
        foreach ($tangkapans as $tangkapan) {
            Notification::create([
                'user_id' => $tangkapan->user_id,
                'tangkapan_id' => $tangkapan->id,
                'type' => 'validation_approved',
                'message' => 'Data hasil tangkap Anda untuk ' . $tangkapan->jenis_ikan . ' (' . $tangkapan->berat . ' kg) telah berhasil divalidasi oleh staff validasi.',
                'read' => false,
            ]);
        }

        return redirect()->route('staff.validasi')->with('success', 'Data terpilih berhasil divalidasi massal');
    }

    /**
     * Polling endpoint: returns current pending count & latest ID
     * Used by the frontend for real-time notification without WebSockets
     */
    public function pollPending(Request $request)
    {
        $currentUser = Auth::user();
        $tpiOptions  = ['Patimban', 'Genteng', 'Mayangan', 'Cirewang', 'Muara Ciasem', 'Blanakan', 'Rawameneng', 'Cilamaya Girang'];

        $query = Tangkapan::whereIn('status', ['Draft', 'Menunggu Validasi']);

        // Tidak ada filter wilayah, poll semua TPI
        $pending   = $query->count();
        $latestId  = $query->max('id') ?? 0;

        // Get the 3 most recent new laporan for the toast detail
        $recent = $query->orderBy('id', 'desc')->limit(3)->get(['id', 'jenis_ikan', 'berat', 'created_at']);

        return response()->json([
            'pending'   => $pending,
            'latest_id' => $latestId,
            'recent'    => $recent->map(fn ($t) => [
                'id'        => $t->id,
                'jenis_ikan'=> $t->jenis_ikan,
                'berat'     => $t->berat,
                'waktu'     => $t->created_at ? $t->created_at->diffForHumans() : '-',
            ]),
        ]);
    }
}
