<div>
    <section id="tabs-livewire-fixture" class="space-y-4">
        @if ($visible)
            @php($items = ['overview' => 'Overview'] + ($notesVisible ? ['notes' => ['label' => 'Notes', 'disabled' => $notesDisabled]] : []))
            <form wire:submit="save">
                <x-sirius::tabs id="livewire-project-tabs" wire:key="project-tabs" :items="$items" :active="$tab" x-on:tabs:change="if ($event.target === $el) $wire.set('tab', $event.detail.value)">
                    <x-slot:panel-overview><x-sirius::input id="livewire-tab-title" label="Project title" wire:model="title" /></x-slot:panel-overview>
                    @if ($notesVisible)
                        <x-slot:panel-notes><x-sirius::textarea id="livewire-tab-notes" label="Notes" wire:model="notes" /></x-slot:panel-notes>
                    @endif
                </x-sirius::tabs>
                <x-sirius::button id="save-tab-project" type="submit">Save project</x-sirius::button>
            </form>
            <x-sirius::tabs id="local-livewire-tabs" wire:key="local-tabs" :items="['overview' => 'Overview', 'notes' => 'Notes']">
                <x-slot:panel-overview>Local overview, revision {{ $revision }}</x-slot:panel-overview>
                <x-slot:panel-notes>Local notes, revision {{ $revision }}</x-slot:panel-notes>
            </x-sirius::tabs>
        @endif
        <div class="flex flex-wrap gap-3">
            <x-sirius::button id="server-select-notes" wire:click="$set('tab', 'notes')">Select notes from server</x-sirius::button>
            <x-sirius::button id="refresh-tabs" wire:click="refreshExample">Refresh project</x-sirius::button>
            <x-sirius::button id="disable-notes" wire:click="$toggle('notesDisabled')">Toggle notes disabled</x-sirius::button>
            <x-sirius::button id="remove-notes" wire:click="$toggle('notesVisible')">Toggle notes panel</x-sirius::button>
            <x-sirius::button id="toggle-tabs" wire:click="$toggle('visible')">Toggle Tabs</x-sirius::button>
        </div>
        <output id="tabs-server-state">{{ $tab }}</output>
        <output id="tabs-revision">Revision: {{ $revision }}</output>
        <output id="tabs-saved-title">{{ $title }}</output>
    </section>
</div>
