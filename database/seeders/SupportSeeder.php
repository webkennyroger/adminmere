<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have a user to attach tickets to, or use factory
        $user = \App\Models\User::first() ?? \App\Models\User::factory()->create();

        \App\Models\Support::factory(10)->create([
            'user_id' => $user->id,
        ])->each(function ($support) {
            // Randomly add replies to some tickets
            if (rand(0, 1)) {
                \App\Models\SupportReply::factory(rand(1, 3))->create([
                    'support_id' => $support->id,
                    'user_id' => $support->user_id, // Simulate user reply
                ]);
                
                // Simulate admin reply using an existing user (mocking admin)
                 \App\Models\SupportReply::factory(rand(1, 2))->create([
                    'support_id' => $support->id,
                    'user_id' => \App\Models\User::inRandomOrder()->first()->id, 
                ]);
            }
        });
    }
}
