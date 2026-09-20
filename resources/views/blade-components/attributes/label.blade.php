<x-docs-props :rows="[
    ['required', 'boolean', 'false', 'Append a red asterisk.'],
    ['status', 'string | null', 'null', 'Optional live status aligned opposite the label. An empty string reserves a target for dynamic updates.'],
    ['status-id', 'string | null', 'id → for → null', 'Override the status element ID. By default, append -label-status to the label id, falling back to for; omit the ID when neither is provided.'],
    ['as', 'label | legend', 'label', 'Use legend to name a fieldset. Other tags are rejected.'],
]" />
