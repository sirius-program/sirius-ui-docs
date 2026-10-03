<div class="flex flex-wrap gap-2">
    @foreach (['primary', 'info', 'success', 'danger', 'warning', 'secondary', 'ghost', 'outline'] as $variant)
        <x-sirius::button :variant="$variant" :data-sir-dialog-open="'alert-variant-'.$variant">{{ ucfirst($variant) }}</x-sirius::button>
        <x-sirius::alert :id="'alert-variant-'.$variant" :variant="$variant" icon="heroicon-o-information-circle" title="Settings updated" text="Your project settings have been updated.">
            <x-slot:footer>
                <x-sirius::button data-sir-dialog-close>Done</x-sirius::button>
            </x-slot:footer>
        </x-sirius::alert>
    @endforeach
</div>
