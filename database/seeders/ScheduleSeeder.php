<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\User;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating 10 Schedule Events...');
        
        // Ensure user exists for scheduling (assuming schedules might belong to users, though basic factory might not require it based on previous view)
        // Checking previous file content: Schedule::factory()->count(20)->create();
        // Just changing count to 10.

        Schedule::factory()->count(10)->create();
    }
}
