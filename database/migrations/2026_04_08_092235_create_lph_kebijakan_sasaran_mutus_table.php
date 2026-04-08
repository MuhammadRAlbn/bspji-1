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
        Schema::create('lph_kebijakan_sasaran_mutus', function (Blueprint $table) {
            $table->id();
            $table->text('kebijakan')->nullable();
            $table->text('sasaran_mutu')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lph_kebijakan_sasaran_mutus');
    }
};
