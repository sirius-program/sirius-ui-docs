<x-layouts::app title="Dialog">
    <x-docs-page :navigation="['Dialog' => ['dialog-demo' => 'Demo', 'dialog-usage' => 'Usage', 'dialog-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'state-and-events' => 'State and events', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">LAYOUT</p>
                <h1 class="text-3xl font-semibold">Dialog</h1>
                <p>Show focused content above the page.</p>
            </header>
            <section id="dialog-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.dialog-form-example />
                </div>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.dialog-summary')
                    @include('blade-components.demos.dialog-form-blade')
                </div>
            </section>
            <section id="dialog-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.dialog')
            </section>
            <section id="dialog-attributes">
                @include('blade-components.attributes.dialog')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Uses native <x-sirius::code>dialog</x-sirius::code> for focus containment and inactive background content. Background scrolling is locked without removing scrollbar space; previous scroll styles and focus are restored on close or removal.</p>
                <p>The dialog and backdrop fade in and out. Reduced-motion preferences disable the animation. Focus and scroll lock remain active until the closing fade finishes.</p>
                <p>The body scrolls independently while the header and footer remain visible.</p>
                <p>The header supplies the accessible name. Without a header, provide <x-sirius::code>aria-label</x-sirius::code> or <x-sirius::code>aria-labelledby</x-sirius::code>. Section IDs use the root ID plus <x-sirius::code>-header</x-sirius::code>, <x-sirius::code>-body</x-sirius::code>, or <x-sirius::code>-footer</x-sirius::code>. Use an explicit ID and <x-sirius::code>wire:key</x-sirius::code> for stable Livewire identity.</p>
                <p>One Dialog, Alert, or Slideover can be active at a time. Opening another closes the previous one. Nested overlays are unsupported.</p>
            </section>
            <section id="state-and-events" class="space-y-3">
                <h2 class="text-xl font-medium">State and events</h2>
                <p>Use <x-sirius::code>data-sir-dialog-open="id"</x-sirius::code> on a trigger. Use <x-sirius::code>data-sir-dialog-close</x-sirius::code> inside the dialog, or give it a target ID outside. Use buttons with <x-sirius::code>type="button"</x-sirius::code> for these actions.</p>
                <p>Alpine can bind <x-sirius::code>x-bind:data-open</x-sirius::code>. Livewire uses <x-sirius::code>:open</x-sirius::code> and the close event below; unsynchronized server renders restore the supplied state. Content and validation updates do not reset focus or reopen an active dialog.</p>
                @include('blade-components.examples.dialog-livewire')
                <p>Dispatch <x-sirius::code>dialog:show</x-sirius::code> or <x-sirius::code>dialog:hide</x-sirius::code> on document with <x-sirius::code>detail: { id }</x-sirius::code> for programmatic control. Do not toggle the native HTML <x-sirius::code>open</x-sirius::code> attribute.</p>
                <p><x-sirius::code>dialog:open</x-sirius::code> and <x-sirius::code>dialog:close</x-sirius::code> bubble from the component with <x-sirius::code>detail.id</x-sirius::code> and <x-sirius::code>detail.reason</x-sirius::code>. Close reasons are <x-sirius::code>button</x-sirius::code>, <x-sirius::code>escape</x-sirius::code>, <x-sirius::code>backdrop</x-sirius::code>, <x-sirius::code>state</x-sirius::code>, <x-sirius::code>api</x-sirius::code>, <x-sirius::code>native</x-sirius::code>, <x-sirius::code>replaced</x-sirius::code>, <x-sirius::code>removed</x-sirius::code>, or <x-sirius::code>navigation</x-sirius::code>. Nested requests emit <x-sirius::code>dialog:blocked</x-sirius::code>.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <x-sirius::code>dialog</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.dialog-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
