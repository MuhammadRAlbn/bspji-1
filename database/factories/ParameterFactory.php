<?php

namespace Database\Factories;

use App\Models\Komoditi;
use App\Models\Lab;
use App\Models\Parameter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Parameter>
 */
class ParameterFactory extends Factory
{
    protected $model = Parameter::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->words(2, true),
            'metode_uji' => fake()->optional()->word(),
            'satuan' => fake()->randomElement(['mg/L', 'pH', '%', 'NTU', 'mg/kg']),
            'baku_mutu' => fake()->optional()->word(),
            'lab_id' => Lab::factory(),
            'komoditi_id' => Komoditi::factory(),
            'harga' => fake()->numberBetween(50000, 500000),
        ];
    }
}
