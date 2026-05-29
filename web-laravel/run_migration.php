<?php

use Illuminate\Support\Facades\DB;

require __DIR__ . '/bootstrap/app.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->call('migrate', ['--force' => true]);

exit($status);
