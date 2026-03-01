<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating 10 Schedule Events...');

        // Ensure user exists for scheduling (assuming schedules might belong to users, though basic factory might not require it based on previous view)
        // Schedule::factory()->count(10)->create();

        // Manual creation for production safety
        $user = User::first();
        if ($user) {
            Schedule::create([
                'user_id' => $user->id,
                'title' => 'Treino Matinal',
                'description' => 'Corrida leve no parque',
                'event_date' => now()->addDays(1),
                'event_time' => '07:00:00',
                'color' => 'Primary',
            ]);
        }
    }
}
