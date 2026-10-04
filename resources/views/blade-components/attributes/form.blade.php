<section class="min-w-0 space-y-3" data-docs-props>
    <h3 class="text-xl font-medium">Attributes</h3>
    <x-docs-props :rows="[
        ['action', 'string', 'required', 'Explicit form destination, usually generated with route().'],
        ['method', 'GET | POST | PUT | PATCH | DELETE', 'GET', 'Case-insensitive request method. PUT, PATCH, and DELETE use POST with a hidden _method field. Non-GET methods receive a CSRF field.'],
        ['sending-file', 'boolean', 'false', 'Use multipart/form-data. Requires a non-GET method; conflicting enctype values are rejected.'],
    ]" note="Accepts HTML5 form attributes, Alpine events, data-*, and ARIA. Submissions use the browser; Livewire submission handling is not provided." />
</section>
