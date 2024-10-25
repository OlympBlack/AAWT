<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'wording' => $this->faker->randomElement(['Mathématiques', 'Français', 'Histoire-Géographie', 'Physique-Chimie', 'SVT', 'Anglais', 'Espagnol', 'Philosophie']),
            'coefficient' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'classroom_id' => Classroom::factory(),
        ];
    }
}
