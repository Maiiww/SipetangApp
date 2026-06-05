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
            if (!Schema::hasColumn('hasil_tangkap', 'catatan')) {
                $table->text('catatan')->nullable()->after('status');
            }
            if (!Schema::hasColumn('hasil_tangkap', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable();
            }
            if (!Schema::hasColumn('hasil_tangkap', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable();
            }
            if (!Schema::hasColumn('hasil_tangkap', 'revision_needed')) {
                $table->boolean('revision_needed')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_tangkap', function (Blueprint $table) {
            $table->dropColumn(['catatan', 'rejected_by', 'rejected_at', 'revision_needed']);
        });
    }
};
