<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory(10)->create();

        $admin = Admin::factory()->create();
        $admin->user->nama = 'Admin';
        $admin->user->username = 'admin';
        $admin->user->password = 'admin';
        $admin->user->save();
    }
}
