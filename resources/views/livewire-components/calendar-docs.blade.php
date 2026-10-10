<x-layouts::app title="Calendar · Overview">
    <x-docs-page :navigation="['Overview' => ['calendar-demo' => 'Demo', 'calendar-usage' => 'Usage', 'calendar-attributes' => 'Attributes', 'assets-and-interaction' => 'Assets and interaction', 'explore-calendar' => 'Explore Calendar', 'global-configuration' => 'Global Configuration', 'translations' => 'Translations']]">
        <article class="mx-auto flex min-w-0 max-w-4xl flex-col gap-8">
            <header class="space-y-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">CALENDAR</p>
                <h1 class="text-3xl font-semibold">Overview</h1>
                <p>Manage schedules with month, week, day, and agenda views, powered by <x-sirius::link href="https://fullcalendar.io/" target="_blank" rel="noopener noreferrer">FullCalendar</x-sirius::link></p>
            </header>
            <section id="calendar-demo" class="space-y-4">
                <h2 class="text-xl font-medium">Demo</h2>
                <div data-demo-mode="livewire">
                    @include('livewire-components.demos.calendar-overview')
                </div>
            </section>
            <section id="calendar-usage" class="space-y-4">
                <h2 class="text-xl font-medium">Usage</h2>
                <p>Create a class under <x-sirius::code>App\Livewire</x-sirius::code>, extend <x-sirius::code>Sirius\Ui\Livewire\Calendar</x-sirius::code>, and implement <x-sirius::code>events()</x-sirius::code>. The base class renders the calendar; no separate view or <x-sirius::code>render()</x-sirius::code> method is needed.</p>
                @include('livewire-components.examples.calendar-create-class')
                <p>The example uses the docs sample source.</p>
                @include('livewire-components.examples.calendar')
            </section>
            <section id="calendar-attributes">
                @include('livewire-components.attributes.calendar')
            </section>
            <section id="assets-and-interaction" class="space-y-4">
                <h2 class="text-xl font-medium">Assets and interaction</h2>
                <p>Import the package CSS and JavaScript, or publish and load <x-sirius::code>sirius-ui-assets</x-sirius::code>.</p>
                @include('blade-components.examples.assets')
                <p>Loading covers the whole calendar, including its toolbar, and keeps the previous height. Controls unlock when the request finishes.</p>
                <p>FullCalendar Standard 7.1.1 is bundled. No CDN, API key, or framework setup is required. Calendar resizes when shown in Tabs, Dialog, or Slideover.</p>
            </section>
            <section id="explore-calendar" class="space-y-4">
                <h2 class="text-xl font-medium">Explore Calendar</h2>
                <ul class="space-y-3">
                    <li><x-sirius::link href="{{ route('livewire-components.calendar.actions') }}" wire:navigate>Actions</x-sirius::link> — Connect your own forms and save drag/resize changes.</li>
                    <li><x-sirius::link href="{{ route('livewire-components.calendar.events') }}" wire:navigate>Events</x-sirius::link> — Supply Eloquent or Collection data, date spans, and recurring schedules.</li>
                    <li><x-sirius::link href="{{ route('livewire-components.calendar.options') }}" wire:navigate>Options</x-sirius::link> — Set views, locale, timezone, and local rendering hooks.</li>
                </ul>
            </section>
            <section id="global-configuration" class="space-y-4">
                <h2 class="text-xl font-medium">Global configuration</h2>
                <p>Publish the config to set defaults. Timezone falls back through <x-sirius::code>sirius-ui.timezone &rarr; app.timezone &rarr; UTC</x-sirius::code>. Locale falls back through <x-sirius::code>sirius-ui.locale &rarr; app.locale &rarr; app.fallback_locale &rarr; en</x-sirius::code>. Invalid explicit values are rejected.</p>
                @include('blade-components.examples.datetime-picker-config')
            </section>
            <section id="translations" class="space-y-3">
                <h2 class="text-xl font-medium">Translations</h2>
                <p>Edit the <x-sirius::code>calendar</x-sirius::code> array in <x-sirius::code>lang/vendor/sirius/{locale}/sirius-ui.php</x-sirius::code>.</p>
                @include('livewire-components.examples.calendar-translations')
            </section>
        </article>
    </x-docs-page>
</x-layouts::app>
