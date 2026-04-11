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
        Schema::create('detail_informasis', function (Blueprint $table) {
            $table->id();
            $table->string('tipe');
            $table->string('kategori_id');
            $table->string('judul');
            $table->string('pdf_file');
            $table->text('keterangan')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->index(['tipe', 'kategori_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_informasis');
    }
};
