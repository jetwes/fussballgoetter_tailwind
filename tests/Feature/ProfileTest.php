<?php

use App\Livewire\AvatarUploader;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

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

it('renders the profile page with the avatar uploader', function () {
    actingAs(User::factory()->create())
        ->get(route('profile'))
        ->assertOk()
        ->assertSeeLivewire(AvatarUploader::class)
        ->assertSee('Push-Benachrichtigungen');
});

it('stores a cropped and resized avatar', function () {
    Storage::fake('avatars');
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(AvatarUploader::class)
        ->set('photo', UploadedFile::fake()->image('me.png', 800, 600))
        ->assertHasNoErrors()
        ->call('save', ['x' => 100, 'y' => 50, 'width' => 400, 'height' => 400])
        ->assertHasNoErrors()
        ->assertRedirect(route('profile'));

    $user->refresh();

    expect($user->avatar)->toStartWith('/user/avatars/')
        ->and($user->avatar_url)->toBe($user->avatar);

    Storage::disk('avatars')->assertExists(basename($user->avatar));

    [$width, $height] = getimagesizefromstring(Storage::disk('avatars')->get(basename($user->avatar)));
    expect($width)->toBe(240)->and($height)->toBe(240);
});

it('rejects non-image uploads', function () {
    Livewire::actingAs(User::factory()->create())
        ->test(AvatarUploader::class)
        ->set('photo', UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf'))
        ->assertHasErrors('photo');
});
