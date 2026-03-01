<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        $sportTypes = ['run', 'bike', 'hike', 'walk', 'swim'];
        $sportType = $this->faker->randomElement($sportTypes);

        // Distance varies by sport type
        $distance = match ($sportType) {
            'run' => $this->faker->numberBetween(3000, 21000), // 3-21km
            'bike' => $this->faker->numberBetween(10000, 100000), // 10-100km
            'hike' => $this->faker->numberBetween(5000, 20000), // 5-20km
            'walk' => $this->faker->numberBetween(2000, 10000), // 2-10km
            'swim' => $this->faker->numberBetween(500, 5000), // 0.5-5km
            default => $this->faker->numberBetween(3000, 15000),
        };

        // Duration based on distance and average pace
        $duration = (int) ($distance / 1000 * $this->faker->numberBetween(300, 600)); // 5-10 min/km

        // Calories based on distance
        $calories = (int) ($distance / 1000 * $this->faker->numberBetween(60, 100));

        $mediaOptions = [
            null, // No media
            ['https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=800&auto=format&fit=crop&q=60'], // Single image
            [
                'https://images.unsplash.com/photo-1552674605-4694559e5bc7?w=800&auto=format&fit=crop&q=60',
                'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?w=800&auto=format&fit=crop&q=60',
            ], // Two images
            [
                'https://images.unsplash.com/photo-1551632811-561732d1e306?w=800&auto=format&fit=crop&q=60',
                'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=800&auto=format&fit=crop&q=60',
                'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&auto=format&fit=crop&q=60',
            ], // Three images
        ];

        return [
            'user_id' => User::factory(),
            'app_id' => $this->faker->uuid(),
            'title' => $this->faker->randomElement([
                'Corrida matinal',
                'Treino de velocidade',
                'Longão de domingo',
                'Corrida leve',
                'Treino intervalado',
                'Corrida na praia',
                'Trilha no parque',
                'Pedal da tarde',
                'Caminhada relaxante',
            ]),
            'sport_type' => $sportType,
            'start_time' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'distance' => $distance,
            'duration' => $duration,
            'calories' => $calories,
            'polylines' => null, // Can be added later if needed
            'privacy' => $this->faker->randomElement(['public', 'friends', 'private']),
            'description' => $this->faker->optional(0.7)->sentence(),
            'mood' => $this->faker->optional()->numberBetween(1, 5),
            'media' => $this->faker->randomElement($mediaOptions),
            'tagged_users' => null,
        ];
    }
}
