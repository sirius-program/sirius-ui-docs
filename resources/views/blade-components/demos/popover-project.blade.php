<div class="flex flex-wrap gap-3">
    @foreach (['info', 'primary', 'secondary', 'warning', 'success', 'danger'] as $variant)
        <x-sirius::popover :id="'project-sharing-' . $variant" label="Project access" :variant="$variant">
            <x-slot:trigger>
                <x-sirius::button :id="'project-sharing-' . $variant . '-trigger'" variant="outline">{{ ucfirst($variant) }}</x-sirius::button>
            </x-slot:trigger>
            <h3 class="font-semibold">Website redesign</h3>
            <p class="mt-2 text-sm">Only invited team members can open this project.</p>
            <x-sirius::button class="mt-3" size="sm" data-sir-popover-close>Got it</x-sirius::button>
        </x-sirius::popover>
    @endforeach
</div>
