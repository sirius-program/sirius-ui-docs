<div class="min-w-0 space-y-3" data-docs-props>
    <h4 class="mt-5 text-lg font-medium">Parent</h4>
    <x-docs-props :rows="[
        ['label', 'string', 'Translated Breadcrumb', 'Accessible navigation name.'],
        ['separator', 'string', '/', 'Text between items.'],
        ['separator-icon', 'string | null', 'null', 'Blade icon name. Overrides the text separator.']
    ]" />
    <h4 class="mt-5 text-lg font-medium">Item</h4>
    <x-docs-props :rows="[
        ['link', 'string | null', 'null', 'Destination URL. Omit for plain text.'],
        ['current', 'boolean', 'false', 'Marks the current page.']
    ]" />
</div>
