<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const JENIS_DOKUMEN = [
        ['kode' => 'zona-integritas', 'nama' => 'Zona Integritas', 'urutan' => 1],
        ['kode' => 'ikm-laporan', 'nama' => 'Laporan IKM', 'urutan' => 2],
        ['kode' => 'indeks-persepsi-korupsi', 'nama' => 'Indeks Persepsi Korupsi', 'urutan' => 3],
        ['kode' => 'benturan-kepentingan', 'nama' => 'Benturan Kepentingan', 'urutan' => 4],
        ['kode' => 'benturan-laporan', 'nama' => 'Laporan Pelaksanaan Benturan Kepentingan', 'urutan' => 5],
        ['kode' => 'gratifikasi-laporan', 'nama' => 'Laporan Pelaksanaan Gratifikasi', 'urutan' => 6],
        ['kode' => 'wbs-laporan', 'nama' => 'Laporan Pelaksanaan WBS', 'urutan' => 7],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('zona_integritas_jenis_dokumens')->upsert(
            array_map(
                fn (array $jenis): array => [
                    ...$jenis,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                self::JENIS_DOKUMEN,
            ),
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
            ->whereIn('kode', array_column(self::JENIS_DOKUMEN, 'kode'))
            ->delete();
    }
};
