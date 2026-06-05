<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate([
            'username' => 'imamarifin'
        ], [
            'password'      => Hash::make('rahasia123'),
            'role'          => 'juruRekap',
            'nama'          => 'IMAM ARIFIN',
            'no_induk'      => 'JR04',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '0895346788823',
            'alamat'        => 'Jl. Raya Blanakan No. 12, Subang',
            'wilayah'       => 'TPI Blanakan',
            'status_akun'   => 'Aktif',
            'foto_profil'   => null, 
        ]);

        User::updateOrCreate([
            'username' => 'budidoremi'
        ], [
            'password'      => Hash::make('12345678'),
            'role'          => 'juruRekap',
            'nama'          => 'BUDI DOREMI',
            'no_induk'      => 'JR05',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '081234567890',
            'alamat'        => 'Pamanukan, Subang',
            'wilayah'       => 'TPI Patimban',
            'status_akun'   => 'Aktif',
            'foto_profil'   => null,
        ]);

        User::firstOrCreate([
            'username' => 'admin_pusat'
        ], [
            'password'      => Hash::make('rahasia123'),
            'role'          => 'admin',
            'nama'          => 'ADMIN PUSAT',
            'no_induk'      => 'ADM01',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon'    => '082111222333',
            'alamat'        => 'Kantor Dinas Perikanan Pusat, Subang',
            'wilayah'       => 'Dinas Pusat',
            'status_akun'   => 'Aktif',
            'foto_profil'   => null,
        ]);
        
        User::firstOrCreate([
            'username'      => 'staff_tpi',
        ], [
            'password'      => Hash::make('rahasia123'),
            'role'          => 'staff',
            'nama'          => 'STAFF VALIDASI TPI',
            'no_induk'      => 'STF01',
            'jenis_kelamin' => 'Perempuan',
            'no_telepon'    => '083144555666',
            'alamat'        => 'Kantor Cabang Dinas Blanakan',
            'wilayah'       => 'TPI Blanakan',
            'status_akun'   => 'Aktif',
            'foto_profil'   => null,
        ]);
        //User::truncate();
    }
}