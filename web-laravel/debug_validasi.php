<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Tangkapan;

echo "=== USERS ===\n";
$users = User::select('id', 'username', 'role', 'wilayah')->get();
foreach ($users as $u) {
    echo "$u->id | $u->username | $u->role | $u->wilayah\n";
}

echo "\n=== TANGKAPAN (Latest 10) ===\n";
$tangkapans = Tangkapan::with('user')->orderBy('created_at', 'desc')->limit(10)->get();
foreach ($tangkapans as $t) {
    echo "ID:" . $t->id . " | User:" . $t->user->username . " | TPI:" . $t->user->wilayah . " | Status:" . $t->status . " | Created:" . $t->created_at . "\n";
}

echo "\n=== TANGKAPAN WITH MENUNGGU VALIDASI ===\n";
$pending = Tangkapan::where('status', 'Menunggu Validasi')->with('user')->get();
echo "Count: " . $pending->count() . "\n";
foreach ($pending as $t) {
    echo "ID:" . $t->id . " | User:" . $t->user->username . " | TPI:" . $t->user->wilayah . " | Status:" . $t->status . "\n";
}
