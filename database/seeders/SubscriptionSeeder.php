<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating 10 Subscriptions (Premium Users)...');

        // Create 10 specific users who are subscribers
        for ($i = 1; $i <= 10; $i++) {
            $user = User::firstOrCreate(
                ['email' => "subscriber{$i}@example.com"],
                [
                    'name' => "Assinante {$i}",
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );

            // ...existing code...
            if (! $user->profile) {
                Profile::create([
                    'user_id' => $user->id,
                    'role' => 'user',
                    'plan' => ['monthly', 'annual'][rand(0, 1)],
                    'phone' => '(11) 9'.rand(1000, 9999).'-'.rand(1000, 9999),
                ]);
            } else {
                // Force update to ensuring they are subscribers if they already existed
                $user->profile->update([
                    'plan' => ['monthly', 'annual'][rand(0, 1)],
                ]);
            }
            // ...existing code...
        }
    }
}
