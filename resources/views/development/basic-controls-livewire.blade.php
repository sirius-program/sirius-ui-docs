<div class="space-y-5" data-basic-example>
    <form wire:submit="save" novalidate class="space-y-5">
        @if ($showControls)
            <div wire:key="basic-controls" class="space-y-5">
                @if ($kind === 'password')
                    @include('blade-components.demos.password-livewire-fields', ['demoId' => $this->getId()])
                @else
                    @foreach (['input', 'textarea', 'checkbox', 'radio', 'switch'] as $control)
                        @include('blade-components.demos.'.$control.'-livewire-fields', ['demoId' => $this->getId()])
                    @endforeach
                @endif
            </div>
        @endif
        <div class="flex flex-wrap gap-2">
            <flux:button type="submit">Submit / Validate</flux:button>
            <flux:button type="button" wire:click="loadExample">Load Value</flux:button>
            <flux:button type="button" wire:click="resetExample">Reset Sample</flux:button>
            <flux:button type="button" wire:click="$toggle('locked')">Toggle Readonly</flux:button>
        </div>
        <p data-basic-lock-status>Readonly: {{ $locked ? 'on' : 'off' }}</p>
        @if ($saved)<p role="status">Sample validated. Nothing was stored.</p>@endif
    </form>
</div>
