<div class="flex flex-wrap gap-3">
    <x-sirius::button icon="heroicon-o-check" wire:click="save" wire:loading.attr="disabled" :disabled="$disabled">Save draft</x-sirius::button>
    <x-sirius::button as="a" variant="link" href="{{ route('blade-components.form') }}">View form guide</x-sirius::button>
    <x-sirius::button variant="outline" icon="heroicon-o-arrow-down-tray" aria-label="Download invoice" disabled />
    <x-sirius::button loading>Exporting invoice</x-sirius::button>
    <x-sirius::button as="a" href="/unavailable" :disabled="$disabled" wire:click.prevent="save" data-disabled-link>Download invoice</x-sirius::button>
</div>
<p role="status" data-save-status>{{ $saved ? 'Draft saved.' : 'Draft not saved.' }}</p>
<x-sirius::button variant="secondary" wire:click="$toggle('disabled')">Toggle disabled</x-sirius::button>
<x-sirius::button variant="secondary" wire:click="refreshExample">Reset sample</x-sirius::button>
