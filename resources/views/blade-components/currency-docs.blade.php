<x-layouts::app title="Currency">
    <x-docs-page :navigation="['Currency' => ['currency-demo' => 'Demo', 'currency-usage' => 'Usage', 'currency-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="currency">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">Currency</h1>
                <p>An input component for currency values with flexible formatting.</p>
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
                <p>Labels, helpers, named error bags, nested names, and error keys follow the shared field contract. Keep monetary model values as strings: display <code>1,234.50</code>, bind and submit <code>1234.50</code>. Prefixes and suffixes are never submitted.</p>
                <p>Validate canonical strings on the server. These demos use an anchored decimal regex and a string length limit; budget rejects negative amounts and more than two fractional digits, while adjustment allows a sign and three fractional digits. The demos deliberately use <code>novalidate</code> to show server errors. No amounts are persisted.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package assets once, or publish <code>sirius-ui-assets</code> and load the published CSS and JavaScript. No extra library is needed.</p>
                @include('blade-components.examples.assets')
                <p>Typing inserts thousands separators and preserves the caret. Paste trims surrounding whitespace and validates the configured grouping; malformed groups, currency symbols, exponent notation, and mixed locale formats reject the entire paste without changing the previous amount. A leading decimal becomes <code>0.5</code>; a trailing decimal remains while editing and disappears on blur. A lone minus is an incomplete edit with an empty canonical value.</p>
                <p>Native reset, Livewire updates, conditional remounts, and navigation resynchronize the display. JavaScript maintains one named canonical input; without JavaScript the visible input submits unformatted text. Server validation is required in both cases. Disabled controls are omitted and readonly amounts remain submitted.</p>
                <p>For programmatic plain JavaScript updates, set the value of <code>[data-sir-currency-value]</code> inside the control wrapper; dispatch its input event when a model binding should also update. Input/change/blur events on the visible control are forwarded to that binding input. Consumer listeners on the visible control see formatted text.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
