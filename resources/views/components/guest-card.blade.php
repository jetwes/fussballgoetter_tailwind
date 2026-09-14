@props(['title'])

<div class="mx-auto flex min-h-[70vh] w-full max-w-md flex-col justify-center py-8">
    <a href="/" class="mx-auto mb-6">
        <img src="/img/logo_fussballgoetter_mid.png" alt="Fußballgötter" class="h-32 w-auto dark:rounded-2xl dark:bg-white/90 dark:p-3">
    </a>

    <flux:heading size="xl" level="1" class="mb-6 text-center">{{ $title }}</flux:heading>

    <flux:card class="space-y-6">
        {{ $slot }}
    </flux:card>

    @isset($footer)
        <div class="mt-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
            {{ $footer }}
        </div>
    @endisset
</div>
