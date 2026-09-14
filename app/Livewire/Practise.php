<?php

namespace App\Livewire;

use App\Models\Draw;
use App\Models\Participation;
use App\Models\Practise as PractiseModel;
use App\Models\Seat;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Training')]
class Practise extends Component
{
    public int $places = 0;

    public ?string $comment = null;

    public function mount(): void
    {
        if ($participation = $this->participation) {
            $this->places = (int) $participation->places;
            $this->comment = $participation->comment;
        }
    }

    #[Computed]
    public function practise(): PractiseModel
    {
        return PractiseModel::current()->load(['participations', 'participators', 'cancellations', 'seats.user', 'draw']);
    }

    #[Computed]
    public function participation(): ?Participation
    {
        return $this->practise->participations->firstWhere('user_id', auth()->id());
    }

    #[Computed]
    public function isParticipating(): bool
    {
        return (bool) $this->participation?->participate;
    }

    #[Computed]
    public function beer(): ?Participation
    {
        return $this->practise->participators->firstWhere('beer', true);
    }

    #[Computed]
    public function drivers(): Collection
    {
        return $this->practise->participators->where('places', '>', 0)->values();
    }

    #[Computed]
    public function mySeat(): ?Seat
    {
        return $this->practise->seats->firstWhere('user_id', auth()->id());
    }

    #[Computed]
    public function birthdays(): Collection
    {
        return User::whereNotNull('birthday')
            ->get()
            ->filter(fn (User $user) => $user->hasBirthdayWithinDays(6))
            ->sortBy(fn (User $user) => $user->birthday->format('md'))
            ->values();
    }

    #[Computed]
    public function canDraw(): bool
    {
        return auth()->user()->canDraw()
            && ! $this->practise->draw
            && $this->practise->isDrawOpen();
    }

    public function participate(bool $participate): void
    {
        $practise = $this->practise;

        if (! $practise->isRegistrationOpen()) {
            Flux::toast(variant: 'warning', text: 'Die Anmeldung für dieses Training ist geschlossen.');

            return;
        }

        $participation = $this->participation;

        if ($participation) {
            $participation->participate = $participate;

            if (! $participate) {
                $participation->beer = false;
                $participation->places = 0;
                $participation->comment = null;
                Seat::where('practise_id', $practise->id)
                    ->where(fn ($query) => $query->where('user_id', auth()->id())->orWhere('driver_id', auth()->id()))
                    ->delete();
                $this->places = 0;
                $this->comment = null;
            }

            $participation->save();
        } else {
            Participation::create([
                'user_id' => auth()->id(),
                'practise_id' => $practise->id,
                'participate' => $participate,
            ]);
        }

        $this->refresh();

        $participate
            ? Flux::toast(variant: 'success', text: 'Du bist dabei – bis dann!')
            : Flux::toast(variant: 'warning', text: 'Schade, du hast dich abgemeldet.');
    }

    public function setBeer(bool $beer): void
    {
        $participation = $this->participation;

        if (! $participation || ! $participation->participate) {
            Flux::toast(variant: 'warning', text: 'Du kannst kein Bier mitbringen – du bist noch nicht angemeldet ;)');

            return;
        }

        $participation->beer = $beer;
        $participation->save();
        $this->refresh();

        $beer
            ? Flux::toast(variant: 'success', text: 'DANKE! Du bringst Bier mit.')
            : Flux::toast(variant: 'warning', text: 'Schade, du bringst doch kein Bier mit.');
    }

    public function updatedPlaces(mixed $places): void
    {
        $participation = $this->participation;

        if (! $participation?->participate) {
            return;
        }

        $this->places = max(0, (int) $places);
        $participation->places = $this->places;
        $participation->save();

        if ($this->places > 0) {
            Seat::firstOrCreate([
                'practise_id' => $participation->practise_id,
                'driver_id' => auth()->id(),
                'user_id' => auth()->id(),
            ]);
        }

        $this->refresh();
    }

    public function updatedComment(?string $comment): void
    {
        $participation = $this->participation;

        if (! $participation?->participate) {
            return;
        }

        $participation->comment = filled($comment) ? $comment : null;
        $participation->save();
        $this->refresh();
    }

    public function noDrive(): void
    {
        $participation = $this->participation;

        if (! $participation) {
            return;
        }

        $participation->places = 0;
        $participation->comment = null;
        $participation->save();

        Seat::where('practise_id', $participation->practise_id)->where('driver_id', auth()->id())->delete();

        $this->places = 0;
        $this->comment = null;
        $this->refresh();
    }

    public function takeSeat(int $driverId): void
    {
        if (! $this->isParticipating || $this->mySeat) {
            return;
        }

        Seat::create([
            'driver_id' => $driverId,
            'user_id' => auth()->id(),
            'practise_id' => $this->practise->id,
        ]);

        $this->refresh();
        Flux::toast(variant: 'success', text: 'Du hast einen Mitfahrplatz reserviert.');
    }

    public function leaveSeat(): void
    {
        Seat::where('user_id', auth()->id())->where('practise_id', $this->practise->id)->delete();
        $this->refresh();
    }

    public function shuffle(): void
    {
        $practise = $this->practise;

        if (! $this->canDraw) {
            Flux::toast(variant: 'warning', text: 'Die Auslosung ist gerade nicht möglich.');

            return;
        }

        Draw::createFromNames(
            $practise,
            $practise->participators->map(fn (Participation $participation) => $participation->user->name)->all(),
            auth()->user(),
        );

        $this->redirectRoute('shuffle', $practise, navigate: false);
    }

    private function refresh(): void
    {
        unset($this->practise, $this->participation, $this->isParticipating, $this->beer, $this->drivers, $this->mySeat, $this->canDraw);
    }

    public function render()
    {
        return view('livewire.practise', [
            'features' => config('fussballgoetter.features'),
            'location' => config('fussballgoetter.practise.location'),
            'mapsUrl' => config('fussballgoetter.practise.maps_url'),
        ]);
    }
}
