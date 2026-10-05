<div class="space-y-4" data-docs-props>
    <h2 class="text-xl font-medium">Filter types</h2>
    <x-docs-props :rows="[
        ['text', 'Search input', 'Empty string', 'Validated text passed to your callback.'],
        ['select', 'Select', 'Empty string', 'Local options or a remote search endpoint.'],
        ['date', 'Datetime Picker', 'Empty string', 'Canonical Y-m-d value.'],
        ['time', 'Datetime Picker', 'Empty string', 'Canonical H:i value.'],
        ['datetime', 'Datetime Picker', 'Empty string', 'Canonical Y-m-d H:i:s value.'],
    ]" note="Using Sirius UI blade component under the hood, look at each blade component's page for more detail information about the specific component. Empty values skip the callback. Temporal values are validated before filtering." />
</div>
