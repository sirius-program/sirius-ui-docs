<div data-select-example>
    <form wire:submit="save" novalidate class="space-y-5">
        @if ($showControls)
        <div wire:key="select-controls" class="space-y-5">
            <x-sirius::select :id="$this->getId().'-shipping'" name="shipping" label="Delivery method" required
                :options="\App\Support\SelectCatalog::shipping()" wire:model.live="shipping"
                helper="Choose how your order will arrive." :readonly="$locked" :disabled="$disabled" data-select-shipping />
            <x-sirius::select :id="$this->getId().'-topics'" name="topics" label="Workshop interests" required
                :options="\App\Support\SelectCatalog::topics()" wire:model.live="topics" multiple :clearable="true"
                helper="Choose the sessions you want to attend." :readonly="$locked" :disabled="$disabled" data-select-topics />
            <x-sirius::select :id="$this->getId().'-venue'" name="venue" label="Event venue"
                :options="[]" wire:model.live="venue" :search-url="route('blade-components.select.options')"
                helper="Search the public venue directory." :readonly="$locked" :disabled="$disabled" data-select-venue />
        </div>
        @endif
        <div class="flex flex-wrap gap-2">
            <flux:button type="submit">Submit / Validate</flux:button>
            <flux:button type="button" wire:click="loadExample">Load Value</flux:button>
            <flux:button type="button" wire:click="resetExample">Reset Sample</flux:button>
            <flux:button type="button" wire:click="$toggle('locked')">Toggle Readonly</flux:button>
        </div>
        <p role="status">Readonly: {{ $locked ? 'on' : 'off' }}</p>
        @if ($saved)<p role="status">Selections validated. Nothing was stored.</p>@endif
    </form>
</div>
