<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'description'=> fake()->sentence(),
            'status'=> fake()->randomElement(['PENDING', 'COMPLETED']),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
