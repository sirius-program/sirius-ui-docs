<x-layouts::app title="Chart · Extensions">
    <x-docs-page :navigation="['Extensions' => ['chart-demo' => 'Demo', 'chart-usage' => 'Usage', 'local-extensions' => 'Local extensions', 'lifecycle' => 'Lifecycle']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">CHART</p>
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
                <p>After package scripts load, call <x-sirius::code>SiriusChart.register(id, factory)</x-sirius::code>. The factory receives <x-sirius::code>id</x-sirius::code>, root <x-sirius::code>element</x-sirius::code>, child <x-sirius::code>wire</x-sirius::code>, and the native Chart.js <x-sirius::code>library</x-sirius::code>. Return <x-sirius::code>options</x-sirius::code> and an optional native <x-sirius::code>plugins</x-sirius::code> array. One factory applies per chart ID.</p>
                <p>Use functions for tooltip labels, axis ticks, click handlers, and plugin hooks. Dispatch events with <x-sirius::code>wire.dispatch()</x-sirius::code> to an application listener. Validate its indexes and authorize any server action there.</p>
                <p>The adapter owns canvas, type/data synchronization, resizing, loading, disposal, and the <x-sirius::code>siriusTheme</x-sirius::code> plugin. Factories cannot replace those fields. Native callbacks and plugin hooks run alongside synchronization; JavaScript strings from PHP are never evaluated.</p>
                <p>Custom controllers, scales, or global plugins can be installed by calling <x-sirius::code>library.register()</x-sirius::code> from your application factory. Their dependencies and compatibility belong to the application. The example uses a free inline plugin.</p>
            </section>
            <section id="lifecycle" class="space-y-4">
                <h2 class="text-xl font-medium">Lifecycle</h2>
                <p>The returned function removes your registration. Call it when the registration is no longer needed; Alpine's <x-sirius::code>destroy()</x-sirius::code> is one place to do so. Release plugin resources in Chart.js <x-sirius::code>afterDestroy</x-sirius::code>.</p>
                <p><x-sirius::code>SiriusChart.get(id)</x-sirius::code> returns the native instance or null after removal. Use it for local inspection, export, or interaction. Persistent data/options changes belong in the parent props, because the next render restores those props.</p>
                <p>The root emits <x-sirius::code>sirius:chart-ready</x-sirius::code> with the chart instance after creation and <x-sirius::code>sirius:chart-error</x-sirius::code> after a rendering failure. Both events bubble. Retry uses the current props and factory.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
