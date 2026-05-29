<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CuacaController extends Controller
{
    public function getCuaca()
    {
        // Cache disimpan selama 30 menit
        $cuaca = Cache::remember('cuaca_subang_lengkap', 1800, function () {
            
            $response = Http::timeout(10)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => -6.2800, 
                'longitude' => 107.6900,
                'current' => 'temperature_2m,weather_code,wind_speed_10m,wind_direction_10m',
                'hourly' => 'temperature_2m,weather_code,wind_speed_10m',
                'timezone' => 'Asia/Jakarta',
                'forecast_days' => 1
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Data Saat Ini (Current)
                $suhu = $data['current']['temperature_2m'] ?? 0;
                $kecepatanAngin = $data['current']['wind_speed_10m'] ?? 0;
                $derajatAngin = $data['current']['wind_direction_10m'] ?? 0;
                $kodeCuaca = $data['current']['weather_code'] ?? 0;

                // Konversi Derajat Angin ke Teks Arah Mata Angin
                $arahAngin = $this->konversiArahAngin($derajatAngin);

                // Terjemahan Teks Cuaca
                $statusCuaca = $this->terjemahkanCuaca($kodeCuaca);

                // Pesan Peringatan Gelombang
                $peringatan = "Wilayah Utara Kondisi Aman";
                if ($kecepatanAngin >= 15 && $kecepatanAngin < 25) {
                    $peringatan = "Wilayah Utara Gelombang Sedang Tinggi";
                } elseif ($kecepatanAngin >= 25) {
                    $peringatan = "Bahaya! Angin Kencang & Gelombang Tinggi";
                }

                // Mengambil Prakiraan 4 Jam ke Depan (Hourly)
                $prakiraanJam = [];
                $jamSekarang = Carbon::now('Asia/Jakarta')->hour;

                for ($i = $jamSekarang; $i < $jamSekarang + 4; $i++) {
                    if (isset($data['hourly']['time'][$i])) {
                        $waktu = Carbon::parse($data['hourly']['time'][$i])->format('H:i');
                        $prakiraanJam[] = [
                            'jam' => $waktu . ' WIB',
                            'suhu' => round($data['hourly']['temperature_2m'][$i]) . '°C',
                            'cuaca' => $this->terjemahkanCuaca($data['hourly']['weather_code'][$i]),
                            'angin' => $data['hourly']['wind_speed_10m'][$i] . ' km/jam'
                        ];
                    }
                }

                return [
                    'status' => 'success',
                    'data' => [
                        'cuaca' => $statusCuaca,
                        'peringatan' => $peringatan,
                        'suhu' => round($suhu) . '°C',
                        'kecepatan_angin' => $kecepatanAngin . ' km/jam',
                        'arah_angin' => $arahAngin . ' (' . $derajatAngin . '°)',
                        'prakiraan_hourly' => $prakiraanJam
                    ]
                ];
            }

            return ['status' => 'error', 'message' => 'Gagal memuat cuaca'];
        });

        return response()->json($cuaca);
    }

    // Helper Fungsi Menerjemahkan Cuaca
    private function terjemahkanCuaca($kode) {
        if ($kode == 0) return "Cerah";
        if ($kode >= 1 && $kode <= 3) return "Cerah Berawan";
        if ($kode >= 45 && $kode <= 48) return "Kabut";
        if ($kode >= 51 && $kode <= 67) return "Hujan Ringan/Sedang";
        return "Hujan Lebat / Badai";
    }

    // Helper Fungsi Konversi Kompas Arah Angin
    private function konversiArahAngin($derajat) {
        $arah = ['Utara', 'Timur Laut', 'Timur', 'Tenggara', 'Selatan', 'Barat Daya', 'Barat', 'Barat Laut'];
        return $arah[round($derajat / 45) % 8];
    }
}