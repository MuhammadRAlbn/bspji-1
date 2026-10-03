<?php

namespace App\Exceptions;

use Illuminate\Contracts\Debug\ShouldntReport;
use RuntimeException;

class PasswordChangeThrottled extends RuntimeException implements ShouldntReport
{
    public function __construct(public readonly int $seconds)
    {
        parent::__construct('Terlalu banyak percobaan penggantian password.');
    }
}
