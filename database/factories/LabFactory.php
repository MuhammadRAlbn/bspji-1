<?php

namespace Database\Factories;

use App\Models\Lab;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lab>
 */
class LabFactory extends Factory
{
    protected $model = Lab::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->randomElement(Lab::NAMES),
        ];
    }
}
