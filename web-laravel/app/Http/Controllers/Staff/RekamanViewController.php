<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Tangkapan;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekamanViewController extends Controller
{
    /**
     * Display data that needs revision for current user (jururekap)
     */
    public function revisiData(Request $request)
    {
        $search = $request->input('search', '');

        // Get data that needs revision (status = 'Revisi') for current user
        $query = Tangkapan::where('user_id', Auth::id())
            ->where('status', 'Revisi')
            ->where('revision_needed', true);

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('nama_pembeli', 'like', '%' . $search . '%')
                    ->orWhere('jenis_ikan', 'like', '%' . $search . '%');
            });
        }

        $dataRevisi = $query->orderBy('rejected_at', 'desc')->paginate(10);

        // Count notification untuk juru rekap
        $notificationCount = Notification::where('user_id', Auth::id())
            ->where('read', false)
            ->count();

        return view('Staff.rekaman-revisi', compact('dataRevisi', 'search', 'notificationCount'));
    }

    /**
     * Submit revision data
     */
    public function submitRevisi(Request $request, $id)
    {
        $request->validate([
            'nama_pembeli' => 'required|string',
            'nama_nelayan' => 'required|string',
            'jenis_ikan' => 'required|string',
            'berat' => 'required|numeric|min:0.1',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        $tangkapan = Tangkapan::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'Revisi')
            ->firstOrFail();

        // Update data dengan informasi revisi
        $tangkapan->update([
            'nama_pembeli' => $request->nama_pembeli,
            'nama_nelayan' => $request->nama_nelayan,
            'jenis_ikan' => $request->jenis_ikan,
            'berat' => $request->berat,
            'harga_jual' => $request->harga_jual,
            'status' => 'Menunggu Validasi', // Change back to pending validation
            'revision_needed' => false,
        ]);

        // Mark notification as read
        Notification::where('tangkapan_id', $id)
            ->where('user_id', Auth::id())
            ->update(['read' => true]);

        return redirect()->route('staff.rekaman.revisi')->with('success', 'Data revisi berhasil dikirim untuk divalidasi kembali');
    }

    /**
     * Get notifications for juru rekap
     */
    public function getNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Staff.notifikasi-revisi', compact('notifications'));
    }
}
