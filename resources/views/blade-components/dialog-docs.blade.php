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
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Uses native <code>dialog</code> for focus containment and inactive background content. Background scrolling is locked without removing scrollbar space; previous scroll styles and focus are restored on close or removal.</p>
                <p>The dialog and backdrop fade in and out. Reduced-motion preferences disable the animation. Focus and scroll lock remain active until the closing fade finishes.</p>
                <p>The body scrolls independently while the header and footer remain visible.</p>
                <p>The header supplies the accessible name. Without a header, provide <code>aria-label</code> or <code>aria-labelledby</code>. Section IDs use the root ID plus <code>-header</code>, <code>-body</code>, or <code>-footer</code>. Use an explicit ID and <code>wire:key</code> for stable Livewire identity.</p>
                <p>One Dialog, Alert, or Slideover can be active at a time. Opening another closes the previous one. Nested overlays are unsupported.</p>
            </section>
            <section id="state-and-events" class="space-y-3">
                <h2 class="text-xl font-medium">State and events</h2>
                <p>Use <code>data-sir-dialog-open="id"</code> on a trigger. Use <code>data-sir-dialog-close</code> inside the dialog, or give it a target ID outside. Use buttons with <code>type="button"</code> for these actions.</p>
                <p>Alpine can bind <code>x-bind:data-open</code>. Livewire uses <code>:open</code> and the close event below; unsynchronized server renders restore the supplied state. Content and validation updates do not reset focus or reopen an active dialog.</p>
                @include('blade-components.examples.dialog-livewire')
                <p>Dispatch <code>dialog:show</code> or <code>dialog:hide</code> on document with <code>detail: { id }</code> for programmatic control. Do not toggle the native HTML <code>open</code> attribute.</p>
                <p><code>dialog:open</code> and <code>dialog:close</code> bubble from the component with <code>detail.id</code> and <code>detail.reason</code>. Close reasons are <code>button</code>, <code>escape</code>, <code>backdrop</code>, <code>state</code>, <code>api</code>, <code>native</code>, <code>replaced</code>, <code>removed</code>, or <code>navigation</code>. Nested requests emit <code>dialog:blocked</code>.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <code>dialog</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.dialog-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
