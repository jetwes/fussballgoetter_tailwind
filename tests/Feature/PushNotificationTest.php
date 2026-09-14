<?php

use App\Livewire\Practise;
use App\Models\Participation;
use App\Models\Practise as PractiseModel;
use App\Models\User;
use App\Notifications\PractiseReminder;
use App\Notifications\TeamsDrawn;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\artisan;

beforeEach(fn () => Carbon::setTestNow('2026-09-14 10:00:00'));
afterEach(fn () => Carbon::setTestNow());

function subscribe(User $user): void
{
    $user->updatePushSubscription('https://push.example.com/'.$user->id, 'p256dh-key', 'auth-token', 'aesgcm');
}

it('stores and removes push subscriptions', function () {
    $user = User::factory()->create();

    actingAs($user)->postJson(route('push.subscribe'), [
        'endpoint' => 'https://push.example.com/abc',
        'keys' => ['p256dh' => 'key', 'auth' => 'token'],
        'contentEncoding' => 'aes128gcm',
    ])->assertOk();

    expect($user->pushSubscriptions()->count())->toBe(1);

    actingAs($user)->deleteJson(route('push.unsubscribe'), ['endpoint' => 'https://push.example.com/abc'])->assertOk();

    expect($user->pushSubscriptions()->count())->toBe(0);
});

it('reminds only subscribed players without an answer, once per window', function () {
    Notification::fake();

    $practise = PractiseModel::create(['name' => 'x', 'date_of_practise' => '2026-09-15 19:30:00']);

    $answered = User::factory()->create();
    $silent = User::factory()->create();
    $noPush = User::factory()->create();
    subscribe($answered);
    subscribe($silent);

    Participation::create(['user_id' => $answered->id, 'practise_id' => $practise->id, 'participate' => true]);

    // 24h vor der Frist (Frist = 15:30 am 15.09.) → 15:30 am 14.09.; jetzt ist 10:00 → noch nicht fällig
    artisan('practise:remind')->assertSuccessful();
    Notification::assertNothingSent();

    Carbon::setTestNow('2026-09-14 15:40:00');
    artisan('practise:remind')->assertSuccessful();

    Notification::assertSentTo($silent, PractiseReminder::class);
    Notification::assertNotSentTo([$answered, $noPush], PractiseReminder::class);

    // Gleiches Fenster erneut → nichts
    artisan('practise:remind')->assertSuccessful();
    Notification::assertSentTimes(PractiseReminder::class, 1);

    // 3h-Fenster
    Carbon::setTestNow('2026-09-15 12:45:00');
    artisan('practise:remind')->assertSuccessful();
    Notification::assertSentTimes(PractiseReminder::class, 2);
});

it('notifies subscribed participants when the teams are drawn', function () {
    Notification::fake();
    config()->set('fussballgoetter.drawers', ['Trainer']);

    $practise = PractiseModel::create(['name' => 'x', 'date_of_practise' => '2026-09-14 19:30:00']);
    $trainer = User::factory()->create(['name' => 'Trainer']);
    $player = User::factory()->create();
    subscribe($player);

    foreach ([$trainer, $player] as $user) {
        Participation::create(['user_id' => $user->id, 'practise_id' => $practise->id, 'participate' => true]);
    }

    Carbon::setTestNow('2026-09-14 17:00:00');

    Livewire::actingAs($trainer)->test(Practise::class)->call('shuffle');

    Notification::assertSentTo($player, TeamsDrawn::class);
    Notification::assertNotSentTo($trainer, TeamsDrawn::class);
});
