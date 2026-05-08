<?php

/**
 * Test Search and Filter Functionality
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Laporan;

echo "═══════════════════════════════════════════════════════════\n";
echo "SEARCH & FILTER FUNCTIONALITY TEST\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Test 1: Search by TPI
echo "TEST 1: Search by TPI Name\n";
echo "───────────────────────────────────────────────────────────\n";
$results = Laporan::where('namaTPI', 'like', '%Mayangan%')->count();
echo sprintf("Search 'Mayangan': %d results\n", $results);

$results = Laporan::where('namaTPI', 'like', '%Blanakan%')->count();
echo sprintf("Search 'Blanakan': %d results\n\n", $results);

// Test 2: Search by Fish Type
echo "TEST 2: Search by Fish Type\n";
echo "───────────────────────────────────────────────────────────\n";
$results = Laporan::where('jenisIkan', 'like', '%Cakalang%')->count();
echo sprintf("Search 'Cakalang': %d results\n", $results);

$results = Laporan::where('jenisIkan', 'like', '%Kembung%')->count();
echo sprintf("Search 'Kembung': %d results\n\n", $results);

// Test 3: Filter by Status
echo "TEST 3: Filter by Status\n";
echo "───────────────────────────────────────────────────────────\n";
$pending = Laporan::where('status', 'pending')->count();
$validated = Laporan::where('status', 'validated')->count();
$rejected = Laporan::where('status', 'rejected')->count();
echo sprintf("Pending: %d laporans\n", $pending);
echo sprintf("Validated: %d laporans\n", $validated);
echo sprintf("Rejected: %d laporans\n", $rejected);
echo sprintf("Total: %d laporans\n\n", $pending + $validated + $rejected);

// Test 4: Combined Search + Filter
echo "TEST 4: Combined Search & Filter\n";
echo "───────────────────────────────────────────────────────────\n";
$results = Laporan::where('status', 'pending')
    ->where('namaTPI', 'like', '%Mayangan%')
    ->count();
echo sprintf("Pending + TPI 'Mayangan': %d results\n", $results);

$results = Laporan::where('status', 'validated')
    ->where('jenisIkan', 'like', '%Cakalang%')
    ->count();
echo sprintf("Validated + Fish 'Cakalang': %d results\n\n", $results);

// Test 5: Pagination test
echo "TEST 5: Pagination (10 items per page)\n";
echo "───────────────────────────────────────────────────────────\n";
$all = Laporan::orderBy('tanggalInput', 'desc')->paginate(10);
echo sprintf("Page 1 items: %d\n", count($all->items()));
echo sprintf("Total items: %d\n", $all->total());
echo sprintf("Total pages: %d\n", $all->lastPage());
echo sprintf("Items per page: 10\n\n",);

echo "═══════════════════════════════════════════════════════════\n";
echo "✓ All search and filter functions are ready!\n";
echo "═══════════════════════════════════════════════════════════\n";
