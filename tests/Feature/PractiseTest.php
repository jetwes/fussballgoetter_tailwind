<?php

use App\Livewire\Practise;
use App\Models\Draw;
use App\Models\Participation;
use App\Models\Practise as PractiseModel;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    Carbon::setTestNow('2026-09-14 10:00:00'); // Montag
});

afterEach(fn () => Carbon::setTestNow());

function nextPractise(): PractiseModel
{
    return PractiseModel::create([
        'name' => 'Fußballgötter',
        'date_of_practise' => Carbon::parse('2026-09-14 19:30:00'),
    ]);
}

it('creates the next practise automatically when none exists', function () {
    actingAs(User::factory()->create());

    get('/')->assertOk()->assertSee('Nächstes Training');

    expect(PractiseModel::count())->toBe(1)
        ->and(PractiseModel::first()->date_of_practise->format('Y-m-d H:i'))->toBe('2026-09-21 19:30');
});

it('lets a user sign up and cancel', function () {
    $practise = nextPractise();
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Practise::class)
        ->call('participate', true)
        ->assertSee('Dabei');

    expect($practise->participators()->count())->toBe(1);

    Livewire::actingAs($user)
        ->test(Practise::class)
        ->call('participate', false)
        ->assertSee('Abgesagt');

    expect($practise->participators()->count())->toBe(0)
        ->and($practise->cancellations()->count())->toBe(1);
});

it('refuses changes after the registration deadline', function () {
    nextPractise();
    Carbon::setTestNow('2026-09-14 16:00:00'); // < 4h vor Anpfiff

    Livewire::actingAs(User::factory()->create())
        ->test(Practise::class)
        ->assertSee('geschlossen')
        ->call('participate', true);

    expect(Participation::count())->toBe(0);
});

it('only lets configured users draw the teams once the window is open', function () {
    config()->set('fussballgoetter.drawers', ['Trainer']);
    $practise = nextPractise();

    $players = User::factory()->count(5)->create();
    $players->each(fn (User $player) => Participation::create([
        'user_id' => $player->id,
        'practise_id' => $practise->id,
        'participate' => true,
    ]));

    $trainer = User::factory()->create(['name' => 'Trainer']);

    // Zu früh
    Livewire::actingAs($trainer)->test(Practise::class)->call('shuffle');
    expect(Draw::count())->toBe(0);

    Carbon::setTestNow('2026-09-14 17:00:00');

    // Kein Ausloser
    Livewire::actingAs($players->first())->test(Practise::class)->call('shuffle');
    expect(Draw::count())->toBe(0);

    Livewire::actingAs($trainer)
        ->test(Practise::class)
        ->assertSee('Teams losen')
        ->call('shuffle')
        ->assertRedirect(route('shuffle', $practise));

    $draw = Draw::sole();
    $teams = $draw->teams();

    expect($teams)->toHaveCount(2)
        ->and(collect($teams)->flatten()->sort()->values()->all())
        ->toBe($players->pluck('name')->sort()->values()->all());

    actingAs($trainer)->get(route('shuffle', $practise))
        ->assertOk()
        ->assertSee('Team A')
        ->assertSee('Team B');
});

it('shows upcoming birthdays', function () {
    nextPractise();
    User::factory()->create(['name' => 'Geburtstagskind', 'birthday' => '1980-09-16']);
    User::factory()->create(['name' => 'Spaeter', 'birthday' => '1980-10-16']);

    Livewire::actingAs(User::factory()->create())
        ->test(Practise::class)
        ->assertSee('Geburtstagskind')
        ->assertDontSee('Spaeter');
});
