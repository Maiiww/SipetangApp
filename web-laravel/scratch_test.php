<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$request = \Illuminate\Http\Request::create('/staff/cetak-laporan/filter', 'GET', [
    'jenis_laporan' => 'bulanan',
    'bulan' => '7',
    'tahun' => ''
]);
$app->instance('request', $request);

$controller = new \App\Http\Controllers\Staff\CetakLaporanController();
try {
    $response = $controller->getFilteredData($request);
    echo "Response Code: " . $response->getStatusCode() . "\n";
    echo $response->getContent() . "\n";
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
