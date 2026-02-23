<?php

use App\Livewire\Posts\CreatePost;
use App\Models\User;
use App\Models\Post;
use Livewire\Livewire;

it('can create a post', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreatePost::class)
        ->set('postForm.content', 'Test Post Content')
        ->call('save')
        ->assertDispatched('post-created')
        ->assertSet('postForm.content', '');

    expect(Post::where('content', 'Test Post Content')->exists())->toBeTrue();
});

it('can create a poll', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreatePost::class)
        ->set('isPoll', true)
        ->set('pollForm.title', 'Favorite Fruit?')
        ->set('pollForm.content', 'Choose one')
        ->set('pollForm.options', ['Apple', 'Banana'])
        ->call('save')
        ->assertDispatched('post-created');

    $poll = Post::where('title', 'Favorite Fruit?')->first();
    expect($poll)->not->toBeNull()
        ->and($poll->type)->toBe('poll')
        ->and($poll->pollOptions)->toHaveCount(2);
});
