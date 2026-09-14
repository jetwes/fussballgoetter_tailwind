<?php

use App\Livewire\Statistics;
use App\Models\Participation;
use App\Models\Practise;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(fn () => Carbon::setTestNow('2026-09-14 10:00:00'));
afterEach(fn () => Carbon::setTestNow());

it('ranks players by attendance over past practises', function () {
    $past1 = Practise::create(['name' => 'x', 'date_of_practise' => '2026-09-07 19:30:00']);
    $past2 = Practise::create(['name' => 'x', 'date_of_practise' => '2026-08-31 19:30:00']);
    $future = Practise::create(['name' => 'x', 'date_of_practise' => '2026-09-21 19:30:00']);

    $anna = User::factory()->create(['name' => 'Anna']);
    $ben = User::factory()->create(['name' => 'Ben']);

    foreach ([$past1, $past2, $future] as $practise) {
        Participation::create(['user_id' => $anna->id, 'practise_id' => $practise->id, 'participate' => true]);
    }
    Participation::create(['user_id' => $ben->id, 'practise_id' => $past1->id, 'participate' => false]);
    Participation::create(['user_id' => $ben->id, 'practise_id' => $past2->id, 'participate' => true]);

    $component = Livewire::withoutLazyLoading()->actingAs($anna)->test(Statistics::class);

    expect($component->instance()->practises)->toHaveCount(2);

    $players = $component->instance()->players;

    expect($players->pluck('user.name')->all())->toBe(['Anna', 'Ben'])
        ->and($players[0]->yes)->toBe(2)
        ->and($players[0]->rate)->toBe(100)
        ->and($players[1]->yes)->toBe(1)
        ->and($players[1]->no)->toBe(1)
        ->and($players[1]->rate)->toBe(50);

    $component->assertSee('Fleißtabelle 2026')->assertSee('Anna');
});

it('shows the statistics page to logged in users', function () {
    actingAs(User::factory()->create())->get(route('statistics'))->assertOk()->assertSee('Statistik');
});

it('redirects guests away from the statistics page', function () {
    test()->get(route('statistics'))->assertRedirect(route('login'));
});
