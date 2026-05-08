<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\LaporanViewController;
use App\Http\Controllers\Staff\ValidasiController;
use App\Models\User;

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
        if (strtolower(auth()->user()->role) === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('staff.dashboard');
    })->name('dashboard');

    // --- DAFTAR ROUTE STAFF ---
    Route::prefix('staff')->group(function () {

        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');

        Route::get('/validasi-laporan', [ValidasiController::class, 'index'])->name('staff.validasi');
        Route::post('/validasi-laporan/{id}/validate', [ValidasiController::class, 'validate'])->name('staff.validasi.validate');
        Route::post('/validasi-laporan/{id}/reject', [ValidasiController::class, 'reject'])->name('staff.validasi.reject');
        Route::get('/validasi-laporan/{id}', [ValidasiController::class, 'show'])->name('staff.validasi.show');

        Route::get('/statistik', function () {
            return view('Staff.statistik');
        })->name('staff.statistik');

        Route::get('/cetak-laporan', function () {
            return view('Staff.cetak-laporan');
        })->name('staff.cetak');

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

    // --- DAFTAR ROUTE ADMIN ---
    Route::get('/admin/dashboard', function () {
        abort_if(strtolower(auth()->user()->role) !== 'admin', 403);
        return view('Admin.dashboard-admin');
    })->name('admin.dashboard');

    Route::get('/manajemen-user', function () {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return redirect()->route('dashboard');
        }
        return redirect()->route('admin.manajemen.user');
    })->name('manajemen.user');

    Route::get('/admin/manajemen-user', [UserController::class, 'index'])
        ->name('admin.manajemen.user');

    Route::post('/admin/user/store', [UserController::class, 'store'])->name('admin.user.store');
});

// Guest Routes
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');
