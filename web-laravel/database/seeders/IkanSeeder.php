<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ikan;

class IkanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarIkan = [
            'Bawal Hitam',
            'Bawal Putih',
            'Biji Nangka',
            'Cucut',
            'Ekor Kuning',
            'Tiga Waja/Gulamah',
            'Japuh',
            'Kakap Merah',
            'Kembung',
            'Kerapu Kerong',
            'Kuniran',
            'Kuwe',
            'Layang',
            'Layur',
            'Manyung',
            'Pari Burung',
            'Pari Lainnya',
            'Peperek',
            'Remang',
            'Selar',
            'Tenggiri',
            'Tembang',
            'Terubuk',
            'Tongkol abu-abu',
            'Ikan Lainnya',
            'Ikan Demersal Lainnya',
            'Ikan Karang Lainnya',
            'Udang Dogol',
            'Udang lainnya',
            'Udang Jerbung/Putih',
            'Udang Krosok',
            'Kerang Darah',
            'Cumi-Cumi',
            'Sotong',
            'Belanak'

        ];

        //Ikan::truncate();

        foreach ($daftarIkan as $ikan) {
            Ikan::create([
                'nama_ikan' => $ikan
            ]);
        }
    }
}
