<div class="space-y-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1">Statistik</flux:heading>
            <flux:text class="mt-1">Wer war wie oft dabei? Vergangene Trainings und die Fleißtabelle.</flux:text>
        </div>

        @if ($this->years->count() > 1)
            <flux:select wire:model.live="year" class="w-32" aria-label="Jahr">
                @foreach ($this->years as $y)
                    <flux:select.option :value="$y">{{ $y }}</flux:select.option>
                @endforeach
            </flux:select>
        @endif
    </div>

    @if ($this->practises->isEmpty())
        <flux:card variant="soft" class="text-center">
            <flux:icon.chart-bar class="mx-auto size-10 text-zinc-400" />
            <flux:heading class="mt-3">Noch keine vergangenen Trainings</flux:heading>
            <flux:text class="mt-1">Sobald das erste Training vorbei ist, erscheint hier die Auswertung.</flux:text>
        </flux:card>
    @else
        @php
            $total = $this->practises->count();
            $avg = $total > 0 ? round($this->practises->avg('participators_count'), 1) : 0;
            $max = $this->practises->max('participators_count');
        @endphp

        <div class="grid grid-cols-3 gap-3">
            <flux:card size="sm" class="text-center">
                <div class="text-2xl font-extrabold text-violet-600 dark:text-violet-400">{{ $total }}</div>
                <div class="text-xs font-medium uppercase tracking-wide text-zinc-500">Trainings</div>
            </flux:card>
            <flux:card size="sm" class="text-center">
                <div class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ number_format($avg, 1, ',', '.') }}</div>
                <div class="text-xs font-medium uppercase tracking-wide text-zinc-500">Ø Spieler</div>
            </flux:card>
            <flux:card size="sm" class="text-center">
                <div class="text-2xl font-extrabold text-amber-600 dark:text-amber-400">{{ $max }}</div>
                <div class="text-xs font-medium uppercase tracking-wide text-zinc-500">Rekord</div>
            </flux:card>
        </div>

        <flux:card class="space-y-4">
            <div class="flex items-center gap-2">
                <flux:icon.trophy variant="mini" class="text-amber-500" />
                <flux:heading size="lg">Fleißtabelle {{ $year }}</flux:heading>
            </div>

            <ol class="divide-y divide-zinc-100 dark:divide-zinc-700">
                @foreach ($this->players as $row)
                    <li class="flex items-center gap-3 py-2.5" wire:key="player-{{ $row->user->id }}">
                        <span class="w-6 shrink-0 text-center text-sm font-semibold text-zinc-400">{{ $loop->iteration }}</span>
                        <flux:avatar :src="$row->user->avatar_url" :name="$row->user->name" size="sm" circle />
                        <div class="min-w-0 flex-1">
                            <div class="truncate font-medium {{ $row->user->id === auth()->id() ? 'text-violet-700 dark:text-violet-300' : '' }}">{{ $row->user->name }}</div>
                            <div class="mt-1 h-1.5 w-full max-w-48 overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-700">
                                <div class="h-full rounded-full bg-emerald-500" style="width: {{ $row->rate }}%"></div>
                            </div>
                        </div>
                        <div class="text-right text-sm tabular-nums">
                            <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $row->yes }}×</span>
                            <span class="text-zinc-400"> dabei</span>
                            <span class="block text-xs text-zinc-500">{{ $row->rate }} % · {{ $row->no }} Absagen</span>
                        </div>
                    </li>
                @endforeach
            </ol>
        </flux:card>

        <flux:card class="space-y-4">
            <div class="flex items-center gap-2">
                <flux:icon.calendar variant="mini" class="text-zinc-500" />
                <flux:heading size="lg">Vergangene Trainings</flux:heading>
            </div>

            <div class="divide-y divide-zinc-100 dark:divide-zinc-700">
                @foreach ($this->practises as $practise)
                    <div class="flex flex-wrap items-center gap-3 py-2.5" wire:key="practise-{{ $practise->id }}">
                        <div class="min-w-0 flex-1">
                            <div class="font-medium">{{ $practise->date_of_practise->translatedFormat('l, d.m.Y') }}</div>
                            <div class="text-sm text-zinc-500">{{ $practise->date_of_practise->format('H:i') }} Uhr</div>
                        </div>
                        <flux:badge color="green" size="sm" icon="check-circle">{{ $practise->participators_count }}</flux:badge>
                        <flux:badge color="red" size="sm" icon="x-circle">{{ $practise->cancellations_count }}</flux:badge>
                        @if ($practise->draw)
                            <flux:button href="{{ route('shuffle', $practise) }}" size="xs" variant="ghost" icon="trophy" wire:navigate>Teams</flux:button>
                        @endif
                    </div>
                @endforeach
            </div>
        </flux:card>
    @endif
</div>
