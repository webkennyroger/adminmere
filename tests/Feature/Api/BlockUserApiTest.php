<?php

use App\Models\User;

test('user can block another user via api', function () {
    $user = User::factory()->create();
    $target = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->postJson("/api/users/{$target->id}/block");

    $response->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath('is_blocked', true);

    expect($user->blockedUsers()->where('blocked_user_id', $target->id)->exists())->toBeTrue();
});

test('blocking twice unblocks the user via api', function () {
    $user = User::factory()->create();
    $target = User::factory()->create();
    $user->blockedUsers()->attach($target->id);

    $response = $this->actingAs($user, 'sanctum')
        ->postJson("/api/users/{$target->id}/block");

    $response->assertStatus(200)
        ->assertJsonPath('is_blocked', false);

    expect($user->blockedUsers()->where('blocked_user_id', $target->id)->exists())->toBeFalse();
});

test('user cannot block themselves via api', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->postJson("/api/users/{$user->id}/block");

    $response->assertStatus(400);
});

test('blocked user cannot send a message to the blocker', function () {
    $blocker = User::factory()->create();
    $blocked = User::factory()->create();
    $blocker->blockedUsers()->attach($blocked->id);

    $response = $this->actingAs($blocked, 'sanctum')
        ->postJson('/api/messages', [
            'recipient_id' => $blocker->id,
            'content' => 'Hey',
        ]);

    $response->assertStatus(403);
    $this->assertDatabaseCount('messages', 0);
});

test('user who blocked the recipient cannot send them a message either', function () {
    $blocker = User::factory()->create();
    $blocked = User::factory()->create();
    $blocker->blockedUsers()->attach($blocked->id);

    $response = $this->actingAs($blocker, 'sanctum')
        ->postJson('/api/messages', [
            'recipient_id' => $blocked->id,
            'content' => 'Hey',
        ]);

    $response->assertStatus(403);
    $this->assertDatabaseCount('messages', 0);
});

test('messages work normally when there is no block', function () {
    $sender = User::factory()->create();
    $recipient = User::factory()->create();

    $response = $this->actingAs($sender, 'sanctum')
        ->postJson('/api/messages', [
            'recipient_id' => $recipient->id,
            'content' => 'Hey',
        ]);

    $response->assertStatus(201);
    $this->assertDatabaseCount('messages', 1);
});
