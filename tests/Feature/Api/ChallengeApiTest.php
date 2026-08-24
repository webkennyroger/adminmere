<?php

use App\Models\Challenge;
use App\Models\User;

test('user can join a challenge via api', function () {
    $user = User::factory()->create();
    $challenge = Challenge::factory()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->postJson("/api/challenges/{$challenge->id}/join");

    $response->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath('is_joined', true);

    expect($user->challenges()->where('challenges.id', $challenge->id)->exists())->toBeTrue();
});

test('joining a challenge twice does not duplicate the pivot row', function () {
    $user = User::factory()->create();
    $challenge = Challenge::factory()->create();

    $this->actingAs($user, 'sanctum')->postJson("/api/challenges/{$challenge->id}/join");
    $this->actingAs($user, 'sanctum')->postJson("/api/challenges/{$challenge->id}/join");

    expect($user->challenges()->where('challenges.id', $challenge->id)->count())->toBe(1);
});

test('user can leave a joined challenge via api', function () {
    $user = User::factory()->create();
    $challenge = Challenge::factory()->create();
    $user->challenges()->attach($challenge->id, ['progress' => 0, 'status' => 'joined']);

    $response = $this->actingAs($user, 'sanctum')
        ->postJson("/api/challenges/{$challenge->id}/leave");

    $response->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath('is_joined', false);

    expect($user->challenges()->where('challenges.id', $challenge->id)->exists())->toBeFalse();
});

test('active challenges endpoint only returns non-completed joined challenges', function () {
    $user = User::factory()->create();
    $active = Challenge::factory()->ongoing()->create();
    $completed = Challenge::factory()->ongoing()->create();
    $user->challenges()->attach($active->id, ['progress' => 0, 'status' => 'joined']);
    $user->challenges()->attach($completed->id, ['progress' => 100, 'status' => 'completed']);

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/stats/challenges/active');

    $response->assertStatus(200);
    $ids = collect($response->json('data'))->pluck('id');
    expect($ids)->toContain($active->id);
    expect($ids)->not->toContain($completed->id);
});
