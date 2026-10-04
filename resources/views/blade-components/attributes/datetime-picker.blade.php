<section class="min-w-0 space-y-3" data-docs-props>
    <h3 class="text-xl font-medium">Attributes</h3>
    <x-docs-props :rows="[
        ['type', 'date | time | datetime', 'date', 'Date, time, or both. Submitted formats: Y-m-d, H:i, or Y-m-d H:i:s. Includes a calendar or clock icon.'],
        ['display-format', 'string', 'd/m/Y; H:i; d/m/Y H:i:S', 'Flatpickr display format; uppercase S means seconds. Include all parts needed by the selected type.'],
        ['timezone', 'IANA timezone', 'sirius-ui.timezone → app.timezone → UTC', 'Timezone for the initial day/time; overrides config. Does not convert values to UTC.'],
        ['locale', 'string', 'sirius-ui.locale → app.locale → app.fallback_locale → en', 'Priority: prop, options.locale, then global defaults. Regional codes use a bundled match or language fallback, such as id_ID → id. Unsupported languages are rejected.'],
        ['week-start', 'integer | null', 'locale default', 'First weekday: 0 (Sunday) through 6 (Saturday).'],
        ['minute-increment', 'integer', '5', 'Time spinner increment, 1–60; not a server-side restriction on submitted minutes.'],
        ['min-date', 'string | null', 'null', 'Earliest date in canonical date/datetime format; unavailable in time type.'],
        ['max-date', 'string | null', 'null', 'Latest date in canonical date/datetime format; unavailable in time type.'],
        ['min-time', 'string | null', 'null', 'Earliest time in H:i format for time/datetime. Overnight ranges are rejected.'],
        ['max-time', 'string | null', 'null', 'Latest time in H:i format for time/datetime. Overnight ranges are rejected.'],
        ['disabled-dates', 'array', '[]', 'Unavailable Y-m-d dates for date/datetime. Validate equivalent restrictions on the server.'],
        ['clearable', 'boolean', '!required', 'Show the Clear suffix button. Defaults to !required; explicit values override it. Keyboard deletion and reset remain available.'],
        ['options', 'array', '[]', 'Compatible Flatpickr options: minDate, maxDate, minTime, maxTime, disable, locale, minuteIncrement, hourIncrement, time_24hr, weekNumbers, showMonths, monthSelectorType, position, shorthandCurrentMonth, ariaDateFormat, defaultHour, defaultMinute. Defaults, then options, then explicit non-null props determine precedence. Other options are rejected.'],
        ['label', 'string | null', 'null', 'Label text; hidden when empty.'],
        ['helper', 'string | null', 'null', 'Helper text below the control.'],
        ['error-key', 'string | null', 'null', 'Validation key. Defaults to wire:model, then the field name.'],
        ['error-bag', 'string', 'default', 'Laravel validation error bag.'],
        ['errors', 'ViewErrorBag | null', 'null', 'Custom error bags; defaults to Laravel or Livewire errors.'],
        ['size', 'sm | md | lg', 'md', 'Font and padding size; separate from HTML size.'],
        ['wrapper-class', 'string', 'empty string', 'CSS classes for the field wrapper.'],
    ]" note="Accepts HTML5 input attributes, Alpine events, data-*, ARIA, and supported Livewire bindings. Type and widget lifecycle are managed by the package." />
</section>