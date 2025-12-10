<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have enough users to play with
        if (User::count() < 20) {
            User::factory(20)->create();
        }

        // 3. Set all profiles to 'free' first (baseline)
        \App\Models\Profile::query()->update(['plan' => 'free']);

        // 4. Set 30% of users as subscribers (monthly or annual)
        $users = User::with('profile')->inRandomOrder()->take((int) (User::count() * 0.3))->get();

        foreach ($users as $user) {
            if ($user->profile) {
                $user->profile->update([
                    'plan' => fake()->randomElement(['monthly', 'annual']),
                ]);
            }
        }
    }
}
