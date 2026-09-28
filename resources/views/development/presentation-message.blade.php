<x-sirius::message id="livewire-invoice-message" wire:key="invoice-notice" :reset-key="$revision" variant="success" icon="heroicon-o-check-circle" dismissible>
    Invoice #1042 was sent to the customer.
</x-sirius::message>
<x-sirius::message variant="warning" icon="heroicon-o-exclamation-triangle">
    Add a billing address before sending the next invoice.
</x-sirius::message>
<div class="flex flex-wrap gap-3">
    <x-sirius::button variant="secondary" wire:click="save">Refresh status</x-sirius::button>
    <x-sirius::button variant="secondary" wire:click="refreshExample">Show message again</x-sirius::button>
</div>
<p role="status" data-refresh-status>{{ $saved ? 'Status refreshed.' : 'Ready.' }}</p>
