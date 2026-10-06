<x-layouts::app title="Chart · Data">
    <x-docs-page :navigation="['Data' => ['chart-demo' => 'Demo', 'chart-usage' => 'Usage', 'data-sources' => 'Data sources', 'datasets' => 'Datasets', 'updates' => 'Updates']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">CHART</p>
                <h1 class="text-3xl font-semibold">Data</h1>
                <p>Turn your source data into labels and datasets.</p>
            </header>
            <section id="chart-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div class="space-y-8" data-demo-mode="livewire">
                    @include('livewire-components.demos.chart-data')
                </div>
            </section>
            <section id="chart-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.chart-data')
            </section>
            <section id="data-sources" class="space-y-4">
                <h2 class="text-xl font-medium">Data sources</h2>
                <p>The chart receives arrays, not queries. Aggregate scoped Eloquent records or map a Collection in your application, then pass the result. Apply authorization before preparing data.</p>
                @include('livewire-components.examples.chart-data-sources')
            </section>
            <section id="datasets" class="space-y-4">
                <h2 class="text-xl font-medium">Datasets</h2>
                <p>Use native <a href="https://www.chartjs.org/docs/latest/general/data-structures.html" target="_blank" rel="noopener noreferrer" class="text-blue-500 dark:text-blue-400 hover:underline">Chart.js data structures</a>: numbers, nulls, coordinate objects, tuples, or keyed values. Scatter uses x/y points; bubble also uses r. Dataset fields such as colors, parsing, and stack pass through unchanged.</p>
                <p>Set a dataset's <code>type</code> to mix controllers, such as a line over bars. All standard controllers are bundled: bar, line, pie, doughnut, radar, polarArea, scatter, and bubble.</p>
                @include('livewire-components.examples.chart-dataset')
                <p>Data and PHP options must contain JSON-compatible values. Objects, closures, infinite numbers, and prototype keys are rejected. Use <a href="{{ route('livewire-components.chart.extensions') }}" class="underline" wire:navigate>Extensions</a> for functions.</p>
            </section>
            <section id="updates" class="space-y-4">
                <h2 class="text-xl font-medium">Updates</h2>
                <p>Keep an explicit ID and stable Livewire key. Change props in the parent component; the child props are reactive. Replace an array or change dataset values in a parent action. Empty or entirely null dataset values show the empty state.</p>
                <p>Show <code>loading</code> for work outside the immediate parent request. Loading ends when you change the prop back to false; handle request errors in your application.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
