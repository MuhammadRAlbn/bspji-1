<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class PasswordWithinHashLimit implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || Hash::getDefaultDriver() !== 'bcrypt') {
            return;
        }

        if (strlen($value) > 72) {
            $fail('Password maksimal 72 byte untuk bcrypt; karakter seperti emoji dapat memakai lebih dari satu byte.');
        }

        if (str_contains($value, "\0")) {
            $fail('Password tidak boleh mengandung karakter null.');
        }
    }
}
