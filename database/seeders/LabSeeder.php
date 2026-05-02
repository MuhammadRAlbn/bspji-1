<?php

namespace Database\Seeders;

use App\Models\Lab;
use Illuminate\Database\Seeder;

class LabSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Lab::NAMES as $nama) {
            Lab::query()->firstOrCreate(['nama' => $nama]);
        }
    }
}
