<?php

namespace Database\Factories;

use App\Models\TrainingPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrainingPlan>
 */
class TrainingPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'sport_type' => 'running',
            'weeks' => $this->faker->numberBetween(4, 8),
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
        ];
    }
}
