<x-layouts::app title="Tabs">
    <x-docs-page :navigation="['Tabs' => ['tabs-demo' => 'Demo', 'tabs-usage' => 'Usage', 'tabs-attributes' => 'Attributes', 'tabs-array' => 'Tab item definitions', 'assets-and-interaction' => 'Assets and interaction', 'state-and-events' => 'State and events', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">LAYOUT</p>
                <h1 class="text-3xl font-semibold">Tabs</h1>
                <p>Organize related content into local panels.</p>
            </header>
            <section id="tabs-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">@include('blade-components.demos.tabs-project')</div>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">@include('blade-components.demos.tabs-settings')</div>
            </section>
            <section id="tabs-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.tabs')
            </section>
            <section id="tabs-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.tabs')
            </section>
            <section id="tabs-array" class="space-y-3">
                <h2 class="text-xl font-medium">Tab items definitions</h2>
                @include('blade-components.attributes.tabs-array')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Use Left/Right arrows for horizontal tabs and Up/Down for vertical tabs. Home and End move to the first and last enabled tab. Tab moves into the selected panel.</p>
                <p>All panels are rendered and stay in the DOM. Switching hides inactive panels and removes them from keyboard navigation; form values are preserved. Hidden controls remain part of form submission. Applications handle validation and select the panel containing an invalid field.</p>
                <p>Works with Alpine changes, Livewire updates, and navigation. Use an explicit ID and <x-sirius::code>wire:key</x-sirius::code> for stable Livewire identity.</p>
            </section>
            <section id="state-and-events" class="space-y-3">
                <h2 class="text-xl font-medium">State and events</h2>
                <p>Listen for <x-sirius::code>tabs:change</x-sirius::code> on the wrapper. Events bubble with <x-sirius::code>detail.id</x-sirius::code>, <x-sirius::code>detail.value</x-sirius::code>, <x-sirius::code>detail.previous</x-sirius::code>, and <x-sirius::code>detail.reason</x-sirius::code>. Local selection survives unrelated Livewire updates; changes to <x-sirius::code>active</x-sirius::code> select the requested panel.</p>
                @include('blade-components.examples.tabs-binding')
                <p>For Alpine, bind <x-sirius::code>x-bind:data-active</x-sirius::code> and update your state from <x-sirius::code>tabs:change</x-sirius::code>. Check <x-sirius::code>$event.target === $el</x-sirius::code> when nesting Tabs.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <x-sirius::code>tabs</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.tabs-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
