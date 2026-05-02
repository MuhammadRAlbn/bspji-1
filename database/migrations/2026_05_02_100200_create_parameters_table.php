<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('metode_uji')->nullable();
            $table->string('satuan')->nullable();
            $table->string('baku_mutu')->nullable();
            $table->foreignId('lab_id')->constrained('labs')->cascadeOnDelete();
            $table->foreignId('komoditi_id')->constrained('komoditis')->cascadeOnDelete();
            $table->unsignedInteger('harga')->default(0);
            $table->timestamps();

            $table->index(['komoditi_id', 'lab_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
