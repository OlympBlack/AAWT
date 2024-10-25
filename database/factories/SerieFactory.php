<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SerieFactory extends Factory
{
    public function definition(): array
    {
        return [
            'wording' => $this->faker->randomElement(['Scientifique', 'Littéraire', 'Économique et Social', 'Technologique']),
        ];
    }
}
