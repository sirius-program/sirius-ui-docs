<h2 class="text-xl font-medium mb-4">Attributes</h2>
<x-docs-props :rows="[
    ['type', 'string', 'bar', 'Native controller: bar, line, pie, doughnut, radar, polarArea, scatter, or bubble.'],
    ['data', 'array', 'labels: [], datasets: []', 'Chart.js labels and datasets. Keep dataset values JSON-compatible.'],
    ['options', 'array', '[]', 'Serializable Chart.js options. See Options for defaults and precedence.'],
    ['label', 'string | null', 'Translation', 'Accessible chart name. An explicit name cannot be empty.'],
    ['description', 'string | null', 'null', 'Plain text explanation connected to the canvas.'],
    ['width', 'integer | null', 'Container width', 'Positive width in pixels, limited to the available container width.'],
    ['height', 'integer | null', '320', 'Positive height in pixels. An explicit value overrides maintainAspectRatio.'],
    ['loading', 'boolean', 'false', 'Show the loading overlay. Requests from the chart and its immediate Livewire parent also show it.'],
]" note="" />
