<x-layouts::app title="Label">
    <x-docs-page :navigation="['Label' => ['label-demo' => 'Demo', 'label-usage' => 'Usage', 'label-attributes' => 'Attributes', 'assets' => 'Assets']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="label">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">FORM CONTROL</p>
                <h1 class="text-3xl font-semibold">Label</h1>
                <p>A label with an optional required marker.</p>
            </header>
            <section id="label-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div id="label-blade" class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.label-blade')
                </div>
            </section>
            <section id="label-usage" class="space-y-3">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.label')
            </section>
            <div id="label-attributes">
                @include('blade-components.attributes.label')
            </div>
            <section id="assets" class="space-y-3">
                <h2 class="text-xl font-medium">Assets</h2>
                <p>Load the package CSS. No JavaScript is needed.</p>
                <p>Labels have no outer margin. Set spacing on your label-and-input wrapper.</p>
                <p>Use <x-sirius::code>--sir-color-danger</x-sirius::code> to change the required-marker and error color.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>