<?php

namespace Database\Seeders;

use App\Models\Goal;
use Illuminate\Database\Seeder;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating 10 Goals...');

        $goals = [
            [
                'title' => 'Meta de Usuários',
                'metric' => 'users',
                'target_value' => 100,
                'period' => 'monthly',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth(),
            ],
            [
                'title' => 'Meta de Vendas',
                'metric' => 'sales',
                'target_value' => 50,
                'period' => 'monthly',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth(),
            ],
            [
                'title' => 'Meta de Receita',
                'metric' => 'revenue',
                'target_value' => 10000,
                'period' => 'monthly',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth(),
            ],
        ];

        foreach ($goals as $goal) {
            Goal::create($goal);
        }

        // Generate 7 more to reach 10
        // Generate 7 more to reach 10 - REMOVED FOR PRODUCTION
        $needed = 10 - count($goals);
        // Factories disabled in production without dev deps
        // if ($needed > 0) {
        //     Goal::factory($needed)->create();
        // }
    }
}
