<?php

use App\Jobs\MatchSegmentsForActivity;
use App\Models\Activity;
use App\Models\Segment;
use App\Models\SegmentEffort;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

test('user can create a segment', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/segments', [
        'name' => 'Volta do Parque',
        'sport_type' => 'running',
        'start_lat' => -23.55,
        'start_lng' => -46.63,
        'end_lat' => -23.555,
        'end_lng' => -46.635,
        'radius_m' => 40,
    ]);

    $response->assertStatus(201)->assertJsonPath('success', true);
    expect(Segment::where('name', 'Volta do Parque')->where('created_by', $user->id)->exists())->toBeTrue();
});

test('index returns nearby segments sorted by distance', function () {
    $user = User::factory()->create();
    $near = Segment::factory()->create(['start_lat' => -23.55, 'start_lng' => -46.63]);
    $far = Segment::factory()->create(['start_lat' => -23.90, 'start_lng' => -46.90]);

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/segments?lat=-23.551&lng=-46.631&radius_km=10');

    $response->assertStatus(200);
    $ids = collect($response->json('data'))->pluck('id');
    expect($ids->first())->toBe($near->id);
    expect($ids)->not->toContain($far->id);
});

test('show returns leaderboard ranked by best effort per user', function () {
    $segment = Segment::factory()->create();
    $activity = Activity::factory()->create();
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    // userA's best effort is faster (60s) than their other effort (90s)
    SegmentEffort::factory()->create([
        'segment_id' => $segment->id,
        'activity_id' => $activity->id,
        'user_id' => $userA->id,
        'duration_seconds' => 90,
    ]);
    $activity2 = Activity::factory()->create();
    SegmentEffort::factory()->create([
        'segment_id' => $segment->id,
        'activity_id' => $activity2->id,
        'user_id' => $userA->id,
        'duration_seconds' => 60,
    ]);
    SegmentEffort::factory()->create([
        'segment_id' => $segment->id,
        'activity_id' => Activity::factory()->create()->id,
        'user_id' => $userB->id,
        'duration_seconds' => 75,
    ]);

    $response = $this->actingAs($userA, 'sanctum')->getJson("/api/segments/{$segment->id}");

    $response->assertStatus(200);
    $leaderboard = $response->json('data.leaderboard');
    expect($leaderboard)->toHaveCount(2);
    expect($leaderboard[0]['user_id'])->toBe($userA->id);
    expect($leaderboard[0]['best_seconds'])->toBe(60);
    expect($leaderboard[1]['user_id'])->toBe($userB->id);
    expect($leaderboard[1]['best_seconds'])->toBe(75);
});

test('matching job records an effort when the route crosses the segment', function () {
    $user = User::factory()->create();
    $segment = Segment::factory()->create([
        'sport_type' => 'run',
        'start_lat' => -23.5500,
        'start_lng' => -46.6300,
        'end_lat' => -23.5520,
        'end_lng' => -46.6320,
        'radius_m' => 40,
    ]);

    $baseTime = now()->timestamp;
    $activity = Activity::factory()->create([
        'user_id' => $user->id,
        'sport_type' => 'run',
        'polylines' => [
            'points' => [
                ['lat' => -23.5480, 'lng' => -46.6280, 't' => $baseTime],
                ['lat' => -23.5500, 'lng' => -46.6300, 't' => $baseTime + 30], // entra no segmento
                ['lat' => -23.5510, 'lng' => -46.6310, 't' => $baseTime + 60],
                ['lat' => -23.5520, 'lng' => -46.6320, 't' => $baseTime + 90], // sai do segmento
                ['lat' => -23.5540, 'lng' => -46.6340, 't' => $baseTime + 120],
            ],
        ],
    ]);

    (new MatchSegmentsForActivity($activity->id))->handle();

    $effort = SegmentEffort::where('segment_id', $segment->id)->where('activity_id', $activity->id)->first();
    expect($effort)->not->toBeNull();
    expect($effort->duration_seconds)->toBe(60);
    expect($effort->user_id)->toBe($user->id);
});

test('matching job does nothing when route points have no timestamp', function () {
    $segment = Segment::factory()->create([
        'sport_type' => 'run',
        'start_lat' => -23.5500,
        'start_lng' => -46.6300,
        'end_lat' => -23.5520,
        'end_lng' => -46.6320,
    ]);

    $activity = Activity::factory()->create([
        'sport_type' => 'run',
        'polylines' => [
            'points' => [
                ['lat' => -23.5500, 'lng' => -46.6300],
                ['lat' => -23.5520, 'lng' => -46.6320],
            ],
        ],
    ]);

    (new MatchSegmentsForActivity($activity->id))->handle();

    expect(SegmentEffort::where('activity_id', $activity->id)->exists())->toBeFalse();
});

test('matching job does nothing when the route never reaches the segment', function () {
    $segment = Segment::factory()->create([
        'sport_type' => 'run',
        'start_lat' => -23.5500,
        'start_lng' => -46.6300,
        'end_lat' => -23.5520,
        'end_lng' => -46.6320,
        'radius_m' => 40,
    ]);

    $baseTime = now()->timestamp;
    $activity = Activity::factory()->create([
        'sport_type' => 'run',
        'polylines' => [
            'points' => [
                ['lat' => -23.0000, 'lng' => -46.0000, 't' => $baseTime],
                ['lat' => -23.0010, 'lng' => -46.0010, 't' => $baseTime + 30],
            ],
        ],
    ]);

    (new MatchSegmentsForActivity($activity->id))->handle();

    expect(SegmentEffort::where('segment_id', $segment->id)->where('activity_id', $activity->id)->exists())->toBeFalse();
});

test('saving an activity with timed route points creates a segment effort end to end', function () {
    Queue::fake();

    $user = User::factory()->create();
    Segment::factory()->create([
        'sport_type' => 'run',
        'start_lat' => -23.5500,
        'start_lng' => -46.6300,
        'end_lat' => -23.5520,
        'end_lng' => -46.6320,
        'radius_m' => 40,
    ]);

    $baseTime = now()->timestamp;
    $response = $this->actingAs($user, 'sanctum')->postJson('/api/activities', [
        'activityTitle' => 'Corrida no parque',
        'sport' => 'run',
        'createdAt' => now()->toIso8601String(),
        'distanceInMeters' => 3000,
        'durationInSeconds' => 900,
        'routePoints' => [
            ['lat' => -23.5480, 'lng' => -46.6280, 't' => $baseTime],
            ['lat' => -23.5500, 'lng' => -46.6300, 't' => $baseTime + 30],
            ['lat' => -23.5520, 'lng' => -46.6320, 't' => $baseTime + 90],
        ],
    ]);

    $response->assertStatus(200);
    Queue::assertPushed(MatchSegmentsForActivity::class);
});
