<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="sir-scrollbar">
    <head>@include('partials.head')</head>
    <body class="docs-shell">
        <a href="#docs-main" class="docs-skip-link">Skip to content</a>
        <aside class="docs-sidebar" data-docs-sidebar>
            <div class="docs-sidebar-brand"><x-app-logo :href="route('dashboard')" wire:navigate /></div>
            <div class="docs-sidebar-scroll"><x-docs-navigation prefix="desktop" /></div>
        </aside>
        <div class="docs-workspace">
            <x-app-header :title="$title ?? null" />
            {{ $slot }}
        </div>
        <x-sirius::slideover id="docs-navigation" side="left" size="sm" class="docs-mobile-navigation"
            header-class="docs-mobile-header" body-class="docs-mobile-body" data-docs-mobile-navigation>
            <x-slot:header><x-app-logo :href="route('dashboard')" wire:navigate /></x-slot:header>
            <x-slot:body><x-docs-navigation prefix="mobile" /></x-slot:body>
        </x-sirius::slideover>
        @livewireScripts
    </body>
</html>
