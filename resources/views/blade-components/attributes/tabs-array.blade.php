<div class="min-w-0 space-y-3" data-docs-props>
    <x-docs-props :rows="[
        ['items.*.label', 'string', 'Required', 'Tab text. A plain string item is shorthand for this label.'],
        ['items.*.icon', 'string | null', 'null', 'Blade icon name.'],
        ['items.*.disabled', 'boolean', 'false', 'Excludes the tab from selection and keyboard navigation.']
    ]" note="When every tab is disabled, all panels remain hidden." />
</div>