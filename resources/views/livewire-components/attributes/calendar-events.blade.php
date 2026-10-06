<h2 class="text-xl font-medium mb-4">Event Arrays</h2>
<x-docs-props :rows="[
    ['id', 'string | integer', 'Required', 'Unique event identity, normalized to a string.'],
    ['title', 'string', 'Required', 'Event label.'],
    ['start', 'string', 'Required for one-off events', 'All-day date or timed date with an offset.'],
    ['end', 'string | null', 'null', 'Exclusive end, later than start.'],
    ['allDay', 'boolean', 'Inferred from start', 'Treat the event as an all-day date span.'],
    ['url', 'string | null', 'null', 'HTTP(S), local path, or hash link. Redirect from onEventClick() to navigate.'],
    ['editable', 'boolean', 'Calendar setting', 'Allow drag/resize for this event. Recurring definitions remain read-only unless opted in.'],
    ['startEditable', 'boolean', 'editable', 'Allow dragging this event.'],
    ['durationEditable', 'boolean', 'editable', 'Allow resizing this event.'],
    ['daysOfWeek', 'array | null', 'null', 'Recurring weekdays, from 0 (Sunday) to 6 (Saturday).'],
    ['startTime', 'string | null', 'null', 'Recurring start time in HH:mm or HH:mm:ss.'],
    ['endTime', 'string | null', 'null', 'Recurring end time in HH:mm or HH:mm:ss.'],
    ['startRecur', 'string | null', 'null', 'First recurrence date in Y-m-d.'],
    ['endRecur', 'string | null', 'null', 'Exclusive recurrence end date in Y-m-d.'],
]" note="Event arrays accept additional serializable FullCalendar Standard fields." />
