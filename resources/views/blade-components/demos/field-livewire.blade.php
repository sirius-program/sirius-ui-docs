<form wire:submit="save" novalidate class="space-y-4" data-live-field-example>
    @if ($labelOnly)
        @include('blade-components.demos.label-controls', ['livewire' => true, 'demoId' => $this->getId(), 'values' => []])
    @else
    <x-sirius::field :id="$this->getId().'-email'" name="email" label="Email address" helper="Your address stays in this example only."
        wire:model="email" required :readonly="$locked" type="email" autocomplete="email" data-example-email>
        <input {{ $component->controlAttributes() }}>
    </x-sirius::field>
    @endif
    <div class="flex flex-wrap gap-3">
        <x-sirius::button type="submit">Submit / Validate</x-sirius::button>
        <x-sirius::button type="button" wire:click="loadExample">Load Value</x-sirius::button>
        <x-sirius::button type="button" wire:click="resetForm">Reset Sample</x-sirius::button>
        <x-sirius::button type="button" wire:click="$toggle('locked')">Toggle Readonly</x-sirius::button>
    </div>
    @if ($saved)
        <p role="status">Validation passed. Nothing was stored.</p>
    @endif
</form>
