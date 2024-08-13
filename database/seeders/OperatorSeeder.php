<?php

namespace Database\Seeders;

use App\Models\Operator;
use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Operator::factory(10)->create();

        $operator = Operator::factory()->create();
        $operator->user->nama = 'Operator';
        $operator->user->username = 'operator';
        $operator->user->password = 'operator';
        $operator->user->save();
    }
}
