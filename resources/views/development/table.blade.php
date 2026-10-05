<x-layouts::app title="Table integration">
    <x-docs-page :navigation="[]">
        <div class="space-y-8">
            <h1 class="text-2xl font-semibold">Table integration</h1>
            <livewire:examples.table-actions />
            <livewire:examples.invoice-table id="second-table" record-label="invoices" />
            <livewire:examples.table-bulk-actions id="bulk-first" />
            <livewire:examples.table-bulk-actions id="bulk-second" />
            <x-sirius::button id="table-navigation" :href="route('livewire-components.table')" as="a" wire:navigate>Table docs</x-sirius::button>
        </div>
    </x-docs-page>
</x-layouts::app>
