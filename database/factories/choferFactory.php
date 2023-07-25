<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class choferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'=>fake()->name(),
            //'apellidoPaterno'=>fake()->lastName(),
            //'apellidoMaterno'=>fake()->lastName(),
            'fechaNacimiento'=>fake()->date(),
            'numCelular'=>fake()->randomNumber(),
            'noLicencia'=>fake()->text(50),
            'noVisa'=>fake()->text(50)
        ];
    }
}
