<div class="space-y-4" data-docs-props>
    <h2 class="text-xl font-medium">Parameters</h2>
    <x-docs-props :rows="[
        ['key', 'string', 'Required', 'Unique filter key.'],
        ['label', 'string', 'Required', 'Filter label.'],
        ['apply', 'Closure', 'Required', 'Receive the source and validated string value. Modify a Builder, or return the filtered Collection.'],
        ['type', 'text | select | date | time | datetime', 'text', 'Search input, Select, or Datetime Picker inside the dropdown.'],
        ['options', 'array', '[]', 'Value and label pairs for Select. Local filters accept only these values.'],
        ['default', 'string', 'Empty string', 'Initial value and value restored by Reset filters.'],
        ['searchUrl', 'string | null', 'null', 'Same-origin Select endpoint for remote search, pagination, and selected-label resolution. Only available with type select.'],
    ]" note="Values are validated before the callback runs." />
</div>
