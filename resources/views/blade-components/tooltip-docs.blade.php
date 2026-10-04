<x-layouts::app title="Tooltip">
    <x-docs-page :navigation="['Tooltip' => ['tooltip-demo' => 'Demo', 'tooltip-usage' => 'Usage', 'tooltip-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Tooltip</h1>
                <p>Show a short hint for a control.</p>
            </header>
            <section id="tooltip-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    @include('blade-components.demos.tooltip-project')
                </div>
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    @include('blade-components.demos.tooltip-icon')
                </div>
            </section>
            <section id="tooltip-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.tooltip')
            </section>
            <section id="tooltip-attributes">
                @include('blade-components.attributes.tooltip')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Requires a browser with the Popover API. Panels stay above scrollable content, including Dialog and Slideover. Fades respect reduced motion.</p>
                <p>The arrow follows the trigger when the panel flips or shifts.</p>
                <p>Hover or focus the trigger to show the hint; Escape dismisses it. Keep an accessible name on icon-only triggers. Tooltip content cannot contain interactive controls, if you want to add interactive controls, use <a href="{{ route('blade-components.popover') }}" wire:navigate class="text-blue-500 dark:text-blue-400 hover:underline">Popover</a> component instead.</p>
                <p>Works with Alpine changes, Livewire updates, and navigation. Use an explicit ID and <code>wire:key</code> for stable Livewire identity.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
