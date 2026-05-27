<?php

namespace Database\Seeders;

use App\Models\Tangkapan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TangkapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test data with status "Menunggu Validasi"
        Tangkapan::create([
            'user_id' => 1,
            'nama_pembeli' => 'PT Maju Jaya',
            'nama_nelayan' => 'Nelayan Subang 1',
            'jenis_ikan' => 'Ikan Tenggiri',
            'berat' => 50.5,
            'harga_jual' => 750000,
            'status' => 'Menunggu Validasi',
        ]);

        Tangkapan::create([
            'user_id' => 1,
            'nama_pembeli' => 'PT Maju Jaya',
            'nama_nelayan' => 'Nelayan Subang 2',
            'jenis_ikan' => 'Ikan Kembung',
            'berat' => 75.0,
            'harga_jual' => 650000,
            'status' => 'Menunggu Validasi',
        ]);

        Tangkapan::create([
            'user_id' => 1,
            'nama_pembeli' => 'PT Sejahtera',
            'nama_nelayan' => 'Nelayan Subang 3',
            'jenis_ikan' => 'Ikan Mackerel',
            'berat' => 45.5,
            'harga_jual' => 550000,
            'status' => 'Menunggu Validasi',
        ]);
    }
}
