<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hasil_tangkap', function (Blueprint $table) {
            // Tambahkan kolom catatan untuk menyimpan alasan penolakan atau keterangan lainnya
            if (!Schema::hasColumn('hasil_tangkap', 'catatan')) {
                $table->text('catatan')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_tangkap', function (Blueprint $table) {
            if (Schema::hasColumn('hasil_tangkap', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });
    }
};
