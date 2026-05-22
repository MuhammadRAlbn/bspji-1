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
        Schema::create('zona_integritas_pengaduan_sequences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('last_sequence')->default(500000);
            $table->timestamps();
        });

        DB::table('zona_integritas_pengaduan_sequences')->insert([
            'id' => 1,
            'last_sequence' => 500000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::create('zona_integritas_pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengaduan', 11)->unique();
            $table->unsignedSmallInteger('tahun_pengaduan')->index();
            $table->unsignedBigInteger('sequence')->unique();
            $table->string('nama');
            $table->string('jenis_pengaduan', 32)->index();
            $table->string('jenis_pelanggan');
            $table->string('nama_dilaporkan');
            $table->string('judul');
            $table->text('uraian');
            $table->string('bukti_dukung_path')->nullable();
            $table->string('bukti_dukung_nama')->nullable();
            $table->string('status', 80)->default('pengaduan_diterima')->index();
            $table->text('hasil_teks')->nullable();
            $table->string('dokumen_hasil_path')->nullable();
            $table->string('dokumen_hasil_nama')->nullable();
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_integritas_pengaduans');
        Schema::dropIfExists('zona_integritas_pengaduan_sequences');
    }
};
