<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PedimentoRT>
 */
class PedimentoRTFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'semana'=>fake()->numberBetween(1,54),
            'patente'=>fake()->numberBetween(1000,9000),
            'noPedimento'=>fake()->text(16),
        ];
    }
}
