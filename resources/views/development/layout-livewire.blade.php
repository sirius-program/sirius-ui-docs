<div data-layout-example class="space-y-4">
    <x-sirius::card id="livewire-card" :header="'Invoice revision ' . $revision" footer="Customer billing">
        Amount due: $120
    </x-sirius::card>
    @if ($visible)
        <x-sirius::accordion id="livewire-shipping" wire:key="shipping" trigger="Shipping details" :open="$expanded" transition
            x-on:accordion:toggle="if ($event.target === $el && $wire.expanded !== $event.detail.open) $wire.set('expanded', $event.detail.open)">
            <a href="#tracking" id="tracking-link">Track parcel</a>
        </x-sirius::accordion>
    @endif
    <div class="flex flex-wrap gap-3">
        <x-sirius::button wire:click="$toggle('expanded')">Toggle from server</x-sirius::button>
        <x-sirius::button wire:click="refreshExample">Refresh invoice</x-sirius::button>
        <x-sirius::button wire:click="$toggle('visible')">Toggle visibility</x-sirius::button>
    </div>
    <output data-layout-state>{{ $expanded ? 'Open' : 'Closed' }}</output>
</div>
