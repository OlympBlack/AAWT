<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['id' => 1, 'wording' => 'admin']);
        Role::create(['id' => 2, 'wording' => 'parent']);
        Role::create(['id' => 3, 'wording' => 'teacher']);
        Role::create(['id' => 4, 'wording' => 'student']);
    }
}
