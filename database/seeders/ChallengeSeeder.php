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

        $this->command->info('Criando 10 desafios...');

        // Create 10 challenges, assigning each to a random category
        Challenge::factory(10)->create(function () use ($categories) {
            return ['category_id' => $categories->random()->id];
        });

        $this->command->info('✅ 10 desafios criados com sucesso!');
    }
}