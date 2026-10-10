<div class="min-w-0 space-y-3" data-docs-props>
    <h4 class="mt-5 text-lg font-medium">Parent</h4>
    <x-docs-props :rows="[
        ['label', 'string', 'Translated Navigation', 'Accessible navigation name.']
    ]" />
    <h4 class="mt-5 text-lg font-medium">Item</h4>
    <x-docs-props :rows="[
        ['icon', 'string | null', 'null', 'Blade icon name.'],
        ['name', 'string | null', 'null', 'Item text. The default slot takes precedence; provide one of them.'],
        ['link', 'string | null', 'null', 'Destination URL. Omit for an action button. Submenu triggers cannot also be links.'],
        ['trailing', 'string | slot | null', 'null', 'Right-side shortcut or badge. A named slot takes precedence.'],
        ['disabled', 'boolean', 'false', 'Blocks activation and removes link destinations.'],
        ['active', 'boolean', 'false', 'Highlights the item. Navigation links also mark the current page.'],
        ['submenu', 'slot | null', 'null', 'Nested menu items. Opens by click or keyboard.'],
        ['open', 'boolean', 'false', 'Initial or bound submenu state. Disabled items stay closed.'],
        ['transition', 'boolean', 'false', 'Animates content on opening. Closing is immediate; reduced-motion preferences disable animation.']
    ]" />
    <h4 class="mt-5 text-lg font-medium">Category</h4>
    <x-docs-props :rows="[
        ['title', 'string', 'Required', 'Section heading.'],
        ['icon', 'string | null', 'null', 'Blade icon beside the heading.']
    ]" />
    <p>Place items inside a category and nested items inside the submenu slot. List markup is generated for you. Item attributes, including wire:key, apply to the link or button. Use x-bind:open on a submenu trigger to bind its state with Alpine.</p>
</div>
