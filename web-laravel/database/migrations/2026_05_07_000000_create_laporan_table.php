<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->string('idLaporan')->primary();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('namaTPI');
            $table->string('jenisIkan');
            $table->decimal('beratTotal', 10, 2);
            $table->enum('status', ['pending', 'validated', 'rejected'])->default('pending');
            $table->dateTime('tanggalInput');
            $table->dateTime('tanggalValidasi')->nullable();
            $table->string('validasiOleh')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('validasiOleh')->references('username')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
