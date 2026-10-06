<x-layouts::app title="Calendar · Actions">
    <x-docs-page :navigation="['Actions' => ['calendar-demo' => 'Demo', 'calendar-usage' => 'Usage', 'interaction-hooks' => 'Interaction hooks', 'saving-changes' => 'Saving changes', 'refresh' => 'Refresh']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">CALENDAR</p>
                <h1 class="text-3xl font-semibold">Actions</h1>
                <p>Connect application-owned forms and save schedule changes.</p>
            </header>
            <section id="calendar-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.calendar-host')
                </div>
            </section>
            <section id="calendar-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.calendar-actions')
            </section>
            <section id="interaction-hooks" class="space-y-4">
                <h2 class="text-xl font-medium">Interaction hooks</h2>
                <p>Override <code>onDateClick()</code>, <code>onSelect()</code>, or <code>onEventClick()</code> to open your own form or navigate. Defaults dispatch <code>calendar:date-click</code>, <code>calendar:select</code>, and <code>calendar:event-click</code>.</p>
                <p>All contexts contain calendar <code>id</code> and <code>timezone</code>. Date/range contexts add <code>start</code>, nullable <code>end</code>, and <code>allDay</code>. Event contexts add <code>eventId</code> and the server-loaded <code>record</code>.</p>
                <p>Event clicks also include an <code>occurrence</code> span for the clicked date, including recurring instances. Event URLs require a redirect from <code>onEventClick()</code>.</p>
                <p>The demo parent listens for the subclass's events and owns the create/edit/delete form.</p>
                <x-docs-code language="PHP" :source="file_get_contents(app_path('Livewire/Examples/CalendarActions.php'))" />
                <x-docs-example view="livewire-components.demos.calendar" />
            </section>
            <section id="saving-changes" class="space-y-4">
                <h2 class="text-xl font-medium">Saving changes</h2>
                <p><code>onEventDrop()</code> and <code>onEventResize()</code> receive <code>eventId</code>, <code>record</code>, <code>old</code>, <code>new</code>, and <code>relatedIds</code>, alongside the calendar ID and timezone.</p>
                <p>Reload and authorize the record, validate the proposed schedule, save it, then return true. Returning false or a failed request restores the old position.</p>
                <p>The application owns conflict checks and grouped/recurring edit policy. Try <strong>Toggle rejected changes</strong> to see rollback.</p>
            </section>
            <section id="refresh" class="space-y-4">
                <h2 class="text-xl font-medium">Refresh</h2>
                <p>Call <code>refreshCalendar()</code> on the subclass, or dispatch <code>calendar:refresh.{id}</code> after an external form saves. Refresh keeps the current date and view.</p>
                <x-docs-code language="PHP" source="$this->dispatch('calendar:refresh.team-calendar');" />
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
