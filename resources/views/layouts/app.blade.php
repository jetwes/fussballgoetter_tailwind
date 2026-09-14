<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="vapid-public-key" content="{{ config('webpush.vapid.public_key') }}">
    <meta name="theme-color" content="#6d28d9">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Fußballgötter">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <title>{{ isset($title) ? $title.' · ' : '' }}{{ config('app.name') }}</title>

    <link rel="manifest" href="/site.webmanifest">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/img/icons/icon-192.png" type="image/png">
    <link rel="apple-touch-icon" href="/img/icons/apple-touch-icon.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-800 antialiased dark:bg-zinc-900 dark:text-zinc-100">
    @auth
        <x-app-header />
    @endauth

    <flux:main container class="max-w-5xl">
        <x-flash-messages />

        {{ $slot }}
    </flux:main>

    <flux:footer class="p-0!">
        <div class="mx-auto w-full max-w-5xl px-6 py-10 text-center text-sm text-zinc-500 lg:px-8 dark:text-zinc-400">
            &copy; {{ now()->year }} Jens Twesmann &middot;
            <flux:link href="https://github.com/jetwes/fussballgoetter_tailwind" external variant="subtle">Quelltext auf GitHub</flux:link>
        </div>
    </flux:footer>

    @fluxScripts
    @livewireScriptConfig
    <flux:toast position="bottom end" />
</body>
</html>
