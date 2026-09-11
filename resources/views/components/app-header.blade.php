@props([
    'title' => null,
])

<flux:header sticky class="border-b border-zinc-200 bg-white/95 py-3 backdrop-blur dark:border-zinc-700 dark:bg-zinc-900/95">
    <div class="flex min-w-0 items-center gap-3">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <div class="min-w-0">
            <flux:heading size="lg" level="1" class="truncate">
                {{ $title ?? config('app.name', 'Laravel') }}
            </flux:heading>

            {{ Breadcrumbs::view('partials.breadcrumbs') }}
        </div>
    </div>

    <flux:spacer />

    <flux:dropdown position="bottom" align="end">
        <flux:button
            variant="subtle"
            icon="computer-desktop"
            aria-label="{{ __('Change appearance') }}"
        />

        <flux:menu>
            <flux:menu.radio.group x-data x-model="$flux.appearance">
                <flux:menu.radio value="light">{{ __('Light') }}</flux:menu.radio>
                <flux:menu.radio value="dark">{{ __('Dark') }}</flux:menu.radio>
                <flux:menu.radio value="system">{{ __('System') }}</flux:menu.radio>
            </flux:menu.radio.group>
        </flux:menu>
    </flux:dropdown>
</flux:header>
