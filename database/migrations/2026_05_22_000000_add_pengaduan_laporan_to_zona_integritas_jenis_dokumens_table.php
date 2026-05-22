<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const KODE = 'pengaduan-laporan';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('zona_integritas_jenis_dokumens')->upsert(
            [
                [
                    'kode' => self::KODE,
                    'nama' => 'Laporan Pelaksanaan Pengaduan',
                    'urutan' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ],
            ['kode'],
            ['nama', 'urutan', 'updated_at'],
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('zona_integritas_jenis_dokumens')
            ->where('kode', self::KODE)
            ->delete();
    }
};
