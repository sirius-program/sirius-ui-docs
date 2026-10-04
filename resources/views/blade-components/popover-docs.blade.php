<x-layouts::app title="Popover">
    <x-docs-page :navigation="['Popover' => ['popover-demo' => 'Demo', 'popover-usage' => 'Usage', 'popover-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction', 'state-and-events' => 'State and events', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Popover</h1>
                <p>Show extra content without leaving the page.</p>
            </header>
            <section id="popover-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    @include('blade-components.demos.popover-project')
                </div>
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    @include('blade-components.demos.popover-filter')
                </div>
            </section>
            <section id="popover-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.popover')
            </section>
            <section id="popover-attributes">
                @include('blade-components.attributes.popover')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Requires a browser with the Popover API. Panels stay above scrollable content, including Dialog and Slideover. Fades respect reduced motion.</p>
                <p>The arrow follows the trigger when the panel flips or shifts.</p>
                <p>Click, Enter, or Space toggles the panel. Opening moves focus into its content; Escape and close actions return focus to the trigger. Outside click or tabbing out closes it without moving focus. Popover does not trap focus.</p>
                <p>Works with Alpine changes, Livewire updates, and navigation. Use an explicit ID and <code>wire:key</code> for stable Livewire identity.</p>
            </section>
            <section id="state-and-events" class="space-y-3">
                <h2 class="text-xl font-medium">State and events</h2>
                <p>Listen for <code>popover:open</code> and <code>popover:close</code> on the root. Events bubble with <code>event.detail.id</code> and <code>event.detail.reason</code>. Client open state survives unrelated Livewire updates.</p>
                <p>Put <code>data-sir-popover-close</code> on an action to close the panel. Opening another Popover closes the previous one; nested panels close before their parent.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <code>popover</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.popover-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
