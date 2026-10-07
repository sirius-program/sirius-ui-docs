<div data-currency-example>
    <form wire:submit="save" novalidate class="space-y-5">
        @if ($showControls)
            <div wire:key="currency-controls" class="space-y-5">
                <x-sirius::currency :id="$this->getId().'-budget'" label="Project budget" name="budget"
                    wire:model.live.debounce.150ms="budget" prefix="$" min="0" required
                    helper="Set the budget for the website redesign in USD."
                    :readonly="$locked" :disabled="$disabled" data-currency-budget />
                <x-sirius::currency :id="$this->getId().'-adjustment'" label="Invoice adjustment" name="adjustment"
                    wire:model.blur.live="adjustment" thousands-separator="." decimal-separator="," :precision="3" allow-negative
                    suffix="IDR" required helper="Use a negative amount for a credit; up to 3 decimal places."
                    :readonly="$locked" :disabled="$disabled" data-currency-adjustment />
            </div>
        @endif
        <div class="flex flex-wrap gap-2">
            <x-sirius::button type="submit">Submit / Validate</x-sirius::button>
            <x-sirius::button wire:click="loadExample" type="button">Load Value</x-sirius::button>
            <x-sirius::button wire:click="resetExample" type="button">Reset Sample</x-sirius::button>
            <x-sirius::button wire:click="$toggle('locked')" type="button">Toggle Readonly</x-sirius::button>
        </div>
        <p role="status">Readonly: {{ $locked ? 'on' : 'off' }}</p>
        @if ($saved)<p role="status">Amounts validated. Nothing was stored.</p>@endif
    </form>
</div>
