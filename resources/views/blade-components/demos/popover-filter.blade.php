<div x-data="{ archived: false }" class="space-y-3">
    <x-sirius::popover id="project-filter" label="Filter projects" placement="bottom" class="w-72" wrapper-class="block">
        <x-slot:trigger>
            <x-sirius::button id="project-filter-trigger" icon="heroicon-o-adjustments-horizontal">Filter projects</x-sirius::button>
        </x-slot:trigger>
        <h3 class="mb-3 font-semibold">Project visibility</h3>
        <x-sirius::checkbox id="include-archived" label="Include archived projects" x-model="archived" />
        <x-sirius::button id="apply-project-filter" class="mt-4" size="sm" data-sir-popover-close>Apply</x-sirius::button>
    </x-sirius::popover>
    <p class="text-sm" x-text="archived ? 'Showing active and archived projects.' : 'Showing active projects.'"></p>
</div>
