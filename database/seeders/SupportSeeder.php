<?php

namespace Database\Seeders;

use App\Models\Support;
use App\Models\User;
use Illuminate\Database\Seeder;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating 10 Support Tickets...');

        // Ensure we have users
        if (User::count() === 0) {
            User::factory(1)->create();
        }

        // Create exactly 10 tickets distributed among random users
        Support::factory(10)->create([
            'user_id' => fn () => User::inRandomOrder()->first()->id,
        ])->each(function ($support) {
            // Randomly add replies to some tickets
            if (rand(0, 1)) {
                 // 1-3 replies
                \App\Models\SupportReply::factory(rand(1, 3))->create([
                    'support_id' => $support->id,
                    'user_id' => $support->user_id, 
                ]);
            }
        });
    }
}
