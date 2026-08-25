<?php

namespace Database\Factories;

use App\Models\Segment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Segment>
 */
class SegmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startLat = $this->faker->latitude(-23.6, -23.5);
        $startLng = $this->faker->longitude(-46.7, -46.6);

        return [
            'name' => $this->faker->streetName(),
            'sport_type' => 'running',
            'start_lat' => $startLat,
            'start_lng' => $startLng,
            'end_lat' => $startLat + 0.005,
            'end_lng' => $startLng + 0.005,
            'radius_m' => 40,
            'created_by' => User::factory(),
        ];
    }
}
