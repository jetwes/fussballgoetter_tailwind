<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Draw extends Model
{
    protected $guarded = [];

    public function practise(): BelongsTo
    {
        return $this->belongsTo(Practise::class);
    }

    public function drawer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'drawer_id');
    }

    /**
     * Die Teams als Liste von Namenslisten (leere Teams werden weggelassen).
     *
     * @return array<int, array<int, string>>
     */
    public function teams(): array
    {
        return collect([$this->teamA, $this->teamB, $this->teamC])
            ->map(fn (?string $team) => array_values(array_filter(array_map('trim', explode(',', (string) $team)))))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Teilt die Namen zufällig in zwei oder drei Teams auf und speichert die Auslosung.
     *
     * @param  array<int, string>  $names
     */
    public static function createFromNames(Practise $practise, array $names, User $drawer): self
    {
        shuffle($names);

        $teamCount = count($names) >= (int) config('fussballgoetter.practise.three_teams_from', 15) ? 3 : 2;
        $teams = count($names) > 0 ? array_chunk($names, (int) ceil(count($names) / $teamCount)) : [];

        return static::create([
            'practise_id' => $practise->id,
            'teamA' => isset($teams[0]) ? implode(',', $teams[0]) : null,
            'teamB' => isset($teams[1]) ? implode(',', $teams[1]) : null,
            'teamC' => $teamCount === 3 && isset($teams[2]) ? implode(',', $teams[2]) : null,
            'drawer_id' => $drawer->id,
        ]);
    }
}
