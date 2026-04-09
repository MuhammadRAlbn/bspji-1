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
        Schema::create('lsih_ruang_lingkups', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('lsih_alurs', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('lsih_tarifs', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lsih_ruang_lingkups');
        Schema::dropIfExists('lsih_alurs');
        Schema::dropIfExists('lsih_tarifs');
    }
};
