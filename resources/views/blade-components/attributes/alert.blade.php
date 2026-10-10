<div class="min-w-0 space-y-3" data-docs-props>
    <x-docs-props :rows="[
        ['text', 'string', 'required', 'Plain text for the prompt. HTML is escaped.'],
        ['title', 'string | null', 'null', 'Optional heading between the icon and text. HTML is escaped.'],
        ['icon', 'string | null', 'null', 'Registered Blade Icons name. Decorative; the title or text provides the accessible name.'],
        ['variant', 'primary | info | success | danger | warning | secondary | ghost | outline', 'info', 'Visual style.'],
        ['footer', 'slot | null', 'null', 'Your action buttons or other footer content.'],
        ['open', 'boolean', 'false', 'Initial/server modal state. Synchronize user closes back to your Alpine or Livewire state.'],
        ['size', 'sm | md | lg | xl | full', 'md', 'Maximum width: 24, 32, 48, or 64 rem; full uses the available width. All sizes fit the viewport.'],
        ['closable', 'boolean', 'false', 'Show the header Close button. Does not change Escape or backdrop behavior.'],
        ['close-on-escape', 'boolean', 'true', 'Allow Escape to close the dialog.'],
        ['close-on-backdrop', 'boolean', 'true', 'Allow a click outside the dialog to close it.'],
        ['initial-focus', 'string | null', 'null', 'CSS selector inside the dialog. Falls back to autofocus or native initial focus when unavailable.'],
    ]" />
</div>