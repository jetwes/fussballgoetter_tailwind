<x-layouts::app title="Auslosung">
    <div class="space-y-6">
        <div>
            <flux:heading size="xl" level="1">Auslosung</flux:heading>
            <flux:text class="mt-1">
                Training am {{ $practise->date_of_practise->format('d.m.Y') }} &middot;
                ausgelost von <strong>{{ $draw->drawer?->name ?? 'unbekannt' }}</strong>
                am {{ $draw->created_at->format('d.m.Y') }} um {{ $draw->created_at->format('H:i') }} Uhr
            </flux:text>
        </div>

        <div class="grid gap-6 {{ count($teams) >= 3 ? 'md:grid-cols-3' : 'md:grid-cols-2' }}">
            @foreach ($teams as $index => $team)
                @php($colors = ['violet', 'emerald', 'amber'])
                <flux:card class="space-y-4">
                    <div class="flex items-center justify-between">
                        <flux:heading size="lg">Team {{ chr(65 + $index) }}</flux:heading>
                        <flux:badge :color="$colors[$index % 3]" size="sm">{{ count($team) }} Spieler</flux:badge>
                    </div>
                    <ol class="divide-y divide-zinc-100 dark:divide-zinc-700">
                        @foreach ($team as $player)
                            <li class="flex items-center gap-3 py-2">
                                <span class="flex size-7 items-center justify-center rounded-full bg-zinc-100 text-xs font-semibold text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300">{{ $loop->iteration }}</span>
                                <span class="font-medium">{{ $player }}</span>
                            </li>
                        @endforeach
                    </ol>
                </flux:card>
            @endforeach
        </div>

        <flux:button href="{{ route('home') }}" variant="ghost" icon="arrow-left">Zurück zum Training</flux:button>
    </div>
</x-layouts::app>
