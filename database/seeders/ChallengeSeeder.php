<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\User;
use App\Notifications\ChallengeCreated;
use Illuminate\Database\Seeder;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure Categories exist
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        $this->command->info('Creating 10 Challenges...');

        $admin = User::where('email', 'webkennyroger@gmail.com')->first();
        $categories = Category::all();

        // 1. Fixed Data (6 items)
        $challengeData = [
            [
                'title' => 'Desafio 30 Dias de Corrida',
                'description' => 'Corra pelo menos 5km por dia durante 30 dias consecutivos',
                'category_slug' => 'corrida',
                'goal_km' => 150.00,
            ],
            [
                'title' => 'Maratona de Caminhada',
                'description' => 'Complete 10.000 passos por dia durante 21 dias',
                'category_slug' => 'caminhada',
                'goal_km' => 100.00,
            ],
            [
                'title' => 'Ciclismo Extremo',
                'description' => 'Percorra 100km de bicicleta em uma semana',
                'category_slug' => 'ciclismo',
                'goal_km' => 100.00,
            ],
            [
                'title' => 'Natação Diária',
                'description' => 'Nade 1km por dia durante 15 dias',
                'category_slug' => 'natacao',
                'goal_km' => 15.00,
            ],
            [
                'title' => 'Yoga Matinal',
                'description' => 'Pratique 30 minutos de yoga todas as manhãs por 30 dias',
                'category_slug' => 'yoga',
                'goal_km' => 0.00,
            ],
            [
                'title' => 'Força Total',
                'description' => 'Complete 20 treinos de musculação em 30 dias',
                'category_slug' => 'musculacao',
                'goal_km' => 0.00,
            ],
        ];

        foreach ($challengeData as $data) {
            $category = Category::where('slug', $data['category_slug'])->first() ?? $categories->random();

            $challenge = Challenge::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'category_id' => $category->id,
                'goal_km' => $data['goal_km'],
                'start_date' => now(),
                'end_date' => now()->addDays(30),
            ]);

            if ($admin) {
                $admin->notify(new ChallengeCreated($challenge));
            }
        }

        // 2. Random Data (4 items) to reach 10 - DISABLED FOR PRODUCTION
        $needed = 10 - count($challengeData);
        // if ($needed > 0) {
        //     Challenge::factory($needed)->create([...]);
        // }

        $this->command->info('✅ 10 Challenges created and notifications synced!');
    }
}
