<?php

namespace Tests\Feature\Filament\Pengujian;

use App\Actions\Images\ConvertUploadedImageToWebp;
use App\Exceptions\InvalidUploadedImage;
use App\Filament\Clusters\Pengujian\Resources\SpmPengujianResource;
use App\Filament\Clusters\Pengujian\Resources\SpmPengujianResource\Pages\CreateSpmPengujian;
use App\Filament\Clusters\Pengujian\Resources\SpmPengujianResource\Pages\EditSpmPengujian;
use App\Models\SpmPengujian;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Tests\TestCase;

class SpmPengujianResourceTest extends TestCase
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
            '/admin/pengujian/spm',
            parse_url(SpmPengujianResource::getUrl('index'), PHP_URL_PATH),
        );

        $this->get(SpmPengujianResource::getUrl('index'))
            ->assertOk();
    }

    public function test_guest_and_humas_cannot_manage_spm(): void
    {
        auth()->logout();

        $this->get(SpmPengujianResource::getUrl('index'))
            ->assertRedirect(filament()->getPanel('admin')->getLoginUrl());

        $this->actingAs(User::factory()->create([
            'role' => User::ROLE_HUMAS,
        ]));

        $this->assertFalse(SpmPengujianResource::canAccess());

        $this->get(SpmPengujianResource::getUrl('index'))
            ->assertForbidden();
    }

    public function test_admin_upload_is_saved_only_as_random_webp(): void
    {
        Livewire::test(CreateSpmPengujian::class)
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('poster-spm.jpg', 1200, 800),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $spmPengujian = SpmPengujian::query()->sole();

        $this->assertMatchesRegularExpression(
            '/\Apengujian\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/',
            $spmPengujian->image_path,
        );
        $this->assertStringNotContainsString('poster-spm', $spmPengujian->image_path);
        Storage::disk('public')->assertExists($spmPengujian->image_path);
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($spmPengujian->image_path));
        $this->assertFalse(SpmPengujianResource::canCreate());
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
            Livewire::test(CreateSpmPengujian::class)
                ->fillForm(['image_path' => $upload])
                ->call('create')
                ->assertHasFormErrors(['image_path']);
        }

        $this->assertFalse(SpmPengujian::query()->exists());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_client_cannot_replace_existing_state_with_another_path(): void
    {
        $spmPengujian = $this->createStoredSpm();
        $originalPath = $spmPengujian->image_path;
        $foreignPath = 'berita/'.Str::ulid().'.webp';

        Storage::disk('public')->put($foreignPath, $this->webpContents());

        Livewire::test(EditSpmPengujian::class, [
            'record' => $spmPengujian->getRouteKey(),
        ])
            ->set('data.image_path', ['tampered' => $foreignPath])
            ->call('save')
            ->assertHasFormErrors(['image_path.tampered']);

        $this->assertSame($originalPath, $spmPengujian->fresh()->image_path);
        Storage::disk('public')->assertExists($originalPath);
    }

    public function test_replacing_image_removes_previous_file_after_save(): void
    {
        $spmPengujian = $this->createStoredSpm();
        $oldPath = $spmPengujian->image_path;

        Livewire::test(EditSpmPengujian::class, [
            'record' => $spmPengujian->getRouteKey(),
        ])
            ->set('data.image_path', [])
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('replacement.png', 90, 120),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $newPath = $spmPengujian->fresh()->image_path;

        $this->assertNotSame($oldPath, $newPath);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($newPath);
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($newPath));
    }

    public function test_deleting_record_removes_managed_image(): void
    {
        $spmPengujian = $this->createStoredSpm();
        $path = $spmPengujian->image_path;

        $spmPengujian->delete();

        $this->assertModelMissing($spmPengujian);
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

        Livewire::test(CreateSpmPengujian::class)
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('valid.jpg', 120, 80),
            ])
            ->call('create')
            ->assertHasFormErrors(['image_path']);

        $this->assertFalse(SpmPengujian::query()->exists());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    private function createStoredSpm(): SpmPengujian
    {
        $path = ConvertUploadedImageToWebp::DIRECTORY.'/'.Str::ulid().'.webp';

        Storage::disk('public')->put($path, $this->webpContents());

        return SpmPengujian::query()->create([
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
