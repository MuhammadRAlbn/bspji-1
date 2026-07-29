<?php

namespace Tests\Feature\Filament\KonsultasiPendampingan;

use App\Actions\Images\ConvertUploadedImageToWebp;
use App\Exceptions\InvalidUploadedImage;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\SpmKonsultasiPendampinganResource;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\SpmKonsultasiPendampinganResource\Pages\CreateSpmKonsultasiPendampingan;
use App\Filament\Clusters\KonsultasiPendampingan\Resources\SpmKonsultasiPendampinganResource\Pages\EditSpmKonsultasiPendampingan;
use App\Models\SpmKonsultasiPendampingan;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Tests\TestCase;

class SpmKonsultasiPendampinganResourceTest extends TestCase
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
            '/admin/konsultasi-pendampingan/spm',
            parse_url(SpmKonsultasiPendampinganResource::getUrl('index'), PHP_URL_PATH),
        );

        $this->get(SpmKonsultasiPendampinganResource::getUrl('index'))
            ->assertOk();
    }

    public function test_guest_and_humas_cannot_manage_spm(): void
    {
        auth()->logout();

        $this->get(SpmKonsultasiPendampinganResource::getUrl('index'))
            ->assertRedirect(filament()->getPanel('admin')->getLoginUrl());

        $this->actingAs(User::factory()->create([
            'role' => User::ROLE_HUMAS,
        ]));

        $this->assertFalse(SpmKonsultasiPendampinganResource::canAccess());

        $this->get(SpmKonsultasiPendampinganResource::getUrl('index'))
            ->assertForbidden();
    }

    public function test_admin_upload_is_saved_only_as_random_webp(): void
    {
        Livewire::test(CreateSpmKonsultasiPendampingan::class)
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('poster-spm-konsultasi.jpg', 1200, 800),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $spmKonsultasiPendampingan = SpmKonsultasiPendampingan::query()->sole();

        $this->assertMatchesRegularExpression(
            '/\Akonsultasi-pendampingan\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/',
            $spmKonsultasiPendampingan->image_path,
        );
        $this->assertStringNotContainsString('poster-spm', $spmKonsultasiPendampingan->image_path);
        Storage::disk('public')->assertExists($spmKonsultasiPendampingan->image_path);
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($spmKonsultasiPendampingan->image_path));
        $this->assertFalse(SpmKonsultasiPendampinganResource::canCreate());
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
            Livewire::test(CreateSpmKonsultasiPendampingan::class)
                ->fillForm(['image_path' => $upload])
                ->call('create')
                ->assertHasFormErrors(['image_path']);
        }

        $this->assertFalse(SpmKonsultasiPendampingan::query()->exists());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_client_cannot_replace_existing_state_with_another_path(): void
    {
        $spmKonsultasiPendampingan = $this->createStoredSpm();
        $originalPath = $spmKonsultasiPendampingan->image_path;
        $foreignPath = 'berita/'.Str::ulid().'.webp';

        Storage::disk('public')->put($foreignPath, $this->webpContents());

        Livewire::test(EditSpmKonsultasiPendampingan::class, [
            'record' => $spmKonsultasiPendampingan->getRouteKey(),
        ])
            ->set('data.image_path', ['tampered' => $foreignPath])
            ->call('save')
            ->assertHasFormErrors(['image_path.tampered']);

        $this->assertSame($originalPath, $spmKonsultasiPendampingan->fresh()->image_path);
        Storage::disk('public')->assertExists($originalPath);
    }

    public function test_replacing_image_removes_previous_file_after_save(): void
    {
        $spmKonsultasiPendampingan = $this->createStoredSpm();
        $oldPath = $spmKonsultasiPendampingan->image_path;

        Livewire::test(EditSpmKonsultasiPendampingan::class, [
            'record' => $spmKonsultasiPendampingan->getRouteKey(),
        ])
            ->set('data.image_path', [])
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('replacement.png', 90, 120),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $newPath = $spmKonsultasiPendampingan->fresh()->image_path;

        $this->assertNotSame($oldPath, $newPath);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($newPath);
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($newPath));
    }

    public function test_deleting_record_removes_managed_image(): void
    {
        $spmKonsultasiPendampingan = $this->createStoredSpm();
        $path = $spmKonsultasiPendampingan->image_path;

        $spmKonsultasiPendampingan->delete();

        $this->assertModelMissing($spmKonsultasiPendampingan);
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

        Livewire::test(CreateSpmKonsultasiPendampingan::class)
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('valid.jpg', 120, 80),
            ])
            ->call('create')
            ->assertHasFormErrors(['image_path']);

        $this->assertFalse(SpmKonsultasiPendampingan::query()->exists());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    private function createStoredSpm(): SpmKonsultasiPendampingan
    {
        $path = ConvertUploadedImageToWebp::DIRECTORY_KONSULTASI_PENDAMPINGAN.'/'.Str::ulid().'.webp';

        Storage::disk('public')->put($path, $this->webpContents());

        return SpmKonsultasiPendampingan::query()->create([
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
