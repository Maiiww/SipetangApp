<?php
require 'bootstrap/app.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();
$users = App\Models\User::all();
foreach($users as $user) {
    echo 'ID: ' . $user->id . ', Username: ' . $user->username . ', Role: ' . $user->role . PHP_EOL;
    echo 'Password Hash: ' . $user->password . PHP_EOL;
    echo '---' . PHP_EOL;
}
