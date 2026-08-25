<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Club>
 */
class ClubFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true).' Run Club',
            'description' => $this->faker->sentence(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),
            'category' => $this->faker->randomElement(['running', 'cycling', 'trail', 'walking']),
            'is_public' => true,
            'creator_id' => User::factory(),
            'creator_name' => $this->faker->name(),
            'members_count' => 0,
            'followers_count' => 0,
        ];
    }
}
