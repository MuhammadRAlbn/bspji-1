<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ZonaIntegritasPengaduanNumberGenerator
{
    /**
     * @return array{nomor_pengaduan: string, tahun_pengaduan: int, sequence: int}
     */
    public function next(): array
    {
        $year = (int) Carbon::now('Asia/Jakarta')->format('Y');

        $sequenceRow = DB::table('zona_integritas_pengaduan_sequences')
            ->where('id', 1)
            ->lockForUpdate()
            ->first();

        if (! $sequenceRow) {
            DB::table('zona_integritas_pengaduan_sequences')->insert([
                'id' => 1,
                'last_sequence' => 500000,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $sequenceRow = DB::table('zona_integritas_pengaduan_sequences')
                ->where('id', 1)
                ->lockForUpdate()
                ->first();
        }

        $sequence = (int) $sequenceRow->last_sequence + 1;

        DB::table('zona_integritas_pengaduan_sequences')
            ->where('id', 1)
            ->update([
                'last_sequence' => $sequence,
                'updated_at' => now(),
            ]);

        return [
            'nomor_pengaduan' => $year.str_pad((string) $sequence, 7, '0', STR_PAD_LEFT),
            'tahun_pengaduan' => $year,
            'sequence' => $sequence,
        ];
    }
}
