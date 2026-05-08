<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('route_name');
            $table->string('icon')->nullable();
            $table->string('allowed_roles');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('menus')->insert([
            ['title' => 'Dashboard', 'route_name' => 'admin.dashboard', 'icon' => 'fa-th-large', 'allowed_roles' => 'admin', 'sort_order' => 1, 'is_active' => true],
            ['title' => 'Manajemen User', 'route_name' => 'admin.manajemen.user', 'icon' => 'fa-users', 'allowed_roles' => 'admin', 'sort_order' => 2, 'is_active' => true],
            ['title' => 'Dashboard', 'route_name' => 'staff.dashboard', 'icon' => 'fa-th-large', 'allowed_roles' => 'staff,juruRekap', 'sort_order' => 1, 'is_active' => true],
            ['title' => 'Validasi Laporan', 'route_name' => 'staff.validasi', 'icon' => 'fa-check-circle', 'allowed_roles' => 'staff,juruRekap', 'sort_order' => 2, 'is_active' => true],
            ['title' => 'Cetak Laporan', 'route_name' => 'staff.cetak', 'icon' => 'fa-print', 'allowed_roles' => 'staff,juruRekap', 'sort_order' => 3, 'is_active' => true],
            ['title' => 'Data Statistik', 'route_name' => 'staff.statistik', 'icon' => 'fa-chart-bar', 'allowed_roles' => 'staff,juruRekap', 'sort_order' => 4, 'is_active' => true],
            ['title' => 'Notifikasi', 'route_name' => 'staff.notifikasi', 'icon' => 'fa-bell', 'allowed_roles' => 'staff,juruRekap', 'sort_order' => 5, 'is_active' => true],
            ['title' => 'Profil', 'route_name' => 'staff.profile', 'icon' => 'fa-user', 'allowed_roles' => 'staff,juruRekap', 'sort_order' => 6, 'is_active' => true],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
