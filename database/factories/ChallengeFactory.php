<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChallengeFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-2 months', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, '+2 months');

        $titles = [
            'Desafio 100km do Mês',
            'Corrida pela Saúde',
            'Desafio de Verão',
            'Meta Fitness Janeiro',
            'Desafio Quilômetros de Ouro',
            'Corrida Solidária',
            'Desafio 50km',
            'Maratona Virtual',
            'Desafio Primavera',
            'Corrida de Inverno',
            'Desafio Meio Ambiente',
            'Super Desafio Fitness',
            'Corrida das Estrelas',
            'Desafio Run for Fun',
            'Meta 150km'
        ];

        return [
            'title' => $this->faker->randomElement($titles) . ' ' . $this->faker->year(),
            'description' => $this->faker->paragraph(3),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'goal_km' => $this->faker->randomFloat(2, 50, 300), // Entre 50km e 300km
            'category_id' => Category::factory(),
            'image' => null, // Pode adicionar imagens fake depois
            'is_active' => $this->faker->boolean(85), // 85% chance de ser ativo
        ];
    }

    /**
     * Desafio com categoria específica
     */
    public function forCategory(Category $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category_id' => $category->id,
        ]);
    }

    /**
     * Desafio ativo
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Desafio inativo
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Desafio de corrida curta (50-100km)
     */
    public function shortDistance(): static
    {
        return $this->state(fn (array $attributes) => [
            'goal_km' => $this->faker->randomFloat(2, 50, 100),
        ]);
    }

    /**
     * Desafio de corrida média (100-200km)
     */
    public function mediumDistance(): static
    {
        return $this->state(fn (array $attributes) => [
            'goal_km' => $this->faker->randomFloat(2, 100, 200),
        ]);
    }

    /**
     * Desafio de corrida longa (200-300km)
     */
    public function longDistance(): static
    {
        return $this->state(fn (array $attributes) => [
            'goal_km' => $this->faker->randomFloat(2, 200, 300),
        ]);
    }

    /**
     * Desafio em andamento (data atual entre início e fim)
     */
    public function ongoing(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(20),
            'is_active' => true,
        ]);
    }

    /**
     * Desafio futuro
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(35),
            'is_active' => true,
        ]);
    }

    /**
     * Desafio finalizado
     */
    public function finished(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->subDays(40),
            'end_date' => now()->subDays(10),
            'is_active' => false,
        ]);
    }
}