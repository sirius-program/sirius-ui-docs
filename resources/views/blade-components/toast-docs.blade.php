<x-layouts::app title="Toast">
    <x-docs-page :navigation="['Toast' => ['toast-demo' => 'Demo', 'toast-usage' => 'Usage', 'toast-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'state-and-events' => 'State and events', 'global-configuration' => 'Global configuration', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">PRESENTATION</p>
                <h1 class="text-3xl font-semibold">Toast</h1>
                <p>Show a short notification without interrupting the current task.</p>
            </header>
            <section id="toast-demo" class="space-y-5">
                <h2 class="text-xl font-medium">Demo</h2>
                @foreach (['toast-variants', 'toast-positions',  'toast-actions'] as $demo)
                    <div class="rounded-xl border border-slate-300 p-6 dark:border-slate-600" data-demo-mode="blade">@include('blade-components.demos.'.$demo)</div>
                @endforeach
            </section>
            <section id="toast-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('blade-components.examples.toast')
            </section>
            <section id="toast-attributes">
                @include('blade-components.attributes.toast')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Timers pause while hovered, focused, or the browser tab is hidden. Entry and exit use fade and slide; reduced motion disables the animation.</p>
                <p>Up to three notifications appear at once across all positions. The next 20 wait in order; overflow removes the oldest waiting notification. Waiting timers start when shown. Opening the same ID again restarts its timer without adding a duplicate.</p>
                <p>Toasts do not lock scrolling or take focus. They remain interactive above Dialog and Slideover. Navigation clears visible and waiting notifications.</p>
                <p>Requires a browser with the native Popover API. Notifications use polite announcements; danger notifications use assertive announcements.</p>
            </section>
            <section id="state-and-events" class="space-y-3">
                <h2 class="text-xl font-medium">State and events</h2>
                <p>Render the Toast first, then open or close it by ID with <code>data-sir-toast-open</code>, <code>data-sir-toast-close</code>, or <code>toast:show</code>/<code>toast:hide</code> with <code>detail: { id }</code>. Events do not create new Toasts from payload content.</p>
                <p><code>toast:open</code> and <code>toast:close</code> bubble from the wrapper with <code>detail.id</code> and <code>detail.reason</code>. Close reasons include button, escape, api, state, timeout, overflow, removed, and navigation. Queued notifications emit open only when shown.</p>
                @include('blade-components.examples.toast-binding')
                <p>For Alpine, bind <code>x-bind:data-open</code> and update your state from <code>toast:close</code>. Unrelated Livewire renders preserve visible state and do not revive closed notifications.</p>
            </section>
            <section id="global-configuration" class="space-y-3">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Publish <code>sirius-ui-config</code> and change the default duration and position in <code>config/sirius-ui.php</code>.</p>
                @include('blade-components.examples.toast-config')
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>The built-in Close button uses Dialog translations. Edit the <code>dialog</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>. This translation is used only for accessibility.</p>
                @include('blade-components.examples.dialog-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
