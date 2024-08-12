<?php

namespace Database\Factories;

use App\Models\Skpd;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OperatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $user->assignRole('operator');

        return [
            'user_id' => $user->id,
            'skpd_id' => Skpd::inRandomOrder()->first()->id,
        ];
    }
}
