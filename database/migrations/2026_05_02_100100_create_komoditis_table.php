<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komoditis', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->index();
            $table->text('peraturan')->nullable();
            $table->foreignId('lab_id')->constrained('labs')->cascadeOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komoditis');
    }
};
