<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="sir-scrollbar">
    <head>
        @include('partials.head')
    </head>
    <body class="docs-shell landing-shell">
        <x-sirius::link href="#landing-main" class="docs-skip-link">Skip to content</x-sirius::link>
        <header class="landing-header">
            <div class="landing-header-inner">
                <x-app-logo :href="route('home')" wire:navigate />
                <nav aria-label="Main navigation" class="landing-header-actions">
                    <x-sirius::link :href="route('started.introduction')" wire:navigate>Documentation</x-sirius::link>
                    <x-sirius::dropdown id="landing-appearance-menu" align="end" content-role="dialog">
                        <x-slot:trigger aria-label="Change appearance" title="Change appearance">
                            <x-sirius::icon name="heroicon-o-computer-desktop" />
                        </x-slot:trigger>
                        <x-appearance-options prefix="landing" />
                    </x-sirius::dropdown>
                </nav>
            </div>
        </header>
        <main id="landing-main" class="landing-main" tabindex="-1">{{ $slot }}</main>
        <footer class="landing-footer">
            <p>Sirius UI &middot; Components for Laravel Blade and Livewire.</p>
            <x-sirius::link :href="route('started.license')" wire:navigate>MIT license</x-sirius::link>
        </footer>
        @livewireScripts
    </body>
</html>
