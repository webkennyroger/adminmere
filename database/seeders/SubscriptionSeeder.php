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

        // Set all to free first (optional, ensuring baseline)
        User::query()->update(['plan' => 'free']);

        // Set 30% of users as subscribers (various plans)
        $users = User::inRandomOrder()->take((int) (User::count() * 0.3))->get();

        foreach ($users as $user) {
            $user->update([
                'plan' => fake()->randomElement(['premium', 'pro', 'basic']),
            ]);
        }
    }
}
