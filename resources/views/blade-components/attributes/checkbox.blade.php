<x-docs-props :rows="[
    ['label', 'string | null', 'null', 'Label text; hidden when empty.'],
    ['helper', 'string | null', 'null', 'Helper text below the control.'],
    ['error-key', 'string | null', 'null', 'Validation key. Defaults to wire:model, then the field name.'],
    ['error-bag', 'string', 'default', 'Laravel validation error bag.'],
    ['errors', 'ViewErrorBag | null', 'null', 'Custom error bags; defaults to Laravel or Livewire errors.'],
    ['size', 'sm | md | lg', 'md', 'Font and padding size; separate from HTML size.'],
    ['wrapper-class', 'string', 'empty string', 'CSS classes for the field wrapper.'],
    ['indeterminate', 'boolean', 'false', 'Show a mixed state without changing the value. Cleared on interaction.'],
]" />
