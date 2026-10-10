<x-layouts::app title="Popover">
    <x-docs-page :navigation="['Popover' => ['popover-demo' => 'Demo', 'popover-usage' => 'Usage', 'popover-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'state-and-events' => 'State and events', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Popover</h1>
                <p>Show extra content without leaving the page.</p>
            </header>
            <section id="popover-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.popover-project')
                </div>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.popover-filter')
                </div>
            </section>
            <section id="popover-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.popover')
            </section>
            <section id="popover-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.popover')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Requires a browser with the Popover API. Panels stay above scrollable content, including Dialog and Slideover. Fades respect reduced motion.</p>
                <p>The arrow follows the trigger when the panel flips or shifts.</p>
                <p>Click, Enter, or Space toggles the panel. Opening moves focus into its content; Escape and close actions return focus to the trigger. Outside click or tabbing out closes it without moving focus. Popover does not trap focus.</p>
                <p>Works with Alpine changes, Livewire updates, and navigation. Use an explicit ID and <x-sirius::code>wire:key</x-sirius::code> for stable Livewire identity.</p>
            </section>
            <section id="state-and-events" class="space-y-3">
                <h2 class="text-xl font-medium">State and events</h2>
                <p>Listen for <x-sirius::code>popover:open</x-sirius::code> and <x-sirius::code>popover:close</x-sirius::code> on the root. Events bubble with <x-sirius::code>event.detail.id</x-sirius::code> and <x-sirius::code>event.detail.reason</x-sirius::code>. Client open state survives unrelated Livewire updates.</p>
                <p>Put <x-sirius::code>data-sir-popover-close</x-sirius::code> on an action to close the panel. Opening another Popover closes the previous one; nested panels close before their parent.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <x-sirius::code>popover</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.popover-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
