<x-layouts::app title="Calendar · Options">
    <x-docs-page :navigation="['Options' => ['calendar-demo' => 'Demo', 'calendar-usage' => 'Usage', 'fullcalendar-options' => 'FullCalendar options', 'local-extensions' => 'Local extensions']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">CALENDAR</p>
                <h1 class="text-3xl font-semibold">Options</h1>
                <p>Configure views, locale, timezone, and local rendering.</p>
            </header>
            <section id="calendar-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.calendar-options')
                </div>
            </section>
            <section id="calendar-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                @include('livewire-components.examples.calendar-options')
            </section>
            <section id="fullcalendar-options" class="space-y-4">
                <h2 class="text-xl font-medium">FullCalendar options</h2>
                <p>Use serializable Standard options from the <x-sirius::link href="https://fullcalendar.io/docs" target="_blank" rel="noopener noreferrer">FullCalendar v7 reference</x-sirius::link>, such as <x-sirius::code>validRange</x-sirius::code>, <x-sirius::code>businessHours</x-sirius::code>, <x-sirius::code>weekends</x-sirius::code>, or <x-sirius::code>eventConstraint</x-sirius::code>. Validate restrictions again in your application.</p>
                <p><x-sirius::code>lazyFetching</x-sirius::code> defaults to false so navigation fetches current server data. Enable the range cache only if you refresh after application changes.</p>
                <p>Adapter-owned options are rejected: <x-sirius::code>{{ implode(', ', \Sirius\Ui\Calendar\Options::OWNED) }}</x-sirius::code>. Call protected <x-sirius::code>configure()</x-sirius::code> from an application action to update server-side options.</p>
                <x-docs-code language="PHP" source="$this->configure(['weekends' => false, 'timeZone' => 'UTC']);" />
            </section>
            <section id="local-extensions" class="space-y-4">
                <h2 class="text-xl font-medium">Local extensions</h2>
                <p>PHP options cannot contain JavaScript functions. Register local hooks after package scripts load; use text nodes or sanitized content when rendering event titles.</p>
                @include('livewire-components.examples.calendar-extension')
                <p>Call the returned cleanup function when the registration is no longer needed. <x-sirius::code>SiriusCalendar.get(id)</x-sirius::code> returns the native API for navigation or local selection; it does not authorize server mutations.</p>
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
