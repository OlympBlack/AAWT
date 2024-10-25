<?php

namespace Database\Factories;

use App\Models\Serie;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassroomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'wording' => $this->faker->randomElement(['6ème', '5ème', '4ème', '3ème', '2nde', '1ère', 'Terminale']) ,
            'costs' => $this->faker->numberBetween(50000, 200000),
            'serie_id' => Serie::factory(),
        ];
    }
}
