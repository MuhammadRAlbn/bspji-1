<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ruang_lingkup_kalibrasis', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->json('details')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruang_lingkup_kalibrasis');
    }
};
