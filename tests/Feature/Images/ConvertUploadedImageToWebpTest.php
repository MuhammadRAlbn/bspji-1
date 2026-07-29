<?php

namespace Tests\Feature\Images;

use App\Actions\Images\ConvertUploadedImageToWebp;
use App\Exceptions\InvalidUploadedImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ConvertUploadedImageToWebpTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_supported_raster_formats_are_reencoded_as_webp(): void
    {
        foreach (['jpg', 'png', 'webp'] as $extension) {
            $upload = UploadedFile::fake()->image("spm.{$extension}", 120, 80);
            $path = (new ConvertUploadedImageToWebp)->execute($upload);

            $this->assertMatchesRegularExpression(
                '/\Apengujian\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/',
                $path,
            );
            Storage::disk('public')->assertExists($path);
            $this->assertSame('image/webp', Storage::disk('public')->mimeType($path));

            $imageInfo = getimagesize(Storage::disk('public')->path($path));

            $this->assertIsArray($imageInfo);
            $this->assertSame(IMAGETYPE_WEBP, $imageInfo[2]);
            $this->assertSame(120, $imageInfo[0]);
            $this->assertSame(80, $imageInfo[1]);
        }
    }

    public function test_polyglot_payload_is_removed_during_reencoding(): void
    {
        $source = UploadedFile::fake()->image('source.jpg', 40, 20);
        $sourceContents = file_get_contents($source->getRealPath());
        $payload = '<?php echo "compromised"; ?>';

        $this->assertIsString($sourceContents);

        $upload = UploadedFile::fake()->createWithContent(
            'spm.jpg',
            $sourceContents.$payload,
        );

        $path = (new ConvertUploadedImageToWebp)->execute($upload);
        $storedContents = Storage::disk('public')->get($path);

        $this->assertStringNotContainsString($payload, $storedContents);
        $this->assertStringNotContainsString('<?php', $storedContents);
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($path));
    }

    public function test_executable_names_and_invalid_image_contents_are_rejected(): void
    {
        $validJpeg = UploadedFile::fake()->image('source.jpg', 20, 20);
        $validJpegContents = file_get_contents($validJpeg->getRealPath());

        $this->assertIsString($validJpegContents);

        $uploads = [
            UploadedFile::fake()->createWithContent('payload.php', $validJpegContents),
            UploadedFile::fake()->createWithContent('payload.php7', $validJpegContents),
            UploadedFile::fake()->createWithContent('payload.phtml', $validJpegContents),
            UploadedFile::fake()->createWithContent('payload.phar', $validJpegContents),
            UploadedFile::fake()->createWithContent('payload.php.jpg', $validJpegContents),
            UploadedFile::fake()->createWithContent('fake.jpg', '<?php echo "shell"; ?>'),
            UploadedFile::fake()->createWithContent('image.svg', '<svg xmlns="http://www.w3.org/2000/svg"></svg>'),
            UploadedFile::fake()->image('animation.gif', 20, 20),
        ];

        foreach ($uploads as $upload) {
            $this->assertRejected($upload);
        }

        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_size_and_dimension_limits_are_enforced_again_by_converter(): void
    {
        $this->assertRejected(
            UploadedFile::fake()->image('oversized.jpg', 20, 20)->size(5121),
        );
        $this->assertRejected(
            UploadedFile::fake()->image('too-wide.png', 4097, 10),
        );

        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_custom_directory_execution_and_security_validation(): void
    {
        $upload = UploadedFile::fake()->image('spm-kalibrasi.jpg', 100, 100);
        $path = (new ConvertUploadedImageToWebp)->execute(
            $upload,
            ConvertUploadedImageToWebp::DIRECTORY_KALIBRASI,
        );

        $this->assertMatchesRegularExpression(
            '/\Akalibrasi\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/',
            $path,
        );
        $uploadSertifikasi = UploadedFile::fake()->image('spm-sertifikasi.jpg', 100, 100);
        $pathSertifikasi = (new ConvertUploadedImageToWebp)->execute(
            $uploadSertifikasi,
            ConvertUploadedImageToWebp::DIRECTORY_SERTIFIKASI_PRODUK,
        );

        $this->assertMatchesRegularExpression(
            '/\Asertifikasi-produk\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/',
            $pathSertifikasi,
        );
        Storage::disk('public')->assertExists($pathSertifikasi);

        $uploadLph = UploadedFile::fake()->image('spm-lph.jpg', 100, 100);
        $pathLph = (new ConvertUploadedImageToWebp)->execute(
            $uploadLph,
            ConvertUploadedImageToWebp::DIRECTORY_LPH,
        );

        $this->assertMatchesRegularExpression(
            '/\Alph\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/',
            $pathLph,
        );
        Storage::disk('public')->assertExists($pathLph);

        $uploadLsih = UploadedFile::fake()->image('spm-lsih.jpg', 100, 100);
        $pathLsih = (new ConvertUploadedImageToWebp)->execute(
            $uploadLsih,
            ConvertUploadedImageToWebp::DIRECTORY_LSIH,
        );

        $this->assertMatchesRegularExpression(
            '/\Alsih\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/',
            $pathLsih,
        );
        Storage::disk('public')->assertExists($pathLsih);

        $unauthorizedDirectories = [
            '../../secrets',
            'kalibrasi/spm/../other',
            '/absolute/path',
            'unlisted/directory',
        ];

        foreach ($unauthorizedDirectories as $dir) {
            try {
                (new ConvertUploadedImageToWebp)->execute($upload, $dir);
                $this->fail("Direktori {$dir} seharusnya ditolak.");
            } catch (InvalidUploadedImage $e) {
                $this->assertSame('Direktori penyimpanan tidak valid.', $e->getMessage());
            }
        }
    }

    private function assertRejected(UploadedFile $upload): void
    {
        try {
            (new ConvertUploadedImageToWebp)->execute($upload);
        } catch (InvalidUploadedImage) {
            return;
        }

        $this->fail("Upload {$upload->getClientOriginalName()} seharusnya ditolak.");
    }
}
