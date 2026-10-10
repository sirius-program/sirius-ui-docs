<div class="min-w-0 space-y-3" data-docs-props>
    <x-docs-props :rows="[
        ['items', 'array', 'Required', 'Tab names mapped to labels or arrays with label, icon, and disabled (see below).'],
        ['active', 'string | null', 'null', 'Selected tab name. Missing, unknown, or disabled names select the first enabled tab.'],
        ['label', 'string', 'Translated', 'Accessible name for the tab list.'],
        ['orientation', 'horizontal | vertical', 'horizontal', 'Tab list direction and arrow-key navigation.'],
        ['activation', 'automatic | manual', 'automatic', 'Automatic selects on arrow-key focus. Manual waits for Enter, Space, or click.'],
        ['list-class', 'string', 'empty string', 'Additional classes for the tab list.'],
        ['panel-class', 'string', 'empty string', 'Additional classes for each panel.'],
        ['panel-{name}', 'slot', 'Required per tab', 'Panel content. Names start with a letter and use letters, numbers, underscores, or hyphens; their Blade slot names must be distinct.']
    ]" note="Provided HTML5 attributes, Alpine events, data-*, ARIA, and supported Livewire bindings go on the wrapper." />
</div>
