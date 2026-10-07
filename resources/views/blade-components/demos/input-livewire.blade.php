<div class="space-y-5" data-basic-example>
    <form wire:submit="save" novalidate class="space-y-5">
        @if ($showControls)
            <div wire:key="basic-controls" class="space-y-5">
                @include('blade-components.demos.input-livewire-fields', ['demoId' => $this->getId()])
            </div>
        @endif
        <div class="flex flex-wrap gap-2">
            <x-sirius::button type="submit">Submit / Validate</x-sirius::button>
            <x-sirius::button type="button" wire:click="loadExample">Load Value</x-sirius::button>
            <x-sirius::button type="button" wire:click="resetExample">Reset Sample</x-sirius::button>
            <x-sirius::button type="button" wire:click="$toggle('locked')">Toggle Readonly</x-sirius::button>
        </div>
        <p data-basic-lock-status>Readonly: {{ $locked ? 'on' : 'off' }}</p>
        @if ($saved)<p role="status">Sample validated. Nothing was stored.</p>@endif
    </form>
</div>
