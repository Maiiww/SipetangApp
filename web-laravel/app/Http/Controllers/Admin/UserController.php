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
        $users = User::orderByRaw("CASE WHEN role = 'admin' THEN 1 WHEN role = 'staff' THEN 2 WHEN role = 'juruRekap' THEN 3 ELSE 4 END")->get();

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
                'nama' => 'required|string|max:100',
                'no_induk' => 'required|string|max:20',
                'username' => 'required|string|max:50|unique:users,username',
                'password' => 'required|string|min:6|confirmed',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'no_telepon' => 'required|string|max:20',
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

            // Insert ke table users
            $user = User::create([
                'nama' => $validated['nama'],
                'no_induk' => $validated['no_induk'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_telepon' => $validated['no_telepon'],
                'alamat' => $validated['alamat'],
                'role' => $validated['role'],
                'wilayah' => $validated['wilayah'] ?? null
            ]);

            Log::info('User created successfully', [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan',
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role
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
            Log::error('Store User Error', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update status user (aktif/nonaktif)
     */
    public function updateStatus(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'is_active' => 'required|boolean'
            ]);

            $user = User::findOrFail($validated['user_id']);

            // Jangan izinkan update status akun admin
            if ($user->role === 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat mengubah status akun admin'
                ], 403);
            }

            $user->update([
                'is_active' => $validated['is_active']
            ]);

            $statusText = $validated['is_active'] ? 'Aktif' : 'Nonaktif';

            Log::info('User status updated', [
                'user_id' => $user->id,
                'username' => $user->username,
                'status' => $statusText
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status akun berhasil diubah menjadi ' . $statusText,
                'data' => [
                    'id' => $user->id,
                    'is_active' => $user->is_active
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
            Log::error('Update Status Error', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
