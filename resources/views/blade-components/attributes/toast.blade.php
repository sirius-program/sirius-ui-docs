<div class="min-w-0 space-y-3" data-docs-props>
    <x-docs-props :rows="[
        ['text', 'string', 'required', 'Plain text for the notification. HTML is escaped.'],
        ['title', 'string | null', 'null', 'Optional heading between the icon and text. HTML is escaped.'],
        ['icon', 'string | null', 'null', 'Registered Blade Icons name. Decorative; the title or text provides the accessible name.'],
        ['variant', 'primary | info | secondary | success | danger | warning | ghost | outline', 'info', 'Visual style.'],
        ['footer', 'slot | null', 'null', 'Your action buttons or other footer content.'],
        ['position', 'top-start | top-center | top-end | bottom-start | bottom-center | bottom-end | null', 'sirius-ui.toast_position (top-end)', 'Viewport position. Start and end follow LTR/RTL direction; an explicit value overrides configuration.'],
        ['duration', 'integer | null', 'sirius-ui.toast_duration (5000)', 'Time in milliseconds before closing. Zero keeps the notification visible; an explicit value overrides configuration.'],
        ['open', 'boolean', 'false', 'Initial/server notification state. Synchronize user and automatic closes back to your Alpine or Livewire state.'],
        ['closable', 'boolean', 'true', 'Show the Close button and allow Escape while focus is inside the notification.'],
        ['class', 'string', '', 'Additional classes for the content.'],
        ['style', 'string', '', 'Inline styles for the content.'],
    ]" />
</div>
