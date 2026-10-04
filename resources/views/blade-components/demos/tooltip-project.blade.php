<div class="flex flex-wrap gap-3">
    @foreach (['info', 'primary', 'secondary', 'warning', 'success', 'danger'] as $variant)
        <x-sirius::tooltip :id="'project-help-' . $variant" text="Only project members can see this file." :variant="$variant">
            <x-sirius::button :id="'project-help-' . $variant . '-trigger'" variant="outline">{{ ucfirst($variant) }}</x-sirius::button>
        </x-sirius::tooltip>
    @endforeach
</div>
