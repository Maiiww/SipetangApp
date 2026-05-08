<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        \Log::info('Login attempt', ['username' => $request->username, 'user_found' => $user ? true : false]);

        if ($user && $this->checkPassword($request->password, $user->password)) {
            \Log::info('Password check passed', ['username' => $request->username]);
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            // Migrasi password otomatis ke Bcrypt jika masih plain text
            if (!$this->isBcryptHash($user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            // --- BAGIAN KRUSIAL: REDIRECT BERDASARKAN ROLE ---
            $role = strtolower($user->role);
            
            if ($role === 'admin') {
                // Pastikan nama route ini ADA di web.php
                return redirect()->intended(route('admin.dashboard')); 
            }

            return redirect()->intended(route('staff.dashboard'));
        }

        \Log::info('Login failed', ['username' => $request->username]);

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // Fungsi pembantu untuk mengecek format hash
    private function isBcryptHash(string $value): bool
    {
        return preg_match('/^\$2[ayb]\$.{56}$/', $value) === 1;
    }

    // Mendukung pengecekan password lama (plain text) dan baru (hash)
    private function checkPassword(string $plainText, string $storedPassword): bool
    {
        if ($this->isBcryptHash($storedPassword)) {
            return Hash::check($plainText, $storedPassword);
        }
        return hash_equals($plainText, $storedPassword);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}