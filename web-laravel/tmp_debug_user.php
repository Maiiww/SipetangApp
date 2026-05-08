<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$user = App\Models\User::where('username', 'staff1')->first();
if ($user) {
    echo "USERNAME=" . $user->username . PHP_EOL;
    echo "PASSWORD=" . $user->password . PHP_EOL;
    echo "ROLE=" . $user->role . PHP_EOL;
} else {
    echo "NOTFOUND" . PHP_EOL;
}
