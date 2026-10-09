<x-layouts::app title="Table · Row Actions">
    <x-docs-page :navigation="['Row Actions' => ['table-demo' => 'Demo', 'table-usage' => 'Usage', 'table-attributes' => 'Attributes', 'initializing-actions' => 'Initializing actions', 'loading-and-refresh' => 'Loading and refresh']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">TABLE</p>
                <h1 class="text-3xl font-semibold">Row Actions</h1>
                <p>Render row buttons and connect them to your application's handlers.</p>
            </header>
            <section id="table-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.table-host')
                </div>
            </section>
            <section id="table-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.table-row-actions')
            </section>
            <section id="initializing-actions" class="space-y-3">
                <h2 class="text-xl font-medium">Initializing actions</h2>
                <ol class="list-decimal space-y-3 pl-5">
                    <li>Return your button view from <x-sirius::code>rowActionsView()</x-sirius::code>. The view receives the original <x-sirius::code>$record</x-sirius::code>.</li>
                    <li>Use the record to build links or dispatch fields needed by a handler. The demo sends its numeric invoice ID.</li>
                    <li>Render your Dialog, Alert, or Slideover in the parent component and open it with <x-sirius::code>dialog:show</x-sirius::code>.</li>
                    <li>Re-query and authorize the record in the handler, then validate and execute your application's action.</li>
                </ol>
                <p>Table renders the buttons; your application owns execution, feedback, and exports. It does not serialize the whole record or create overlays. Hiding a button does not authorize its action.</p>
                <p>There are no arbitrary toolbar actions. For checked records, see <x-sirius::link href="{{ route('livewire-components.table.bulk-actions') }}" wire:navigate>Bulk Actions</x-sirius::link>.</p>
            </section>
            <section id="loading-and-refresh" class="space-y-3">
                <h2 class="text-xl font-medium">Loading and refresh</h2>
                <p>Loading shows a backdrop over the rows and footer. Toolbar search and filters remain usable. For external processing, pass a reactive parent <x-sirius::code>loading</x-sirius::code> prop or dispatch <x-sirius::code>table:loading</x-sirius::code> with <x-sirius::code>{ id, loading: true }</x-sirius::code>. Clear external loading when processing finishes, fails, or is cancelled.</p>
                <p>Checking or unchecking rows or the current page updates selection without a loading overlay.</p>
                <p>Dispatch <x-sirius::code>table:refresh.{id}</x-sirius::code> or call <x-sirius::code>refreshTable()</x-sirius::code> after changing records. Refresh preserves search, filters, and ordering, and adjusts a page that no longer exists.</p>
                <x-docs-example view="livewire.examples.table-actions" />
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
