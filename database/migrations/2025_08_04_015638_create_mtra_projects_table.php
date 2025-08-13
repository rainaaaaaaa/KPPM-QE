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
        Schema::create('mtra_projects', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kontrak');
            $table->string('lokasi');
            $table->enum('jenis', ['recovery', 'preventif', 'relokasi']);
            $table->string('foto_path')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['planning', 'berjalan', 'selesai'])->default('planning');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtra_projects');
    }
};
