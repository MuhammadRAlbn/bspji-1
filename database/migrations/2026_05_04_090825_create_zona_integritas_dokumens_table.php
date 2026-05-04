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
        Schema::create('zona_integritas_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_dokumen_id')
                ->constrained('zona_integritas_jenis_dokumens')
                ->restrictOnDelete();
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->unsignedInteger('urutan')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_integritas_dokumens');
    }
};
