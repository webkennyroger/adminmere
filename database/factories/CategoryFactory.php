<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = ucfirst($this->faker->words(2, true));

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::random(5),
            'color' => $this->faker->hexColor(),
        ];
    }
}
