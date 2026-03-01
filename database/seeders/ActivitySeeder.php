<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run()
    {
        // Ensure we have some users
        $users = User::all();
        if ($users->count() < 3) {
            $users = User::factory(5)->create();
        }

        $mainUser = $users->first();
        $friend1 = $users->get(1);
        $friend2 = $users->get(2);

        // 1. Activity: Simple Run (Text only)
        $activity1 = Activity::create([
            'user_id' => $mainUser->id,
            'app_id' => 'uuid-demo-1',
            'title' => 'Corrida matinal',
            'sport_type' => 'run',
            'start_time' => Carbon::now()->subDays(1)->setHour(7),
            'distance' => 5000, // 5km
            'duration' => 1800, // 30min
            'calories' => 350,
            'description' => 'Corrida leve para começar o dia.',
            'privacy' => 'public',
        ]);

        // Add likes/comments
        $activity1->likes()->create(['user_id' => $friend1->id]);
        $activity1->comments()->create(['user_id' => $friend1->id, 'body' => 'Boa, continue assim!']);

        // 2. Activity: With Photos (Multiple)
        $activity2 = Activity::create([
            'user_id' => $mainUser->id,
            'app_id' => 'uuid-demo-2',
            'title' => 'Trilha no Parque',
            'sport_type' => 'hike',
            'start_time' => Carbon::now()->subDays(2)->setHour(16),
            'distance' => 8500, // 8.5km
            'duration' => 7200, // 2h
            'calories' => 600,
            'description' => 'Visual incrível hoje!',
            'privacy' => 'public',
            'media' => [
                'https://images.unsplash.com/photo-1551632811-561732d1e306?w=800&auto=format&fit=crop&q=60', // Mountain
                'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=800&auto=format&fit=crop&q=60', // Path
            ],
        ]);

        $activity2->likes()->createMany([
            ['user_id' => $friend1->id],
            ['user_id' => $friend2->id],
        ]);

        // 3. Activity: With Video and Photo
        $activity3 = Activity::create([
            'user_id' => $mainUser->id,
            'app_id' => 'uuid-demo-3',
            'title' => 'Treino de Velocidade',
            'sport_type' => 'run',
            'start_time' => Carbon::now()->subDays(3)->setHour(18),
            'distance' => 10000, // 10km
            'duration' => 3000, // 50min
            'calories' => 800,
            'description' => 'Tiros de 1km.',
            'privacy' => 'public',
            'media' => [
                'https://videos.pexels.com/video-files/2795383/2795383-sd_640_360_25fps.mp4',
                'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=800&auto=format&fit=crop&q=60', // Runner
            ],
        ]);

        // 4. Activity: With Tagged Users (With Friends)
        $activity4 = Activity::create([
            'user_id' => $mainUser->id,
            'app_id' => 'uuid-demo-4',
            'title' => 'Longão de Domingo',
            'sport_type' => 'run',
            'start_time' => Carbon::now()->previous('Sunday')->setHour(6),
            'distance' => 21000, // 21km
            'duration' => 7800, // 2h 10m
            'calories' => 1500,
            'description' => 'Meia maratona com a galera!',
            'privacy' => 'public',
            'tagged_users' => [
                ['id' => $friend1->id, 'name' => $friend1->name, 'avatar' => $friend1->avatar],
                ['id' => $friend2->id, 'name' => $friend2->name, 'avatar' => $friend2->avatar],
            ],
            'media' => [
                'https://images.unsplash.com/photo-1552674605-4694559e5bc7?w=800&auto=format&fit=crop&q=60', // Group running
            ],
        ]);

        $activity4->comments()->create(['user_id' => $friend2->id, 'body' => 'Foi pesado mas valeu a pena!']);

        // 5. Create many random activities - DISABLED FOR PRODUCTION
        // Activity::factory()->count(20)->create([...]);
        // Activity::factory()->count(20)->create([...]);
    }
}
