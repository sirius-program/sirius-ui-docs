<x-layouts::app title="Calendar integration">
    <x-docs-page :navigation="[]">
        <div class="min-w-0 space-y-8">
            <h1 class="text-2xl font-semibold">Calendar integration</h1>
            <livewire:examples.calendar-actions />
            <livewire:examples.team-calendar id="second-calendar" locale="id" timezone="UTC" initial-date="2028-10-16" initial-view="listWeek" />
            <livewire:examples.team-calendar id="rtl-calendar" locale="ar" timezone="Asia/Jakarta" initial-date="2028-10-16" :options="['direction' => 'rtl']" />
            <x-sirius::tabs id="calendar-tabs" label="Schedule panels" :items="['summary' => 'Summary', 'calendar' => 'Calendar']">
                <x-slot:panel-summary>Open the Calendar tab to resize the hidden widget.</x-slot:panel-summary>
                <x-slot:panel-calendar><livewire:examples.team-calendar id="tab-calendar" initial-date="2028-10-16" /></x-slot:panel-calendar>
            </x-sirius::tabs>
            <x-sirius::button data-sir-dialog-open="calendar-dialog">Open calendar dialog</x-sirius::button>
            <x-sirius::dialog id="calendar-dialog" header="Schedule in Dialog" size="xl"><livewire:examples.team-calendar id="dialog-calendar" initial-date="2028-10-16" /></x-sirius::dialog>
            <x-sirius::button data-sir-dialog-open="calendar-slideover">Open calendar slideover</x-sirius::button>
            <x-sirius::slideover id="calendar-slideover" header="Schedule in Slideover" size="xl"><livewire:examples.team-calendar id="slideover-calendar" initial-date="2028-10-16" /></x-sirius::slideover>
        </div>
    </x-docs-page>
</x-layouts::app>
