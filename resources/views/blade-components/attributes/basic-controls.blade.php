@php
    $rows = [
        ['label', 'string | null', 'null', 'Visible label; omitted when empty.'],
        ['helper', 'string | null', 'null', 'Supporting text below the control.'],
        ['error-key', 'string | null', 'null', 'Override the validation key; otherwise use the wire:model path, then the normalized name.'],
        ['error-bag', 'string', 'default', 'Named Laravel validation error bag.'],
        ['errors', 'ViewErrorBag | null', 'null', 'Optional explicit error bags; otherwise supplied by Laravel or Livewire.'],
        ['size', 'sm | md | lg', 'md', 'Visual size (font and padding), independent of the native HTML size attribute.'],
        ['wrapper-class', 'string', 'empty string', 'Additional CSS classes for the field wrapper.'],
    ];
    if (in_array($kind, ['input', 'password'], true)) {
        $rows = array_merge($rows, [
            ['type', 'any valid html5 input type | password', 'text', 'Choose the native input mode; use password for the eye toggle.'],
            ['prefix', 'string | null', 'null', 'Text or named slot before the input. The slot overrides the prop; adornments are excluded from submission.'],
            ['suffix', 'string | null', 'null', 'Text or named slot after the input. The slot overrides the prop; adornments are excluded from submission.'],
            ['control-size', 'integer | null', 'null', 'Native HTML size attribute: approximate width in characters, subject to CSS. Does not limit input length.'],
        ]);
        if ($kind === 'password') {
            $rows[] = ['show-label', 'string', 'Show', 'Translatable button text for showing the password value.'];
            $rows[] = ['hide-label', 'string', 'Hide', 'Translatable button text for hiding the password value.'];
        }
    } elseif ($kind === 'textarea') {
        $rows = array_merge($rows, [
            ['resize', 'none | vertical | horizontal | both', 'vertical', 'Allowed resize directions.'],
            ['editor', 'boolean', 'false', 'Reserved for Phase 7. True is currently rejected.'],
        ]);
    } else {
        if ($kind === 'checkbox') {
            $rows[] = ['indeterminate', 'boolean', 'false', 'Visual mixed state, independent of the checked/submitted value; user activation clears it.'];
        }
    }
@endphp
<x-docs-props :rows="$rows" />
