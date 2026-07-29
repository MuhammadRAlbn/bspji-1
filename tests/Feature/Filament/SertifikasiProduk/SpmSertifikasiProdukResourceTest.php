<?php

namespace Tests\Feature\Filament\SertifikasiProduk;

use App\Actions\Images\ConvertUploadedImageToWebp;
use App\Exceptions\InvalidUploadedImage;
use App\Filament\Clusters\SertifikasiProduk\Resources\SpmSertifikasiProdukResource;
use App\Filament\Clusters\SertifikasiProduk\Resources\SpmSertifikasiProdukResource\Pages\CreateSpmSertifikasiProduk;
use App\Filament\Clusters\SertifikasiProduk\Resources\SpmSertifikasiProdukResource\Pages\EditSpmSertifikasiProduk;
use App\Models\SpmSertifikasiProduk;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Tests\TestCase;

class SpmSertifikasiProdukResourceTest extends TestCase
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
            '/admin/sertifikasi-produk/spm',
            parse_url(SpmSertifikasiProdukResource::getUrl('index'), PHP_URL_PATH),
        );

        $this->get(SpmSertifikasiProdukResource::getUrl('index'))
            ->assertOk();
    }

    public function test_guest_and_humas_cannot_manage_spm(): void
    {
        auth()->logout();

        $this->get(SpmSertifikasiProdukResource::getUrl('index'))
            ->assertRedirect(filament()->getPanel('admin')->getLoginUrl());

        $this->actingAs(User::factory()->create([
            'role' => User::ROLE_HUMAS,
        ]));

        $this->assertFalse(SpmSertifikasiProdukResource::canAccess());

        $this->get(SpmSertifikasiProdukResource::getUrl('index'))
            ->assertForbidden();
    }

    public function test_admin_upload_is_saved_only_as_random_webp(): void
    {
        Livewire::test(CreateSpmSertifikasiProduk::class)
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('poster-spm-sertifikasi.jpg', 1200, 800),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $spmSertifikasiProduk = SpmSertifikasiProduk::query()->sole();

        $this->assertMatchesRegularExpression(
            '/\Asertifikasi-produk\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/',
            $spmSertifikasiProduk->image_path,
        );
        $this->assertStringNotContainsString('poster-spm', $spmSertifikasiProduk->image_path);
        Storage::disk('public')->assertExists($spmSertifikasiProduk->image_path);
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($spmSertifikasiProduk->image_path));
        $this->assertFalse(SpmSertifikasiProdukResource::canCreate());
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
            Livewire::test(CreateSpmSertifikasiProduk::class)
                ->fillForm(['image_path' => $upload])
                ->call('create')
                ->assertHasFormErrors(['image_path']);
        }

        $this->assertFalse(SpmSertifikasiProduk::query()->exists());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_client_cannot_replace_existing_state_with_another_path(): void
    {
        $spmSertifikasiProduk = $this->createStoredSpm();
        $originalPath = $spmSertifikasiProduk->image_path;
        $foreignPath = 'berita/'.Str::ulid().'.webp';

        Storage::disk('public')->put($foreignPath, $this->webpContents());

        Livewire::test(EditSpmSertifikasiProduk::class, [
            'record' => $spmSertifikasiProduk->getRouteKey(),
        ])
            ->set('data.image_path', ['tampered' => $foreignPath])
            ->call('save')
            ->assertHasFormErrors(['image_path.tampered']);

        $this->assertSame($originalPath, $spmSertifikasiProduk->fresh()->image_path);
        Storage::disk('public')->assertExists($originalPath);
    }

    public function test_replacing_image_removes_previous_file_after_save(): void
    {
        $spmSertifikasiProduk = $this->createStoredSpm();
        $oldPath = $spmSertifikasiProduk->image_path;

        Livewire::test(EditSpmSertifikasiProduk::class, [
            'record' => $spmSertifikasiProduk->getRouteKey(),
        ])
            ->set('data.image_path', [])
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('replacement.png', 90, 120),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $newPath = $spmSertifikasiProduk->fresh()->image_path;

        $this->assertNotSame($oldPath, $newPath);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($newPath);
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($newPath));
    }

    public function test_deleting_record_removes_managed_image(): void
    {
        $spmSertifikasiProduk = $this->createStoredSpm();
        $path = $spmSertifikasiProduk->image_path;

        $spmSertifikasiProduk->delete();

        $this->assertModelMissing($spmSertifikasiProduk);
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

        Livewire::test(CreateSpmSertifikasiProduk::class)
            ->fillForm([
                'image_path' => UploadedFile::fake()->image('valid.jpg', 120, 80),
            ])
            ->call('create')
            ->assertHasFormErrors(['image_path']);

        $this->assertFalse(SpmSertifikasiProduk::query()->exists());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    private function createStoredSpm(): SpmSertifikasiProduk
    {
        $path = ConvertUploadedImageToWebp::DIRECTORY_SERTIFIKASI_PRODUK.'/'.Str::ulid().'.webp';

        Storage::disk('public')->put($path, $this->webpContents());

        return SpmSertifikasiProduk::query()->create([
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
