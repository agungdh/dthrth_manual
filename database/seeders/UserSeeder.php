<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('operator');
        });

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => 'admin',
        ])->assignRole('admin');

        User::factory()->create([
            'name' => 'Operator',
            'username' => 'operator',
            'password' => 'operator',
        ])->assignRole('operator');
    }
}
