<x-layouts::app title="Datetime Picker">
    <x-docs-page :navigation="['Datetime Picker' => ['datetime-picker-demo' => 'Demo', 'datetime-picker-usage' => 'Usage', 'datetime-picker-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction', 'global-configuration' => 'Global configuration']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="datetime-picker">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">Datetime Picker</h1>
                <p>Using <a href="https://flatpickr.js.org/" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:underline">flatpickr</a> as a base, the datetime picker is a form control that allows users to select a date and time.</p>
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
                <p>Labels, helpers, error keys, named error bags, and stable explicit IDs follow the shared field contract. The examples submit wall-clock strings: <code>2028-02-29</code>, <code>09:30</code>, and <code>2028-12-31 14:30:45</code>. Display formatting never converts these values to UTC.</p>
                <p>The native controller and Livewire action validate the canonical format, travel-year bounds, reminder, and unavailable departure date. Demos use <code>novalidate</code> to demonstrate server errors. Nothing is persisted. Applications own timezone conversion and validation of ambiguous or nonexistent daylight-saving times.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Flatpickr 4.6.13 and its locales/styles are bundled internally in the package assets under the MIT license. Import assets once or publish <code>sirius-ui-assets</code>; retain the bundled third-party notices. No CDN, key, or second Alpine instance is required.</p>
                @include('blade-components.examples.assets')
                <p>Type in the displayed format or use the popup. Invalid input remains visible and fails client validity; it is passed unchanged to server validation rather than silently converted to another date. Native pages without JavaScript use a plain text field and must receive canonical values.</p>
                <p>Input/change/blur/Enter events are forwarded to the canonical binding input. Livewire and Alpine string bindings support deferred, live/debounce, change/lazy, blur, and Enter timing; numeric/boolean casts are rejected. Consumer listeners on the visible input receive display text. Programmatic native updates set <code>[data-sir-date-value]</code> and dispatch input when a bound model must update.</p>
                <p>Each widget owns one instance and cleans it up after removal or navigation. Native reset, server updates, and readonly/disabled changes resynchronize the picker. Explicit IDs are recommended across Livewire renders. The custom picker also runs on mobile for consistent formatting and bounds.</p>
                <p>Additional serializable options are listed in Attributes. Lifecycle callbacks, custom parsing, HTML arrows, plugins, range/multiple selection, DOM placement, and alternate-input ownership are not exposed in this release. The supplied timezone sets the initial calendar day; values remain wall-clock strings without an offset.</p>
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Publish the package configuration to customize defaults in your application. Missing or null values fall through at render time: timezone uses sirius-ui.timezone → app.timezone → UTC; locale uses sirius-ui.locale → app.locale → app.fallback_locale → en. Explicit invalid values still produce configuration errors. Keep the other existing configuration entries. After changing cached configuration, rebuild the application config cache.</p>
                @include('blade-components.examples.datetime-picker-config')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
