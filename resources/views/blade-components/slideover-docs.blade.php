<x-layouts::app title="Slideover">
    <x-docs-page :navigation="['Slideover' => ['slideover-demo' => 'Demo', 'slideover-usage' => 'Usage', 'slideover-attributes' => 'Attributes'], 'Shared' => ['assets-and-interaction' => 'Assets and interaction', 'state-and-events' => 'State and events', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">LAYOUT</p>
                <h1 class="text-3xl font-semibold">Slideover</h1>
                <p>Open a panel from any viewport edge.</p>
            </header>
            <section id="slideover-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="livewire">
                    <h3 class="font-medium">Livewire</h3>
                    <livewire:examples.slideover-form-example />
                </div>
                <div class="space-y-4 rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">
                    <h3 class="font-medium">Blade</h3>
                    @include('blade-components.demos.slideover-right')
                    @include('blade-components.demos.slideover-left')
                    @include('blade-components.demos.slideover-top')
                    @include('blade-components.demos.slideover-bottom')
                </div>
            </section>
            <section id="slideover-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.slideover')
            </section>
            <section id="slideover-attributes">
                @include('blade-components.attributes.slideover')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Uses Dialog internally. The body scrolls while the header and footer remain visible. The panel slides in and out; reduced-motion preferences disable the animation.</p>
                <p>One Dialog, Alert, or Slideover can be active at a time. Opening another closes the previous one. Nested overlays are unsupported.</p>
                <p>Background scrolling is locked without moving sticky or fixed content. Closing restores focus and previous scroll styles. Section IDs use the root ID plus <code>-header</code>, <code>-body</code>, or <code>-footer</code>.</p>
            </section>
            <section id="state-and-events" class="space-y-3">
                <h2 class="text-xl font-medium">State and events</h2>
                <p>Uses the Dialog controls and events: <code>data-sir-dialog-open="id"</code>, <code>data-sir-dialog-close</code>, and <code>dialog:show</code>/<code>dialog:hide</code> with <code>detail: { id }</code>.</p>
                <p><code>dialog:open</code> and <code>dialog:close</code> bubble from the root with <code>detail.id</code> and <code>detail.reason</code>. Alpine can bind <code>x-bind:data-open</code>; Livewire can pass <code>:open</code> and synchronize its state on close.</p>
                @include('blade-components.examples.slideover-binding')
                <p>IDs default to five random characters. Use an explicit ID and <code>wire:key</code> for stable Livewire identity. Keep an explicit close action when disabling dismissal.</p>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>The built-in Close button uses Dialog translations. Edit the <code>dialog</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.dialog-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
