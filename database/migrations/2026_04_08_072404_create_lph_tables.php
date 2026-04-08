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
        Schema::create('lph_ruang_lingkup', function (Blueprint $table) {
            $table->id();
            $table->string('gambar')->nullable();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('lph_sdm', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori'); // Auditor Halal or Dewan Pembina Syariah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lph_ruang_lingkup');
        Schema::dropIfExists('lph_sdm');
    }
};
