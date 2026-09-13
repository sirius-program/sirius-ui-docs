@php
    $demoBag = $livewire ? 'default' : 'sample-'.$kind;
    $bind = function (string $property, string $modifier = '') use ($livewire, $values) {
        if ($livewire) {
            return new \Illuminate\View\ComponentAttributeBag(['wire:model'.$modifier => $property]);
        }
        if (in_array($property, ['agreed', 'enabled'], true)) {
            return new \Illuminate\View\ComponentAttributeBag(['checked' => !empty($values[$property])]);
        }
        if (in_array($property, ['roles', 'plan'], true)) {
            return new \Illuminate\View\ComponentAttributeBag;
        }
        return new \Illuminate\View\ComponentAttributeBag(['value' => $values[$property] ?? ($property === 'quantity' ? 0 : '')]);
    };
@endphp
@if (in_array($kind, ['input', 'all'], true))
                    <x-sirius::input :id="($automaticIds ?? false) ? null : $demoId.'-title'" placeholder="Website redesign" label="Project title" :error-bag="$demoBag" name="title" :attributes="$bind('title', '')" helper="Up to 80 characters." required maxlength="80" :readonly="$locked" :data-basic-title="$livewire ? true : null">
                        <x-slot:prefix>
                            <x-heroicon-o-pencil class="size-4" aria-hidden="true" />
                        </x-slot:prefix>
                    </x-sirius::input>
                    <x-sirius::input :id="($automaticIds ?? false) ? null : $demoId.'-quantity'" label="Team seats" helper="Reserve up to 100 seats for your team." required type="number" :attributes="$bind('quantity', '.number')" :error-bag="$demoBag" name="quantity" min="0" max="100" step="1" suffix="seats" :readonly="$locked" :data-basic-quantity="$livewire ? true : null" />
@endif
@if (in_array($kind, ['password', 'all'], true))
                    <x-sirius::input :id="($automaticIds ?? false) ? null : $demoId.'-password'" label="Password" type="password" :attributes="$bind('password', '')" :error-bag="$demoBag" name="password" helper="Example only; do not enter a real password." required minlength="8" autocomplete="new-password" :readonly="$locked" :data-basic-password="$livewire ? true : null" />
@endif
@if (in_array($kind, ['textarea', 'all'], true))
                    <x-sirius::textarea :id="($automaticIds ?? false) ? null : $demoId.'-notes'" placeholder="Describe the next project milestone." label="Project brief" :attributes="$bind('notes', '')" :error-bag="$demoBag" name="notes" required rows="4" cols="40" maxlength="500" helper="Plain text, up to 500 characters." :readonly="$locked" :data-basic-notes="$livewire ? true : null" />
@endif
@if (in_array($kind, ['checkbox', 'all'], true))
                    <x-sirius::checkbox :id="($automaticIds ?? false) ? null : $demoId.'-agree'" label="I accept the workspace terms" :attributes="$bind('agreed', '.live')" :error-bag="$demoBag" name="agreed" required :readonly="$locked" helper="Accept the terms before joining the workspace." :data-basic-agree="$livewire ? true : null" />
                    <x-sirius::field :id="($automaticIds ?? false) ? null : $demoId.'-roles'" group label="Member access" :error-bag="$demoBag" error-key="roles" helper="Choose the permissions for a new teammate." required>
                        <div class="flex flex-wrap gap-4">
                            <x-sirius::checkbox :id="($automaticIds ?? false) ? null : $demoId.'-role-zero'" label="Reader" :error-bag="$demoBag" name="roles[]" value="0" :checked="!$livewire && ($kind === 'radio' ? ($values['plan'] ?? null) === '0' : in_array('0', $values['roles'] ?? [], true))" :attributes="$bind('roles', '.live')" :readonly="$locked" :data-basic-role-zero="$livewire ? true : null" />
                            <x-sirius::checkbox :id="($automaticIds ?? false) ? null : $demoId.'-role-editor'" label="Editor" :error-bag="$demoBag" name="roles[]" value="editor" :checked="!$livewire && in_array('editor', $values['roles'] ?? [], true)" :attributes="$bind('roles', '.live')" :readonly="$locked" :data-basic-role-editor="$livewire ? true : null" />
                        </div>
                    </x-sirius::field>
                    <x-sirius::checkbox :id="($automaticIds ?? false) ? null : $demoId.'-mixed'" label="All project notifications" helper="A mixed state indicates that only some project alerts are selected." :indeterminate="$mixed" :readonly="$locked" :data-basic-mixed="$livewire ? true : null" />
@endif
@if (in_array($kind, ['radio', 'all'], true))
                    <x-sirius::field :id="($automaticIds ?? false) ? null : $demoId.'-plans'" group label="Subscription plan" helper="Choose the plan for your workspace." :error-bag="$demoBag" error-key="plan" required>
                        <div class="flex flex-wrap gap-4">
                            <x-sirius::radio :id="($automaticIds ?? false) ? null : $demoId.'-plan-zero'" :error-bag="$demoBag" :name="$livewire ? $demoId.'-plan' : 'plan'" label="Free" value="0" :checked="!$livewire && ($kind === 'radio' ? ($values['plan'] ?? null) === '0' : in_array('0', $values['roles'] ?? [], true))" :attributes="$bind('plan', '.live')" required :readonly="$locked" :data-basic-plan-zero="$livewire ? true : null" />
                            <x-sirius::radio :id="($automaticIds ?? false) ? null : $demoId.'-plan-pro'" :error-bag="$demoBag" :name="$livewire ? $demoId.'-plan' : 'plan'" label="Pro" value="pro" :checked="!$livewire && ($values['plan'] ?? null) === 'pro'" :attributes="$bind('plan', '.live')" required :readonly="$locked" :data-basic-plan-pro="$livewire ? true : null" />
                        </div>
                    </x-sirius::field>
@endif
@if (in_array($kind, ['switch', 'all'], true))
                    <x-sirius::switch :id="($automaticIds ?? false) ? null : $demoId.'-enabled'" label="Enable security alerts" :error-bag="$demoBag" name="enabled" required :attributes="$bind('enabled', '.live')" :readonly="$locked" helper="Security alerts must be enabled for this workspace." :data-basic-enabled="$livewire ? true : null" />
@endif
