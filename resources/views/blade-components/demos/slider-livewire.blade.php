<div data-slider-example>
    <form wire:submit="save" class="space-y-5" novalidate>
        @if ($visible)
            <div wire:key="slider-controls" class="space-y-5">
                <x-sirius::slider id="discount" name="discount" label="Seasonal discount (%)" :value="10" :max="50" :step="5"
                    wire:model.live.debounce.150ms="discount" helper="Set a discount for your holiday promotion." required :readonly="$locked" :disabled="$disabled" />
                <x-sirius::slider id="budget" name="budget" label="Nightly budget (USD)" range
                    :value="[40, 160]" :min="[0, 20]" :max="[200, 300]" :step="[5, 20]"
                    wire:model.live.debounce.150ms="budget" error-key="budget*"
                    helper="Choose the lowest and highest nightly price for your stay." required :readonly="$locked" :disabled="$disabled" />
            </div>
        @endif
        <div class="flex flex-wrap gap-2">
            <x-sirius::button type="submit">Submit / Validate</x-sirius::button>
            <x-sirius::button type="button" wire:click="loadExample">Load Value</x-sirius::button>
            <x-sirius::button type="button" wire:click="resetExample">Reset Sample</x-sirius::button>
            <x-sirius::button type="button" wire:click="$toggle('locked')">Toggle Readonly</x-sirius::button>
        </div>
        <p role="status">Readonly: {{ $locked ? 'on' : 'off' }}</p>
        @if ($saved)<p role="status">Preferences validated. Nothing was stored.</p>@endif
    </form>
</div>
