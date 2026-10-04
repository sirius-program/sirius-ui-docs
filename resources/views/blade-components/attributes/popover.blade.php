<section class="min-w-0 space-y-3" data-docs-props>
    <h3 class="text-xl font-medium">Attributes</h3>
    <x-docs-props :rows="[
        ['trigger', 'slot', 'Required', 'One focusable trigger in the named slot; its attributes and actions are retained.'],
        ['variant', 'info | primary | secondary | warning | success | danger', 'info', 'Visual style.'],
        ['placement', 'top | right | bottom | left', 'bottom', 'Preferred side. The panel flips and stays inside the viewport.'],
        ['label', 'string', 'Translated', 'Accessible name for the panel.'],
        ['open', 'boolean', 'false', 'Initial open state. Changing this prop from Livewire updates the open state.'],
        ['wrapper-class', 'string', 'empty string', 'CSS classes for the wrapper.']
    ]" note="Provided HTML5 attributes, Alpine events, data-*, ARIA, and supported Livewire bindings go on the wrapper. Put trigger attributes and actions on the slotted element." />
</section>
