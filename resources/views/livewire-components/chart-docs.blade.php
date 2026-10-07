<x-layouts::app title="Chart · Overview">
    <x-docs-page :navigation="['Overview' => ['chart-demo' => 'Demo', 'chart-usage' => 'Usage', 'chart-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'explore-chart' => 'Explore Chart', 'global-configuration' => 'Global configuration', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">CHART</p>
                <h1 class="text-3xl font-semibold">Overview</h1>
                <p>Visualize application data, statistics, and more, powered by <a href="https://www.chartjs.org/docs/latest/" target="_blank" rel="noopener noreferrer" class="text-blue-500 dark:text-blue-400 hover:underline">Chart.js</a>.</p>
            </header>
            <section id="chart-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.chart-overview')
                </div>
            </section>
            <section id="chart-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.chart')
            </section>
            <section id="chart-attributes">
                @include('livewire-components.attributes.chart')
            </section>
            <section id="assets-and-interaction" class="space-y-4">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Chart.js 4.5.1 and its date-fns adapter are bundled. No CDN or API key is required. Charts resize when shown in Tabs, Dialog, or Slideover.</p>
                <p>Data changes reuse the chart. Type, options, theme, or local extension changes rebuild it. Removal and Livewire navigation destroy the old instance.</p>
                <p>Loading keeps the chart height and blocks chart interaction. An empty dataset shows the empty message. Rendering errors show Retry; the application handles failed data requests.</p>
                <p>Give the chart a meaningful label and provide its values in text or a table in your application. Reduced-motion preferences disable animation.</p>
            </section>
            <section id="explore-chart" class="space-y-4">
                <h2 class="text-xl font-medium">Explore Chart</h2>
                <ul class="space-y-3">
                    <li><a href="{{ route('livewire-components.chart.data') }}" class="underline" wire:navigate>Data</a> — Prepare Eloquent or Collection data and native datasets.</li>
                    <li><a href="{{ route('livewire-components.chart.extensions') }}" class="underline" wire:navigate>Extensions</a> — Add callbacks, formatters, and local plugins.</li>
                    <li><a href="{{ route('livewire-components.chart.options') }}" class="underline" wire:navigate>Options</a> — Configure axes, legends, sizing, and time scales.</li>
                </ul>
            </section>
            <section id="global-configuration" class="space-y-4">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Publish the config to set defaults. Number formatting uses <code>sirius-ui.locale &rarr; app.locale &rarr; app.fallback_locale &rarr; en</code>; <code>options.locale</code> overrides it. Underscores in the default locale become hyphens for Intl formatting.</p>
                @include('livewire-components.examples.chart-config')
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <code>chart</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>.</p>
                @include('livewire-components.examples.chart-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
