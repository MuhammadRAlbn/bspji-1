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
        Schema::create('direktori_pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->text('alamat')->nullable();
            $table->string('merek')->nullable();
            $table->year('tahun_sertifikasi')->nullable();
            $table->string('no_sertifikat')->nullable();
            $table->string('gambar')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->index('tahun_sertifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direktori_pelanggans');
    }
};
