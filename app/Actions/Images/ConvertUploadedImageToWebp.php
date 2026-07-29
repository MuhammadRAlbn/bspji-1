<?php

namespace App\Actions\Images;

use App\Exceptions\InvalidUploadedImage;
use finfo;
use GdImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

class ConvertUploadedImageToWebp
{
    public const string DIRECTORY = 'pengujian/spm';

    public const string DIRECTORY_PENGUJIAN = 'pengujian/spm';

    public const string DIRECTORY_KALIBRASI = 'kalibrasi/spm';

    public const string DIRECTORY_SERTIFIKASI_PRODUK = 'sertifikasi-produk/spm';

    public const string DIRECTORY_LPH = 'lph/spm';

    public const string DIRECTORY_LSIH = 'lsih/spm';

    public const string DIRECTORY_VERIFIKASI_TKDN = 'verifikasi-tkdn/spm';

    public const string DIRECTORY_PELATIHAN_TEKNIS = 'pelatihan-teknis/spm';

    public const string DIRECTORY_KONSULTASI_PENDAMPINGAN = 'konsultasi-pendampingan/spm';

    public const int MAX_FILE_SIZE = 5 * 1024 * 1024;

    public const int MAX_DIMENSION = 4096;

    public const int QUALITY = 82;

    private const array ALLOWED_DIRECTORIES = [
        self::DIRECTORY_PENGUJIAN,
        self::DIRECTORY_KALIBRASI,
        self::DIRECTORY_SERTIFIKASI_PRODUK,
        self::DIRECTORY_LPH,
        self::DIRECTORY_LSIH,
        self::DIRECTORY_VERIFIKASI_TKDN,
        self::DIRECTORY_PELATIHAN_TEKNIS,
        self::DIRECTORY_KONSULTASI_PENDAMPINGAN,
    ];

    private const array ALLOWED_EXTENSIONS = [
        'jpg',
        'jpeg',
        'png',
        'webp',
    ];

    private const array ALLOWED_IMAGE_TYPES = [
        'image/jpeg' => IMAGETYPE_JPEG,
        'image/png' => IMAGETYPE_PNG,
        'image/webp' => IMAGETYPE_WEBP,
    ];

    public function execute(UploadedFile $file, string $directory = self::DIRECTORY_PENGUJIAN): string
    {
        if (! extension_loaded('gd') || ! function_exists('imagewebp')) {
            $this->fail('Server tidak mendukung konversi gambar WebP.');
        }

        $this->validateTargetDirectory($directory);

        $sourcePath = $file->getRealPath();

        if (! is_string($sourcePath) || ! is_file($sourcePath)) {
            $this->fail('Berkas gambar tidak dapat dibaca.');
        }

        $this->validateOriginalFilename($file);
        $this->validateFileSize($file);

        $imageInfo = @getimagesize($sourcePath);
        $detectedMimeType = (new finfo(FILEINFO_MIME_TYPE))->file($sourcePath);

        if (! is_array($imageInfo) || ! is_string($detectedMimeType)) {
            $this->fail('Isi berkas bukan gambar yang valid.');
        }

        $width = $imageInfo[0] ?? 0;
        $height = $imageInfo[1] ?? 0;
        $imageType = $imageInfo[2] ?? 0;
        $imageMimeType = $imageInfo['mime'] ?? null;
        $expectedImageType = self::ALLOWED_IMAGE_TYPES[$detectedMimeType] ?? null;

        if (
            ! is_int($width)
            || ! is_int($height)
            || $width < 1
            || $height < 1
            || $width > self::MAX_DIMENSION
            || $height > self::MAX_DIMENSION
        ) {
            $this->fail('Dimensi gambar maksimal adalah 4096 × 4096 piksel.');
        }

        if (
            ! is_int($expectedImageType)
            || $imageType !== $expectedImageType
            || $imageMimeType !== $detectedMimeType
        ) {
            $this->fail('Format gambar harus berupa JPEG, PNG, atau WebP yang valid.');
        }

        $image = $this->decode($sourcePath, $imageType);

        try {
            if ($imageType === IMAGETYPE_JPEG) {
                $image = $this->normalizeJpegOrientation($image, $sourcePath);
            }

            if (! imageistruecolor($image)) {
                imagepalettetotruecolor($image);
            }

            imagesavealpha($image, true);
            $webpContents = $this->encode($image);
        } finally {
            imagedestroy($image);
        }

        return $this->store($webpContents, $directory);
    }

