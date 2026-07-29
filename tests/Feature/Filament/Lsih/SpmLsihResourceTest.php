<?php

namespace Tests\Feature\Filament\Lsih;

use App\Actions\Images\ConvertUploadedImageToWebp;
use App\Exceptions\InvalidUploadedImage;
use App\Filament\Clusters\Lsih\Resources\SpmLsihResource;
use App\Filament\Clusters\Lsih\Resources\SpmLsihResource\Pages\CreateSpmLsih;
use App\Filament\Clusters\Lsih\Resources\SpmLsihResource\Pages\EditSpmLsih;
use App\Models\SpmLsih;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Tests\TestCase;

class SpmLsihResourceTest extends TestCase
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
            '/admin/lsih/spm',
            parse_url(SpmLsihResource::getUrl('index'), PHP_URL_PATH),
        );

        $this->get(SpmLsihResource::getUrl('index'))
            ->assertOk();
    }

    public function test_guest_and_humas_cannot_manage_spm(): void
    {
        auth()->logout();

        $this->get(SpmLsihResource::getUrl('index'))
            ->assertRedirect(filament()->getPanel('admin')->getLoginUrl());

        $this->actingAs(User::factory()->create([
            'role' => User::ROLE_HUMAS,
        ]));

        $this->assertFalse(SpmLsihResource::canAccess());

        $this->get(SpmLsihResource::getUrl('index'))
            ->assertForbidden();
    }

    public function test_admin_upload_is_saved_only_as_random_webp(): void
    {
        Livewire::test(CreateSpmLsih::class)
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('poster-spm-lsih.jpg', 1200, 800),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $spmLsih = SpmLsih::query()->sole();

        $this->assertMatchesRegularExpression(
            '/\Alsih\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/',
            $spmLsih->image_path,
        );
        $this->assertStringNotContainsString('poster-spm', $spmLsih->image_path);
        Storage::disk('public')->assertExists($spmLsih->image_path);
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($spmLsih->image_path));
        $this->assertFalse(SpmLsihResource::canCreate());
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
            Livewire::test(CreateSpmLsih::class)
                ->fillForm(['image_path' => $upload])
                ->call('create')
                ->assertHasFormErrors(['image_path']);
        }

        $this->assertFalse(SpmLsih::query()->exists());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_client_cannot_replace_existing_state_with_another_path(): void
    {
        $spmLsih = $this->createStoredSpm();
        $originalPath = $spmLsih->image_path;
        $foreignPath = 'berita/'.Str::ulid().'.webp';

        Storage::disk('public')->put($foreignPath, $this->webpContents());

        Livewire::test(EditSpmLsih::class, [
            'record' => $spmLsih->getRouteKey(),
        ])
            ->set('data.image_path', ['tampered' => $foreignPath])
            ->call('save')
            ->assertHasFormErrors(['image_path.tampered']);

        $this->assertSame($originalPath, $spmLsih->fresh()->image_path);
        Storage::disk('public')->assertExists($originalPath);
    }

    public function test_replacing_image_removes_previous_file_after_save(): void
    {
        $spmLsih = $this->createStoredSpm();
        $oldPath = $spmLsih->image_path;

        Livewire::test(EditSpmLsih::class, [
            'record' => $spmLsih->getRouteKey(),
        ])
            ->set('data.image_path', [])
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('replacement.png', 90, 120),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $newPath = $spmLsih->fresh()->image_path;

        $this->assertNotSame($oldPath, $newPath);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($newPath);
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($newPath));
    }

    public function test_deleting_record_removes_managed_image(): void
    {
        $spmLsih = $this->createStoredSpm();
        $path = $spmLsih->image_path;

        $spmLsih->delete();

        $this->assertModelMissing($spmLsih);
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

        Livewire::test(CreateSpmLsih::class)
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('valid.jpg', 120, 80),
            ])
            ->call('create')
            ->assertHasFormErrors(['image_path']);

        $this->assertFalse(SpmLsih::query()->exists());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    private function createStoredSpm(): SpmLsih
    {
        $path = ConvertUploadedImageToWebp::DIRECTORY_LSIH.'/'.Str::ulid().'.webp';

        Storage::disk('public')->put($path, $this->webpContents());

        return SpmLsih::query()->create([
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
