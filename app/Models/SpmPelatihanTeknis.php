<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SpmPelatihanTeknis extends Model
{
    protected $table = 'spm_pelatihan_tekniss';

    protected $fillable = [
        'image_path',
    ];

    public static function isManagedImagePath(?string $path): bool
    {
        return is_string($path)
            && preg_match('/\Apelatihan-teknis\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/', $path) === 1;
    }

    protected static function booted(): void
    {
        static::updated(function (self $spmPelatihanTeknis): void {
            if (! $spmPelatihanTeknis->wasChanged('image_path')) {
                return;
            }

            static::deleteManagedImage($spmPelatihanTeknis->getRawOriginal('image_path'));
        });

        static::deleted(function (self $spmPelatihanTeknis): void {
            static::deleteManagedImage($spmPelatihanTeknis->image_path);
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
