<x-layouts::app title="Table · Columns">
    <x-docs-page :navigation="['Columns' => ['table-demo' => 'Demo', 'table-usage' => 'Usage', 'table-parameters' => 'Parameters', 'cell-values' => 'Cell values', 'sorting' => 'Sorting']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">TABLE</p>
                <h1 class="text-3xl font-semibold">Columns</h1>
                <p>Manage table's columns.</p>
            </header>
            <section id="table-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.table-columns')
                </div>
            </section>
            <section id="table-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.table-columns')
            </section>
            <section id="table-parameters">
                @include('livewire-components.attributes.table-columns')
            </section>
            <section id="cell-values" class="space-y-3">
                <h2 class="text-xl font-medium">Cell values</h2>
                <p>Table reads the displayed value from the column's <x-sirius::code>key</x-sirius::code>. Use <x-sirius::code>field</x-sirius::code> when its search/sort path differs. Only columns marked <x-sirius::code>searchable</x-sirius::code> participate in global search.</p>
                <p>Use a formatter for text such as prices or dates. Its second argument is the original record, so the demo appends Paid to settled amounts. Formatting does not change search or sorting.</p>
                <p>Use a cell view for markup such as the status badge. It receives <x-sirius::code>$record</x-sirius::code> and <x-sirius::code>$column</x-sirius::code>. A view takes precedence over a formatter; ordinary cell values and formatter strings are escaped.</p>
            </section>
            <section id="sorting" class="space-y-3">
                <h2 class="text-xl font-medium">Sorting</h2>
                <p>Click a sortable heading to cycle ascending, descending, and unsorted. Shift-click to add or change another sorted column; numbers show priority. A plain click keeps only that column.</p>
                <p>Table accepts only registered sortable keys. Removing all sorting restores the source's initial order. Sorted rows use the record key as a tie-breaker.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
