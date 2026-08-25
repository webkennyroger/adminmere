<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Segment;
use App\Models\SegmentEffort;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SegmentEffort>
 */
class SegmentEffortFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'segment_id' => Segment::factory(),
            'activity_id' => Activity::factory(),
            'user_id' => User::factory(),
            'duration_seconds' => $this->faker->numberBetween(30, 600),
            'achieved_at' => now(),
        ];
    }
}
