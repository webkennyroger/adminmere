<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\Club;
use App\Models\Message;
use App\Models\Post;
use App\Models\Segment;
use App\Models\SegmentEffort;
use App\Models\TrainingPlan;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Populates the parts of the app that a real day-to-day user would touch but
 * that the other seeders leave empty: club memberships, challenge/training
 * plan enrollments with real progress, a few posts, DM threads, and a couple
 * of segments with efforts so the leaderboard isn't empty.
 */
class DemoUsageSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('email', '!=', 'webkennyroger@gmail.com')->inRandomOrder()->get();

        if ($users->count() < 5) {
            $this->command->warn('Not enough users to seed demo usage data — skipping.');

            return;
        }

        $this->seedClubs($users);
        $this->seedChallengeEnrollments($users);
        $this->seedTrainingPlanEnrollment($users);
        $this->seedPosts($users);
        $this->seedMessages($users);
        $this->seedSegments($users);
    }

    private function seedClubs($users): void
    {
        $clubs = [
            ['name' => 'Corredores da Cidade', 'category' => 'running', 'description' => 'Grupo de corrida para quem ama a rua e a rotina.'],
            ['name' => 'Trail Runners', 'category' => 'trail', 'description' => 'Trilhas, montanhas e muita aventura.'],
            ['name' => 'Pedal em Grupo', 'category' => 'cycling', 'description' => 'Saídas de bike toda semana, todo nível.'],
            ['name' => 'Caminhada e Bem-Estar', 'category' => 'walking', 'description' => 'Caminhadas leves com foco em saúde e conversa.'],
        ];

        foreach ($clubs as $index => $data) {
            $creator = $users[$index % $users->count()];

            $club = Club::create([
                ...$data,
                'city' => 'São Paulo',
                'state' => 'SP',
                'is_public' => true,
                'creator_id' => $creator->id,
                'creator_name' => $creator->name,
            ]);

            $club->members()->attach($creator->id, ['role' => 'creator']);

            $members = $users->where('id', '!=', $creator->id)->random(min(6, $users->count() - 1));
            foreach ($members as $member) {
                $club->members()->syncWithoutDetaching([$member->id => ['role' => 'member']]);
            }

            $club->update(['members_count' => $club->members()->count()]);
        }

        $this->command->info('Clubs seeded: '.count($clubs));
    }

    private function seedChallengeEnrollments($users): void
    {
        $challenges = Challenge::all();
        if ($challenges->isEmpty()) {
            return;
        }

        $enrollments = 0;
        foreach ($challenges as $challenge) {
            $participants = $users->random(min(8, $users->count()));
            foreach ($participants as $user) {
                $progress = fake()->randomFloat(2, 0, (float) $challenge->goal_km);
                $status = $progress >= $challenge->goal_km ? 'completed' : 'joined';

                $challenge->users()->syncWithoutDetaching([
                    $user->id => ['progress' => $progress, 'status' => $status],
                ]);
                $enrollments++;
            }
        }

        $this->command->info("Challenge enrollments seeded: {$enrollments}");
    }

    private function seedTrainingPlanEnrollment($users): void
    {
        $plans = TrainingPlan::all();
        if ($plans->isEmpty()) {
            return;
        }

        $enrollments = 0;
        foreach ($plans as $index => $plan) {
            $participants = $users->random(min(4, $users->count()));
            foreach ($participants as $i => $user) {
                // Alguns bem no início, outros na metade, um já concluído.
                $currentWeek = min($plan->weeks, max(1, intdiv($i + 1, 2) + 1));
                $currentDay = fake()->numberBetween(1, 7);
                $status = $currentWeek >= $plan->weeks && $i === 0 ? 'completed' : 'active';

                $plan->users()->syncWithoutDetaching([
                    $user->id => [
                        'started_at' => now()->subWeeks($currentWeek),
                        'current_week' => $currentWeek,
                        'current_day' => $currentDay,
                        'status' => $status,
                    ],
                ]);
                $enrollments++;
            }
        }

        $this->command->info("Training plan enrollments seeded: {$enrollments}");
    }

    private function seedPosts($users): void
    {
        $captions = [
            'Fechei meu treino de hoje! 💪',
            'Alguém topa uma corrida no fim de semana?',
            'Nova meta batida esse mês 🎉',
            'Dica de hidratação para os dias mais quentes.',
            'Que treino difícil hoje, mas valeu a pena!',
        ];

        foreach ($captions as $index => $content) {
            Post::create([
                'user_id' => $users[$index % $users->count()]->id,
                'content' => $content,
                'type' => 'post',
                'privacy' => 'public',
                'feed_type' => 'personal',
                'media' => [],
                'meta' => [],
            ]);
        }

        $this->command->info('Posts seeded: '.count($captions));
    }

    private function seedMessages($users): void
    {
        $pairs = 0;
        for ($i = 0; $i < 4 && $i + 1 < $users->count(); $i += 2) {
            $sender = $users[$i];
            $receiver = $users[$i + 1];

            Message::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'content' => 'Bora treinar junto essa semana?',
                'read_at' => null,
            ]);
            Message::create([
                'sender_id' => $receiver->id,
                'receiver_id' => $sender->id,
                'content' => 'Bora! Que dia fica melhor pra você?',
                'read_at' => now(),
            ]);
            $pairs++;
        }

        $this->command->info("Message threads seeded: {$pairs}");
    }

    private function seedSegments($users): void
    {
        $segment = Segment::create([
            'name' => 'Volta do Parque Ibirapuera',
            'sport_type' => 'run',
            'start_lat' => -23.5874,
            'start_lng' => -46.6576,
            'end_lat' => -23.5877,
            'end_lng' => -46.6633,
            'radius_m' => 40,
            'created_by' => $users->first()->id,
        ]);

        $participants = $users->random(min(6, $users->count()));
        foreach ($participants as $user) {
            $activity = $user->activities()->inRandomOrder()->first()
                ?? $user->activities()->create([
                    'title' => 'Corrida no parque',
                    'sport_type' => 'run',
                    'start_time' => now()->subDays(fake()->numberBetween(1, 30)),
                    'distance' => 5000,
                    'duration' => 1800,
                    'calories' => 400,
                    'privacy' => 'public',
                    'feed_type' => 'personal',
                ]);

            SegmentEffort::updateOrCreate(
                ['segment_id' => $segment->id, 'activity_id' => $activity->id],
                [
                    'user_id' => $user->id,
                    'duration_seconds' => fake()->numberBetween(240, 420),
                    'achieved_at' => $activity->start_time ?? now(),
                ]
            );
        }

        $this->command->info('Segments seeded: 1 (with '.$participants->count().' efforts)');
    }
}
