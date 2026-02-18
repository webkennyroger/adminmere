<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserNicknameValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_keep_their_own_nickname()
    {
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'nickname' => 'johndoe',
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/user/profile', [
                'nickname' => 'johndoe',
                'name' => 'John Updated',
            ]);

        if ($response->status() !== 200) {
            dump($response->json());
        }
        $response->assertStatus(200);
        $this->assertEquals('johndoe', $user->fresh()->profile->nickname);
        $this->assertEquals('John Updated', $user->fresh()->name);
    }

    public function test_user_cannot_take_another_users_nickname()
    {
        $user1 = User::factory()->create();
        Profile::create([
            'user_id' => $user1->id,
            'nickname' => 'taken_nick',
        ]);

        $user2 = User::factory()->create();
        Profile::create([
            'user_id' => $user2->id,
            'nickname' => 'user2_nick',
        ]);

        $response = $this->actingAs($user2)
            ->postJson('/api/user/profile', [
                'nickname' => 'taken_nick',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nickname']);
    }

    public function test_user_can_change_to_a_new_unique_nickname()
    {
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
            'nickname' => 'old_nick',
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/user/profile', [
                'nickname' => 'new_unique_nick',
            ]);

        $response->assertStatus(200);
        $this->assertEquals('new_unique_nick', $user->fresh()->profile->nickname);
    }
}
