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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama')->nullable()->after('username');
            $table->string('no_induk')->nullable()->after('nama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('password');
            $table->string('no_telepon')->nullable()->after('jenis_kelamin');
            $table->text('alamat')->nullable()->after('no_telepon');
            $table->string('wilayah')->nullable()->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama', 'no_induk', 'jenis_kelamin', 'no_telepon', 'alamat', 'wilayah']);
        });
    }
};
