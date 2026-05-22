<?php

namespace Database\Seeders;

use App\Models\DirektoriPelanggan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SplFileObject;

class DirektoriPelangganSeeder extends Seeder
{
    /**
     * Seed the direktori pelanggan data from the bundled CSV file.
     */
    public function run(): void
    {
        $path = database_path('direktori-pelanggan.csv');

        if (! file_exists($path)) {
            $this->command?->warn("CSV file not found: {$path}");

            return;
        }

        $file = new SplFileObject($path);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);
        $file->setCsvControl(',', '"', '\\');

        $headers = null;
        $records = [];

        foreach ($file as $row) {
            if ($row === [null] || $row === false) {
                continue;
            }

            $row = array_map(
                fn ($value) => is_string($value) ? trim(str_replace("\xc2\xa0", ' ', $value)) : $value,
                $row
            );

            if ($headers === null) {
                $headers = $row;

                continue;
            }

            if (count($row) < count($headers)) {
                continue;
            }

            $data = array_combine($headers, array_slice($row, 0, count($headers)));

            $records[] = [
                'nama_perusahaan' => $this->emptyToNull($data['Nama Perusahaan'] ?? null),
                'alamat' => $this->emptyToNull($data['Alamat'] ?? null),
                'merek' => $this->emptyToNull($data['Merek'] ?? null),
                'tahun_sertifikasi' => $this->normalizeYear($data['Tahun Sertifikasi Awal'] ?? null),
                'no_sertifikat' => $this->emptyToNull($data['No Sertifikat SPPT SNI Terbaru'] ?? null),
                'gambar' => null,
                'no_hp' => $this->emptyToNull($data['No HP'] ?? null),
                'keterangan' => $this->emptyToNull($data['Keterangan'] ?? null),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::transaction(function () use ($records): void {
            DirektoriPelanggan::query()->delete();

            if ($records !== []) {
                DirektoriPelanggan::query()->insert($records);
            }
        });

        $this->command?->info('Imported '.count($records).' direktori pelanggan records.');
    }

    private function emptyToNull(?string $value): ?string
    {
        $value = $value !== null ? trim($value) : null;

        return $value === '' ? null : $value;
    }

    private function normalizeYear(?string $value): ?int
    {
        $value = $this->emptyToNull($value);

        return $value !== null && preg_match('/^\d{4}$/', $value) === 1 ? (int) $value : null;
    }
}
