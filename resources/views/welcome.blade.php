<x-layouts::app :title="__('Welcome')">
    <article class="mx-auto max-w-4xl space-y-8">
        <header class="space-y-3">
            <x-sirius::badge variant="primary">Sirius UI</x-sirius::badge>
            <h2 class="text-3xl font-semibold">Let's get started</h2>
            <p class="text-slate-600 dark:text-slate-300">Reusable components for Laravel Blade and Livewire.</p>
            <div class="flex flex-wrap gap-3">
                <x-sirius::button as="a" :href="route('started.introduction')" variant="primary" wire:navigate>Getting Started</x-sirius::button>
                <x-sirius::button as="a" :href="route('dashboard')" variant="outline" wire:navigate>Dashboard</x-sirius::button>
            </div>
        </header>
        <x-sirius::card header="Laravel resources">
            <x-slot:body>
                <p class="mb-4 text-slate-600 dark:text-slate-300">Laravel has a rich ecosystem. Explore the documentation and tutorials.</p>
                <div class="flex flex-wrap gap-3">
                    <x-sirius::button as="a" href="https://laravel.com/docs" variant="outline">Documentation</x-sirius::button>
                    <x-sirius::button as="a" href="https://laracasts.com" variant="outline">Laracasts</x-sirius::button>
                    <x-sirius::button as="a" href="https://cloud.laravel.com" variant="outline">Deploy now</x-sirius::button>
                </div>
            </x-slot:body>
        </x-sirius::card>
    </article>
</x-layouts::app>
