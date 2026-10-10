<x-layouts::app title="Calendar · Actions">
    <x-docs-page :navigation="['Actions' => ['calendar-demo' => 'Demo', 'calendar-usage' => 'Usage', 'interaction-hooks' => 'Interaction hooks', 'saving-changes' => 'Saving changes', 'refresh' => 'Refresh']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">CALENDAR</p>
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
                <p>Override <x-sirius::code>onDateClick()</x-sirius::code>, <x-sirius::code>onSelect()</x-sirius::code>, or <x-sirius::code>onEventClick()</x-sirius::code> to open your own form or navigate. Defaults dispatch <x-sirius::code>calendar:date-click</x-sirius::code>, <x-sirius::code>calendar:select</x-sirius::code>, and <x-sirius::code>calendar:event-click</x-sirius::code>.</p>
                <p>All contexts contain calendar <x-sirius::code>id</x-sirius::code> and <x-sirius::code>timezone</x-sirius::code>. Date/range contexts add <x-sirius::code>start</x-sirius::code>, nullable <x-sirius::code>end</x-sirius::code>, and <x-sirius::code>allDay</x-sirius::code>. Event contexts add <x-sirius::code>eventId</x-sirius::code> and the server-loaded <x-sirius::code>record</x-sirius::code>.</p>
                <p>Event clicks also include an <x-sirius::code>occurrence</x-sirius::code> span for the clicked date, including recurring instances. Event URLs require a redirect from <x-sirius::code>onEventClick()</x-sirius::code>.</p>
                <p>The demo parent listens for the subclass's events and owns the create/edit/delete form.</p>
                @include('livewire-components.examples.calendar-parent')
                <x-docs-example view="livewire-components.demos.calendar" />
            </section>
            <section id="saving-changes" class="space-y-4">
                <h2 class="text-xl font-medium">Saving changes</h2>
                <p><x-sirius::code>onEventDrop()</x-sirius::code> and <x-sirius::code>onEventResize()</x-sirius::code> receive <x-sirius::code>eventId</x-sirius::code>, <x-sirius::code>record</x-sirius::code>, <x-sirius::code>old</x-sirius::code>, <x-sirius::code>new</x-sirius::code>, and <x-sirius::code>relatedIds</x-sirius::code>, alongside the calendar ID and timezone.</p>
                <p>Reload and authorize the record, validate the proposed schedule, save it, then return true. Returning false or a failed request restores the old position.</p>
                <p>The application owns conflict checks and grouped/recurring edit policy. Try <strong>Toggle rejected changes</strong> to see rollback.</p>
            </section>
            <section id="refresh" class="space-y-4">
                <h2 class="text-xl font-medium">Refresh</h2>
                <p>Call <x-sirius::code>refreshCalendar()</x-sirius::code> on the subclass, or dispatch <x-sirius::code>calendar:refresh.{id}</x-sirius::code> after an external form saves. Refresh keeps the current date and view.</p>
                @include('livewire-components.examples.calendar-refresh')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
