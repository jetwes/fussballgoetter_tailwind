<x-layouts::app title="Profil">
    @php($user = auth()->user())

    <div class="mx-auto max-w-2xl space-y-6">
        <div>
            <flux:heading size="xl" level="1">Profil</flux:heading>
            <flux:text class="mt-1">Foto, Name, Geburtstag, Passwort und Benachrichtigungen.</flux:text>
        </div>

        <flux:card class="space-y-6">
            <flux:heading size="lg">Profilbild</flux:heading>
            <livewire:avatar-uploader />
        </flux:card>

        <flux:card>
            <x-push-toggle />
        </flux:card>

        <flux:card class="space-y-6">
            <flux:heading size="lg">Persönliche Daten</flux:heading>

            <form method="POST" action="{{ route('change-password') }}" class="space-y-6">
                @csrf

                <div class="grid gap-6 sm:grid-cols-2">
                    <flux:input label="Name" name="name" :value="old('name', $user->name)" required />
                    <flux:input label="Geburtstag" name="birthday" placeholder="TT.MM.JJJJ" :value="old('birthday', $user->birthday?->format('d.m.Y'))" description:trailing="Damit wir dir gratulieren können." />
                </div>

                <flux:separator text="Passwort ändern" />

                <div class="grid gap-6 sm:grid-cols-2">
                    <flux:input label="Neues Passwort" type="password" name="password" autocomplete="new-password" viewable description:trailing="Leer lassen, wenn es nicht geändert werden soll." />
                    <flux:input label="Wiederholung" type="password" name="password_again" autocomplete="new-password" viewable />
                </div>

                <div class="flex justify-end gap-3">
                    <flux:button href="{{ route('home') }}" variant="ghost" wire:navigate>Zurück</flux:button>
                    <flux:button type="submit" variant="primary">Speichern</flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts::app>
