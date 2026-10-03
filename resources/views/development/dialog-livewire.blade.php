<div class="space-y-5" data-dialog-example>
    <x-sirius::button id="livewire-dialog-trigger" wire:click="$set('reviewing', true)">Edit delivery</x-sirius::button>
    <x-sirius::button wire:click="$toggle('visible')">Toggle dialog visibility</x-sirius::button>
    @if ($visible)
        <x-sirius::dialog id="livewire-dialog" wire:key="delivery-dialog" :open="$reviewing" initial-focus="#delivery-address" x-on:dialog:close="if ($event.target === $el && $wire.reviewing) $wire.set('reviewing', false)">
            <x-slot:header><h2>Delivery revision {{ $revision }}</h2></x-slot:header>
            <form wire:submit="save" class="space-y-4" novalidate>
                <x-sirius::input id="delivery-address" label="Delivery address" name="address" wire:model="address" required />
                <x-sirius::select id="dialog-shipping" label="Shipping" name="shipping" wire:model="shipping" :options="[['value' => 'standard', 'label' => 'Standard delivery'], ['value' => 'express', 'label' => 'Express delivery']]" />
                <x-sirius::datetime-picker id="dialog-date" label="Delivery date" name="deliveryDate" wire:model="deliveryDate" />
                <div class="flex flex-wrap gap-2">
                    <x-sirius::button type="submit" variant="primary">Save delivery</x-sirius::button>
                    <x-sirius::button wire:click="$set('revision', {{ $revision + 1 }})">Refresh delivery</x-sirius::button>
                    <x-sirius::button wire:click="$set('visible', false)">Remove dialog</x-sirius::button>
                </div>
            </form>
            <x-slot:footer><x-sirius::button data-sir-dialog-close>Cancel delivery</x-sirius::button></x-slot:footer>
        </x-sirius::dialog>
    @endif
    <p data-dialog-state>{{ $reviewing ? 'Open' : 'Closed' }}</p>
</div>
