<x-docs-props :rows="[
    ['for', 'string | null', 'null', 'ID of the associated native control.', 'Optional'],
    ['required', 'boolean', 'false', 'Append a red asterisk. Use :required=false for a false boolean.', 'Optional'],
    ['as', 'label | legend', 'label', 'Use legend to name a fieldset. Other tags are rejected.', 'Optional'],
    ['class', 'string', 'Empty', 'Classes merged with sir-label.', 'Optional'],
]" note="Applicable HTML5 label/legend attributes, Alpine, data-* and ARIA attributes, and supported Livewire event directives are forwarded to the label or legend. Put wire:model on the actual input, not the label." />
