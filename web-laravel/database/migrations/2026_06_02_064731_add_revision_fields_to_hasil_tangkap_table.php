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
            if (!Schema::hasColumn('hasil_tangkap', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable()->after('status');
                $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('hasil_tangkap', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            }
            if (!Schema::hasColumn('hasil_tangkap', 'revision_needed')) {
                $table->boolean('revision_needed')->default(false)->after('rejected_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_tangkap', function (Blueprint $table) {
            if (Schema::hasColumn('hasil_tangkap', 'revision_needed')) {
                $table->dropColumn('revision_needed');
            }
            if (Schema::hasColumn('hasil_tangkap', 'rejected_at')) {
                $table->dropColumn('rejected_at');
            }
            if (Schema::hasColumn('hasil_tangkap', 'rejected_by')) {
                $table->dropForeign(['rejected_by']);
                $table->dropColumn('rejected_by');
            }
        });
    }
};
