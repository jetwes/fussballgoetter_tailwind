<x-layouts::app title="Anmeldung">
    <x-guest-card title="Anmeldung">
        @if ($errors->any())
            <flux:callout variant="danger" icon="exclamation-triangle" heading="Anmeldung fehlgeschlagen">
                <flux:callout.text>
                    @foreach ($errors->all() as $message)
                        {{ $message }}<br>
                    @endforeach
                </flux:callout.text>
            </flux:callout>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <flux:input label="E-Mail-Adresse" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" placeholder="du@beispiel.de" />

            <flux:input label="Passwort" type="password" name="password" required autocomplete="current-password" viewable />

            <div class="flex items-center justify-between gap-4">
                <flux:checkbox name="remember" label="Angemeldet bleiben" checked />

                <flux:modal.trigger name="forgot-password">
                    <flux:link as="button" type="button" variant="subtle" class="text-sm">Passwort vergessen?</flux:link>
                </flux:modal.trigger>
            </div>

            <flux:button type="submit" variant="primary" class="w-full">Anmelden</flux:button>
        </form>

        <x-slot:footer>
            Noch kein Konto?
            <flux:link href="{{ route('register') }}">Jetzt registrieren</flux:link>
        </x-slot:footer>
    </x-guest-card>

    <flux:modal name="forgot-password" class="md:w-96">
        <form method="POST" action="{{ route('user-password-forgot') }}" class="space-y-6">
            @csrf
            <div>
                <flux:heading size="lg">Passwort vergessen</flux:heading>
                <flux:text class="mt-2">Wir schicken dir ein neues, vorläufiges Passwort per E-Mail. Es wird aktiv, sobald du den Link in der E-Mail anklickst.</flux:text>
            </div>

            <flux:input label="E-Mail-Adresse" type="email" name="email" required placeholder="du@beispiel.de" />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost" type="button">Abbrechen</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Zurücksetzen</flux:button>
            </div>
        </form>
    </flux:modal>
</x-layouts::app>
