<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'Corrida',
            'Caminhada',
            'Ciclismo',
            'Natação',
            'Trilha',
            'Maratona',
            'Meia Maratona',
            'Treino Funcional',
            'Crossfit',
            'Yoga'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(10),
            'is_active' => $this->faker->boolean(90), // 90% chance de ser ativo
        ];
    }

    /**
     * Estado para categoria ativa
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Estado para categoria inativa
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}