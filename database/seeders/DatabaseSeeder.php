<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Serie;
use App\Models\Classroom;
use App\Models\NoteType;
use App\Models\Subject;
use App\Models\Schoolyear;
use App\Models\Registration;
use App\Models\PaymentType;
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

        // Créer des utilisateurs et associer des rôles aléatoires
        User::factory()->count(20)->create();

       
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
        Serie::factory()->count(1)->create();
        Subject::factory()->count(5)->create();
        Schoolyear::factory()->count(3)->create();
        Classroom::factory()->count(1)->create(); // Ajout de la création de Classroom

        // Créer les types de paiement
        PaymentType::create([
            'wording' => 'Paiement total',
            'is_partial' => false,
        ]);

        PaymentType::create([
            'wording' => 'Paiement par tranche',
            'is_partial' => true,
        ]);
        NoteType::create([
            'wording' => 'Interrogation',
        ]);

        NoteType::create([
            'wording' => 'Devoir',
        ]);
    }
}
