@php
    $practise = $this->practise;
    $participation = $this->participation;
    $registrationOpen = $practise->isRegistrationOpen();
@endphp

<div class="space-y-6" wire:poll.30s>
    {{-- Kopfbereich --}}
    <flux:card class="overflow-hidden p-0!">
        <div class="bg-linear-to-br from-violet-600 via-violet-700 to-indigo-800 px-6 py-6 text-white sm:px-8">
            <p class="text-xs font-semibold uppercase tracking-widest text-violet-200">Nächstes Training</p>
            <h1 class="mt-1 text-3xl font-extrabold tracking-tight sm:text-4xl">
                {{ $practise->date_of_practise->translatedFormat('l, d.m.Y') }}
            </h1>

            <dl class="mt-5 grid gap-4 text-sm sm:grid-cols-3">
                <div class="flex items-start gap-2">
                    <flux:icon.clock variant="mini" class="mt-0.5 shrink-0 text-violet-200" />
                    <div>
                        <dt class="text-violet-200">Anpfiff</dt>
                        <dd class="font-semibold">{{ $practise->date_of_practise->format('H:i') }} Uhr <span class="font-normal text-violet-200">· Treffen {{ $practise->meetingTime()->format('H:i') }} Uhr</span></dd>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <flux:icon.map-pin variant="mini" class="mt-0.5 shrink-0 text-violet-200" />
                    <div>
                        <dt class="text-violet-200">Ort</dt>
                        <dd class="font-semibold">
                            {{ $location }}
                            @if ($mapsUrl)
                                &middot; <a href="{{ $mapsUrl }}" target="_blank" rel="noopener" class="font-normal underline decoration-violet-300 underline-offset-2 hover:text-violet-100">Route</a>
                            @endif
                        </dd>
                    </div>
                </div>
                <div class="flex items-start gap-2" x-data="countdown(@js($practise->registrationDeadline()->toIso8601String()))" wire:ignore>
                    <flux:icon.calendar variant="mini" class="mt-0.5 shrink-0 text-violet-200" />
                    <div>
                        <dt class="text-violet-200">Anmeldung</dt>
                        <dd class="font-semibold">
                            @if ($registrationOpen)
                                bis {{ $practise->registrationDeadline()->format('d.m.Y H:i') }} Uhr
                            @else
                                geschlossen
                            @endif
                        </dd>
                        <dd class="mt-1">
                            <span x-text="label" x-cloak
                                  class="inline-block rounded-full px-2 py-0.5 text-xs font-semibold"
                                  x-bind:class="closed ? 'bg-white/15 text-violet-100' : (urgent ? 'animate-pulse bg-amber-400 text-amber-950' : 'bg-white/15 text-white')"></span>
                        </dd>
                    </div>
                </div>
            </dl>
        </div>

        <div class="grid grid-cols-2 divide-x divide-zinc-200 border-b border-zinc-200 dark:divide-zinc-700 dark:border-zinc-700">
            <div class="px-6 py-4 text-center">
                <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ $practise->participators->count() }}</div>
                <div class="text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Zusagen</div>
            </div>
            <div class="px-6 py-4 text-center">
                <div class="text-3xl font-extrabold text-rose-600 dark:text-rose-400">{{ $practise->cancellations->count() }}</div>
                <div class="text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Absagen</div>
            </div>
        </div>

        {{-- Aktionen --}}
        <div class="space-y-4 px-6 py-6 sm:px-8">
            @if ($participation)
                <div class="flex items-center justify-center gap-2 text-sm">
                    <span class="text-zinc-500 dark:text-zinc-400">Dein Status:</span>
                    @if ($participation->participate)
                        <flux:badge color="green" icon="check-circle">Dabei</flux:badge>
                    @else
                        <flux:badge color="red" icon="x-circle">Abgesagt</flux:badge>
                    @endif
                </div>
            @endif

            <div class="flex flex-wrap items-center justify-center gap-3">
                <flux:button
                    wire:click="participate(true)"
                    wire:loading.attr="disabled"
                    :disabled="! $registrationOpen"
                    variant="primary"
                    icon="check"
                    class="min-w-36 bg-emerald-600! text-white! hover:bg-emerald-700! dark:bg-emerald-500! dark:hover:bg-emerald-400!"
                >
                    Ich bin dabei
                </flux:button>

                <flux:button
                    wire:click="participate(false)"
                    wire:loading.attr="disabled"
                    :disabled="! $registrationOpen"
                    variant="primary"
                    icon="x-mark"
                    class="min-w-36 bg-rose-600! text-white! hover:bg-rose-700! dark:bg-rose-500! dark:hover:bg-rose-400!"
                >
                    Diesmal nicht
                </flux:button>
            </div>

            @unless ($registrationOpen)
                <flux:text class="text-center text-sm">Die Anmeldefrist ist abgelaufen. Änderungen sind nicht mehr möglich.</flux:text>
            @endunless

            @if ($practise->draw || $this->canDraw)
                <div class="flex flex-wrap items-center justify-center gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                    @if ($practise->draw)
                        <flux:button href="{{ route('shuffle', $practise) }}" variant="filled" color="amber" icon="trophy" wire:navigate>Auslosung anzeigen</flux:button>
                    @elseif ($this->canDraw)
                        <flux:button
                            wire:click="shuffle"
                            wire:confirm="Teams jetzt auslosen? Das ist nur ein einziges Mal möglich!"
                            variant="filled"
                            color="amber"
                            icon="sparkles"
                        >
                            Teams losen
                        </flux:button>
                        <flux:text class="text-sm">Achtung: nur einmal möglich.</flux:text>
                    @endif
                </div>
            @endif
        </div>
    </flux:card>

    {{-- Push-Hinweis --}}
    <div x-data="{ dismissed: localStorage.getItem('push-hint-dismissed') === '1' }" x-show="! dismissed" x-cloak>
        <div x-data="pushToggle" x-show="supported && ! enabled && ! denied" x-cloak>
            <flux:callout icon="bell" color="violet" heading="Nichts mehr verpassen">
                <flux:callout.text>Wir erinnern dich per Push, wenn du dich noch nicht gemeldet hast, und sagen Bescheid, sobald die Teams gelost sind.</flux:callout.text>
                <x-slot name="actions">
                    <flux:button x-on:click="toggle" x-bind:disabled="busy" size="sm" variant="primary">Aktivieren</flux:button>
                    <flux:button x-on:click="dismissed = true; localStorage.setItem('push-hint-dismissed', '1')" size="sm" variant="ghost">Später</flux:button>
                </x-slot>
            </flux:callout>
        </div>
    </div>

    {{-- Geburtstage --}}
    @if ($this->birthdays->isNotEmpty())
        <flux:callout icon="cake" color="amber" heading="Geburtstag in Sicht!">
            <flux:callout.text>
                @foreach ($this->birthdays as $birthdayUser)
                    <span class="block">
                        <strong>{{ $birthdayUser->name }}</strong> – {{ $birthdayUser->birthday->format('d.m.') }}
                        @if ($birthdayUser->birthday->isBirthday())
                            <flux:badge size="sm" color="amber" inset="top bottom">heute!</flux:badge>
                        @endif
                    </span>
                @endforeach
            </flux:callout.text>
        </flux:callout>
    @endif

    {{-- Bier --}}
    @if ($features['beer'] ?? false)
        <flux:card size="sm" class="flex flex-wrap items-center justify-between gap-4">
            @if ($this->beer)
                <flux:text>Danke an <strong>{{ $this->beer->user->name }}</strong> – bringt Bier mit! 🍻</flux:text>
                @if ($this->beer->user_id === auth()->id())
                    <flux:button wire:click="setBeer(false)" size="sm" variant="ghost">Oh – doch kein Bier von mir</flux:button>
                @endif
            @elseif ($this->isParticipating)
                <flux:text>Bringst du diesmal Bier mit?</flux:text>
                <flux:button wire:click="setBeer(true)" size="sm" variant="filled" color="green" icon="beaker">Ich bringe Bier mit</flux:button>
            @else
                <flux:text>Noch bringt niemand Bier mit.</flux:text>
            @endif
        </flux:card>
    @endif

    {{-- Fahrgemeinschaften --}}
    @if ($features['carpool'] ?? false)
        <flux:card class="space-y-5">
            <div class="flex items-center gap-2">
                <flux:icon.truck variant="mini" class="text-zinc-500" />
                <flux:heading size="lg">Fahrgemeinschaften</flux:heading>
            </div>

            @if ($this->isParticipating)
                <div x-data="{ driving: @js($places > 0) }" class="space-y-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <flux:text>Ich kann fahren:</flux:text>
                        <flux:button x-show="! driving" x-on:click="driving = true" size="sm" variant="filled" color="green">Ja</flux:button>
                        <flux:button x-show="driving" x-on:click="driving = false; $wire.noDrive()" size="sm" variant="filled" color="red">Nein, doch nicht</flux:button>
                    </div>
                    <div x-show="driving" x-cloak class="grid gap-4 sm:grid-cols-2">
                        <flux:input wire:model.live.debounce.500ms="places" type="number" min="0" max="9" label="Freie Plätze" />
                        <flux:input wire:model.live.debounce.750ms="comment" label="Info" placeholder="Treffpunkt / Uhrzeit" />
                    </div>
                </div>
            @endif

            @if ($this->drivers->isNotEmpty())
                <div class="divide-y divide-zinc-100 dark:divide-zinc-700">
                    @foreach ($this->drivers as $driver)
                        @php
                            $passengers = $practise->seats->where('driver_id', $driver->user_id)->where('user_id', '!=', $driver->user_id);
                            $free = max(0, $driver->places - $passengers->count());
                        @endphp
                        <div class="flex flex-wrap items-center gap-3 py-3" wire:key="driver-{{ $driver->id }}">
                            <flux:avatar :src="$driver->user->avatar_url" :name="$driver->user->name" size="sm" circle />
                            <div class="min-w-0 flex-1">
                                <div class="font-medium">{{ $driver->user->name }} <span class="text-sm font-normal text-zinc-500">· {{ $free }} von {{ $driver->places }} frei</span></div>
                                @if ($driver->comment)
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $driver->comment }}</div>
                                @endif
                                @if ($passengers->isNotEmpty())
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Mitfahrer: {{ $passengers->map->user->pluck('name')->join(', ') }}</div>
                                @endif
                            </div>
                            @if ($this->isParticipating && $driver->user_id !== auth()->id())
                                @if ($this->mySeat?->driver_id === $driver->user_id)
                                    <flux:button wire:click="leaveSeat" size="sm" variant="ghost" icon="x-circle">Platz freigeben</flux:button>
                                @elseif (! $this->mySeat && $free > 0)
                                    <flux:button wire:click="takeSeat({{ $driver->user_id }})" size="sm" variant="filled" color="green" icon="check-circle">Mitfahren</flux:button>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <flux:text class="text-sm">Noch keine Fahrer eingetragen.</flux:text>
            @endif
        </flux:card>
    @endif

    {{-- Teilnehmer --}}
    <div>
        <div class="mb-4 flex items-center justify-between">
            <flux:heading size="lg" level="2">Teilnehmer</flux:heading>
            <flux:text class="text-sm">{{ $practise->participations->count() }} Rückmeldungen</flux:text>
        </div>

        @if ($practise->participations->isEmpty())
            <flux:card variant="soft" class="text-center">
                <flux:icon.users class="mx-auto size-10 text-zinc-400" />
                <flux:heading class="mt-3">Noch keine Rückmeldungen</flux:heading>
                <flux:text class="mt-1">Sei der Erste und sag zu!</flux:text>
            </flux:card>
        @else
            @php($counter = 0)
            <ul class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                @foreach ($practise->participations as $entry)
                    <li wire:key="participation-{{ $entry->id }}"
                        class="relative flex flex-col items-center gap-2 rounded-xl border bg-white p-4 text-center shadow-xs transition dark:bg-white/10
                               {{ $entry->participate ? 'border-emerald-200 dark:border-emerald-400/30' : 'border-rose-200 opacity-70 dark:border-rose-400/30' }}
                               {{ $entry->user_id === auth()->id() ? 'ring-2 ring-violet-500/60' : '' }}">
                        @if ($entry->participate)
                            @php($counter++)
                            <span class="absolute left-2 top-2 flex size-6 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">{{ $counter }}</span>
                        @endif
                        <flux:avatar :src="$entry->user->avatar_url" :name="$entry->user->name" size="xl" circle class="{{ $entry->participate ? '' : 'grayscale' }}" />
                        <span class="line-clamp-1 w-full text-sm font-medium">{{ $entry->user->name }}</span>
                        @if ($entry->participate)
                            <flux:badge size="sm" color="green" icon="check-circle">Dabei</flux:badge>
                        @else
                            <flux:badge size="sm" color="red" icon="x-circle">Abgesagt</flux:badge>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
