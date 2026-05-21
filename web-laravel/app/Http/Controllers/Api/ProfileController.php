<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        if ($user->foto_profil) {
            $user->foto_profil_url = url('storage/profil/' . $user->foto_profil);
        } else {
            $user->foto_profil_url = 'https://ui-avatars.com/api/?name=' . urlencode($user->nama) . '&background=002D62&color=fff';
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function updateFoto(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 400);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            
            $filename = 'profil_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            $file->storeAs('public/profil', $filename);

            if ($user->foto_profil && Storage::exists('public/profil/' . $user->foto_profil)) {
                Storage::delete('public/profil/' . $user->foto_profil);
            }

            $user->foto_profil = $filename;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Foto profil berhasil diperbarui!',
                'foto_profil_url' => url('storage/profil/' . $filename)
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'File foto tidak terdeteksi'
        ], 400);
    }
}