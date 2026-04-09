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
        Schema::table('konsultasi_ruang_lingkups', function (Blueprint $table) {
            $table->string('type')->default('paragraph')->after('id');
            $table->string('image')->nullable()->after('content');
            $table->dropColumn('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultasi_ruang_lingkups', function (Blueprint $table) {
            $table->dropColumn(['type', 'image']);
            $table->json('images')->nullable();
        });
    }
};
