<?php

use App\Models\TrainingPlan;
use App\Models\User;

test('user can list training plans with enrollment flag', function () {
    $user = User::factory()->create();
    $plan = TrainingPlan::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/training-plans');

    $response->assertStatus(200)->assertJsonPath('success', true);
    $data = collect($response->json('data'));
    expect($data->firstWhere('id', $plan->id)['is_enrolled'])->toBeFalse();
});

test('show returns plan details with all workouts ordered by week and day', function () {
    $user = User::factory()->create();
    $plan = TrainingPlan::factory()->create(['weeks' => 1]);
    $plan->workouts()->create(['week_number' => 1, 'day_number' => 3, 'title' => 'Dia 3', 'steps' => [['type' => 'rest']]]);
    $plan->workouts()->create(['week_number' => 1, 'day_number' => 1, 'title' => 'Dia 1', 'steps' => [['type' => 'rest']]]);

    $response = $this->actingAs($user, 'sanctum')->getJson("/api/training-plans/{$plan->id}");

    $response->assertStatus(200)
        ->assertJsonPath('data.id', $plan->id)
        ->assertJsonPath('data.is_enrolled', false)
        ->assertJsonPath('data.workouts.0.title', 'Dia 1')
        ->assertJsonPath('data.workouts.1.title', 'Dia 3');
});

test('user can enroll in a training plan', function () {
    $user = User::factory()->create();
    $plan = TrainingPlan::factory()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->postJson("/api/training-plans/{$plan->id}/enroll");

    $response->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath('is_enrolled', true);

    expect($user->trainingPlans()->where('training_plans.id', $plan->id)->exists())->toBeTrue();
    $pivot = $user->trainingPlans()->first()->pivot;
    expect($pivot->current_week)->toBe(1)
        ->and($pivot->current_day)->toBe(1)
        ->and($pivot->status)->toBe('active');
});

test('enrolling twice does not duplicate the pivot row', function () {
    $user = User::factory()->create();
    $plan = TrainingPlan::factory()->create();

    $this->actingAs($user, 'sanctum')->postJson("/api/training-plans/{$plan->id}/enroll");
    $this->actingAs($user, 'sanctum')->postJson("/api/training-plans/{$plan->id}/enroll");

    expect($user->trainingPlans()->where('training_plans.id', $plan->id)->count())->toBe(1);
});

test('user can unenroll from a training plan', function () {
    $user = User::factory()->create();
    $plan = TrainingPlan::factory()->create();
    $user->trainingPlans()->attach($plan->id, [
        'started_at' => now(),
        'current_week' => 1,
        'current_day' => 1,
        'status' => 'active',
    ]);

    $response = $this->actingAs($user, 'sanctum')
        ->postJson("/api/training-plans/{$plan->id}/unenroll");

    $response->assertStatus(200)->assertJsonPath('is_enrolled', false);
    expect($user->trainingPlans()->where('training_plans.id', $plan->id)->exists())->toBeFalse();
});

test('today workout returns null when no active plan', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/training-plans/today');

    $response->assertStatus(200)->assertJsonPath('data', null);
});

test('today workout returns the workout matching current week and day', function () {
    $user = User::factory()->create();
    $plan = TrainingPlan::factory()->create(['weeks' => 4]);
    $plan->workouts()->create([
        'week_number' => 1,
        'day_number' => 1,
        'title' => 'Corrida Leve',
        'steps' => [['type' => 'work', 'distance_m' => 3000]],
    ]);
    $user->trainingPlans()->attach($plan->id, [
        'started_at' => now(),
        'current_week' => 1,
        'current_day' => 1,
        'status' => 'active',
    ]);

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/training-plans/today');

    $response->assertStatus(200)
        ->assertJsonPath('data.title', 'Corrida Leve')
        ->assertJsonPath('data.steps.0.distance_m', 3000);
});

test('completing today advances to the next day', function () {
    $user = User::factory()->create();
    $plan = TrainingPlan::factory()->create(['weeks' => 4]);
    $user->trainingPlans()->attach($plan->id, [
        'started_at' => now(),
        'current_week' => 1,
        'current_day' => 1,
        'status' => 'active',
    ]);

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/training-plans/complete-today');

    $response->assertStatus(200)->assertJsonPath('status', 'active');
    $pivot = $user->trainingPlans()->first()->pivot;
    expect($pivot->current_week)->toBe(1)
        ->and($pivot->current_day)->toBe(2);
});

test('completing the last day of the last week marks the plan completed', function () {
    $user = User::factory()->create();
    $plan = TrainingPlan::factory()->create(['weeks' => 1]);
    $user->trainingPlans()->attach($plan->id, [
        'started_at' => now(),
        'current_week' => 1,
        'current_day' => 7,
        'status' => 'active',
    ]);

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/training-plans/complete-today');

    $response->assertStatus(200)->assertJsonPath('status', 'completed');
    $pivot = $user->trainingPlans()->first()->pivot;
    expect($pivot->status)->toBe('completed');
});
