<x-layouts::app title="Chart · Extensions">
    <x-docs-page :navigation="['Extensions' => ['chart-demo' => 'Demo', 'chart-usage' => 'Usage', 'local-extensions' => 'Local extensions', 'lifecycle' => 'Lifecycle']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">CHART</p>
                <h1 class="text-3xl font-semibold">Extensions</h1>
                <p>Add local callbacks and plugins without sending JavaScript through Livewire.</p>
            </header>
            <section id="chart-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.chart-extensions')
                </div>
            </section>
            <section id="chart-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.chart-extensions')
            </section>
            <section id="local-extensions" class="space-y-4">
                <h2 class="text-xl font-medium">Local extensions</h2>
                <p>After package scripts load, call <code>SiriusChart.register(id, factory)</code>. The factory receives <code>id</code>, root <code>element</code>, child <code>wire</code>, and the native Chart.js <code>library</code>. Return <code>options</code> and an optional native <code>plugins</code> array. One factory applies per chart ID.</p>
                <p>Use functions for tooltip labels, axis ticks, click handlers, and plugin hooks. Dispatch events with <code>wire.dispatch()</code> to an application listener. Validate its indexes and authorize any server action there.</p>
                <p>The adapter owns canvas, type/data synchronization, resizing, loading, disposal, and the <code>siriusTheme</code> plugin. Factories cannot replace those fields. Native callbacks and plugin hooks run alongside synchronization; JavaScript strings from PHP are never evaluated.</p>
                <p>Custom controllers, scales, or global plugins can be installed by calling <code>library.register()</code> from your application factory. Their dependencies and compatibility belong to the application. The example uses a free inline plugin.</p>
            </section>
            <section id="lifecycle" class="space-y-4">
                <h2 class="text-xl font-medium">Lifecycle</h2>
                <p>The returned function removes your registration. Call it when the registration is no longer needed; Alpine's <code>destroy()</code> is one place to do so. Release plugin resources in Chart.js <code>afterDestroy</code>.</p>
                <p><code>SiriusChart.get(id)</code> returns the native instance or null after removal. Use it for local inspection, export, or interaction. Persistent data/options changes belong in the parent props, because the next render restores those props.</p>
                <p>The root emits <code>sirius:chart-ready</code> with the chart instance after creation and <code>sirius:chart-error</code> after a rendering failure. Both events bubble. Retry uses the current props and factory.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
