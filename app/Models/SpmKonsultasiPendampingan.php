<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SpmKonsultasiPendampingan extends Model
{
    protected $table = 'spm_konsultasi_pendampingans';

    protected $fillable = [
        'image_path',
    ];

    public static function isManagedImagePath(?string $path): bool
    {
        return is_string($path)
            && preg_match('/\Akonsultasi-pendampingan\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/', $path) === 1;
    }

    protected static function booted(): void
    {
        static::updated(function (self $spmKonsultasiPendampingan): void {
            if (! $spmKonsultasiPendampingan->wasChanged('image_path')) {
                return;
            }

            static::deleteManagedImage($spmKonsultasiPendampingan->getRawOriginal('image_path'));
        });

        static::deleted(function (self $spmKonsultasiPendampingan): void {
            static::deleteManagedImage($spmKonsultasiPendampingan->image_path);
        });
    }

    private static function deleteManagedImage(?string $path): void
    {
        if (! static::isManagedImagePath($path)) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
