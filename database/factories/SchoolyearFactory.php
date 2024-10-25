<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolyearFactory extends Factory
{
    public function definition(): array
    {
        $year = $this->faker->year();
        return [
            'wording' => $year . '-' . ($year + 1),
        ];
    }
}
