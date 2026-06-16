<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\LaporanViewController;
use App\Http\Controllers\Staff\ValidasiController;
use App\Http\Controllers\Staff\RekamanViewController;
use App\Http\Controllers\Staff\CetakLaporanController;
use App\Http\Controllers\Staff\StatistikController;
use App\Models\User;
use App\Http\Controllers\Staff\LaporanDownloadController;
use App\Http\Controllers\JuruRekap\JuruRekapController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Logic Redirect Dashboard berdasarkan Role
    Route::get('/dashboard', function () {
        $role = strtolower(auth()->user()->role);
        if ($role === 'admin') {
            return redirect()->route('admin.manajemen.user')->with('welcome', session('welcome'));
        } elseif ($role === 'jururekap') {
            return redirect()->route('jururekap.dashboard')->with('welcome', session('welcome'));
        }
        return redirect()->route('staff.dashboard')->with('welcome', session('welcome'));
    })->name('dashboard');

    // --- DAFTAR ROUTE STAFF ---
    Route::prefix('staff')->group(function () {

        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');

        Route::get('/validasi-laporan', [ValidasiController::class, 'index'])->name('staff.validasi');
        Route::get('/validasi-laporan/poll-pending', [ValidasiController::class, 'pollPending'])->name('staff.validasi.poll');

        Route::post('/validasi-laporan/bulk', [ValidasiController::class, 'bulkValidate'])->name('staff.validasi.bulk');

        Route::post('/validasi-laporan/{id}/validate', [ValidasiController::class, 'validate'])->name('staff.validasi.validate');
        Route::post('/validasi-laporan/{id}/reject', [ValidasiController::class, 'reject'])->name('staff.validasi.reject');
        Route::get('/validasi-laporan/{id}', [ValidasiController::class, 'show'])->name('staff.validasi.show');

        // Routes untuk juru rekap - data yang perlu revisi
        Route::get('/rekaman-revisi', [RekamanViewController::class, 'revisiData'])->name('staff.rekaman.revisi');
        Route::post('/rekaman-revisi/{id}', [RekamanViewController::class, 'submitRevisi'])->name('staff.rekaman.submit');
        Route::get('/notifikasi-revisi', [RekamanViewController::class, 'getNotifications'])->name('staff.notifikasi.revisi');

        Route::get('/statistik', [StatistikController::class, 'index'])->name('staff.statistik');

        Route::get('/cetak-laporan', [CetakLaporanController::class, 'index'])->name('staff.cetak');
        Route::post('/cetak-laporan/preview', [CetakLaporanController::class, 'preview'])->name('staff.cetak.preview');
        Route::post('/cetak-laporan/preview-html', [CetakLaporanController::class, 'previewHTML'])->name('staff.cetak.preview_html');
        Route::post('/cetak-laporan/download', [CetakLaporanController::class, 'download'])->name('staff.cetak.download');
        Route::get('/cetak-laporan/filter', [CetakLaporanController::class, 'getFilteredData'])->name('staff.cetak.filter');

        Route::get('/notifikasi', function () {
            return view('Staff.notifikasi');
        })->name('staff.notifikasi');

        Route::get('/profile', function () {
            return view('Staff.profile');
        })->name('staff.profile');

        Route::get('/profile/create', function () {
            return view('Staff.profile-create');
        })->name('staff.profile.create');
    });

    // --- DAFTAR ROUTE JURU REKAP (WEB VERSION) ---
    Route::prefix('jururekap')->group(function () {
        Route::get('/dashboard', [JuruRekapController::class, 'dashboard'])->name('jururekap.dashboard');
        Route::get('/kelola', [JuruRekapController::class, 'kelola'])->name('jururekap.kelola');
        Route::post('/input', [JuruRekapController::class, 'storeCatch'])->name('jururekap.input.store');
        Route::post('/kirim', [JuruRekapController::class, 'sendToStaff'])->name('jururekap.kirim');
        Route::get('/riwayat', [JuruRekapController::class, 'riwayat'])->name('jururekap.riwayat');
        Route::post('/revisi/{id}', [JuruRekapController::class, 'submitRevisi'])->name('jururekap.revisi.submit');
        Route::get('/profile', [JuruRekapController::class, 'profile'])->name('jururekap.profile');
        Route::post('/profile/update-foto', [JuruRekapController::class, 'updateFoto'])->name('jururekap.profile.update_foto');
    });

    // --- DAFTAR ROUTE ADMIN ---
    Route::get('/manajemen-user', function () {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return redirect()->route('dashboard')->with('welcome', session('welcome'));
        }
        return redirect()->route('admin.manajemen.user')->with('welcome', session('welcome'));
    })->name('manajemen.user');

    Route::get('/admin/manajemen-user', [UserController::class, 'index'])
        ->name('admin.manajemen.user');

    Route::post('/admin/user/store', [UserController::class, 'store'])->name('admin.user.store');
    Route::post('/admin/user/update-status', [UserController::class, 'updateStatus'])->name('admin.user.update-status');
});

// Guest Routes
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');
