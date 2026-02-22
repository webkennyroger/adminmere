<?php

use App\Livewire\Home\Partials\ActivityItem;
use App\Livewire\Home\Partials\PostItem;
use App\Models\Activity;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('can edit and delete a post', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'user_id' => $user->id,
        'title' => 'Original Title',
        'content' => 'Original Content',
        'type' => 'post',
        'feed_type' => 'personal',
    ]);

    Livewire::actingAs($user)
        ->test(PostItem::class, ['post' => $post])
        ->call('startEditingPost')
        ->set('editTitle', 'New Title')
        ->set('editContent', 'New Content')
        ->call('updatePost')
        ->assertSet('editingPost', false);

    expect($post->fresh()->title)->toBe('New Title')
        ->and($post->fresh()->content)->toBe('New Content');

    Livewire::actingAs($user)
        ->test(PostItem::class, ['post' => $post])
        ->call('confirmDeletePost')
        ->assertSet('confirmingPostDeletion', true)
        ->call('deletePost');

    expect(Post::find($post->id))->toBeNull();
});

it('can edit and delete an activity', function () {
    $user = User::factory()->create();
    $activity = Activity::create([
        'user_id' => $user->id,
        'title' => 'Original Title',
        'description' => 'Original Content',
        'start_time' => now(),
    ]);

    Livewire::actingAs($user)
        ->test(ActivityItem::class, ['activity' => $activity])
        ->call('startEditingActivity')
        ->set('editTitle', 'New Title')
        ->set('editContent', 'New Content')
        ->call('updateActivity')
        ->assertSet('editingActivity', false);

    expect($activity->fresh()->title)->toBe('New Title')
        ->and($activity->fresh()->description)->toBe('New Content');

    Livewire::actingAs($user)
        ->test(ActivityItem::class, ['activity' => $activity])
        ->call('confirmDeleteActivity')
        ->assertSet('confirmingActivityDeletion', true)
        ->call('deleteActivity');

    expect(Activity::find($activity->id))->toBeNull();
});

it('can edit and delete a poll', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'user_id' => $user->id,
        'title' => 'Poll Title',
        'content' => 'Poll Question',
        'type' => 'poll',
        'feed_type' => 'personal',
    ]);

    Livewire::actingAs($user)
        ->test(PostItem::class, ['post' => $post])
        ->call('startEditingPost')
        ->set('editTitle', 'New Poll Title')
        ->set('editContent', 'New Poll Question')
        ->call('updatePost')
        ->assertSet('editingPoll', false);

    expect($post->fresh()->title)->toBe('New Poll Title')
        ->and($post->fresh()->content)->toBe('New Poll Question');

    Livewire::actingAs($user)
        ->test(PostItem::class, ['post' => $post])
        ->call('confirmDeletePost')
        ->assertSet('confirmingPollDeletion', true)
        ->call('deletePost');

    expect(Post::find($post->id))->toBeNull();
});
