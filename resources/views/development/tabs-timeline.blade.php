<x-layouts::app title="Tabs and Timeline integration">
    <div class="mx-auto max-w-4xl space-y-8 p-6">
        <x-sirius::form method="GET" :action="route('development.tabs-timeline')" id="blade-tabs-form">
            <x-sirius::tabs id="blade-form-tabs" label="Project form" :items="['overview' => 'Overview', 'notes' => 'Notes']">
                <x-slot:panel-overview>
                    <x-sirius::input id="blade-project-title" name="title" label="Project title" value="Website redesign" />
                    <x-sirius::tabs id="nested-project-tabs" label="Project summary" :items="['summary' => 'Summary', 'files' => 'Files']" class="mt-4">
                        <x-slot:panel-summary><p>Website project</p></x-slot:panel-summary>
                        <x-slot:panel-files><p>Three files attached</p></x-slot:panel-files>
                    </x-sirius::tabs>
                </x-slot:panel-overview>
                <x-slot:panel-notes><x-sirius::textarea id="blade-project-notes" name="notes" label="Notes" value="Share the draft on Friday." /></x-slot:panel-notes>
            </x-sirius::tabs>
            <x-sirius::button type="submit">Submit project</x-sirius::button>
        </x-sirius::form>
        <livewire:examples.tabs-example />
        <div x-data="{ tab: 'overview' }">
            <x-sirius::tabs id="alpine-project-tabs" :items="['overview' => 'Overview', 'notes' => 'Notes']" x-bind:data-active="tab" x-on:tabs:change="if ($event.target === $el) tab = $event.detail.value">
                <x-slot:panel-overview>Alpine overview</x-slot:panel-overview>
                <x-slot:panel-notes>Alpine notes</x-slot:panel-notes>
            </x-sirius::tabs>
            <x-sirius::button id="alpine-select-notes" x-on:click="tab = 'notes'">Select notes</x-sirius::button>
            <output id="alpine-tab-state" x-text="tab"></output>
        </div>
        <x-sirius::button id="tabs-overlay-trigger" data-sir-dialog-open="tabs-overlay">Open project dialog</x-sirius::button>
        <x-sirius::dialog id="tabs-overlay" header="Project details">
            <x-sirius::tabs id="dialog-project-tabs" :items="['overview' => 'Overview', 'notes' => 'Notes']">
                <x-slot:panel-overview><x-sirius::input id="dialog-tab-title" label="Project title" value="Website" /></x-slot:panel-overview>
                <x-slot:panel-notes><x-sirius::input id="dialog-tab-notes" label="Notes" /></x-slot:panel-notes>
            </x-sirius::tabs>
        </x-sirius::dialog>
        @include('blade-components.demos.timeline-onboarding')
        <x-sirius::link id="tabs-navigation" href="{{ route('blade-components.tabs') }}" wire:navigate>Tabs docs</x-sirius::link>
    </div>
</x-layouts::app>
