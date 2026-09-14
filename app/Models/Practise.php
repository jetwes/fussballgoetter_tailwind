<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Practise extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'date_of_practise' => 'datetime',
        ];
    }

    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class)
            ->with('user')
            ->orderByDesc('participate')
            ->orderBy('id');
    }

    public function participators(): HasMany
    {
        return $this->hasMany(Participation::class)->where('participate', true)->with('user');
    }

    public function cancellations(): HasMany
    {
        return $this->hasMany(Participation::class)->where('participate', false)->with('user');
    }

    public function draw(): HasOne
    {
        return $this->hasOne(Draw::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function meetingTime(): CarbonInterface
    {
        return $this->date_of_practise->copy()->subMinutes((int) config('fussballgoetter.practise.meet_minutes_before'));
    }

    public function registrationDeadline(): CarbonInterface
    {
        return $this->date_of_practise->copy()->subHours((int) config('fussballgoetter.practise.registration_deadline_hours'));
    }

    public function isRegistrationOpen(): bool
    {
        return now()->lt($this->registrationDeadline());
    }

    public function isDrawOpen(): bool
    {
        return now()->gte($this->date_of_practise->copy()->subHours((int) config('fussballgoetter.practise.draw_opens_hours_before')));
    }

    /**
     * Das aktuelle Training – wird bei Bedarf für die nächste Woche angelegt.
     */
    public static function current(): self
    {
        $visibleUntil = now()->subHours((int) config('fussballgoetter.practise.visible_hours_after'));

        $practise = static::where('date_of_practise', '>=', $visibleUntil)
            ->orderBy('date_of_practise')
            ->first();

        if ($practise) {
            return $practise;
        }

        [$hour, $minute] = explode(':', (string) config('fussballgoetter.practise.time', '19:30'));

        return static::create([
            'name' => config('fussballgoetter.practise.name', 'Fußballgötter'),
            'date_of_practise' => now()
                ->startOfWeek()
                ->addWeek()
                ->addDays((int) config('fussballgoetter.practise.weekday', 1) - 1)
                ->setTime((int) $hour, (int) $minute),
        ]);
    }
}
