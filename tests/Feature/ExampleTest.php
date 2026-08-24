<?php

use App\Models\User;

test('non-admin users are blocked from the web dashboard', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertForbidden();
});

test('admins can access the web dashboard', function () {
    $user = User::factory()->create();
    $user->profile()->update(['role' => 'admin']);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertSuccessful();
});
