<?php

namespace App\Console\Commands;

use App\Models\Practise;
use App\Models\User;
use App\Notifications\PractiseReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SendPractiseReminders extends Command
{
    protected $signature = 'practise:remind {--force : Erinnerung unabhängig vom Zeitfenster sofort senden}';

    protected $description = 'Erinnert alle Spieler ohne Rückmeldung per Push an das nächste Training';

    public function handle(): int
    {
        $practise = Practise::where('date_of_practise', '>', now())->orderBy('date_of_practise')->first();

        if (! $practise || ! $practise->isRegistrationOpen()) {
            $this->info('Kein Training mit offener Anmeldung.');

            return self::SUCCESS;
        }

        $deadline = $practise->registrationDeadline();
        $offsets = collect(config('fussballgoetter.notifications.reminder_hours_before_deadline', []));

        // Das jüngste fällige Erinnerungsfenster (kleinster Offset, dessen Zeitpunkt bereits erreicht ist).
        $due = $this->option('force')
            ? 'force-'.now()->timestamp
            : $offsets
                ->filter(fn (int $hours) => now()->gte($deadline->copy()->subHours($hours)))
                ->sort()
                ->first();

        if ($due === null) {
            $this->info('Aktuell ist keine Erinnerung fällig.');

            return self::SUCCESS;
        }

        $cacheKey = "practise-reminder:{$practise->id}:{$due}";

        if (Cache::has($cacheKey)) {
            $this->info('Diese Erinnerung wurde bereits verschickt.');

            return self::SUCCESS;
        }

        $answered = $practise->participations()->pluck('user_id');

        $users = User::whereNotIn('id', $answered)
            ->whereHas('pushSubscriptions')
            ->get();

        $users->each->notify(new PractiseReminder($practise));

        Cache::put($cacheKey, true, now()->addDays(7));

        $this->info("Erinnerung an {$users->count()} Spieler verschickt.");

        return self::SUCCESS;
    }
}
