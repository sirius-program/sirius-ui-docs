@php
    $rows = [
        ['label', 'string | null', 'null', 'Label text; hidden when empty.'],
        ['helper', 'string | null', 'null', 'Helper text below the control.'],
        ['error-key', 'string | null', 'null', 'Validation key. Defaults to wire:model, then the field name.'],
        ['error-bag', 'string', 'default', 'Laravel validation error bag.'],
        ['errors', 'ViewErrorBag | null', 'null', 'Custom error bags; defaults to Laravel or Livewire errors.'],
        ['size', 'sm | md | lg', 'md', 'Font and padding size; separate from HTML size.'],
        ['wrapper-class', 'string', 'empty string', 'CSS classes for the field wrapper.'],
    ];
    if (in_array($kind, ['input', 'password'], true)) {
        $rows = array_merge($rows, [
            ['type', 'any valid html5 input type | password', 'text', 'Choose the native input mode; use password for the eye toggle.'],
            ['prefix', 'string | null', 'null', 'Text or slot before the input. The slot takes priority; neither is submitted.'],
            ['suffix', 'string | null', 'null', 'Text or slot after the input. The slot takes priority; neither is submitted.'],
            ['control-size', 'integer | null', 'null', 'HTML size: approximate width in characters. Does not limit text length.'],
        ]);
        if ($kind === 'password') {
            $rows[] = ['show-label', 'string', 'Show', 'Button label and tooltip for showing the password.'];
            $rows[] = ['hide-label', 'string', 'Hide', 'Button label and tooltip for hiding the password.'];
        }
    } elseif ($kind === 'textarea') {
        $rows = array_merge($rows, [
            ['resize', 'none | vertical | horizontal | both', 'vertical', 'Allowed resize directions.'],
            ['editor', 'boolean', 'false', 'Not available yet; true is rejected.'],
        ]);
    } else {
        if ($kind === 'checkbox') {
            $rows[] = ['indeterminate', 'boolean', 'false', 'Show a mixed state without changing the value. Cleared on interaction.'];
        }
    }
@endphp
<x-docs-props :rows="$rows" />
