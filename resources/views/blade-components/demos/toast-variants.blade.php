<div class="flex flex-wrap gap-3">
    @foreach (['primary', 'info', 'secondary', 'success', 'danger', 'warning', 'ghost', 'outline'] as $variant)
        <x-sirius::button :variant="$variant" :data-sir-toast-open="'project-toast-'.$variant">{{ ucfirst($variant) }}</x-sirius::button>
        <x-sirius::toast :id="'project-toast-'.$variant" :variant="$variant" title="Project updated" text="The team can now review your changes." icon="heroicon-o-information-circle" />
    @endforeach
</div>
