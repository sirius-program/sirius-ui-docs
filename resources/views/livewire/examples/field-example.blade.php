<form wire:submit="save" novalidate class="space-y-4" data-live-field-example>
    <x-sirius::field :id="$this->getId().'-email'" name="email" label="Email address" helper="Your address stays in this example only."
        wire:model="email" required :readonly="$locked" type="email" autocomplete="email" data-example-email>
        <input {{ $component->controlAttributes() }}>
    </x-sirius::field>
    <div class="flex flex-wrap gap-3">
        <flux:button type="submit">Validate email</flux:button>
        <flux:button type="button" wire:click="resetForm">Reset example</flux:button>
        <flux:button type="button" wire:click="$toggle('locked')">Toggle readonly</flux:button>
    </div>
    @if ($saved)
        <p role="status">Validation passed. Nothing was stored.</p>
    @endif
</form>
