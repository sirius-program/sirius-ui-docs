<div data-phone-example>
    <form wire:submit="save" novalidate class="space-y-5">
        @if ($showControls)
            <div wire:key="phone-controls" class="space-y-5">
                <x-sirius::phone :id="$this->getId().'-delivery'" name="delivery" label="Delivery contact" country="ID"
                    required helper="Courier contact in Indonesia." wire:model.live.debounce.150ms="delivery"
                    :readonly="$locked" :disabled="$disabled" :reset-key="$resetKey" data-phone-delivery />
                <x-sirius::phone :id="$this->getId().'-partner'" name="partner" label="Supplier contact" :country="['ID', 'GB']" delimiter="-"
                    required helper="Choose the supplier country before entering a local number." wire:model.live.debounce.150ms="partner"
                    :readonly="$locked" :disabled="$disabled" :reset-key="$resetKey" data-phone-partner />
                <x-sirius::phone :id="$this->getId().'-traveler'" name="traveler" label="Travel emergency contact" country="*" delimiter="."
                    required helper="An international contact from any supported country." wire:model.live.debounce.150ms="traveler"
                    :readonly="$locked" :disabled="$disabled" :reset-key="$resetKey" data-phone-traveler />
            </div>
        @endif
        <div class="flex flex-wrap gap-2">
            <flux:button type="submit">Submit / Validate</flux:button>
            <flux:button wire:click="loadExample" type="button">Load Value</flux:button>
            <flux:button wire:click="resetExample" type="button">Reset Sample</flux:button>
            <flux:button wire:click="$toggle('locked')" type="button">Toggle Readonly</flux:button>
        </div>
        <p role="status">Readonly: {{ $locked ? 'on' : 'off' }}</p>
        @if ($saved)<p role="status">Phone contacts validated. Nothing was stored.</p>@endif
    </form>
</div>
