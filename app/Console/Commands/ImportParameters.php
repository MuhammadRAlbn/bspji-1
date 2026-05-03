<?php

namespace App\Console\Commands;

use App\Models\Komoditi;
use App\Models\Lab;
use App\Models\Parameter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use SplFileObject;

class ImportParameters extends Command
{
    protected $signature = 'import:parameters
        {path=storage/app/imports/data_parameter.csv : Path to the CSV file}
        {--dry-run : Validate and summarize without writing to the database}
        {--truncate : Delete existing parameters before importing}
        {--skip-invalid : Skip rows with invalid required references instead of failing}';

    protected $description = 'Import parameter pengujian data from a legacy CSV file.';

    public function handle(): int
    {
        $path = base_path($this->argument('path'));

        if (! is_file($path)) {
            $this->error("CSV file not found: {$path}");

            return self::FAILURE;
        }

        $rows = $this->readRows($path);

        if ($rows === []) {
            $this->error('CSV file is empty or could not be parsed.');

            return self::FAILURE;
        }

        $headers = array_map($this->normalizeHeader(...), array_shift($rows));
        $requiredHeaders = ['id', 'nama', 'metode_uji', 'lab_id', 'komoditi_id', 'harga'];
        $missingHeaders = array_diff($requiredHeaders, $headers);

        if ($missingHeaders !== []) {
            $this->error('Missing CSV headers: '.implode(', ', $missingHeaders));

            return self::FAILURE;
        }

        $validLabIds = Lab::query()->pluck('id')->map(fn (int $id): string => (string) $id)->all();
        $validKomoditiIds = Komoditi::query()->pluck('id')->map(fn (int $id): string => (string) $id)->all();

        $validLabIds = array_flip($validLabIds);
        $validKomoditiIds = array_flip($validKomoditiIds);
        $records = [];
        $errors = [];
        $skipped = [];
        $skippedRows = 0;
        $blankPrices = 0;

        foreach ($rows as $lineNumber => $row) {
            $row = array_combine($headers, array_pad($row, count($headers), null));

            if (! $row || $this->isBlankRow($row)) {
                continue;
            }

            $record = [
                'id' => $this->nullableInteger($row['id'] ?? null),
                'nama' => trim((string) ($row['nama'] ?? '')),
                'metode_uji' => $this->nullableString($row['metode_uji'] ?? null),
                'lab_id' => $this->nullableInteger($row['lab_id'] ?? null),
                'komoditi_id' => $this->nullableInteger($row['komoditi_id'] ?? null),
                'harga' => $this->normalizePrice($row['harga'] ?? null),
            ];

            $displayLine = $lineNumber + 2;
            $rowErrors = [];

            if ($record['id'] === null) {
                $rowErrors[] = "Line {$displayLine}: id kosong/tidak valid.";
            }

            if ($record['nama'] === '') {
                $rowErrors[] = "Line {$displayLine}: nama kosong.";
            }

            if ($record['lab_id'] === null || ! isset($validLabIds[(string) $record['lab_id']])) {
                $rowErrors[] = "Line {$displayLine}: lab_id tidak ditemukan ({$row['lab_id']}).";
            }

            if ($record['komoditi_id'] === null || ! isset($validKomoditiIds[(string) $record['komoditi_id']])) {
                $rowErrors[] = "Line {$displayLine}: komoditi_id tidak ditemukan ({$row['komoditi_id']}).";
            }

            if ($rowErrors !== []) {
                if ($this->option('skip-invalid')) {
                    array_push($skipped, ...$rowErrors);
                    $skippedRows++;

                    continue;
                }

                array_push($errors, ...$rowErrors);

                continue;
            }

            if ($record['harga'] === null) {
                $blankPrices++;
            }

            $records[] = $record;
        }

        $this->components->info('Rows ready to import: '.count($records));
        $this->components->info('Rows with NULL harga: '.$blankPrices);

        if ($skipped !== []) {
            $this->components->warn('Skipped invalid rows: '.$skippedRows);

            foreach (array_slice($skipped, 0, 25) as $error) {
                $this->line($error);
            }
        }

        if ($errors !== []) {
            foreach (array_slice($errors, 0, 25) as $error) {
                $this->line($error);
            }

            if (count($errors) > 25) {
                $this->warn('And '.(count($errors) - 25).' more errors.');
            }

            return self::FAILURE;
        }

        if ($this->option('dry-run')) {
            $this->components->info('Dry run passed. No data was written.');

            return self::SUCCESS;
        }

        DB::transaction(function () use ($records): void {
            if ($this->option('truncate')) {
                Parameter::query()->delete();
            }

            foreach (array_chunk($records, 500) as $chunk) {
                Parameter::query()->upsert(
                    array_map(fn (array $record): array => [
                        ...$record,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ], $chunk),
                    ['id'],
                    ['nama', 'metode_uji', 'lab_id', 'komoditi_id', 'harga', 'updated_at'],
                );
            }
        });

        $this->syncAutoIncrement();
        $this->components->info('Import completed.');

        return self::SUCCESS;
    }

    /**
     * @return array<int, array<int, string|null>>
     */
    private function readRows(string $path): array
    {
        $file = new SplFileObject($path);
        $file->setFlags(SplFileObject::DROP_NEW_LINE | SplFileObject::SKIP_EMPTY);
        $rows = [];

        foreach ($file as $line) {
            if (! is_string($line) || trim($line) === '') {
                continue;
            }

            $rows[] = str_getcsv($this->normalizeExportedLine($line), ',', '"', '\\');
        }

        return $rows;
    }

    private function normalizeExportedLine(string $line): string
    {
        $line = trim($line);
        $line = ltrim($line, "\xEF\xBB\xBF");

        if (str_ends_with($line, ';')) {
            $line = substr($line, 0, -1);
        }

        if (str_starts_with($line, '"') && str_ends_with($line, '"')) {
            $line = substr($line, 1, -1);
            $line = str_replace('""', '"', $line);
        }

        return $line;
    }

    private function normalizeHeader(?string $header): string
    {
        return trim(strtolower((string) $header));
    }

    /**
     * @param array<string, mixed> $row
     */
    private function isBlankRow(array $row): bool
    {
        return collect($row)->every(fn (mixed $value): bool => blank($value));
    }

    private function nullableString(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function nullableInteger(mixed $value): ?int
    {
        $value = trim((string) $value);

        return ctype_digit($value) ? (int) $value : null;
    }

    private function normalizePrice(mixed $value): ?int
    {
        $value = trim((string) $value);
        $lowerValue = strtolower($value);

        if ($value === '' || $value === '-' || in_array($lowerValue, ['null', 'n/a', 'na'], true)) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $value);

        if ($digits === '') {
            return null;
        }

        $price = (int) $digits;

        return $price === 0 ? null : $price;
    }

    private function syncAutoIncrement(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $table = (new Parameter())->getTable();
        $nextId = ((int) Parameter::query()->max('id')) + 1;

        if (Schema::hasTable($table) && $nextId > 1) {
            DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = {$nextId}");
        }
    }
}
