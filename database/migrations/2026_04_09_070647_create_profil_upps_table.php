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
        Schema::create('profil_upps', function (Blueprint $table) {
            $table->id();
            $table->string('moto_pelayanan_path')->nullable();
            $table->text('tupoksi')->nullable();
            $table->json('waktu_pelayanan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_upps');
    }
};
