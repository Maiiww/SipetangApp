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
        Schema::create('juruRekap', function (Blueprint $table) {
            $table->string('idJururekap')->primary();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama');
            $table->string('wilayah');
            $table->string('no_telepon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juruRekap');
    }
};
