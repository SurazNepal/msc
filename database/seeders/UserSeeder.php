<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test Employee',
            'email' => 'employee@gmail.com',
        ])->assignRole(RolesEnum::Employee->value);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ])->assignRole(RolesEnum::Admin->value);
    }
}
