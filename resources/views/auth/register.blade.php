<x-layouts::app title="Registrieren">
    <x-guest-card title="Neues Konto anlegen">
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <flux:input label="Name" name="name" :value="old('name')" required autofocus autocomplete="name" description="So wirst du in der Teilnehmerliste angezeigt." />

            <flux:input label="E-Mail-Adresse" type="email" name="email" :value="old('email')" required autocomplete="email" />

            <flux:input label="Passwort" type="password" name="password" required autocomplete="new-password" viewable description="Mindestens 8 Zeichen." />

            <flux:input label="Passwort wiederholen" type="password" name="password_confirmation" required autocomplete="new-password" viewable />

            <flux:button type="submit" variant="primary" class="w-full">Registrieren</flux:button>
        </form>

        <x-slot:footer>
            Schon registriert?
            <flux:link href="{{ route('login') }}">Zur Anmeldung</flux:link>
        </x-slot:footer>
    </x-guest-card>
</x-layouts::app>
