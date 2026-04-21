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
        Schema::create('section_testimonis', function (Blueprint $table) {
            $table->id();
            $table->string('gambar_pelanggan');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('nama_perusahaan');
            $table->text('pesan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_testimonis');
    }
};
