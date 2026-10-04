<section class="min-w-0 space-y-3" data-docs-props>
    <h3 class="text-xl font-medium">Attributes</h3>
    <x-docs-props :rows="[
        ['text', 'string', 'Required', 'Plain text shown on hover or focus. HTML is escaped.'],
        ['variant', 'info | primary | secondary | warning | success | danger', 'info', 'Visual style.'],
        ['placement', 'top | right | bottom | left', 'top', 'Preferred side. The panel flips and stays inside the viewport.']
    ]" note="Provided HTML5 attributes, Alpine events, data-*, ARIA, and supported Livewire bindings go on the wrapper. Put trigger attributes and actions on the slotted element." />
</section>
