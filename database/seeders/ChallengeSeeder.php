<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Challenge;
use Illuminate\Database\Seeder;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        // Verifica se existem categorias
        if (Category::count() === 0) {
            $this->command->warn('⚠️  Nenhuma categoria encontrada. Criando categorias primeiro...');
            $this->call(CategorySeeder::class);
        }

        $categories = Category::all();

        // Criar desafios em andamento
        $this->command->info('Criando desafios em andamento...');
        foreach ($categories->take(4) as $category) {
            Challenge::factory()
                ->forCategory($category)
                ->ongoing()
                ->create();
        }

        // Criar desafios futuros
        $this->command->info('Criando desafios futuros...');
        Challenge::factory()
            ->count(5)
            ->upcoming()
            ->create();

        // Criar desafios finalizados
        $this->command->info('Criando desafios finalizados...');
        Challenge::factory()
            ->count(3)
            ->finished()
            ->create();

        // Criar desafios variados (curta, média e longa distância)
        $this->command->info('Criando desafios de diferentes distâncias...');
        Challenge::factory()->count(3)->shortDistance()->create();
        Challenge::factory()->count(3)->mediumDistance()->create();
        Challenge::factory()->count(2)->longDistance()->create();

        // Criar alguns desafios inativos
        $this->command->info('Criando desafios inativos...');
        Challenge::factory()->count(2)->inactive()->create();

        $totalChallenges = Challenge::count();
        $this->command->info("✅ Total de {$totalChallenges} desafios criados com sucesso!");
    }
}