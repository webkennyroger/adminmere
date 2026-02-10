<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_sync_activity_from_app()
    {
        // Create user
        $user = User::factory()->create();

        // Simulate App Payload
        $payload = [
            'id' => 'uuid-1234-5678',
            'activityTitle' => 'Morning Run',
            'sport' => 'run',
            'createdAt' => now()->toIso8601String(),
            'distanceInMeters' => 5000.5,
            'durationInSeconds' => 1800,
            'routePoints' => [['lat' => 10.0, 'lng' => 20.0]],
            'calories' => 300,
            'privacy' => 'public',
        ];

        // Act
        $response = $this->actingAs($user)
            ->postJson('/api/activities', $payload);

        // Assert
        $response->assertStatus(201);

        $this->assertDatabaseHas('activities', [
            'app_id' => 'uuid-1234-5678',
            'title' => 'Morning Run',
            'distance' => 5000.5,
            'user_id' => $user->id,
        ]);
    }
}
