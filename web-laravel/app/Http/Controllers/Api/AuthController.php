<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            
            if ($user->role !== 'juru_rekap') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akses Ditolak!'
                ], 403); 
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Login Berhasil',
                'data' => $user
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Nama pengguna atau kata sandi Anda salah.'
        ], 401);
    }
    
}