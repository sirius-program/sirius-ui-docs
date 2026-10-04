<section class="min-w-0 space-y-3" data-docs-props>
    <h3 class="text-xl font-medium">Attributes</h3>
    <x-docs-props :rows="[
        ['name', 'string', 'Required', 'Registered Blade Icons name, such as heroicon-o-check.'],
        ['size', 'sm | md | lg', 'md', 'Icon size.'],
        ['label', 'string | null', 'null', 'Accessible name. Omit for a decorative icon.']
    ]" note="Accepts SVG attributes, Alpine events, data-*, ARIA, and supported Livewire directives." />
</section>
