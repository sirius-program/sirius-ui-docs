<x-layouts::app title="Calendar · Events">
    <x-docs-page :navigation="['Events' => ['calendar-demo' => 'Demo', 'calendar-usage' => 'Usage', 'events-arrays' => 'Event Arrays', 'visible-range' => 'Visible range', 'date-spans' => 'Date spans', 'recurrence' => 'Recurrence']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">CALENDAR</p>
                <h1 class="text-3xl font-semibold">Events</h1>
                <p>Supply schedule records from an Eloquent query or a Collection.</p>
            </header>
            <section id="calendar-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <h3 class="text-lg font-medium">Eloquent</h3>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.calendar-events-eloquent')
                </div>
                <h3 class="text-lg font-medium">Collection</h3>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.calendar-events-collection')
                </div>
            </section>
            <section id="calendar-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.calendar-events')
            </section>
            <section id="events-arrays">
                @include('livewire-components.attributes.calendar-events')
            </section>
            <section id="visible-range" class="space-y-4">
                <h2 class="text-xl font-medium">Visible range</h2>
                <p><code>events(CarbonImmutable $start, CarbonImmutable $end, string $timezone): iterable</code> receives the visible range in the resolved timezone. Return serializable event arrays with unique IDs.</p>
                <p>Include every event that overlaps the range: event start &lt; range end, and event end &gt; range start. The Eloquent demo uses one-day issue dates; the Collection demo also includes sessions that started before the range.</p>
                <p>Keep permission and tenant constraints in your source. Requests are limited to 370 days; the package does not query business models.</p>
            </section>
            <section id="date-spans" class="space-y-4">
                <h2 class="text-xl font-medium">Date spans</h2>
                <p>Use <code>Y-m-d</code> for all-day dates and ISO-8601 dates with an offset for timed events. Ends are exclusive: an event ending on October 20 occupies dates through October 19.</p>
                <p>A missing end stays null; FullCalendar uses its configured display duration. Each event must contain JSON-compatible values.</p>
            </section>
            <section id="recurrence" class="space-y-4">
                <h2 class="text-xl font-medium">Recurrence</h2>
                <p>Simple daily/weekly schedules use <code>daysOfWeek</code>, optional times, and a recurrence date range. Recurring definitions are read-only by default.</p>
                <p>Recurring times are local to the calendar timezone. Return expanded events with explicit offsets and unique IDs when a series must keep its own timezone or support individual exceptions.</p>
                <p>Override protected <code>recurringEditable()</code> only when your edit hooks enforce an occurrence/series policy. RRule and Premium resource views are outside this release.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
