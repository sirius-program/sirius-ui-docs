<x-layouts::app title="Table · Overview">
    <x-docs-page :navigation="['Overview' => ['table-demo' => 'Demo', 'table-usage' => 'Usage', 'table-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'explore-table' => 'Explore Table', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">TABLE</p>
                <h1 class="text-3xl font-semibold">Overview</h1>
                <p>Build a Livewire table from your own records and column definitions.</p>
            </header>
            <section id="table-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">@include('livewire-components.demos.table-overview')</div>
            </section>
            <section id="table-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                <p>Create a class under <x-sirius::code>App\Livewire</x-sirius::code>, extend <x-sirius::code>Sirius\Ui\Livewire\Table</x-sirius::code>, and define <x-sirius::code>query()</x-sirius::code> and <x-sirius::code>columns()</x-sirius::code>. The base class renders the table; you do not need a separate Table view or <x-sirius::code>render()</x-sirius::code> method.</p>
                @include('livewire-components.examples.table-create-class')
                <p>The example uses the docs sample source.</p>
                @include('livewire-components.examples.table')
            </section>
            <section id="table-attributes">
                @include('livewire-components.attributes.table')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Search, sorting, and pagination update through Livewire. On narrow screens, rows scroll horizontally and footer controls stack.</p>
            </section>
            <section id="explore-table" class="space-y-3">
                <h2 class="text-xl font-medium">Explore Table</h2>
                <ul class="space-y-3">
                    <li><x-sirius::link href="{{ route('livewire-components.table.bulk-actions') }}" wire:navigate>Bulk Actions</x-sirius::link> — Select records across pages and pass their IDs to application-owned buttons and overlays.</li>
                    <li><x-sirius::link href="{{ route('livewire-components.table.query') }}" wire:navigate>Query</x-sirius::link> — Return an Eloquent Builder or a Collection, keep records scoped, and set page sizes.</li>
                    <li><x-sirius::link href="{{ route('livewire-components.table.columns') }}" wire:navigate>Columns</x-sirius::link> — Choose headings, searchable fields, sorting, formatters, and custom cell views.</li>
                    <li><x-sirius::link href="{{ route('livewire-components.table.filters') }}" wire:navigate>Filters</x-sirius::link> — Define text, select, date, time, and datetime filters, including remote options.</li>
                    <li><x-sirius::link href="{{ route('livewire-components.table.row-actions') }}" wire:navigate>Row Actions</x-sirius::link> — Add row buttons and connect your own links, Dialog, Alert, or Slideover.</li>
                </ul>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <x-sirius::code>table</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>.</p>
                @include('livewire-components.examples.table-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
