<x-layouts::app title="Datetime Picker">
    <x-docs-page :navigation="['Datetime Picker' => ['datetime-picker-demo' => 'Demo', 'datetime-picker-usage' => 'Usage', 'datetime-picker-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'global-configuration' => 'Global configuration', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="datetime-picker">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">FORM CONTROL</p>
                <h1 class="text-3xl font-semibold">Datetime Picker</h1>
                <p>Date and time selection components, powered by <x-sirius::link href="https://flatpickr.js.org/" target="_blank" rel="noopener noreferrer">flatpickr</x-sirius::link>.</p>
            </header>
            <section id="datetime-picker-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.datetime-picker-example />
                </div>
                <div id="datetime-picker-blade" class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.datetime-picker-blade')
                </div>
            </section>
            <section id="datetime-picker-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.datetime-picker')
            </section>
            <section id="datetime-picker-attributes" class="space-y-3">
                <h2 class="text-xl font-medium">Attributes</h2>
                @include('blade-components.attributes.datetime-picker')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                <p>Flatpickr and its locales are bundled. No CDN or API key is needed.</p>
                @include('blade-components.examples.assets')
                <p>Choose from the popup or type in the display format. Invalid text stays visible for validation. Without JavaScript, enter the submitted format directly.</p>
                <p>Livewire and Alpine bindings accept strings and support deferred, live/debounce, change/lazy, blur, and Enter updates. Number and boolean modifiers are unsupported. For JavaScript updates, set <x-sirius::code>[data-sir-date-value].value</x-sirius::code> and dispatch <x-sirius::code>input</x-sirius::code>. Visible-input events contain display text.</p>
                <p>Form resets, server updates, and readonly/disabled changes refresh the picker. Use stable IDs with Livewire.</p>
                <p>Only the Flatpickr options listed in Attributes are supported. Range and multiple selection are unavailable.</p>
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Publish the config to set defaults. Timezone falls back through <x-sirius::code>sirius-ui.timezone &rarr; app.timezone &rarr; UTC</x-sirius::code>. Locale falls back through <x-sirius::code>sirius-ui.locale &rarr; app.locale &rarr; app.fallback_locale &rarr; en</x-sirius::code>. Invalid explicit values are rejected.</p>
                @include('blade-components.examples.datetime-picker-config')
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>These are translation string used for client-side validation and messages, for server-side use Laravel's translation string. These strings follow the application locale. The <x-sirius::code>locale</x-sirius::code> prop controls calendar month and weekday names.</p>
                <p>Edit the <x-sirius::code>datetime-picker</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>.</p>
                @include('blade-components.examples.datetime-picker-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
