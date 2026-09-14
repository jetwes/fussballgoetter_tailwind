<div x-data="avatarCropper" class="space-y-4">
    @if ($photo && $photo->isPreviewable())
        <div class="space-y-4">
            <div class="mx-auto w-full max-w-sm overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800 [&_.cropper-view-box]:rounded-full [&_.cropper-face]:rounded-full">
                <img src="{{ $photo->temporaryUrl() }}" alt="Vorschau" class="block max-w-full" x-init="$nextTick(() => start($el))" wire:key="preview-{{ $photo->getFilename() }}" />
            </div>
            <flux:text class="text-center text-sm">Ausschnitt verschieben und zoomen. Der Kreis zeigt das spätere Profilbild.</flux:text>
            <div class="flex flex-wrap justify-center gap-3">
                <flux:button wire:click="cancel" x-on:click="stop" variant="ghost">Abbrechen</flux:button>
                <flux:button x-on:click="save" variant="primary" icon="check">Foto speichern</flux:button>
            </div>
        </div>
    @else
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
            <flux:avatar :src="$user->avatar_url" :name="$user->name" size="xl" circle class="shrink-0" />

            <div class="flex-1 space-y-2">
                <flux:input type="file" wire:model="photo" label="Neues Foto" accept="image/png,image/jpeg,image/webp" description:trailing="JPG, PNG oder WebP. Du kannst den Ausschnitt anschließend wählen." />
                <div wire:loading wire:target="photo" class="flex items-center gap-2 text-sm text-zinc-500">
                    <flux:icon.loading variant="mini" /> Bild wird hochgeladen …
                </div>
            </div>
        </div>
    @endif
</div>
