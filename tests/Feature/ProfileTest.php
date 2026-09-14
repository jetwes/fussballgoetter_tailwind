<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;

it('updates name, birthday and password', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('change-password'), [
            'name' => 'Neuer Name',
            'birthday' => '24.12.1980',
            'password' => 'neues-passwort',
            'password_again' => 'neues-passwort',
        ])
        ->assertRedirect(route('home'))
        ->assertSessionHas('success-message');

    $user->refresh();

    expect($user->name)->toBe('Neuer Name')
        ->and($user->birthday->format('Y-m-d'))->toBe('1980-12-24')
        ->and(Hash::check('neues-passwort', $user->password))->toBeTrue();
});

it('validates the birthday format', function () {
    actingAs(User::factory()->create())
        ->from(route('profile'))
        ->post(route('change-password'), ['name' => 'X', 'birthday' => '1980-12-24'])
        ->assertRedirect(route('profile'))
        ->assertSessionHasErrors('birthday');
});

it('stores a resized avatar', function () {
    Storage::fake('avatars');
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('change-avatar'), ['avatar' => UploadedFile::fake()->image('me.png', 800, 600)])
        ->assertRedirect(route('home'));

    $user->refresh();

    expect($user->avatar)->toStartWith('/user/avatars/')
        ->and($user->avatar_url)->toBe($user->avatar);

    Storage::disk('avatars')->assertExists(basename($user->avatar));
});
