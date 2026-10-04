<x-sirius::tabs id="project-sections" label="Project details" :items="[
    'overview' => ['label' => 'Overview', 'icon' => 'heroicon-o-document-text'],
    'members' => 'Members',
    'billing' => ['label' => 'Billing', 'disabled' => true],
    'activity' => 'Activity',
]">
    <x-slot:panel-overview>
        <h3 class="font-semibold">Website redesign</h3>
        <p class="mt-2">The homepage draft is ready for review.</p>
    </x-slot:panel-overview>
    <x-slot:panel-members><p>Alex handles design. Sam handles development.</p></x-slot:panel-members>
    <x-slot:panel-billing><p>Billing becomes available after the project is approved.</p></x-slot:panel-billing>
    <x-slot:panel-activity>
        <p>The design draft was shared this morning.</p>
        <x-sirius::button as="a" href="#project-review" class="mt-3">Review draft</x-sirius::button>
    </x-slot:panel-activity>
</x-sirius::tabs>
