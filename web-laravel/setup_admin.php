<?php
require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Create admin_pusat user
$admin = User::firstOrCreate(
    ['username' => 'admin_pusat'],
    [
        'password' => Hash::make('rahasia123'),
        'role' => 'admin',
        'nama' => 'ADMIN PUSAT',
        'no_induk' => 'ADM01',
        'jenis_kelamin' => 'Laki-laki',
        'no_telepon' => '082111222333',
        'alamat' => 'Kantor Dinas Perikanan Pusat, Subang',
        'wilayah' => 'Dinas Pusat',
        'status_akun' => 'Aktif',
        'foto_profil' => null,
    ]
);

// Also create other test users
$staff = User::firstOrCreate(
    ['username' => 'staff_tpi'],
    [
        'password' => Hash::make('rahasia123'),
        'role' => 'staff',
        'nama' => 'STAFF VALIDASI TPI',
        'no_induk' => 'STF01',
        'jenis_kelamin' => 'Perempuan',
        'no_telepon' => '083144555666',
        'alamat' => 'Kantor Dinas Perikanan Pusat, Subang',
        'wilayah' => 'TPI Blanakan',
        'status_akun' => 'Aktif',
        'foto_profil' => null,
    ]
);

echo "✓ Users created successfully!\n";
echo "admin_pusat / rahasia123\n";
echo "staff_tpi / rahasia123\n";
