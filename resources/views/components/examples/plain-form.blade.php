<form id="plain-basic-form" method="POST" action="{{ route('components.basic.store') }}" class="space-y-4" novalidate>
    @csrf
    <x-sirius::input id="plain-title" name="title" label="Title" helper="Required; no data is stored." required :value="old('title', 'Initial title')" error-bag="basic" prefix="Project" suffix="Example" />
    <x-sirius::input id="plain-quantity" name="quantity" type="number" label="Quantity" min="0" max="100" :value="old('quantity', 0)" error-bag="basic" />
    <x-sirius::textarea id="plain-notes" name="notes" label="Notes" :value="old('notes', 'Initial notes')" error-bag="basic" />
    <x-sirius::field id="plain-roles" group label="Roles" helper="Multiple values may be submitted." error-key="roles" error-bag="basic">
        <x-sirius::checkbox id="plain-reader" name="roles[]" label="Reader role" value="0" :checked="in_array('0', old('roles', ['0']), true)" />
        <x-sirius::checkbox id="plain-editor" name="roles[]" label="Editor role" value="editor" :checked="in_array('editor', old('roles', []), true)" />
    </x-sirius::field>
    <x-sirius::field id="plain-plan" group label="Plan" helper="Select one plan." error-key="plan" error-bag="basic" required>
        <x-sirius::radio id="plain-free" name="plan" label="Free plan" value="0" :checked="old('plan', '0') === '0'" required />
        <x-sirius::radio id="plain-pro" name="plan" label="Pro plan" value="pro" :checked="old('plan', '0') === 'pro'" required />
    </x-sirius::field>
    <x-sirius::switch id="plain-enabled" name="enabled" label="Enabled" value="1" :checked="(bool) old('enabled', true)" readonly />
    <x-sirius::checkbox id="plain-disabled" name="ignored" label="Disabled example" checked disabled />
    <x-sirius::checkbox id="plain-mixed" label="Mixed example" indeterminate />
    <x-sirius::input id="plain-password" type="password" label="Unsubmitted demo password" value="demo-secret" />
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit">Submit Blade sample</flux:button>
        <flux:button type="reset">Reset Blade sample</flux:button>
    </div>
</form>
@if (session('basic-result'))
    <p role="status">Blade sample received. Nothing was stored.</p>
@endif
