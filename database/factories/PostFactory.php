<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->optional()->sentence(),
            'content' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(['post', 'poll']),
            'privacy' => 'public',
            'feed_type' => 'personal',
            'media' => [],
            'meta' => [],
        ];
    }
}
