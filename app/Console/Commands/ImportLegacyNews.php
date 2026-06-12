<?php

namespace App\Console\Commands;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ImportLegacyNews extends Command
{
    protected $signature = 'import:legacy-news
        {--limit=20 : Number of latest legacy rows to import}
        {--dry-run : Preview mapped rows without writing to the database}';

    protected $description = 'Import latest rows from the legacy event table into news.';

    public function handle(): int
    {
        if (! Schema::hasTable('event')) {
            $this->error('Legacy table "event" was not found.');

            return self::FAILURE;
        }

        if (! Schema::hasTable('news')) {
            $this->error('Target table "news" was not found.');

            return self::FAILURE;
        }

        $limit = max(1, (int) $this->option('limit'));
        $usedSlugs = [];

        $rows = DB::table('event')
            ->select(['id_event', 'title_event', 'date_event', 'image_event', 'content_event'])
            ->orderByDesc('date_event')
            ->orderByDesc('id_event')
            ->limit($limit)
            ->get();

        if ($rows->isEmpty()) {
            $this->components->warn('No legacy rows found.');

            return self::SUCCESS;
        }

        $skippedExisting = 0;

        $records = $rows->map(function (object $row) use (&$usedSlugs, &$skippedExisting): ?array {
            $legacyId = (int) $row->id_event;
            $title = trim((string) $row->title_event);
            $publishedAt = $this->publishedAt($row->date_event);

            if (News::query()->where('title', $title)->where('published_at', $publishedAt)->exists()) {
                $skippedExisting++;

                return null;
            }

            return [
                'title' => Str::limit($title !== '' ? $title : "Berita Lama {$legacyId}", 255, ''),
                'slug' => $this->uniqueSlug($title, $legacyId, $usedSlugs),
                'excerpt' => null,
                'body' => (string) ($row->content_event ?? ''),
                'cover_image' => $this->coverImage($row->image_event),
                'status' => News::STATUS_PUBLISHED,
                'published_at' => $publishedAt,
                'created_at' => $publishedAt,
                'updated_at' => now(),
                'legacy_id' => $legacyId,
            ];
        })->filter()->values();

        $this->table(
            ['Legacy ID', 'Tanggal', 'Judul', 'Slug'],
            $records
                ->map(fn (array $record): array => [
                    $record['legacy_id'],
                    $record['published_at']->toDateString(),
                    Str::limit($record['title'], 55),
                    $record['slug'],
                ])
                ->all(),
        );

        $this->components->info('Rows ready to import: '.$records->count());

        if ($skippedExisting > 0) {
            $this->components->warn("Skipped existing rows: {$skippedExisting}");
        }

        if ($this->option('dry-run')) {
            $this->components->info('Dry run passed. No data was written.');

            return self::SUCCESS;
        }

        DB::transaction(function () use ($records): void {
            $records->each(function (array $record): void {
                unset($record['legacy_id']);

                News::query()->create($record);
            });
        });

        $this->components->info('Import completed.');

        return self::SUCCESS;
    }

    /**
     * @param  array<string, bool>  $usedSlugs
     */
    private function uniqueSlug(string $title, int $legacyId, array &$usedSlugs): string
    {
        $base = Str::slug($title) ?: "berita-lama-{$legacyId}";
        $candidate = $this->slugWithSuffix($base);
        $counter = 2;

        while (isset($usedSlugs[$candidate]) || News::query()->where('slug', $candidate)->exists()) {
            $suffix = $counter === 2 ? "-{$legacyId}" : "-{$legacyId}-{$counter}";
            $candidate = $this->slugWithSuffix($base, $suffix);
            $counter++;
        }

        $usedSlugs[$candidate] = true;

        return $candidate;
    }

    private function slugWithSuffix(string $base, string $suffix = ''): string
    {
        return Str::limit($base, 255 - strlen($suffix), '').$suffix;
    }

    private function coverImage(?string $image): ?string
    {
        $image = trim((string) $image);

        if ($image === '') {
            return null;
        }

        $image = ltrim(str_replace('\\', '/', $image), '/');

        return Str::startsWith($image, 'berita/') ? $image : "berita/{$image}";
    }

    private function publishedAt(mixed $date): Carbon
    {
        if ($date === null || trim((string) $date) === '') {
            return now();
        }

        return Carbon::parse($date)->startOfDay();
    }
}
