<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
                <flux:sidebar.group :heading="__('Sirius UI')" class="grid">
                    <flux:sidebar.item :href="route('components.index')" :current="request()->routeIs('components.index')" wire:navigate>
                        {{ __('Components') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item :href="route('components.label')" :current="request()->routeIs('components.label')" wire:navigate>Label</flux:sidebar.item>
                    <flux:sidebar.item :href="route('components.forms')" :current="request()->routeIs('components.forms')" wire:navigate>Form conventions</flux:sidebar.item>
                    @foreach (['input' => 'Input', 'textarea' => 'Textarea', 'choices' => 'Checkbox, Radio & Switch'] as $control => $controlLabel)
                        <flux:sidebar.item :href="route('components.control', ['control' => $control])" :current="request()->route('control') === $control" wire:navigate>{{ $controlLabel }}</flux:sidebar.item>
                    @endforeach
                </flux:sidebar.group>
            </flux:sidebar.nav>
        </flux:sidebar>

        <x-app-header :$title />

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
