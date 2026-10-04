<x-layouts::app title="Tabs">
    <x-docs-page :navigation="['Tabs' => ['tabs-demo' => 'Demo', 'tabs-usage' => 'Usage', 'tabs-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction', 'state-and-events' => 'State and events', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">LAYOUT</p>
                <h1 class="text-3xl font-semibold">Tabs</h1>
                <p>Organize related content into local panels.</p>
            </header>
            <section id="tabs-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">@include('blade-components.demos.tabs-project')</div>
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">@include('blade-components.demos.tabs-settings')</div>
            </section>
            <section id="tabs-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.tabs')
            </section>
            <section id="tabs-attributes">@include('blade-components.attributes.tabs')</section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Use Left/Right arrows for horizontal tabs and Up/Down for vertical tabs. Home and End move to the first and last enabled tab. Tab moves into the selected panel.</p>
                <p>All panels are rendered and stay in the DOM. Switching hides inactive panels and removes them from keyboard navigation; form values are preserved. Hidden controls remain part of form submission. Applications handle validation and select the panel containing an invalid field.</p>
                <p>Works with Alpine changes, Livewire updates, and navigation. Use an explicit ID and <code>wire:key</code> for stable Livewire identity.</p>
            </section>
            <section id="state-and-events" class="space-y-3">
                <h2 class="text-xl font-medium">State and events</h2>
                <p>Listen for <code>tabs:change</code> on the wrapper. Events bubble with <code>detail.id</code>, <code>detail.value</code>, <code>detail.previous</code>, and <code>detail.reason</code>. Local selection survives unrelated Livewire updates; changes to <code>active</code> select the requested panel.</p>
                @include('blade-components.examples.tabs-binding')
                <p>For Alpine, bind <code>x-bind:data-active</code> and update your state from <code>tabs:change</code>. Check <code>$event.target === $el</code> when nesting Tabs.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <code>tabs</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.tabs-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
