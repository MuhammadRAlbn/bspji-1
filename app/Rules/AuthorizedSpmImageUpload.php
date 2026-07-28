<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class AuthorizedSpmImageUpload implements ValidationRule
{
    public function __construct(private readonly ?string $originalPath) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value instanceof TemporaryUploadedFile) {
            return;
        }

        if (
            is_string($value)
            && is_string($this->originalPath)
            && hash_equals($this->originalPath, $value)
        ) {
            return;
        }

        $fail('Berkas gambar SPM yang dipilih tidak valid.');
    }
}
