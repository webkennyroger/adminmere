<?php

namespace Database\Seeders;

use App\Models\TrainingPlan;
use Illuminate\Database\Seeder;

class TrainingPlanSeeder extends Seeder
{
    /**
     * Seed a couple of curated training plans so the feature isn't empty on launch.
     */
    public function run(): void
    {
        $this->seedBeginner5k();
        $this->seedIntermediate10k();
    }

    private function seedBeginner5k(): void
    {
        $plan = TrainingPlan::create([
            'title' => '5K para Iniciantes',
            'description' => 'Plano de 4 semanas para quem está começando a correr, intercalando caminhada e corrida até completar 5km continuamente.',
            'sport_type' => 'running',
            'weeks' => 4,
            'level' => 'beginner',
        ]);

        $restDay = fn () => [['type' => 'rest']];

        $weeks = [
            1 => [
                2 => ['title' => 'Caminhada/Corrida Leve', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'duration_s' => 60, 'target_pace_min_km' => 7.0],
                    ['type' => 'rest', 'duration_s' => 90],
                    ['type' => 'work', 'duration_s' => 60, 'target_pace_min_km' => 7.0],
                    ['type' => 'rest', 'duration_s' => 90],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
                4 => ['title' => 'Intervalos Curtos', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'duration_s' => 90, 'target_pace_min_km' => 7.0],
                    ['type' => 'rest', 'duration_s' => 90],
                    ['type' => 'work', 'duration_s' => 90, 'target_pace_min_km' => 7.0],
                    ['type' => 'rest', 'duration_s' => 90],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
                6 => ['title' => 'Corrida Longa Leve', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'distance_m' => 1500, 'target_pace_min_km' => 7.5],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
            ],
            2 => [
                2 => ['title' => 'Intervalos Progressivos', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'duration_s' => 180, 'target_pace_min_km' => 6.8],
                    ['type' => 'rest', 'duration_s' => 90],
                    ['type' => 'work', 'duration_s' => 180, 'target_pace_min_km' => 6.8],
                    ['type' => 'rest', 'duration_s' => 90],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
                4 => ['title' => 'Corrida Contínua Curta', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'distance_m' => 2000, 'target_pace_min_km' => 7.0],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
                6 => ['title' => 'Corrida Longa', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'distance_m' => 2500, 'target_pace_min_km' => 7.5],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
            ],
            3 => [
                2 => ['title' => 'Tiros Médios', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'distance_m' => 800, 'target_pace_min_km' => 6.5],
                    ['type' => 'rest', 'duration_s' => 120],
                    ['type' => 'work', 'distance_m' => 800, 'target_pace_min_km' => 6.5],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
                4 => ['title' => 'Corrida Contínua', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'distance_m' => 3500, 'target_pace_min_km' => 7.0],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
                6 => ['title' => 'Corrida Longa', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'distance_m' => 4000, 'target_pace_min_km' => 7.5],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
            ],
            4 => [
                2 => ['title' => 'Ativação', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'distance_m' => 2000, 'target_pace_min_km' => 6.8],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
                4 => ['title' => 'Corrida Contínua', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'distance_m' => 4000, 'target_pace_min_km' => 7.0],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
                6 => ['title' => '5K Final', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'distance_m' => 5000, 'target_pace_min_km' => 7.0],
                    ['type' => 'cooldown', 'duration_s' => 180],
                ]],
            ],
        ];

        foreach ($weeks as $weekNumber => $days) {
            for ($day = 1; $day <= 7; $day++) {
                $plan->workouts()->create([
                    'week_number' => $weekNumber,
                    'day_number' => $day,
                    'title' => $days[$day]['title'] ?? 'Descanso',
                    'steps' => $days[$day]['steps'] ?? $restDay(),
                ]);
            }
        }
    }

    private function seedIntermediate10k(): void
    {
        $plan = TrainingPlan::create([
            'title' => '10K Intermediário',
            'description' => 'Plano de 6 semanas para corredores que já completam 5km e querem evoluir para 10km com mais ritmo.',
            'sport_type' => 'running',
            'weeks' => 6,
            'level' => 'intermediate',
        ]);

        for ($week = 1; $week <= 6; $week++) {
            $longRunDistance = 4000 + ($week * 800); // progride de 4.8km a 8.8km
            $tempoDistance = 3000 + ($week * 300);

            $days = [
                2 => ['title' => 'Tiros de Velocidade', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 480],
                    ['type' => 'work', 'distance_m' => 400, 'target_pace_min_km' => 5.5],
                    ['type' => 'rest', 'duration_s' => 90],
                    ['type' => 'work', 'distance_m' => 400, 'target_pace_min_km' => 5.5],
                    ['type' => 'rest', 'duration_s' => 90],
                    ['type' => 'work', 'distance_m' => 400, 'target_pace_min_km' => 5.5],
                    ['type' => 'cooldown', 'duration_s' => 480],
                ]],
                4 => ['title' => 'Corrida de Ritmo (Tempo Run)', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 480],
                    ['type' => 'work', 'distance_m' => $tempoDistance, 'target_pace_min_km' => 6.0],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
                6 => ['title' => 'Corrida Longa', 'steps' => [
                    ['type' => 'warmup', 'duration_s' => 300],
                    ['type' => 'work', 'distance_m' => $longRunDistance, 'target_pace_min_km' => 6.8],
                    ['type' => 'cooldown', 'duration_s' => 300],
                ]],
            ];

            for ($day = 1; $day <= 7; $day++) {
                $plan->workouts()->create([
                    'week_number' => $week,
                    'day_number' => $day,
                    'title' => $days[$day]['title'] ?? 'Descanso',
                    'steps' => $days[$day]['steps'] ?? [['type' => 'rest']],
                ]);
            }
        }
    }
}
