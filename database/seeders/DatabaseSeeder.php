<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Challenge;
use App\Models\Goal;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');

        // Create or get Admin User (Premium - Annual)
        $admin = User::firstOrCreate(
            ['email' => 'webkennyroger@gmail.com'],
            [
                'name' => 'Kenny Roger',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
            ]
        );

        if (!$admin->profile) {
            Profile::create([
                'user_id' => $admin->id,
                'role' => 'admin',
                'plan' => 'annual',
                'phone' => '(11) 98765-4321',

            ]);
        }

        // Create Free Users
        for ($i = 1; $i <= 5; $i++) {
            $user = User::firstOrCreate(
                ['email' => "usuario{$i}@example.com"],
                [
                    'name' => "Usuário Gratuito {$i}",
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );

            if (!$user->profile) {
                Profile::create([
                    'user_id' => $user->id,
                    'role' => 'user',
                    'plan' => 'free', // Free user
                    'phone' => "(11) 9" . rand(1000, 9999) . "-" . rand(1000, 9999),

                ]);
            }
        }

        // Create Premium Users (Monthly)
        for ($i = 1; $i <= 3; $i++) {
            $user = User::firstOrCreate(
                ['email' => "premium{$i}@example.com"],
                [
                    'name' => "Usuário Premium {$i}",
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );

            if (!$user->profile) {
                Profile::create([
                    'user_id' => $user->id,
                    'role' => 'user',
                    'plan' => 'monthly',
                    'phone' => "(11) 9" . rand(1000, 9999) . "-" . rand(1000, 9999),

                ]);
            }
        }

        // Create Premium Users (Annual)
        for ($i = 1; $i <= 2; $i++) {
            $user = User::firstOrCreate(
                ['email' => "anual{$i}@example.com"],
                [
                    'name' => "Usuário Anual {$i}",
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );

            if (!$user->profile) {
                Profile::create([
                    'user_id' => $user->id,
                    'role' => 'user',
                    'plan' => 'annual',
                    'phone' => "(11) 9" . rand(1000, 9999) . "-" . rand(1000, 9999),

                ]);
            }
        }

        // Create Categories
        $categories = [
            ['name' => 'Corrida', 'color' => 'red'],
            ['name' => 'Caminhada', 'color' => 'green'],
            ['name' => 'Ciclismo', 'color' => 'blue'],
            ['name' => 'Natação', 'color' => 'cyan'],
            ['name' => 'Yoga', 'color' => 'purple'],
            ['name' => 'Musculação', 'color' => 'orange'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'color' => $cat['color'],
                ]
            );
        }

        // Create Challenges
        $challengeData = [
            [
                'title' => 'Desafio 30 Dias de Corrida',
                'description' => 'Corra pelo menos 5km por dia durante 30 dias consecutivos',
                'category_id' => 1,
                'points' => 500,
            ],
            [
                'title' => 'Maratona de Caminhada',
                'description' => 'Complete 10.000 passos por dia durante 21 dias',
                'category_id' => 2,
                'points' => 300,
            ],
            [
                'title' => 'Ciclismo Extremo',
                'description' => 'Percorra 100km de bicicleta em uma semana',
                'category_id' => 3,
                'points' => 800,
            ],
            [
                'title' => 'Natação Diária',
                'description' => 'Nade 1km por dia durante 15 dias',
                'category_id' => 4,
                'points' => 450,
            ],
            [
                'title' => 'Yoga Matinal',
                'description' => 'Pratique 30 minutos de yoga todas as manhãs por 30 dias',
                'category_id' => 5,
                'points' => 350,
            ],
            [
                'title' => 'Força Total',
                'description' => 'Complete 20 treinos de musculação em 30 dias',
                'category_id' => 6,
                'points' => 700,
            ],
        ];

        foreach ($challengeData as $challenge) {
            Challenge::create([
                'title' => $challenge['title'],
                'description' => $challenge['description'],
                'category_id' => $challenge['category_id'],
                'points' => $challenge['points'],
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'is_active' => true,
            ]);
        }

        // Create Goals
        $goals = [
            [
                'name' => 'Meta de Usuários',
                'metric' => 'users',
                'target_value' => 100,
                'current_value' => User::count(),
                'period' => 'monthly',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth(),
            ],
            [
                'name' => 'Meta de Vendas',
                'metric' => 'sales',
                'target_value' => 50,
                'current_value' => 5,
                'period' => 'monthly',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth(),
            ],
            [
                'name' => 'Meta de Receita',
                'metric' => 'revenue',
                'target_value' => 10000,
                'current_value' => 2500,
                'period' => 'monthly',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth(),
            ],
        ];

        foreach ($goals as $goal) {
            Goal::create($goal);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: webkennyroger@gmail.com / password');
        $this->command->info('Free Users: usuario1@example.com to usuario5@example.com / password');
        $this->command->info('Premium Users: premium1@example.com to premium3@example.com / password');
        $this->command->info('Annual Users: anual1@example.com to anual2@example.com / password');
    }
}
