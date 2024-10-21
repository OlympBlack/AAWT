<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Exécuter le RoleSeeder en premier
        $this->call(RoleSeeder::class);

        // Créer un utilisateur admin
        User::factory()->create([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'role_id' => 1, // ID du rôle admin
            'email' => 'test@example.com',
            'password' => "password123"
        ]);

        // Créer quelques utilisateurs supplémentaires avec des rôles aléatoires
        User::factory(10)->create();
    }
}
