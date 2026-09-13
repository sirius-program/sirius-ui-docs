<form method="POST" action="{{ route('development.fields.validate') }}" novalidate class="space-y-4" data-blade-field-example>
    @csrf
    <x-sirius::field id="plain-email" name="contact[email]" label="Email address" helper="Your address stays in this example only."
        error-bag="profile" type="email" required :value="session('field-loaded') ? 'reader@example.com' : old('contact.email')" autocomplete="email">
        <input {{ $component->controlAttributes() }}>
    </x-sirius::field>
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
    @if (session('form-success'))<p role="status">{{ session('form-success') }}</p>@endif
</form>
