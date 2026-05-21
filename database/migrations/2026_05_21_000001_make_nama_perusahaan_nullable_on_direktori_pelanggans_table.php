<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('direktori_pelanggans', function (Blueprint $table) {
            $table->string('nama_perusahaan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('direktori_pelanggans')
            ->whereNull('nama_perusahaan')
            ->update(['nama_perusahaan' => '']);

        Schema::table('direktori_pelanggans', function (Blueprint $table) {
            $table->string('nama_perusahaan')->nullable(false)->change();
        });
    }
};
