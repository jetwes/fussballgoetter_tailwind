@props(['compact' => false])

<div x-data="pushToggle" x-show="supported" x-cloak {{ $attributes->class('flex flex-wrap items-center gap-3') }}>
    @unless ($compact)
        <div class="min-w-0 flex-1">
            <flux:heading>Push-Benachrichtigungen</flux:heading>
            <flux:text class="mt-1 text-sm">
                <span x-show="! denied">Erinnerung, wenn du dich noch nicht zum Training gemeldet hast, und Bescheid, sobald die Teams gelost sind.</span>
                <span x-show="denied" x-cloak>Benachrichtigungen sind im Browser blockiert. Bitte in den Website-Einstellungen wieder erlauben.</span>
            </flux:text>
        </div>
    @endunless

    <flux:button x-on:click="toggle" x-bind:disabled="busy || denied" size="sm" variant="filled" x-bind:class="enabled ? '' : ''" icon="bell">
        <span x-show="! enabled">Benachrichtigungen aktivieren</span>
        <span x-show="enabled" x-cloak>Benachrichtigungen aus</span>
    </flux:button>
</div>
