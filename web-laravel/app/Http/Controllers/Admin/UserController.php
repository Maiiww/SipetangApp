<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Menampilkan halaman manajemen user
     */
    public function index()
    {
        $users = User::all()->map(function ($user) {
            $profile = null;
            $role = strtolower($user->role);

            if ($role === 'admin') {
                $profile = DB::table('admin')->where('idUser', $user->idUser)->first();
            } elseif ($role === 'staff') {
                $profile = DB::table('staff')->where('idUser', $user->idUser)->first();
            } elseif ($role === 'jururekap') {
                $profile = DB::table('jururekap')->where('idUser', $user->idUser)->first();
            }

            $petugasId = $profile->idStaff ?? $profile->idAdmin ?? $profile->idJuruRekap ?? $user->idUser;

            return (object) [
                'idUser' => $user->idUser,
                'username' => $user->username,
                'role' => $user->role,
                'nama' => $profile->nama ?? $user->username,
                'idPetugas' => $petugasId,
                'asal_tpi' => $profile->wilayah ?? '',
                'jenis_kelamin' => $profile->jenis_kelamin ?? '-',
                'no_telepon' => $profile->noTelepon ?? '-',
                'alamat' => $profile->alamat ?? '-',
            ];
        });

        return view('Admin.manajemen-user', compact('users'));
    }

    /**
     * Menyimpan user baru ke database
     */
    public function store(Request $request)
    {
        try {
            Log::info('Store User Request', $request->all());

            $validated = $request->validate([
                'nama' => 'required|string|max:50',
                'no_induk' => 'required|string|max:20',
                'username' => 'required|string|max:15|unique:user,username',
                'password' => 'required|string|min:6|confirmed',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'no_telepon' => 'required|string|max:15',
                'alamat' => 'required|string|max:255',
                'role' => 'required|in:Admin,juruRekap,staff',
                'wilayah' => 'nullable|string|max:100'
            ], [
                'nama.required' => 'Nama petugas harus diisi',
                'no_induk.required' => 'Nomor induk harus diisi',
                'username.required' => 'Username harus diisi',
                'username.unique' => 'Username sudah terdaftar',
                'password.required' => 'Password harus diisi',
                'password.confirmed' => 'Password tidak sesuai dengan konfirmasinya',
                'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
                'no_telepon.required' => 'Nomor telepon harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'role.required' => 'Role harus dipilih'
            ]);

            // Generate ID User
            $lastUser = DB::table('user')->orderBy('idUser', 'DESC')->first();
            $lastNum = 0;
            if ($lastUser) {
                preg_match('/\d+$/', $lastUser->idUser, $matches);
                $lastNum = intval($matches[0] ?? 0);
            }
            $newId = 'USR' . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);

            // Insert ke table user
            DB::table('user')->insert([
                'idUser' => $newId,
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role']
            ]);

            Log::info('User created', ['idUser' => $newId, 'role' => $validated['role']]);

            // Insert ke table sesuai role
            if ($validated['role'] === 'staff') {
                // Generate ID Staff
                $lastStaff = DB::table('staff')->orderBy('idStaff', 'DESC')->first();
                $lastNum = 0;
                if ($lastStaff) {
                    preg_match('/\d+$/', $lastStaff->idStaff, $matches);
                    $lastNum = intval($matches[0] ?? 0);
                }
                $staffId = 'STF' . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);

                DB::table('staff')->insert([
                    'idStaff' => $staffId,
                    'nama' => $validated['nama'],
                    'nip' => $validated['no_induk'],
                    'jabatan' => 'staff',
                    'noTelepon' => $validated['no_telepon'],
                    'idUser' => $newId
                ]);

                Log::info('Staff created', ['idStaff' => $staffId]);

            } elseif ($validated['role'] === 'juruRekap') {
                // Generate ID Juru Rekap
                $lastJuruRekap = DB::table('jururekap')->orderBy('idJuruRekap', 'DESC')->first();
                $lastNum = 0;
                if ($lastJuruRekap) {
                    preg_match('/\d+/', $lastJuruRekap->idJuruRekap, $matches);
                    $lastNum = intval($matches[0] ?? 0);
                }
                $juruRekapId = str_pad($lastNum + 1, 5, '0', STR_PAD_LEFT);

                DB::table('jururekap')->insert([
                    'idJuruRekap' => $juruRekapId,
                    'nama' => $validated['nama'],
                    'wilayah' => $validated['wilayah'] ?? '-',
                    'noTelepon' => $validated['no_telepon'],
                    'idUser' => $newId
                ]);

                Log::info('Juru Rekap created', ['idJuruRekap' => $juruRekapId]);

            } elseif ($validated['role'] === 'Admin') {
                // Generate ID Admin
                $lastAdmin = DB::table('admin')->orderBy('idAdmin', 'DESC')->first();
                $lastNum = 0;
                if ($lastAdmin) {
                    preg_match('/\d+$/', $lastAdmin->idAdmin, $matches);
                    $lastNum = intval($matches[0] ?? 0);
                }
                $adminId = 'ADM' . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);

                DB::table('admin')->insert([
                    'idAdmin' => $adminId,
                    'nama' => $validated['nama'],
                    'nip' => $validated['no_induk'],
                    'jabatan' => 'admin',
                    'noTelepon' => $validated['no_telepon'],
                    'idUser' => $newId
                ]);

                Log::info('Admin created', ['idAdmin' => $adminId]);
            }

            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan',
                'data' => [
                    'idUser' => $newId,
                    'username' => $validated['username'],
                    'role' => $validated['role']
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Store User Error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
