<x-docs-props :rows="[
    ['variant', 'primary | info | success | danger | warning | secondary | ghost | outline', 'info', 'Visual style. Danger defaults to role=alert; other variants use role=status.'],
    ['icon', 'string|null', 'null', 'Optional Blade Icons name.'],
    ['dismissible', 'boolean', 'false', 'Shows the dismiss button.'],
    ['reset-key', 'string|number', '\'\'', 'Change to show a dismissed message again.'],
    ['id', 'string', 'Random 5 characters', 'Use an explicit ID for stable Livewire identity and external selectors.']
]" note="Accepts HTML5 attributes, Alpine events, data-*, ARIA, and supported Livewire directives. These components do not use wire:model." />
