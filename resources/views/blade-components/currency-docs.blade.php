<x-layouts::app title="Currency">
    <x-docs-page :navigation="['Currency' => ['currency-demo' => 'Demo', 'currency-usage' => 'Usage', 'currency-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction', 'global-configuration' => 'Global configuration']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="currency">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">Currency</h1>
                <p>Currency input with configurable number formatting.</p>
            </header>
            <section id="currency-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.currency-example />
                </div>
                <div id="currency-blade" class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.currency-blade')
                </div>
            </section>
            <section id="currency-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.currency')
            </section>
            <section id="currency-attributes">
                @include('blade-components.attributes.currency')
            </section>
            <section id="shared-field-contract" class="space-y-3">
                <h2 class="text-xl font-medium">Shared field contract</h2>
                <p>Labels, helper text, and Laravel or Livewire validation errors are linked automatically.</p>
                <p>Use strings for amounts: <code>1,234.50</code> is displayed, while <code>1234.50</code> is submitted. Prefixes and suffixes are excluded.</p>
                <p>Validate the submitted decimal string, including its sign, precision, and limits.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>

                @include('blade-components.examples.assets')
                <p>Separators are added as you type. Pasted text must match the configured format; invalid pastes leave the value unchanged. A trailing decimal is removed on blur. A lone minus submits an empty value.</p>
                <p>Form resets and Livewire updates refresh the display. Without JavaScript, the field submits text as entered. Readonly values are submitted; disabled values are omitted.</p>
                <p>For JavaScript updates, set <code>[data-sir-currency-value].value</code> and dispatch <code>input</code>. Events on the visible input contain formatted text.</p>
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Publish the config to set default separators and precision. Missing or null settings use comma, dot, and 2 decimal places. Component props override these defaults.</p>
                @include('blade-components.examples.currency-config')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
