<section class="min-w-0 space-y-3" data-docs-props>
    <h3 class="text-xl font-medium">Attributes</h3>
    <x-docs-props :rows="[
        ['header', 'string | null', 'null', 'Header text. The named header slot overrides it.'],
        ['body', 'string | null', 'null', 'Body text. A nonempty default slot overrides it.'],
        ['footer', 'string | null', 'null', 'Footer text. The named footer slot overrides it.'],
        ['header-class', 'string', 'empty string', 'Additional classes for the header.'],
        ['body-class', 'string', 'empty string', 'Additional classes for the body.'],
        ['footer-class', 'string', 'empty string', 'Additional classes for the footer.'],
        ['open', 'boolean', 'false', 'Initial/server modal state. Synchronize user closes back to your Alpine or Livewire state.'],
        ['size', 'sm | md | lg | xl | full', 'md', 'Maximum width: 24, 32, 48, or 64 rem; full uses the available width. All sizes fit the viewport.'],
        ['closable', 'boolean', 'true', 'Show the header Close button. Does not change Escape or backdrop behavior.'],
        ['close-on-escape', 'boolean', 'true', 'Allow Escape to close the dialog.'],
        ['close-on-backdrop', 'boolean', 'true', 'Allow a click outside the dialog to close it.'],
        ['initial-focus', 'string | null', 'null', 'CSS selector inside the dialog. Falls back to autofocus or native initial focus when unavailable.'],
    ]"/>
</section>