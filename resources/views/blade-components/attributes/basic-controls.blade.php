@php
    $rows = [
        ['id', 'string', 'Random 5 characters', 'Generated when omitted or null; prefixes helper/error IDs. Pass an explicit unique ID for stable Livewire identity or external selectors.', 'Optional'],
        ['label', 'string | null', 'null', 'Visible label; omitted when empty.', 'Optional'],
        ['name', 'string | null', 'null', 'Native submitted field name, including array-style names.', 'Optional'],
        ['helper', 'string | null', 'null', 'Supporting text below the control.', 'Optional'],
        ['required', 'boolean', 'false', 'Required indicator and native required state; grouped choices show one marker.', 'Optional'],
        ['disabled', 'boolean', 'false', 'Disables interaction and omits the control from submission.', 'Optional'],
        ['readonly', 'boolean', 'false', $kind === 'radio' ? 'Requires package JavaScript. Set consistently across a radio group; one readonly option locks user changes throughout the same-name/form group while preserving focus and server updates.' : 'Prevents editing while retaining submission and focus. Checkbox/switch require package JavaScript. This is a UI constraint, not authorization.', 'Optional'],
        ['error-key', 'string | null', 'null', 'Overrides error lookup from the binding or normalized name.', 'Optional'],
        ['error-bag', 'string', 'default', 'Laravel named validation bag. Choice groups share their parent bag.', 'Optional'],
        ['errors', 'ViewErrorBag | null', 'null', 'Optional explicit error bag; otherwise supplied by Laravel/Livewire.', 'Optional'],
        ['size', 'sm | md | lg', 'md', 'Visual sizing, independent from the native size attribute.', 'Optional'],
        ['wrapper-class', 'string', "''", 'Additional classes for the field wrapper.', 'Optional'],
        ['class', 'string', "''", 'Additional classes merged onto the native control.', 'Optional'],
    ];
    if (in_array($kind, ['input', 'password'], true)) {
        $rows = array_merge($rows, [
            ['type', 'text | number | password', 'text', 'Choose the native input mode; use password for the eye toggle.', 'Optional'],
            ['value', 'string | number | null', 'null', 'Initial ordinary Blade value; Livewire bindings own reactive values. Never repopulate real passwords from old input or log them.', 'Optional'],
            ['prefix / suffix', 'string | named slot', 'null', 'Visual adornments excluded from submission; named slots take precedence. Describe essential units in the label or helper.', 'Optional'],
            ['control-size', 'integer | null', 'null', 'Native HTML size, separately from visual size.', 'Optional'],
            ['show-label / hide-label', 'string', 'Show / Hide', 'Translatable eye-button labels for hover tooltips and assistive technology; both follow the current action. The toggle preserves value and selection, never submits, and returns focus to the input. Native reset/remount masks the value.', 'Optional'],
        ]);
    } elseif ($kind === 'textarea') {
        $rows = array_merge($rows, [
            ['value / default slot', 'string | slot', 'null', 'Initial content; a non-null value takes precedence over the slot.', 'Optional'],
            ['resize', 'none | vertical | horizontal | both', 'vertical', 'Allowed resize directions.', 'Optional'],
            ['richtext', 'boolean', 'false', 'Reserved for Phase 7. True is currently rejected.', 'Optional'],
            ['rows / cols / maxlength / wrap', 'HTML attributes', 'Browser default', 'Native dimensions, length limit, and wrapping behavior.', 'Optional'],
        ]);
    } else {
        $rows = array_merge($rows, [
            ['value', 'string | number', 'on', 'Value submitted when checked; unchecked controls are omitted. Keep distinct option values, including string 0. Normalize booleans with Request::boolean().', 'Optional'],
            ['checked', 'boolean', 'false', 'Initial ordinary Blade checked state; Livewire owns bound state.', 'Optional'],
        ]);
        if ($kind === 'checkbox') {
            $rows[] = ['indeterminate', 'boolean', 'false', 'Visual mixed state, independent of the checked/submitted value. User activation clears it; server updates and native resets restore the declared state.', 'Optional'];
        }
    }
@endphp
<x-docs-props :rows="$rows" />
