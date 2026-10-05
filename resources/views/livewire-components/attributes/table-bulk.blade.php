<div class="space-y-4" data-docs-props>
    <h2 class="text-xl font-medium">Methods and variables</h2>
    <x-docs-props :rows="[
        ['bulkActionsView()', 'string | null', 'null', 'Blade view name enabling checkboxes and the bulk menu. Receives selectedIds, including checked IDs from other pages. An empty selection disables the menu.'],
        ['selectedIds', 'array of integer | string', '[]', 'Locked selection state. IDs keep their source key types. Use selection methods instead of setting this property.'],
        ['toggleSelection(id)', 'method', '—', 'Checks or unchecks a record on the current page of the scoped query. Accepts an integer or string ID.'],
        ['togglePageSelection()', 'method', '—', 'Checks the current page, or unchecks it when every visible record is checked. Partial selection shows an indeterminate header checkbox.'],
        ['clearSelection()', 'method', '—', 'Clears all checked IDs on this Table, including other pages.'],
        ['removeSelection(ids)', 'method', '—', 'Removes only the supplied IDs from this Table selection. Accepts an array of integer or string IDs.'],
    ]" note="" />
</div>
