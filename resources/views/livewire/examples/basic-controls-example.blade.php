<div class="space-y-5" data-basic-example>
    <form wire:submit="save" novalidate class="space-y-5">
        @if ($showControls)
            <div wire:key="basic-controls" class="space-y-5">
                @if (in_array($kind, ['input', 'all'], true))
                    <x-sirius::input :id="$this->getId().'-title'" label="Project title" name="title" wire:model="title" helper="Up to 80 characters." required maxlength="80" :readonly="$locked" data-basic-title>
                        <x-slot:prefix>@svg('heroicon-o-pencil', 'size-4', ['aria-hidden' => 'true'])</x-slot:prefix>
                    </x-sirius::input>
                    <x-sirius::input :id="$this->getId().'-quantity'" label="Quantity" type="number" wire:model.number="quantity" name="quantity" min="0" max="100" step="1" suffix="units" :readonly="$locked" data-basic-quantity />
                @endif
                @if (in_array($kind, ['password', 'all'], true))
                    <x-sirius::input :id="$this->getId().'-password'" label="Demo password" type="password" wire:model="password" name="password" helper="Example only; do not enter a real password." required minlength="8" autocomplete="new-password" :readonly="$locked" data-basic-password />
                @endif
                @if (in_array($kind, ['textarea', 'all'], true))
                    <x-sirius::textarea :id="$this->getId().'-notes'" label="Notes" wire:model="notes" name="notes" rows="4" cols="40" maxlength="500" helper="Plain text, up to 500 characters." :readonly="$locked" data-basic-notes />
                @endif
                @if (in_array($kind, ['checkbox', 'all'], true))
                    <x-sirius::checkbox :id="$this->getId().'-agree'" label="Accept example terms" wire:model.live="agreed" name="agreed" required :readonly="$locked" helper="Required for the checkbox example." data-basic-agree />
                    <x-sirius::field :id="$this->getId().'-roles'" group label="Roles" error-key="roles" helper="Choose one or more roles." required>
                        <div class="flex flex-wrap gap-4">
                            <x-sirius::checkbox :id="$this->getId().'-role-zero'" label="Reader" name="roles[]" value="0" wire:model.live="roles" :readonly="$locked" data-basic-role-zero />
                            <x-sirius::checkbox :id="$this->getId().'-role-editor'" label="Editor" name="roles[]" value="editor" wire:model.live="roles" :readonly="$locked" data-basic-role-editor />
                        </div>
                    </x-sirius::field>
                    <x-sirius::checkbox :id="$this->getId().'-mixed'" label="Mixed-state demonstration" :indeterminate="$mixed" :readonly="$locked" data-basic-mixed />
                @endif
                @if (in_array($kind, ['radio', 'all'], true))
                    <x-sirius::field :id="$this->getId().'-plans'" group label="Plan" helper="Choose exactly one plan." error-key="plan" required>
                        <div class="flex flex-wrap gap-4">
                            <x-sirius::radio :id="$this->getId().'-plan-zero'" :name="$this->getId().'-plan'" label="Free" value="0" wire:model.live="plan" required :readonly="$locked" data-basic-plan-zero />
                            <x-sirius::radio :id="$this->getId().'-plan-pro'" :name="$this->getId().'-plan'" label="Pro" value="pro" wire:model.live="plan" required :readonly="$locked" data-basic-plan-pro />
                        </div>
                    </x-sirius::field>
                @endif
                @if (in_array($kind, ['switch', 'all'], true))
                    <x-sirius::switch :id="$this->getId().'-enabled'" label="Enable notifications" name="enabled" wire:model.live="enabled" :readonly="$locked" helper="Native checkbox semantics with an on/off appearance." data-basic-enabled />
                @endif
            </div>
        @endif
        <div class="flex flex-wrap gap-2">
            <flux:button type="submit">Validate sample</flux:button>
            <flux:button type="button" wire:click="loadExample">Load server values</flux:button>
            <flux:button type="button" wire:click="resetExample">Reset sample</flux:button>
            <flux:button type="button" wire:click="$toggle('locked')">Toggle sample readonly</flux:button>
        </div>
        <p data-basic-lock-status>Readonly: {{ $locked ? 'on' : 'off' }}</p>
        @if ($saved)<p role="status">Sample validated. Nothing was stored.</p>@endif
    </form>
</div>
