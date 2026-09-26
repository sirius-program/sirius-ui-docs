<x-layouts::app title="Label">
    <x-docs-page :navigation="['Label' => ['label-demo' => 'Demo', 'label-usage' => 'Usage', 'label-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="label">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">Label</h1>
                <p>A label with an optional required marker.</p>
            </header>
            <section id="label-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.field-example :label-only="true" />
                </div>
                <div id="label-blade" class="space-y-4 rounded-xl border border-zinc-200 p-6 dark:border-zinc-700" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.label-blade')
                </div>
            </section>
            <section id="label-usage" class="space-y-3">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.label')
            </section>
            <div id="label-attributes">@include('blade-components.attributes.label')</div>
            <section id="shared-field-contract" class="space-y-3">
                <h2 class="text-xl font-medium">Shared field contract</h2>
                <p>For standalone labels, set <code>required</code> on the input and link helper/error text yourself. Field and input components handle this automatically.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Load the package CSS. No JavaScript is needed.</p>
                <p>Labels have no outer margin. Set spacing on your label-and-input wrapper.</p>
                <p>Use <code>--sir-color-danger</code> to change the required-marker and error color.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>