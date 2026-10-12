<?php

namespace Tests\Feature\Filament\Pengujian;

use App\Filament\Clusters\Pengujian\Resources\SertifikasiResource;
use App\Filament\Clusters\Pengujian\Resources\SertifikasiResource\Pages\CreateSertifikasi;
use App\Filament\Clusters\Pengujian\Resources\SertifikasiResource\Pages\ListSertifikasis;
use App\Models\Sertifikasi;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Mockery;
use Tests\TestCase;

class SertifikasiResourceTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));
    }

    public function test_admin_reordering_is_saved_and_displayed_on_the_website(): void
    {
        $first = Sertifikasi::query()->create(['image' => 'sertifikasi/first.webp']);
        $second = Sertifikasi::query()->create(['image' => 'sertifikasi/second.webp']);
        $third = Sertifikasi::query()->create(['image' => 'sertifikasi/third.webp']);

        Livewire::test(ListSertifikasis::class)
            ->assertCanSeeTableRecords([$first, $second, $third], inOrder: true)
            ->call('toggleTableReordering')
            ->call('reorderTable', [$third->getKey(), $first->getKey(), $second->getKey()])
            ->call('toggleTableReordering')
            ->assertCanSeeTableRecords([$third, $first, $second], inOrder: true);

        $this->assertSame(1, $third->fresh()->urutan);
        $this->assertSame(2, $first->fresh()->urutan);
        $this->assertSame(3, $second->fresh()->urutan);

        $this->get(route('pengujian.index'))
            ->assertOk()
            ->assertSeeInOrder([
                asset('storage/'.$third->image),
                asset('storage/'.$first->image),
                asset('storage/'.$second->image),
            ], escape: false);
    }

    public function test_new_certificate_is_appended_after_the_existing_order(): void
    {
        $first = Sertifikasi::query()->create(['image' => 'sertifikasi/first.webp']);
        $second = Sertifikasi::query()->create(['image' => 'sertifikasi/second.webp']);
        $first->update(['urutan' => 2]);
        $second->update(['urutan' => 1]);

        $new = Sertifikasi::query()->create(['image' => 'sertifikasi/new.webp']);

        $this->assertSame(3, $new->urutan);
        $this->assertSame(
            [$second->getKey(), $first->getKey(), $new->getKey()],
            Sertifikasi::query()->ordered()->pluck('id')->all(),
        );
    }

    public function test_replacing_a_certificate_image_keeps_its_position(): void
    {
        $certificate = Sertifikasi::query()->create([
            'image' => 'sertifikasi/original.webp',
            'urutan' => 5,
        ]);

        $certificate->update(['image' => 'sertifikasi/replacement.webp']);

        $this->assertSame(5, $certificate->fresh()->urutan);
    }

    public function test_deleting_a_certificate_preserves_the_remaining_order(): void
    {
        $first = Sertifikasi::query()->create(['image' => 'sertifikasi/first.webp']);
        $second = Sertifikasi::query()->create(['image' => 'sertifikasi/second.webp']);
        $third = Sertifikasi::query()->create(['image' => 'sertifikasi/third.webp']);

        $second->delete();

        $this->assertSame(
            [$first->getKey(), $third->getKey()],
            Sertifikasi::query()->ordered()->pluck('id')->all(),
        );
    }

    public function test_non_admin_users_cannot_reorder_certificates(): void
    {
        $admin = auth()->user();
        $first = Sertifikasi::query()->create(['image' => 'sertifikasi/first.webp']);
        $second = Sertifikasi::query()->create(['image' => 'sertifikasi/second.webp']);

        foreach ([User::ROLE_HUMAS, User::ROLE_FAP, User::ROLE_KEPALA_BALAI] as $role) {
            $this->actingAs($admin);
            $component = Livewire::test(ListSertifikasis::class);
            $this->actingAs(User::factory()->create(['role' => $role]));

            $this->assertFalse(SertifikasiResource::canReorder());

            $component->call('reorderTable', [$second->getKey(), $first->getKey()]);

            $this->assertSame(1, $first->fresh()->urutan);
            $this->assertSame(2, $second->fresh()->urutan);
        }
    }

    public function test_multiple_upload_creates_separate_certificates_at_the_end(): void
    {
        $existing = Sertifikasi::query()->create(['image' => 'sertifikasi/existing.webp']);

        Livewire::test(ListSertifikasis::class)
            ->callAction('uploadMultiple', data: ['images' => [
                UploadedFile::fake()->image('first.jpg', 120, 80),
                UploadedFile::fake()->image('second.png', 120, 80),
                UploadedFile::fake()->image('third.webp', 120, 80),
            ]])
            ->assertHasNoActionErrors()
            ->assertNotified('3 sertifikat berhasil diunggah.');

        $certificates = Sertifikasi::query()->ordered()->get();

        $this->assertCount(4, $certificates);
        $this->assertSame($existing->getKey(), $certificates->first()->getKey());
        $this->assertSame([1, 2, 3, 4], $certificates->pluck('urutan')->all());
        $this->assertSame(['jpg', 'png', 'webp'], $certificates->skip(1)->map(fn (Sertifikasi $certificate): string => pathinfo($certificate->image, PATHINFO_EXTENSION))->values()->all());

        foreach ($certificates->skip(1) as $certificate) {
            Storage::disk('public')->assertExists($certificate->image);
        }
    }

    public function test_single_certificate_upload_remains_available(): void
    {
        Livewire::test(CreateSertifikasi::class)
            ->fillForm(['image' => UploadedFile::fake()->image('single.jpg', 120, 80)])
            ->call('create')
            ->assertHasNoFormErrors();

        $certificate = Sertifikasi::query()->sole();

        $this->assertSame(1, $certificate->urutan);
        Storage::disk('public')->assertExists($certificate->image);
    }

    public function test_multiple_upload_rolls_back_when_existing_capacity_is_exceeded(): void
    {
        for ($index = 1; $index <= 6; $index++) {
            Sertifikasi::query()->create(['image' => 'sertifikasi/existing-'.$index.'.webp']);
        }

        Livewire::test(ListSertifikasis::class)
            ->callAction('uploadMultiple', data: ['images' => [
                UploadedFile::fake()->image('first.jpg', 120, 80),
                UploadedFile::fake()->image('second.jpg', 120, 80),
            ]])
            ->assertHasActionErrors(['images']);

        $this->assertSame(6, Sertifikasi::query()->count());
        $this->assertSame([], Storage::disk('public')->allFiles('sertifikasi'));
    }

    public function test_multiple_upload_rejects_non_images_and_existing_file_paths(): void
    {
        Storage::disk('public')->put('sertifikasi/existing.webp', 'existing file');

        Livewire::test(ListSertifikasis::class)
            ->callAction('uploadMultiple', data: ['images' => [UploadedFile::fake()->create('document.pdf')]])
            ->assertHasActionErrors();

        Livewire::test(ListSertifikasis::class)
            ->callAction('uploadMultiple', data: ['images' => ['sertifikasi/existing.webp']])
            ->assertHasActionErrors(['images']);

        $this->assertSame(0, Sertifikasi::query()->count());
        Storage::disk('public')->assertExists('sertifikasi/existing.webp');
    }

    public function test_failed_file_write_creates_no_certificate(): void
    {
        $disk = Mockery::mock(Storage::disk('public'))->makePartial();
        $disk->shouldReceive('put')->once()->andReturn(false);
        Storage::set('public', $disk);

        Livewire::test(ListSertifikasis::class)
            ->callAction('uploadMultiple', data: ['images' => [UploadedFile::fake()->image('failed.jpg', 120, 80)]])
            ->assertHasActionErrors(['images']);

        $this->assertSame(0, Sertifikasi::query()->count());
        $this->assertSame([], Storage::disk('public')->allFiles('sertifikasi'));
    }

    public function test_backfill_preserves_the_latest_first_order_for_existing_certificates(): void
    {
        $table = (new Sertifikasi)->getTable();

        DB::table($table)->insert([
            ['image' => 'sertifikasi/old.webp', 'created_at' => '2026-01-01 00:00:00', 'updated_at' => '2026-01-01 00:00:00'],
            ['image' => 'sertifikasi/new.webp', 'created_at' => '2026-02-01 00:00:00', 'updated_at' => '2026-02-01 00:00:00'],
            ['image' => 'sertifikasi/tie.webp', 'created_at' => '2026-02-01 00:00:00', 'updated_at' => '2026-02-01 00:00:00'],
        ]);

        $migration = require database_path('migrations/2026_10_12_030933_backfill_sertifikasi_urutan.php');
        $migration->up();

        $this->assertSame(
            ['sertifikasi/tie.webp', 'sertifikasi/new.webp', 'sertifikasi/old.webp'],
            Sertifikasi::query()->ordered()->pluck('image')->all(),
        );
        $this->assertSame([1, 2, 3], Sertifikasi::query()->ordered()->pluck('urutan')->all());
        $this->assertSame('2026-01-01 00:00:00', DB::table($table)->where('image', 'sertifikasi/old.webp')->value('updated_at'));
    }
}
