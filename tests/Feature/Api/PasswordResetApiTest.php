<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('authenticated user can update their password via api', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $response = $this->actingAs($user, 'sanctum')
        ->putJson('/api/user/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response->assertStatus(200);

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('updating password via api requires the correct current password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $response = $this->actingAs($user, 'sanctum')
        ->putJson('/api/user/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['current_password']);

    expect(Hash::check('password', $user->refresh()->password))->toBeTrue();
});

test('updating password via api requires guests to be rejected', function () {
    $response = $this->putJson('/api/user/password', [
        'current_password' => 'password',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertStatus(401);
});
