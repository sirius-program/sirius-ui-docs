<section class="min-w-0 space-y-3" data-docs-props>
    <h3 class="text-xl font-medium">Attributes</h3>
    <x-docs-props :rows="[
        ['label', 'string | null', 'null', 'Label text; hidden when empty.'],
        ['helper', 'string | null', 'null', 'Helper text below the control.'],
        ['error-key', 'string | null', 'null', 'Validation key. Defaults to wire:model, then the field name.'],
        ['error-bag', 'string', 'default', 'Laravel validation error bag.'],
        ['errors', 'ViewErrorBag | null', 'null', 'Custom error bags; defaults to Laravel or Livewire errors.'],
        ['size', 'sm | md | lg', 'md', 'Font and padding size; separate from HTML size.'],
        ['wrapper-class', 'string', 'empty string', 'CSS classes for the field wrapper.'],
        ['type', 'any valid HTML5 input type', 'text', 'Choose the native input mode; use password for the eye toggle.'],
        ['prefix', 'string | null', 'null', 'Text or slot before the input. The slot takes priority; neither is submitted.'],
        ['suffix', 'string | null', 'null', 'Text or slot after the input. The slot takes priority; neither is submitted.'],
        ['control-size', 'integer | null', 'null', 'HTML size: approximate width in characters. Does not limit text length.'],
        ['show-label', 'string', 'Show', 'Button label and tooltip for showing the password.'],
        ['hide-label', 'string', 'Hide', 'Button label and tooltip for hiding the password.'],
    ]" />
</section>