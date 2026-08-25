<?php

use App\Models\Club;
use App\Models\User;

test('index lists clubs without the missing deleted_at column error', function () {
    $user = User::factory()->create();
    Club::factory()->count(3)->create();

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/clubs');

    $response->assertStatus(200);
    expect($response->json('data'))->toHaveCount(3);
});

test('user can join a club', function () {
    $user = User::factory()->create();
    $club = Club::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->postJson("/api/clubs/{$club->id}/join");

    $response->assertStatus(200)->assertJsonPath('is_following', true);
    expect($club->isMember($user->id))->toBeTrue();
    expect($club->refresh()->members_count)->toBe(1);
});

test('joining twice returns an error instead of duplicating membership', function () {
    $user = User::factory()->create();
    $club = Club::factory()->create();
    $club->members()->attach($user->id, ['role' => 'member']);

    $response = $this->actingAs($user, 'sanctum')->postJson("/api/clubs/{$club->id}/join");

    $response->assertStatus(400);
});

test('user can leave a club', function () {
    $user = User::factory()->create();
    $club = Club::factory()->create(['members_count' => 1]);
    $club->members()->attach($user->id, ['role' => 'member']);

    $response = $this->actingAs($user, 'sanctum')->postJson("/api/clubs/{$club->id}/leave");

    $response->assertStatus(200)->assertJsonPath('is_following', false);
    expect($club->isMember($user->id))->toBeFalse();
});

test('the creator cannot leave their own club', function () {
    $creator = User::factory()->create();
    $club = Club::factory()->create(['creator_id' => $creator->id]);
    $club->members()->attach($creator->id, ['role' => 'creator']);

    $response = $this->actingAs($creator, 'sanctum')->postJson("/api/clubs/{$club->id}/leave");

    $response->assertStatus(400);
    expect($club->isMember($creator->id))->toBeTrue();
});
