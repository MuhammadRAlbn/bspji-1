<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SpmLsih extends Model
{
    protected $fillable = [
        'image_path',
    ];

    public static function isManagedImagePath(?string $path): bool
    {
        return is_string($path)
            && preg_match('/\Alsih\/spm\/[0-9A-HJKMNP-TV-Z]{26}\.webp\z/', $path) === 1;
    }

    protected static function booted(): void
    {
        static::updated(function (self $spmLsih): void {
            if (! $spmLsih->wasChanged('image_path')) {
                return;
            }

            static::deleteManagedImage($spmLsih->getRawOriginal('image_path'));
        });

        static::deleted(function (self $spmLsih): void {
            static::deleteManagedImage($spmLsih->image_path);
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
