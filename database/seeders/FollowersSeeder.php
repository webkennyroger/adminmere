<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersSeeder extends Seeder
{
    public function run()
    {
        // 1. Get the Main Admin User
        $admin = User::where('email', 'webkennyroger@gmail.com')->first();

        if (! $admin) {
            $admin = User::first(); // Fallback if explicit admin not found
        }

        if (! $admin) {
            return;
        } // Safety check

        // 2. Get all other users (excluding admin)
        $allUsers = User::where('id', '!=', $admin->id)->get();

        // 3. Make Admin follow EVERYONE (so feed becomes full)
        $admin->following()->syncWithoutDetaching($allUsers->pluck('id'));

        // 4. Make everyone follow Admin (so everyone sees Admin's posts)
        foreach ($allUsers as $user) {
            $user->following()->syncWithoutDetaching([$admin->id]);
        }

        // 5. Create some mutual follows among random users (for network simulation)
        // Group 1 follows Group 2
        $group1 = $allUsers->take(5);
        $group2 = $allUsers->skip(5)->take(5);

        foreach ($group1 as $u1) {
            foreach ($group2 as $u2) {
                $u1->following()->syncWithoutDetaching($u2->id);
                $u2->following()->syncWithoutDetaching($u1->id);
            }
        }
    }
}
