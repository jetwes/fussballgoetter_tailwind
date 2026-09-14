<?php

namespace App\Livewire;

use App\Models\Participation;
use App\Models\Practise;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Lazy]
#[Title('Statistik')]
class Statistics extends Component
{
    #[Url]
    public ?int $year = null;

    public function mount(): void
    {
        $this->year ??= (int) now()->year;
    }

    #[Computed]
    public function years(): Collection
    {
        return Practise::where('date_of_practise', '<', now())
            ->pluck('date_of_practise')
            ->map(fn ($date) => (int) $date->year)
            ->unique()
            ->sortDesc()
            ->values();
    }

    #[Computed]
    public function practises(): Collection
    {
        return Practise::where('date_of_practise', '<', now())
            ->whereYear('date_of_practise', $this->year)
            ->withCount(['participators', 'cancellations'])
            ->with('draw')
            ->orderByDesc('date_of_practise')
            ->get();
    }

    #[Computed]
    public function players(): Collection
    {
        $practiseIds = $this->practises->pluck('id');
        $total = $practiseIds->count();

        $rows = Participation::whereIn('practise_id', $practiseIds)
            ->selectRaw('user_id, sum(case when participate then 1 else 0 end) as yes, sum(case when participate then 0 else 1 end) as no')
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        return User::whereIn('id', $rows->keys())
            ->get()
            ->map(fn (User $user) => (object) [
                'user' => $user,
                'yes' => (int) $rows[$user->id]->yes,
                'no' => (int) $rows[$user->id]->no,
                'rate' => $total > 0 ? (int) round($rows[$user->id]->yes / $total * 100) : 0,
            ])
            ->sortBy([['yes', 'desc'], ['no', 'asc'], fn ($a, $b) => strcasecmp($a->user->name, $b->user->name)])
            ->values();
    }

    public function updatedYear(): void
    {
        unset($this->practises, $this->players);
    }

    public function placeholder(): string
    {
        return view('livewire.statistics-placeholder')->render();
    }

    public function render()
    {
        return view('livewire.statistics');
    }
}
