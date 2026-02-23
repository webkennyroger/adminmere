<?php

use App\Models\User;
use App\Models\Activity;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->admin = User::factory()->create();
    $this->admin->profile->update(['role' => 'admin']);
});

test('can update an activity via api', function () {
    $activity = Activity::factory()->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->user, 'sanctum')
        ->putJson("/api/activities/activity_{$activity->id}", [
            'activityTitle' => 'Updated Activity Title',
        ]);

    $response->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.activityTitle', 'Updated Activity Title');

    expect($activity->refresh()->title)->toBe('Updated Activity Title');
});

test('can delete an activity via api', function () {
    $activity = Activity::factory()->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->user, 'sanctum')
        ->deleteJson("/api/activities/activity_{$activity->id}");

    $response->assertStatus(200)
        ->assertJsonPath('success', true);

    expect(Activity::find($activity->id))->toBeNull();
});

test('admin can delete any activity', function () {
    $activity = Activity::factory()->create(['user_id' => $this->user->id]);

    $response = $this->actingAs($this->admin, 'sanctum')
        ->deleteJson("/api/activities/activity_{$activity->id}");

    $response->assertStatus(200);
    expect(Activity::find($activity->id))->toBeNull();
});
