<?php

use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

// Ensure we have users
if (User::count() < 5) {
    \App\Models\User::factory(10)->create();
}

$me = User::first();
echo "Main User: {$me->name} (ID: {$me->id})\n";

// Make sure I follow someone
$others = User::where('id', '!=', $me->id)->take(3)->get();
foreach ($others as $other) {
    if (!$me->following()->where('following_id', $other->id)->exists()) {
        $me->following()->attach($other->id);
        echo "Followed: {$other->name}\n";
    }
}

// Make sure someone follows me (for followers count)
$fans = User::where('id', '!=', $me->id)->skip(3)->take(2)->get();
foreach ($fans as $fan) {
    if (!$fan->following()->where('following_id', $me->id)->exists()) {
        $fan->following()->attach($me->id);
        echo "New Fan: {$fan->name}\n";
    }
}

// Create some activities for the people I follow
foreach ($others as $other) {
    if ($other->activities()->count() == 0) {
        Activity::create([
            'user_id' => $other->id,
            'title' => 'Morning Run',
            'sport_type' => 'Run',
            'start_time' => now(),
            'distance' => 5000,
            'duration' => 1800,
            'calories' => 300,
            'privacy' => 'public'
        ]);
        echo "Created activity for {$other->name}\n";
    }
}

// Create some suggestions by ensuring there are users I DO NOT follow
$strangers = User::where('id', '!=', $me->id)
    ->whereNotIn('id', $me->following()->pluck('users.id'))
    ->take(5)
    ->get();

echo "Suggested candidates: " . $strangers->count() . "\n";
