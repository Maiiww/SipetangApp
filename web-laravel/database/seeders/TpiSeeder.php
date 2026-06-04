<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TpiSeeder extends Seeder
{
    public function run(): void
    {
        // 8 TPI yang akan ditambahkan
        $tpiList = [
            [
                'username' => 'tpi_patimban',
                'nama' => 'JURU REKAP PATIMBAN',
                'wilayah' => 'TPI Patimban',
                'no_induk' => 'JR01',
            ],
            [
                'username' => 'tpi_genteng',
                'nama' => 'JURU REKAP GENTENG',
                'wilayah' => 'TPI Genteng',
                'no_induk' => 'JR02',
            ],
            [
                'username' => 'tpi_mayangan',
                'nama' => 'JURU REKAP MAYANGAN',
                'wilayah' => 'TPI Mayangan',
                'no_induk' => 'JR03',
            ],
            [
                'username' => 'tpi_cirewang',
                'nama' => 'JURU REKAP CIREWANG',
                'wilayah' => 'TPI Cirewang',
                'no_induk' => 'JR06',
            ],
            [
                'username' => 'tpi_muara_ciasem',
                'nama' => 'JURU REKAP MUARA CIASEM',
                'wilayah' => 'TPI Muara Ciasem',
                'no_induk' => 'JR07',
            ],
            [
                'username' => 'tpi_blanakan',
                'nama' => 'JURU REKAP BLANAKAN',
                'wilayah' => 'TPI Blanakan',
                'no_induk' => 'JR08',
            ],
            [
                'username' => 'tpi_rawameneng',
                'nama' => 'JURU REKAP RAWAMENENG',
                'wilayah' => 'TPI Rawameneng',
                'no_induk' => 'JR09',
            ],
            [
                'username' => 'tpi_cilamaya_girang',
                'nama' => 'JURU REKAP CILAMAYA GIRANG',
                'wilayah' => 'TPI Cilamaya Girang',
                'no_induk' => 'JR10',
            ],
        ];

        foreach ($tpiList as $tpi) {
            // Cek apakah user sudah ada
            if (!User::where('username', $tpi['username'])->exists()) {
                User::create([
                    'username' => $tpi['username'],
                    'password' => Hash::make('12345678'),
                    'role' => 'juruRekap',
                    'nama' => $tpi['nama'],
                    'no_induk' => $tpi['no_induk'],
                    'jenis_kelamin' => 'Laki-laki',
                    'no_telepon' => '0812-0000-0000',
                    'alamat' => 'Jl. Pelabuhan, ' . $tpi['wilayah'],
                    'wilayah' => $tpi['wilayah'],
                    'status_akun' => 'Aktif',
                    'foto_profil' => null,
                ]);
            }
        }
    }
}
