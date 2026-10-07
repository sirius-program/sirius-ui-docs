<x-layouts::app title="Table · Bulk Actions">
    <x-docs-page :navigation="['Bulk Actions' => ['table-demo' => 'Demo', 'table-usage' => 'Usage', 'methods-and-variables' => 'Methods and variables', 'selection' => 'Selection', 'application-handlers' => 'Application handlers']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">TABLE</p>
                <h1 class="text-3xl font-semibold">Bulk Actions</h1>
                <p>Pass checked record IDs to your application's buttons and links.</p>
            </header>
            <section id="table-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.table-bulk-host')
                </div>
            </section>
            <section id="table-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.table-bulk')
            </section>
            <section id="methods-and-variables" class="space-y-4">
                @include('livewire-components.attributes.table-bulk')
            </section>
            <section id="selection" class="space-y-3">
                <h2 class="text-xl font-medium">Selection</h2>
                <p>The footer counts all checked records, including other pages.</p>
                <p>Pagination, page-size changes, sorting, and refresh preserve selection. Search and filter changes, including Reset filters, clear it. Selecting all matching results is not supported.</p>
                <p>An empty selection never means all records.</p>
                <p>Cancellation preserves selection. After an action, your application chooses whether to clear every ID or remove only the processed IDs.</p>
                @include('livewire-components.examples.table-selection-events')
            </section>
            <section id="application-handlers" class="space-y-3">
                <h2 class="text-xl font-medium">Application handlers</h2>
                <p>Render your Dialog, Alert, or Slideover in a parent component. Encode <code>$selectedIds</code> with <code>Js::from()</code> for event payloads, or pass them as link parameters.</p>
                <p>Validate the IDs, re-query within the user's scope, and authorize each record when executing. Checked IDs are input, not permission. The demo checks its workspace; add your application's policies or gates.</p>
                <p>Your application owns confirmation, mutations, CSV exports, transactions, retries, and feedback. Set and clear external loading on success, failure, and cancellation, then request refresh and selection cleanup explicitly.</p>
                <p>The navigation example reloads this page with the selected IDs and displays their scoped invoice numbers. It does not restore Table selection from the URL.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
