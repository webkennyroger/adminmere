<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ChatTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $me = User::first();
        if (! $me) {
            $me = User::factory()->create(['name' => 'Me', 'email' => 'me@example.com']);
        }

        $fakeUsers = [
            'Jenny Wilson' => 'Hey there! How\'s your day going?',
            'Cameron Williamson' => 'Enjoy the weekend!',
            'Leslie Alexander' => 'We still on for coffee this morning?',
            'Bessie Cooper' => 'Just finished reviewing your work',
            'Albert Flores' => 'Those dates work for me',
        ];

        $times = [
            '09:45 AM',
            '08:30 AM',
            '07:25 AM',
            '04:56 PM',
            '02:18 PM',
        ];

        $i = 0;
        foreach ($fakeUsers as $name => $msgContent) {
            $user = User::firstOrCreate(
                ['email' => str_replace(' ', '.', strtolower($name)).'@example.com'],
                ['name' => $name, 'password' => bcrypt('password')]
            );

            // Make me follow them and they follow me
            if (! $me->isFollowing($user)) {
                $me->follow($user);
            }
            if (! $user->isFollowing($me)) {
                $user->follow($me);
            }

            // Create some messages
            // Old message from Me
            Message::create([
                'sender_id' => $me->id,
                'receiver_id' => $user->id,
                'content' => 'Hey '.explode(' ', $name)[0].'!',
                'created_at' => Carbon::parse($times[$i])->subHours(2),
                'read_at' => now(),
            ]);

            // Latest message from them
            $lastMsg = Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $me->id,
                'content' => $msgContent,
                'created_at' => Carbon::parse($times[$i]),
                'read_at' => ($i > 2) ? now() : null, // Leslie and above have unread messages in the screenshot? No, the screenshot shows indicators for Jenny, Cameron, Leslie.
            ]);

            $i++;
        }
    }
}
