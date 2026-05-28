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
        // Create data asli dari Budi
        Tangkapan::create([
            'user_id' => 1,
            'nama_pembeli' => 'Budi',
            'nama_nelayan' => '',
            'jenis_ikan' => 'Tongkol',
            'berat' => 30.0,
            'harga_jual' => 600000,
            'status' => 'Menunggu Validasi',
        ]);
    }
}
