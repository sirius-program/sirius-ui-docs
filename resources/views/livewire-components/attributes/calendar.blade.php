<h2 class="text-xl font-medium mb-4">Attributes</h2>
<x-docs-props :rows="[
    ['label', 'string | null', 'Translation', 'Accessible calendar name.'],
    ['initial-view', 'string | null', 'dayGridMonth', 'dayGridMonth, timeGridWeek, timeGridDay, or listWeek.'],
    ['initial-date', 'string | null', 'Today', 'Initial date in the resolved timezone.'],
    ['locale', 'string | null', 'sirius-ui.locale → app.locale → app.fallback_locale → en', 'Date formatting locale. Region names fall back to their bundled language when needed.'],
    ['timezone', 'IANA timezone | null', 'sirius-ui.timezone → app.timezone → UTC', 'IANA timezone for rendering and PHP event-source dates.'],
    ['first-day', 'integer | null', 'Locale default', 'First weekday, from 0 (Sunday) to 6 (Saturday).'],
    ['selectable', 'boolean | null', 'false', 'Allow date/range selection. Date clicks remain available.'],
    ['editable', 'boolean | null', 'false', 'Allow dragging/resizing, subject to per-event permissions and application acknowledgment.'],
    ['options', 'array', '[]', 'Additional serializable FullCalendar v7 options. Explicit props override this array.'],
]" note="Accepts these component props. HTML5, Alpine, data/ARIA attributes, and form wire:model bindings are not forwarded to the calendar. Use the local JavaScript extension for render hooks." />
