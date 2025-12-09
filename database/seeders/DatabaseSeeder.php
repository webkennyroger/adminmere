<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Generate 10 Users
        User::factory(10)->create();

        // Ensure a specific test user exists
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            CategorySeeder::class,
            ChallengeSeeder::class,
            SupportSeeder::class,
            GoalSeeder::class,
            SubscriptionSeeder::class,
        ]);
    }
}
