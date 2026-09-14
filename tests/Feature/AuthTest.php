<?php

use App\Models\User;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('redirects guests from the home page to the login', function () {
    get('/')->assertRedirect(route('login'));
});

it('renders the login page', function () {
    get(route('login'))
        ->assertOk()
        ->assertSee('Anmeldung')
        ->assertSee('Passwort vergessen?');
});

it('logs a user in', function () {
    $user = User::factory()->create(['password' => 'geheim123']);

    post(route('login'), ['email' => $user->email, 'password' => 'geheim123'])
        ->assertRedirect('/');

    assertAuthenticatedAs($user);
});

it('registers a new user with a generated avatar', function () {
    post(route('register'), [
        'name' => 'Neuer Spieler',
        'email' => 'neu@example.com',
        'password' => 'passwort123',
        'password_confirmation' => 'passwort123',
    ])->assertRedirect('/');

    $user = User::where('email', 'neu@example.com')->firstOrFail();

    expect($user->avatar)->toContain('dicebear.com')
        ->and($user->avatar_url)->toBe($user->avatar);
});