    private function validateOriginalFilename(UploadedFile $file): void
    {
        $originalName = $file->getClientOriginalName();
        $extension = Str::lower($file->getClientOriginalExtension());

        if (
            ! in_array($extension, self::ALLOWED_EXTENSIONS, true)
            || preg_match('/\.(?:php\d*|phtml|phar|phps)(?:\.|$)/i', $originalName) === 1
        ) {
            $this->fail('Ekstensi berkas tidak diizinkan.');
        }
    }

    private function validateFileSize(UploadedFile $file): void
    {
        $size = $file->getSize();

        if (! is_int($size) || $size < 1 || $size > self::MAX_FILE_SIZE) {
            $this->fail('Ukuran gambar maksimal adalah 5 MB.');
        }
    }

    private function decode(string $sourcePath, int $imageType): GdImage
    {
        $decoder = match ($imageType) {
            IMAGETYPE_JPEG => 'imagecreatefromjpeg',
            IMAGETYPE_PNG => 'imagecreatefrompng',
            IMAGETYPE_WEBP => 'imagecreatefromwebp',
            default => null,
        };

        if (! is_string($decoder) || ! function_exists($decoder)) {
            $this->fail('Server tidak mendukung format gambar tersebut.');
        }

        $image = @$decoder($sourcePath);

        if (! $image instanceof GdImage) {
            $this->fail('Gambar gagal dibuka dengan aman.');
        }

        return $image;
    }

    private function normalizeJpegOrientation(GdImage $image, string $sourcePath): GdImage
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($sourcePath, 'IFD0', true, false);
        $orientation = is_array($exif)
            ? (int) ($exif['IFD0']['Orientation'] ?? $exif['Orientation'] ?? 1)
            : 1;

        return match ($orientation) {
            2 => $this->flip($image, IMG_FLIP_HORIZONTAL),
            3 => $this->rotate($image, 180),
            4 => $this->flip($image, IMG_FLIP_VERTICAL),
            5 => $this->rotate($this->flip($image, IMG_FLIP_HORIZONTAL), -90),
            6 => $this->rotate($image, -90),
            7 => $this->rotate($this->flip($image, IMG_FLIP_HORIZONTAL), 90),
            8 => $this->rotate($image, 90),
            default => $image,
        };
    }

    private function flip(GdImage $image, int $mode): GdImage
    {
        if (! imageflip($image, $mode)) {
            $this->fail('Orientasi gambar gagal dinormalisasi.');
        }

        return $image;
    }

    private function rotate(GdImage $image, int $angle): GdImage
    {
        $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
        $rotatedImage = imagerotate($image, $angle, $transparent === false ? 0 : $transparent);

        if (! $rotatedImage instanceof GdImage) {
            $this->fail('Orientasi gambar gagal dinormalisasi.');
        }

        imagesavealpha($rotatedImage, true);
        imagedestroy($image);

        return $rotatedImage;
    }

    private function encode(GdImage $image): string
    {
        ob_start();

        try {
            $encoded = imagewebp($image, null, self::QUALITY);
            $contents = ob_get_clean();
        } catch (Throwable $exception) {
            ob_end_clean();

            report($exception);
            $this->fail('Gambar gagal dikonversi menjadi WebP.');
        }

        if (
            ! $encoded
            || ! is_string($contents)
            || mb_strlen($contents, '8bit') < 12
            || ! Str::startsWith($contents, 'RIFF')
            || mb_substr($contents, 8, 4, '8bit') !== 'WEBP'
        ) {
            $this->fail('Hasil konversi WebP tidak valid.');
        }

        return $contents;
    }

    private function validateTargetDirectory(string $directory): void
    {
        if (
            ! in_array($directory, self::ALLOWED_DIRECTORIES, true)
            || str_contains($directory, '..')
            || str_contains($directory, '\\')
            || str_contains($directory, "\0")
            || str_starts_with($directory, '/')
        ) {
            $this->fail('Direktori penyimpanan tidak valid.');
        }
    }

    private function store(string $contents, string $directory): string
    {
        $path = $directory.'/'.Str::ulid().'.webp';
        $disk = Storage::disk('public');

        try {
            if (! $disk->put($path, $contents, ['visibility' => 'public'])) {
                $this->fail('Gambar WebP gagal disimpan.');
            }

            if ($disk->mimeType($path) !== 'image/webp') {
                $disk->delete($path);
                $this->fail('Hasil penyimpanan WebP tidak valid.');
            }
        } catch (InvalidUploadedImage $exception) {
            $disk->delete($path);

            throw $exception;
        } catch (Throwable $exception) {
            $disk->delete($path);
            report($exception);

            $this->fail('Gambar WebP gagal disimpan.');
        }

        return $path;
    }

    private function fail(string $message): never
    {
        throw new InvalidUploadedImage($message);
    }
}
