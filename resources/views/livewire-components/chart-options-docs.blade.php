<x-layouts::app title="Chart · Options">
    <x-docs-page :navigation="['Options' => ['chart-demo' => 'Demo', 'chart-usage' => 'Usage', 'native-options' => 'Native options', 'sizing' => 'Sizing', 'time-scales' => 'Time scales']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">CHART</p>
                <h1 class="text-3xl font-semibold">Options</h1>
                <p>Configure native chart behavior and sizing.</p>
            </header>
            <section id="chart-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.chart-options')
                </div>
            </section>
            <section id="chart-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.chart-options')
            </section>
            <section id="native-options" class="space-y-4">
                <h2 class="text-xl font-medium">Native options</h2>
                <p>The options bag accepts every JSON-compatible option in the <x-sirius::link href="https://www.chartjs.org/docs/latest/configuration/" target="_blank" rel="noopener noreferrer">Chart.js 4 reference</x-sirius::link>, including scales, parsing, interaction, animation, legends, tooltips, and plugin configuration. Callback functions and canvas/DOM objects require a local extension.</p>
                <p>Defaults are <x-sirius::code>responsive: true</x-sirius::code>, <x-sirius::code>maintainAspectRatio: false</x-sirius::code>, and animation duration 200 ms. Text and grid colors follow the theme. Merge order is defaults, PHP options, then local extension options. Explicit sizing wins over both; reduced motion always disables animation.</p>
                <p>Props <x-sirius::code>type</x-sirius::code> and <x-sirius::code>data</x-sirius::code> are top-level chart configuration. The options bag does not replace them. Plugin objects belong in the factory's <x-sirius::code>plugins</x-sirius::code> list; their serializable settings belong in <x-sirius::code>options.plugins</x-sirius::code>.</p>
            </section>
            <section id="sizing" class="space-y-4">
                <h2 class="text-xl font-medium">Sizing</h2>
                <p>The default stage fills its container and is 320 px tall. Set width and height props in pixels. Width never exceeds the container. An explicit height forces <x-sirius::code>maintainAspectRatio: false</x-sirius::code>; omit height to use the library's aspect-ratio behavior. <x-sirius::code>responsive: false</x-sirius::code> disables resize tracking; explicit size changes still apply.</p>
            </section>
            <section id="time-scales" class="space-y-4">
                <h2 class="text-xl font-medium">Time scales</h2>
                <p>The bundled date adapter uses date-fns 4.4.0 and supports time/timeseries scales. Prefer epoch milliseconds or ISO dates. Date-fns formats use the browser timezone; <x-sirius::code>sirius-ui.timezone</x-sirius::code> is not applied to chart axes.</p>
                @include('livewire-components.examples.chart-time-scales')
                <p>Number formatting uses <x-sirius::code>options.locale</x-sirius::code>. Time labels default to English. To localize time labels, import a date-fns locale object in your application JavaScript and pass it through the local extension's <x-sirius::code>options.scales.x.adapters.date.locale</x-sirius::code>, following the <x-sirius::link href="https://github.com/chartjs/chartjs-adapter-date-fns#configuration" target="_blank" rel="noopener noreferrer">adapter reference</x-sirius::link>.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
