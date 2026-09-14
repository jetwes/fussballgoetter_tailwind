<div class="space-y-6">
    <div class="space-y-2">
        <flux:skeleton class="h-8 w-40" />
        <flux:skeleton class="h-4 w-72" />
    </div>
    <flux:card class="space-y-4">
        <flux:skeleton class="h-5 w-32" />
        @for ($i = 0; $i < 6; $i++)
            <div class="flex items-center gap-3">
                <flux:skeleton class="size-8 rounded-full" />
                <flux:skeleton class="h-4 flex-1" />
                <flux:skeleton class="h-4 w-12" />
            </div>
        @endfor
    </flux:card>
    <flux:card class="space-y-4">
        <flux:skeleton class="h-5 w-40" />
        @for ($i = 0; $i < 4; $i++)
            <flux:skeleton class="h-4 w-full" />
        @endfor
    </flux:card>
</div>
