<x-layouts::app title="Datetime Picker">
    <x-docs-page :navigation="['Datetime Picker' => ['datetime-picker-demo' => 'Demo', 'datetime-picker-usage' => 'Usage', 'datetime-picker-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction', 'global-configuration' => 'Global configuration']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="datetime-picker">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">Datetime Picker</h1>
                <p>Date and time selection components, powered by <a href="https://flatpickr.js.org/" target="_blank" rel="noopener noreferrer" class="text-blue-500 dark:text-blue-400 hover:underline">flatpickr</a>.</p>
            </header>
            <section id="datetime-picker-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.datetime-picker-example />
                </div>
                <div id="datetime-picker-blade" class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.datetime-picker-blade')
                </div>
            </section>
            <section id="datetime-picker-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.datetime-picker')
            </section>
            <section id="datetime-picker-attributes">
                @include('blade-components.attributes.datetime-picker')
            </section>
            <section id="shared-field-contract" class="space-y-3">
                <h2 class="text-xl font-medium">Shared field contract</h2>
                <p>Labels, helper text, and Laravel or Livewire validation errors are linked automatically.</p>
                <p>Values are submitted as local date/time strings: <code>2028-02-29</code>, <code>09:30</code>, or <code>2028-12-31 14:30:45</code>. They are not converted to UTC.</p>
                <p>Your application handles timezone conversion and daylight-saving validation.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                <p>Flatpickr and its locales are bundled. No CDN or API key is needed.</p>
                @include('blade-components.examples.assets')
                <p>Choose from the popup or type in the display format. Invalid text stays visible for validation. Without JavaScript, enter the submitted format directly.</p>
                <p>Livewire and Alpine bindings accept strings and support deferred, live/debounce, change/lazy, blur, and Enter updates. Number and boolean modifiers are unsupported. For JavaScript updates, set <code>[data-sir-date-value].value</code> and dispatch <code>input</code>. Visible-input events contain display text.</p>
                <p>Form resets, server updates, and readonly/disabled changes refresh the picker. Use stable IDs with Livewire.</p>
                <p>Only the Flatpickr options listed in Attributes are supported. Range and multiple selection are unavailable.</p>
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Publish the config to set defaults. Timezone falls back through <code>sirius-ui.timezone &rarr; app.timezone &rarr; UTC</code>. Locale falls back through <code>sirius-ui.locale &rarr; app.locale &rarr; app.fallback_locale &rarr; en</code>. Invalid explicit values are rejected.</p>
                @include('blade-components.examples.datetime-picker-config')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
