<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Support>
 */
class SupportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['open', 'pending', 'resolved', 'closed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'critical']),
        ];
    }
}
