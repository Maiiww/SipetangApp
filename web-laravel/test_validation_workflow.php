<?php

/**
 * Test Validation Workflow - Comprehensive Status Check
 * 
 * This script tests:
 * 1. Data integrity in laporan table
 * 2. Validation status changes
 * 3. Filter logic for pending laporans
 */

// Load Laravel bootstrap
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Laporan;
use Illuminate\Support\Facades\DB;

echo "═══════════════════════════════════════════════════════════\n";
echo "VALIDATION WORKFLOW TEST\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Test 1: Check all status values in database
echo "TEST 1: Current Status Distribution\n";
echo "───────────────────────────────────────────────────────────\n";

$statusCounts = DB::table('laporan')
    ->groupBy('status')
    ->selectRaw('status, COUNT(*) as count')
    ->get();

foreach ($statusCounts as $stat) {
    echo sprintf("  %-12s: %3d laporans\n", $stat->status, $stat->count);
}

$totalLaporans = DB::table('laporan')->count();
echo sprintf("  %-12s: %3d laporans (TOTAL)\n\n", "TOTAL", $totalLaporans);

// Test 2: Verify pending laporans are fetched correctly
echo "TEST 2: Pending Laporans List (Controller Query)\n";
echo "───────────────────────────────────────────────────────────\n";

$pendingLaporans = Laporan::where('status', 'pending')
    ->orderBy('tanggalInput', 'desc')
    ->get();

echo sprintf("Total pending: %d\n", count($pendingLaporans));

if (count($pendingLaporans) > 0) {
    echo "\nFirst 3 pending laporans:\n";
    foreach ($pendingLaporans->take(3) as $idx => $laporan) {
        echo sprintf(
            "%d. ID: %-20s | TPI: %-20s | Status: %s\n",
            $idx + 1,
            $laporan->idLaporan,
            substr($laporan->namaTPI, 0, 20),
            $laporan->status
        );
    }
} else {
    echo "⚠️ No pending laporans found!\n";
}
echo "\n";

// Test 3: Check validated today
echo "TEST 3: Validated Today (Stats Calculation)\n";
echo "───────────────────────────────────────────────────────────\n";

$validatedToday = Laporan::where('status', 'validated')
    ->whereDate('tanggalValidasi', today())
    ->count();

echo sprintf("Validated today: %d\n\n", $validatedToday);

// Test 4: Anomalies check
echo "TEST 4: Anomaly Detection (weight > 5 ton)\n";
echo "───────────────────────────────────────────────────────────\n";

$anomalies = Laporan::where('status', 'pending')
    ->where('beratTotal', '>', 5)
    ->count();

echo sprintf("Pending laporans > 5 ton: %d\n\n", $anomalies);

// Test 5: Data integrity check
echo "TEST 5: Data Integrity Check\n";
echo "───────────────────────────────────────────────────────────\n";

$missingValidator = Laporan::where('status', 'validated')
    ->whereNull('validasiOleh')
    ->count();

echo sprintf("Validated laporans without validator: %d\n", $missingValidator);

$missingValidationDate = Laporan::where('status', 'validated')
    ->whereNull('tanggalValidasi')
    ->count();

echo sprintf("Validated laporans without validation date: %d\n", $missingValidationDate);

$rejectedNoReason = Laporan::where('status', 'rejected')
    ->whereNull('catatan')
    ->count();

echo sprintf("Rejected laporans without reason: %d\n\n", $rejectedNoReason);

// Test 6: Filter simulation (what the page displays)
echo "TEST 6: Page Display Simulation\n";
echo "───────────────────────────────────────────────────────────\n";

$pageData = Laporan::where('status', 'pending')
    ->orderBy('tanggalInput', 'desc')
    ->limit(10)
    ->get();

echo sprintf("Laporans displayed on page (limit 10): %d\n", count($pageData));

if (count($pageData) > 0) {
    echo "\nTable preview:\n";
    echo sprintf("%-20s | %-20s | %-15s | %s\n", "Tanggal Input", "Lokasi TPI", "Jenis Ikan", "Status");
    echo str_repeat("─", 70) . "\n";

    foreach ($pageData as $laporan) {
        echo sprintf(
            "%-20s | %-20s | %-15s | %s\n",
            $laporan->tanggalInput->format('Y-m-d H:i'),
            substr($laporan->namaTPI, 0, 20),
            substr($laporan->jenisIkan, 0, 15),
            $laporan->status
        );
    }
}

echo "\n═══════════════════════════════════════════════════════════\n";
echo "TEST COMPLETE\n";
echo "═══════════════════════════════════════════════════════════\n";

// Summary
echo "\n✓ If 'Pending laporans' count > 0 and all show status='pending': System is working\n";
echo "✓ If Validation page displays those pending laporans: UI is correct\n";
echo "✓ After validation, refresh and pending count should decrease by 1\n";
echo "✓ Validated count should increase by 1\n";
