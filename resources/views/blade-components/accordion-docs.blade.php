<x-layouts::app title="Accordion">
    <x-docs-page :navigation="['Accordion' => ['accordion-demo' => 'Demo', 'accordion-usage' => 'Usage', 'accordion-attributes' => 'Attributes']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">LAYOUT</p>
                <h1 class="text-3xl font-semibold">Accordion</h1>
                <p>Show supporting information on demand.</p>
            </header>
            <section id="accordion-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.accordion-returns')
                </div>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    @include('blade-components.demos.accordion-group')
                </div>
            </section>
            <section id="accordion-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.accordion')
            </section>
            <section id="accordion-attributes">
                @include('blade-components.attributes.accordion')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Uses native <code>details</code>/<code>summary</code>. Set the HTML <code>open</code> attribute for an initially expanded section. Enter and Space toggle the focused summary. Closed content is excluded from keyboard navigation.</p>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>JavaScript synchronizes <code>aria-expanded</code>, restores focus to the trigger when focused content is closed, and emits <code>accordion:toggle</code> with <code>detail.id</code> and <code>detail.open</code>. Native disclosure still works without JavaScript.</p>
                <p>For Alpine, use <code>x-bind:open</code> and the toggle event. For Livewire, pass <code>:open</code> and synchronize user toggles as shown below. Server renders otherwise restore the supplied state. Use a stable ID and <code>wire:key</code>; direct <code>wire:model</code> is not supported.</p>
                @include('blade-components.examples.accordion-livewire')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
