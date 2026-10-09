<x-layouts::app title="Table · Query">
    <x-docs-page :navigation="['Table' => ['table-demo' => 'Demo', 'table-usage' => 'Usage', 'query-boundaries' => 'Query boundaries', 'record-keys' => 'Record keys', 'page-sizes' => 'Page sizes', 'state-and-pagination' => 'State and pagination']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">TABLE</p>
                <h1 class="text-3xl font-semibold">Query</h1>
                <p>Manage table's query, can be Laravel's Eloquent or Collection.</p>
            </header>
            <section id="table-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <h3 class="text-lg font-medium">Eloquent</h3>
                <div data-demo-mode="livewire">@include('livewire-components.demos.table-query-eloquent')</div>
                <h3 class="text-lg font-medium">Collection</h3>
                <div data-demo-mode="livewire">@include('livewire-components.demos.table-query-collection')</div>
            </section>
            <section id="table-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.table-query')
            </section>
            <section id="query-boundaries" class="space-y-3">
                <h2 class="text-xl font-medium">Query boundaries</h2>
                <p><x-sirius::code>query()</x-sirius::code> runs on each render. Keep tenant and permission constraints in this method, before Table applies search, filters, and sorting.</p>
                <p>Builder sources search, filter, sort, and paginate in the database. Keep the primary key in selected columns and eager-load relationships used by your views. Table groups search and filter conditions inside the base query.</p>
                <p>Collections may contain models, arrays, or objects. Search, filters, sorting, and pagination run in memory, so use this for data you already load. Collection search matches text without case sensitivity. Eloquent Collections are also supported.</p>
                <p>Read <x-sirius::link href="{{ route('livewire-components.table.filters') }}" wire:navigate>Filters</x-sirius::link> for source-specific callbacks, and <x-sirius::link href="{{ route('livewire-components.table.columns') }}" wire:navigate>Columns</x-sirius::link> for searchable and sortable fields.</p>
            </section>
            <section id="record-keys" class="space-y-3">
                <h2 class="text-xl font-medium">Record keys</h2>
                <p>Models use their primary key; arrays and objects use <x-sirius::code>id</x-sirius::code>. Each key must be a unique, nonempty string or integer. Use <x-sirius::code>recordKey()</x-sirius::code> for another field.</p>
                @include('livewire-components.examples.table-record-key')
                <p>Views and formatters receive the original record. Use <x-sirius::code>data_get($record, 'field')</x-sirius::code> to read either arrays or objects.</p>
            </section>
            <section id="page-sizes" class="space-y-3">
                <h2 class="text-xl font-medium">Page sizes</h2>
                <p>Override <x-sirius::code>pageSizes()</x-sirius::code> to set the rows-per-page choices in the footer. The default is <x-sirius::code>[10, 25, 50]</x-sirius::code>; the first value is selected initially. Return at least one positive integer.</p>
                @include('livewire-components.examples.table-page-sizes')
                <p>This works with both Eloquent and Collection sources. The Collection demo above uses <x-sirius::code>[2, 4]</x-sirius::code>.</p>
            </section>
            <section id="state-and-pagination" class="space-y-3">
                <h2 class="text-xl font-medium">State and pagination</h2>
                <p>Search, filter, sort, and page-size changes return to page one. Footer counts reflect the current result. State is isolated per Table and is not stored in the URL.</p>
                <p>Refresh with <x-sirius::code>table:refresh.{id}</x-sirius::code> or <x-sirius::code>refreshTable()</x-sirius::code> after changing records. Refresh preserves search, filters, and ordering, and adjusts a page that no longer exists.</p>
                <p>Removing all sorting restores the source's initial order. Sorted rows use the record key as a tie-breaker.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
