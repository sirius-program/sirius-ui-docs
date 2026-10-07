<x-sirius::form method="POST" action="{{ route('development.fields.validate') }}" novalidate class="space-y-4" data-blade-field-example>
    <x-sirius::field id="plain-email" name="contact[email]" label="Email address" helper="Your address stays in this example only."
        error-bag="profile" type="email" required :value="session('field-loaded') ? 'reader@example.com' : old('contact.email')" autocomplete="email">
        <input {{ $component->controlAttributes() }}>
    </x-sirius::field>
    <div class="flex flex-wrap gap-2">
        <x-sirius::button type="submit" name="sample_action" value="validate">Submit / Validate</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="load" formnovalidate>Load Value</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</x-sirius::button>
    </div>
    @if (session('form-success'))<p role="status">{{ session('form-success') }}</p>@endif
</x-sirius::form>
