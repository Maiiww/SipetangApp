<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Panggil model User
use Illuminate\Support\Facades\Hash; // Panggil fungsi enkripsi password

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'imamarifin',
            'password' => Hash::make('rahasia123'),
            'role'     => 'juruRekap',
        ]);

        User::create([
            'username' => 'admin_pusat',
            'password' => Hash::make('rahasia123'),
            'role'     => 'admin',
        ]);
        
        User::create([
            'username' => 'staff_tpi',
            'password' => Hash::make('rahasia123'),
            'role'     => 'staff',
        ]);
    }
}