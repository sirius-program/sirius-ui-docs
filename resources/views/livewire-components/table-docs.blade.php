<x-layouts::app title="Table · Overview">
    <x-docs-page :navigation="['Overview' => ['table-demo' => 'Demo', 'table-usage' => 'Usage', 'table-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'explore-table' => 'Explore Table', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">TABLE</p>
                <h1 class="text-3xl font-semibold">Overview</h1>
                <p>Build a Livewire table from your own records and column definitions.</p>
            </header>
            <section id="table-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">@include('livewire-components.demos.table-overview')</div>
            </section>
            <section id="table-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                <p>Create a class under <code>App\Livewire</code>, extend <code>Sirius\Ui\Livewire\Table</code>, and define <code>query()</code> and <code>columns()</code>. The base class renders the table; you do not need a separate Table view or <code>render()</code> method.</p>
                <x-docs-code language="Shell" source="php artisan make:class Livewire/Examples/BasicInvoiceTable" />
                <p>The example uses the docs sample source.</p>
                @include('livewire-components.examples.table')
            </section>
            <section id="table-attributes">
                @include('livewire-components.attributes.table')
            </section>
            <section id="assets-and-interaction" class="space-y-3">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <code>sirius-ui-assets</code>.</p>
                @include('blade-components.examples.assets')
                <p>Search, sorting, and pagination update through Livewire. On narrow screens, rows scroll horizontally and footer controls stack.</p>
            </section>
            <section id="explore-table" class="space-y-3">
                <h2 class="text-xl font-medium">Explore Table</h2>
                <ul class="space-y-3">
                    <li><a href="{{ route('livewire-components.table.query') }}" class="underline" wire:navigate>Query</a> — Return an Eloquent Builder or a Collection, keep records scoped, and set page sizes.</li>
                    <li><a href="{{ route('livewire-components.table.columns') }}" class="underline" wire:navigate>Columns</a> — Choose headings, searchable fields, sorting, formatters, and custom cell views.</li>
                    <li><a href="{{ route('livewire-components.table.filters') }}" class="underline" wire:navigate>Filters</a> — Define text, select, date, time, and datetime filters, including remote options.</li>
                    <li><a href="{{ route('livewire-components.table.row-actions') }}" class="underline" wire:navigate>Row Actions</a> — Add row buttons and connect your own links, Dialog, Alert, or Slideover.</li>
                </ul>
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <code>table</code> array in <code>lang/vendor/sirius/{locale}/sirius-ui.php</code>.</p>
                @include('livewire-components.examples.table-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
