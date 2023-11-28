<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Finca>
 */
class FincaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->text(20),
            'direccion' => $this->faker->address(),
            'dimension' => $this->faker->text(5),
            'nro_finca' => $this->faker->uuid()
        ];
    }
}
