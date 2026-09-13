<x-layouts::app title="Label">
    <x-docs-page :navigation="['Label' => ['label-demo' => 'Demo', 'label-usage' => 'Usage', 'label-attributes' => 'Attributes'], 'Shared' => ['shared-field-contract' => 'Shared field contract', 'assets-and-interaction' => 'Assets and interaction']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8" data-control-demo="label">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">FORM CONTROLS</p>
                <h1 class="text-3xl font-semibold">Label</h1>
                <p>A clear name for every control, with an optional red required marker.</p>
            </header>
            <section id="label-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <p>Collect a billing email and an optional purchase order for a workspace subscription.</p>
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
                <p>Set required on the associated control and link helpers/errors yourself when using a standalone label. The field and dedicated input components handle these relationships automatically.</p>
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the Sirius stylesheet for labels and the required marker. Label requires no JavaScript. Clicking a label focuses its associated control; the marker is hidden from assistive technology because required state belongs to the control.</p>
                <p>Customize <code>--sir-color-danger</code> to change the marker color consistently with field errors.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>