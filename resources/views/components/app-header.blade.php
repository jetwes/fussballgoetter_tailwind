<flux:header class="border-b border-zinc-200 bg-white px-0! dark:border-zinc-700 dark:bg-zinc-800">
    <div class="mx-auto flex h-full min-h-14 w-full max-w-5xl items-center gap-2 px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center" wire:navigate>
            <span class="inline-flex h-12 items-center rounded-lg dark:bg-white dark:px-2">
                <img src="/img/logo_fussballgoetter_wide.png" alt="Fußballgötter" class="h-10 w-auto">
            </span>
            <span class="sr-only">Fußballgötter</span>
        </a>

        <flux:navbar class="ms-4 max-sm:hidden">
            <flux:navbar.item href="{{ route('home') }}" :current="request()->routeIs('home')" icon="calendar" wire:navigate>Training</flux:navbar.item>
            <flux:navbar.item href="{{ route('statistics') }}" :current="request()->routeIs('statistics')" icon="chart-bar" wire:navigate>Statistik</flux:navbar.item>
        </flux:navbar>

        <flux:spacer />

        <flux:dropdown x-data align="end">
            <flux:button variant="subtle" square aria-label="Farbschema wählen">
                <flux:icon.sun x-show="$flux.appearance === 'light' || ($flux.appearance === 'system' && ! $flux.dark)" variant="mini" class="text-zinc-500 dark:text-white" />
                <flux:icon.moon x-show="$flux.appearance === 'dark' || ($flux.appearance === 'system' && $flux.dark)" variant="mini" class="text-zinc-500 dark:text-white" />
            </flux:button>

            <flux:menu>
                <flux:menu.item x-on:click="$flux.appearance = 'light'" icon="sun">Hell</flux:menu.item>
                <flux:menu.item x-on:click="$flux.appearance = 'dark'" icon="moon">Dunkel</flux:menu.item>
                <flux:menu.item x-on:click="$flux.appearance = 'system'" icon="computer-desktop">System</flux:menu.item>
            </flux:menu>
        </flux:dropdown>

        <flux:dropdown align="end">
            <flux:profile :avatar="auth()->user()->avatar_url" :name="auth()->user()->name" circle />

            <flux:menu>
                <flux:menu.heading>{{ auth()->user()->email }}</flux:menu.heading>
                <flux:menu.item href="{{ route('home') }}" icon="calendar" class="sm:hidden" wire:navigate>Training</flux:menu.item>
                <flux:menu.item href="{{ route('statistics') }}" icon="chart-bar" class="sm:hidden" wire:navigate>Statistik</flux:menu.item>
                <flux:menu.item href="{{ route('profile') }}" icon="user-circle" wire:navigate>Profil bearbeiten</flux:menu.item>
                <flux:menu.separator />
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item type="submit" icon="arrow-right-start-on-rectangle" variant="danger">Abmelden</flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </div>
</flux:header>
