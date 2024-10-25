<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Serie;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Schoolyear;
use App\Models\Registration;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer les rôles
        Role::create(['id' => 1, 'wording' => 'admin']);
        Role::create(['id' => 2, 'wording' => 'parent']);
        Role::create(['id' => 3, 'wording' => 'teacher']);
        Role::create(['id' => 4, 'wording' => 'student']);

        // Créer l'admin par défaut
        User::factory()->count(50)->create();
        User::create([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'phone' => '1234567890',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'role_id' => 1,
        ]);


        // Créer des séries, classes et matières
        Serie::factory()->count(5)->create();
        Subject::factory()->count(5)->create();
        Schoolyear::factory()->count(5)->create();
    }
}
