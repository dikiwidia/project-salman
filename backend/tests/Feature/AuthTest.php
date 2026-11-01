<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('user can login with valid credentials', function () {
    $user = User::factory()->create(['password' => 'password']);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['token', 'token_type', 'user' => ['id', 'name', 'email']])
        ->assertJsonPath('user.email', $user->email);

    expect($user->tokens()->count())->toBe(1);
});

test('login fails with invalid credentials', function () {
    $user = User::factory()->create(['password' => 'password']);

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertUnprocessable()->assertJsonValidationErrors('email');
});

test('login requires email and password', function () {
    $this->postJson('/api/login')
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email', 'password']);
});

test('authenticated user can get their profile', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $this->getJson('/api/me')
        ->assertOk()
        ->assertJsonPath('data.id', $user->id)
        ->assertJsonMissingPath('data.password');
});

test('guest cannot access me endpoint', function () {
    $this->getJson('/api/me')->assertUnauthorized();
});

test('user can logout and token is revoked', function () {
    $user = User::factory()->create();
    $token = $user->createToken('api')->plainTextToken;

    $this->withToken($token)->postJson('/api/logout')->assertNoContent();

    expect($user->tokens()->count())->toBe(0);
});
