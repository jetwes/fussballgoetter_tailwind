<?php

namespace Database\Seeders;

use App\Models\Participation;
use App\Models\Practise;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Demo-Daten für die lokale Entwicklung (nicht für Produktion gedacht).
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $trainer = User::factory()->create([
            'name' => 'Übungsleiter',
            'email' => 'trainer@example.com',
            'password' => 'password',
            'birthday' => now()->addDays(2)->subYears(40),
        ]);

        $practise = Practise::current();

        $players = User::factory()->count(9)->create();

        Participation::create(['user_id' => $trainer->id, 'practise_id' => $practise->id, 'participate' => true]);

        $players->each(function (User $player, int $index) use ($practise) {
            $player->update(['avatar' => 'https://api.dicebear.com/9.x/adventurer-neutral/svg?seed='.urlencode($player->name)]);

            Participation::create([
                'user_id' => $player->id,
                'practise_id' => $practise->id,
                'participate' => $index % 4 !== 3,
            ]);
        });
    }
}
