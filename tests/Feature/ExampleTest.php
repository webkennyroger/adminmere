<?php

test('returns a successful response', function () {
    $user = \App\Models\User::factory()->create();
    $response = $this->actingAs($user)->get(route('home'));

    $response->assertStatus(200);
});
