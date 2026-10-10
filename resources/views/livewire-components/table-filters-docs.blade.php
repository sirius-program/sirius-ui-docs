<x-layouts::app title="Table · Filters">
    <x-docs-page :navigation="['Filters' => ['table-demo' => 'Demo', 'table-usage' => 'Usage', 'table-parameters' => 'Parameters', 'interaction' => 'Interaction', 'filter-types' => 'Filter types', 'filter-callbacks' => 'Filter callbacks', 'remote-options' => 'Remote options']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">TABLE</p>
                <h1 class="text-3xl font-semibold">Filters</h1>
                <p>Manage search and filter controls for table data.</p>
            </header>
            <section id="table-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.table-filters')
                </div>
            </section>
            <section id="table-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.table-filters')
            </section>
            <section id="table-parameters">
                @include('livewire-components.attributes.table-filters')
            </section>
            <section id="interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Interaction</h2>
                <p>Filters stay open through focus changes and Table updates. Click outside or click the filter button to close them. Escape closes an open Select or calendar. Tab moves between controls.</p>
                <p>Reset filters restores each default and returns to page one. Global search stays unchanged. Search and filters remain usable while Table results are loading.</p>
            </section>
            <section id="filter-types" class="space-y-3">
                @include('livewire-components.attributes.table-filter-types')
            </section>
            <section id="filter-callbacks" class="space-y-3">
                <h2 class="text-xl font-medium">Filter callbacks</h2>
                <p><x-sirius::code>filters()</x-sirius::code> declares the controls; the public <x-sirius::code>$filters</x-sirius::code> property stores their current values.</p>
                <p>Builder callbacks receive the scoped query and validated string value. Add constraints to that query; Table groups them so an OR cannot escape the base scope.</p>
                <p>Collection callbacks receive the current Collection and validated string value. Return the filtered Collection, as in the example below. Table applies registered filters in order.</p>
                @include('livewire-components.examples.table-collection')
                <p>Each filter key must be unique. Local Select values must match an option; remote values must be authorized in your callback.</p>
            </section>
            <section id="remote-options" class="space-y-3">
                <h2 class="text-xl font-medium">Remote options</h2>
                <p>Use <x-sirius::code>searchUrl</x-sirius::code> with the <x-sirius::link href="{{ route('blade-components.select') }}" wire:navigate>Select component</x-sirius::link> for search, pagination, and selected-label resolution. Scope the endpoint and filter callback to the same permitted records.</p>
                @include('livewire-components.examples.table-options-controller')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
