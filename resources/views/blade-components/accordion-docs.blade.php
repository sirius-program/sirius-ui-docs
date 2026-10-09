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
                <p>Uses native <x-sirius::code>details</x-sirius::code>/<x-sirius::code>summary</x-sirius::code>. Set the HTML <x-sirius::code>open</x-sirius::code> attribute for an initially expanded section. Enter and Space toggle the focused summary. Closed content is excluded from keyboard navigation.</p>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>JavaScript synchronizes <x-sirius::code>aria-expanded</x-sirius::code>, restores focus to the trigger when focused content is closed, and emits <x-sirius::code>accordion:toggle</x-sirius::code> with <x-sirius::code>detail.id</x-sirius::code> and <x-sirius::code>detail.open</x-sirius::code>. Native disclosure still works without JavaScript.</p>
                <p>For Alpine, use <x-sirius::code>x-bind:open</x-sirius::code> and the toggle event. For Livewire, pass <x-sirius::code>:open</x-sirius::code> and synchronize user toggles as shown below. Server renders otherwise restore the supplied state. Use a stable ID and <x-sirius::code>wire:key</x-sirius::code>; direct <x-sirius::code>wire:model</x-sirius::code> is not supported.</p>
                @include('blade-components.examples.accordion-livewire')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
