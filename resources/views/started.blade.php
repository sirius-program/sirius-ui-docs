<x-layouts::app :title="__('Getting Started')">
    <x-docs-page :navigation="['Getting Started' => ['overview' => 'Overview', 'blade-components' => 'Blade components']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header id="overview" class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">SIRIUS UI COMPONENTS</p>
                <h1 class="text-3xl font-semibold">Getting Started</h1>
            </header>
            <p>Reusable Blade and Livewire components. The local package is connected; public components will be added as their implementation phases are completed. Use the documentation README for local installation, assets, architecture rules, and the implementation checklist.</p>
            <section id="blade-components" class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                <h2 class="text-lg font-medium">Blade Components</h2>
                <ul class="list-disc pl-5 mt-3 space-y-3">
                    <li><a class="underline" href="{{ route('blade-components.label') }}" wire:navigate>Label</a></li>
                    @foreach (['input' => 'Input', 'textarea' => 'Textarea', 'choices' => 'Checkbox, Radio & Switch'] as $control => $controlLabel)
                        <li><a class="underline" href="{{ route('blade-components.control', ['control' => $control]) }}" wire:navigate>{{ $controlLabel }}</a></li>
                    @endforeach
                </ul>
                <p class="mt-4">Basic controls are available. Currency and enhanced widgets follow in later phases.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
