<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        $tpi = ['Blanakan', 'Patimban', 'Pondok Bali', 'Mayangan', 'Legonkulon'];
        $ikan = ['Kembung', 'Tongkol', 'Cumi-cumi', 'Tenggiri', 'Cakalang'];
        $status = ['pending', 'validated', 'rejected'];

        // Create sample data
        for ($i = 1; $i <= 30; $i++) {
            Laporan::create([
                'idLaporan' => 'LPR' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'user_id' => $users->random()->id,
                'namaTPI' => $tpi[array_rand($tpi)],
                'jenisIkan' => $ikan[array_rand($ikan)],
                'beratTotal' => rand(50, 500) / 10,
                'status' => $status[array_rand($status)],
                'tanggalInput' => now()->subDays(rand(0, 30)),
                'tanggalValidasi' => rand(0, 1) ? now()->subDays(rand(0, 20)) : null,
                'validasiOleh' => rand(0, 1) ? $users->random()->username : null,
                'catatan' => rand(0, 3) === 0 ? 'Data perlu verifikasi lebih lanjut' : null,
            ]);
        }
    }
}
