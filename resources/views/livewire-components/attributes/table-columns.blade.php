<div class="space-y-4" data-docs-props>
    <h2 class="text-xl font-medium">Parameters</h2>
    <x-docs-props :rows="[
        ['key', 'string', 'Required', 'Unique column key and default record attribute.'],
        ['label', 'string', 'Required', 'Column heading.'],
        ['field', 'string | null', 'key', 'Search/sort field. Use qualified SQL names for Builder sources or dot paths for Collection records.'],
        ['searchable', 'boolean', 'false', 'Include this field in global search.'],
        ['sortable', 'boolean', 'false', 'Allow sorting from the heading.'],
        ['view', 'string | null', 'null', 'Cell view receiving $record and $column. Default cells escape text.'],
        ['format', 'Closure | null', 'null', 'Format the displayed value using the raw value and $record. Plain strings are escaped; a cell view takes precedence.'],
    ]" note="" />
</div>
