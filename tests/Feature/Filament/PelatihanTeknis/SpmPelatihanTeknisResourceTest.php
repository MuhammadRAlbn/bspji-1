<?php

namespace Tests\Feature\Filament\PelatihanTeknis;

use App\Actions\Images\ConvertUploadedImageToWebp;
use App\Exceptions\InvalidUploadedImage;
use App\Filament\Clusters\PelatihanTeknis\Resources\SpmPelatihanTeknisResource;
use App\Filament\Clusters\PelatihanTeknis\Resources\SpmPelatihanTeknisResource\Pages\CreateSpmPelatihanTeknis;
use App\Filament\Clusters\PelatihanTeknis\Resources\SpmPelatihanTeknisResource\Pages\EditSpmPelatihanTeknis;
use App\Models\SpmPelatihanTeknis;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Tests\TestCase;

class SpmPelatihanTeknisResourceTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->actingAs(User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]));
    }

    public function test_admin_can_access_spm_resource_at_expected_slug(): void
    {
        $this->assertSame(
            '/admin/pelatihan-teknis/spm',
            parse_url(SpmPelatihanTeknisResource::getUrl('index'), PHP_URL_PATH),
        );

        $this->get(SpmPelatihanTeknisResource::getUrl('index'))
            ->assertOk();
    }

    public function test_guest_and_humas_cannot_manage_spm(): void
    {
        auth()->logout();

        $this->get(SpmPelatihanTeknisResource::getUrl('index'))
            ->assertRedirect(filament()->getPanel('admin')->getLoginUrl());

        $this->actingAs(User::factory()->create([
            'role' => User::ROLE_HUMAS,
        ]));

        $this->assertFalse(SpmPelatihanTeknisResource::canAccess());

        $this->get(SpmPelatihanTeknisResource::getUrl('index'))
            ->assertForbidden();
    }

    public function test_admin_upload_is_saved_only_as_random_webp(): void
    {
        Livewire::test(CreateSpmPelatihanTeknis::class)
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('poster-spm-pelatihan-teknis.jpg', 1200, 800),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $spmPelatihanTeknis = SpmPelatihanTeknis::query()->sole();

        $this->assertMatchesRegularExpression(
            '/\Apelatihan-teknis\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/',
            $spmPelatihanTeknis->image_path,
        );
        $this->assertStringNotContainsString('poster-spm', $spmPelatihanTeknis->image_path);
        Storage::disk('public')->assertExists($spmPelatihanTeknis->image_path);
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($spmPelatihanTeknis->image_path));
        $this->assertFalse(SpmPelatihanTeknisResource::canCreate());
    }

    public function test_form_rejects_disallowed_types_size_and_dimensions(): void
    {
        $validJpeg = UploadedFile::fake()->image('source.jpg', 20, 20);
        $validJpegContents = file_get_contents($validJpeg->getRealPath());

        $this->assertIsString($validJpegContents);

        $invalidUploads = [
            UploadedFile::fake()->createWithContent('payload.php', $validJpegContents),
            UploadedFile::fake()->createWithContent('fake.jpg', '<?php echo "shell"; ?>'),
            UploadedFile::fake()->createWithContent('image.svg', '<svg xmlns="http://www.w3.org/2000/svg"></svg>'),
            UploadedFile::fake()->image('animation.gif', 20, 20),
            UploadedFile::fake()->image('oversized.jpg', 20, 20)->size(5121),
            UploadedFile::fake()->image('too-wide.png', 4097, 10),
        ];

        foreach ($invalidUploads as $upload) {
            Livewire::test(CreateSpmPelatihanTeknis::class)
                ->fillForm(['image_path' => $upload])
                ->call('create')
                ->assertHasFormErrors(['image_path']);
        }

        $this->assertFalse(SpmPelatihanTeknis::query()->exists());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_client_cannot_replace_existing_state_with_another_path(): void
    {
        $spmPelatihanTeknis = $this->createStoredSpm();
        $originalPath = $spmPelatihanTeknis->image_path;
        $foreignPath = 'berita/'.Str::ulid().'.webp';

        Storage::disk('public')->put($foreignPath, $this->webpContents());

        Livewire::test(EditSpmPelatihanTeknis::class, [
            'record' => $spmPelatihanTeknis->getRouteKey(),
        ])
            ->set('data.image_path', ['tampered' => $foreignPath])
            ->call('save')
            ->assertHasFormErrors(['image_path.tampered']);

        $this->assertSame($originalPath, $spmPelatihanTeknis->fresh()->image_path);
        Storage::disk('public')->assertExists($originalPath);
    }

    public function test_replacing_image_removes_previous_file_after_save(): void
    {
        $spmPelatihanTeknis = $this->createStoredSpm();
        $oldPath = $spmPelatihanTeknis->image_path;

        Livewire::test(EditSpmPelatihanTeknis::class, [
            'record' => $spmPelatihanTeknis->getRouteKey(),
        ])
            ->set('data.image_path', [])
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('replacement.png', 90, 120),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $newPath = $spmPelatihanTeknis->fresh()->image_path;

        $this->assertNotSame($oldPath, $newPath);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($newPath);
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($newPath));
    }

    public function test_deleting_record_removes_managed_image(): void
    {
        $spmPelatihanTeknis = $this->createStoredSpm();
        $path = $spmPelatihanTeknis->image_path;

        $spmPelatihanTeknis->delete();

        $this->assertModelMissing($spmPelatihanTeknis);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_conversion_failure_creates_neither_record_nor_file(): void
    {
        $this->app->bind(
            ConvertUploadedImageToWebp::class,
            fn (): ConvertUploadedImageToWebp => new class extends ConvertUploadedImageToWebp
            {
                public function execute(SymfonyUploadedFile $file, string $directory = self::DIRECTORY_PENGUJIAN): string
                {
                    throw new InvalidUploadedImage('Konversi sengaja digagalkan.');
                }
            },
        );

        Livewire::test(CreateSpmPelatihanTeknis::class)
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('valid.jpg', 120, 80),
            ])
            ->call('create')
            ->assertHasFormErrors(['image_path']);

        $this->assertFalse(SpmPelatihanTeknis::query()->exists());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    private function createStoredSpm(): SpmPelatihanTeknis
    {
        $path = ConvertUploadedImageToWebp::DIRECTORY_PELATIHAN_TEKNIS.'/'.Str::ulid().'.webp';

        Storage::disk('public')->put($path, $this->webpContents());

        return SpmPelatihanTeknis::query()->create([
            'image_path' => $path,
        ]);
    }

    private function webpContents(): string
    {
        $upload = UploadedFile::fake()->image('fixture.webp', 20, 20);
        $contents = file_get_contents($upload->getRealPath());

        $this->assertIsString($contents);

        return $contents;
    }
}
