<div class="min-w-0 space-y-3" data-docs-props>
    <h3 class="text-lg font-medium">Parent</h3>
    <x-docs-props :rows="[
        ['label', 'string', 'Translated', 'Accessible name for the sequence.']
    ]" />
    <h3 class="mt-5 text-lg font-medium">Item</h3>
    <x-docs-props :rows="[
        ['title', 'string | slot', 'Required', 'Item title. A named slot overrides the text.'],
        ['description', 'string | null', 'null', 'Supporting text below the title.'],
        ['state', 'completed | current | upcoming', 'upcoming', 'Marker style and accessible progress state.'],
        ['icon', 'string | null', 'null', 'Blade icon name. Overrides the number.'],
        ['number', 'integer | null', 'null', 'Positive marker number. Omit for the state marker.'],
        ['marker', 'slot', 'Optional', 'Custom decorative marker. Overrides icon and number.'],
    ]" />
</div>
