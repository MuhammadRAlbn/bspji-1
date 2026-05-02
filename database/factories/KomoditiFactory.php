<?php

namespace Database\Factories;

use App\Models\Komoditi;
use App\Models\Lab;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Komoditi>
 */
class KomoditiFactory extends Factory
{
    protected $model = Komoditi::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->words(3, true),
            'peraturan' => fake()->optional()->sentence(),
            'lab_id' => Lab::factory(),
            'keterangan' => fake()->optional()->sentence(),
        ];
    }
}
