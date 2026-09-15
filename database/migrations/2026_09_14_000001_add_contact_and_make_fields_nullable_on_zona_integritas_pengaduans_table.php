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
        Schema::table('zona_integritas_pengaduans', function (Blueprint $table) {
            $table->string('email')->nullable()->after('nama');
            $table->string('telepon', 30)->nullable()->after('email');
            $table->string('jenis_pelanggan')->nullable()->change();
            $table->string('nama_dilaporkan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zona_integritas_pengaduans', function (Blueprint $table) {
            $table->string('jenis_pelanggan')->nullable(false)->change();
            $table->string('nama_dilaporkan')->nullable(false)->change();
            $table->dropColumn(['email', 'telepon']);
        });
    }
};
