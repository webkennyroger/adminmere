<?php

use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->admin = User::factory()->create();
    $this->admin->profile->update(['role' => 'admin']);
});

test('can create a post via api', function () {
    $response = $this->actingAs($this->user, 'sanctum')
        ->postJson('/api/posts', [
            'content' => 'Test Post Content',
            'privacy' => 'public',
        ]);

    $response->assertStatus(201)
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.description', 'Test Post Content');

    expect(Post::where('content', 'Test Post Content')->exists())->toBeTrue();
});

test('can update a post via api', function () {
    $post = Post::factory()->create(['user_id' => $this->user->id, 'type' => 'post']);

    $response = $this->actingAs($this->user, 'sanctum')
        ->putJson("/api/posts/post_{$post->id}", [
            'content' => 'Updated Content',
        ]);

    $response->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.description', 'Updated Content');

    expect($post->refresh()->content)->toBe('Updated Content');
});

test('can delete a post via api', function () {
    $post = Post::factory()->create(['user_id' => $this->user->id, 'type' => 'post']);

    $response = $this->actingAs($this->user, 'sanctum')
        ->deleteJson("/api/posts/post_{$post->id}");

    $response->assertStatus(200)
        ->assertJsonPath('success', true);

    expect(Post::find($post->id))->toBeNull();
});

test('admin can delete any post', function () {
    $post = Post::factory()->create(['user_id' => $this->user->id, 'type' => 'post']);

    $response = $this->actingAs($this->admin, 'sanctum')
        ->deleteJson("/api/posts/post_{$post->id}");

    $response->assertStatus(200);
    expect(Post::find($post->id))->toBeNull();
});

test('cannot delete another users post', function () {
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $otherUser->id, 'type' => 'post']);

    $response = $this->actingAs($this->user, 'sanctum')
        ->deleteJson("/api/posts/post_{$post->id}");

    $response->assertStatus(403);
    expect(Post::find($post->id))->not->toBeNull();
});

test('can create a poll via api', function () {
    $response = $this->actingAs($this->user, 'sanctum')
        ->postJson('/api/polls', [
            'question' => 'What is your favorite color?',
            'options' => ['Red', 'Blue', 'Green'],
            'privacy' => 'public',
        ]);

    $response->assertStatus(201)
        ->assertJsonPath('success', true);

    $poll = Post::where('title', 'What is your favorite color?')->first();
    expect($poll)->not->toBeNull();
    expect($poll->pollOptions)->toHaveCount(3);
});
