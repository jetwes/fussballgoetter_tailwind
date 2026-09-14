<x-layouts::app title="Profil">
    @php($user = auth()->user())

    <div class="mx-auto max-w-2xl space-y-6">
        <div>
            <flux:heading size="xl" level="1">Profil</flux:heading>
            <flux:text class="mt-1">Foto, Name, Geburtstag und Passwort ändern.</flux:text>
        </div>

        <flux:card class="space-y-6">
            <flux:heading size="lg">Profilbild</flux:heading>

            <form method="POST" action="{{ route('change-avatar') }}" enctype="multipart/form-data" class="flex flex-col gap-6 sm:flex-row sm:items-start">
                @csrf
                <flux:avatar :src="$user->avatar_url" :name="$user->name" size="xl" circle class="shrink-0" />

                <div class="flex-1 space-y-4">
                    <flux:input type="file" name="avatar" label="Neues Foto" accept="image/png,image/jpeg,image/webp" description="JPG, PNG oder WebP – wird automatisch auf 240×240 Pixel zugeschnitten." required />
                    <flux:button type="submit" variant="primary" icon="photo">Foto speichern</flux:button>
                </div>
            </form>
        </flux:card>

        <flux:card class="space-y-6">
            <flux:heading size="lg">Persönliche Daten</flux:heading>

            <form method="POST" action="{{ route('change-password') }}" class="space-y-6">
                @csrf

                <div class="grid gap-6 sm:grid-cols-2">
                    <flux:input label="Name" name="name" :value="old('name', $user->name)" required />
                    <flux:input label="Geburtstag" name="birthday" placeholder="TT.MM.JJJJ" :value="old('birthday', $user->birthday?->format('d.m.Y'))" description="Damit wir dir gratulieren können." />
                </div>

                <flux:separator text="Passwort ändern" />

                <div class="grid gap-6 sm:grid-cols-2">
                    <flux:input label="Neues Passwort" type="password" name="password" autocomplete="new-password" viewable description="Leer lassen, wenn es nicht geändert werden soll." />
                    <flux:input label="Wiederholung" type="password" name="password_again" autocomplete="new-password" viewable />
                </div>

                <div class="flex justify-end gap-3">
                    <flux:button href="{{ route('home') }}" variant="ghost">Zurück</flux:button>
                    <flux:button type="submit" variant="primary">Speichern</flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts::app>
