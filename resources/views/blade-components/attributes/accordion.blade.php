<div class="min-w-0 space-y-3" data-docs-props>
    <x-docs-props :rows="[
        ['trigger', 'string | slot', 'Required', 'Summary text. A named trigger slot overrides the text prop. Do not place interactive controls inside it.'],
        ['transition', 'boolean', 'false', 'Animates content on opening. Closing is immediate; reduced-motion preferences disable animation.'],
        ['name', 'string | null', 'null', 'Use the same nonempty name to group items. Opening one closes the others; all can be closed. Give each group a unique name and set open on at most one item.'],
        ['trigger-class', 'string', 'empty string', 'Additional classes for the trigger.'],
        ['content-class', 'string', 'empty string', 'Additional classes for the content.']
    ]" />
</div>