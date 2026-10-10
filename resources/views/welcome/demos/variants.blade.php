<div class="landing-showcases">
    <x-sirius::card header="Buttons">
        <div class="flex flex-wrap gap-3" data-landing-buttons>
            @foreach (['primary', 'info', 'secondary', 'success', 'danger', 'warning', 'ghost', 'outline', 'link'] as $variant)
                <x-sirius::button :variant="$variant" data-sir-toast-open="landing-toast">{{ ucfirst($variant) }}</x-sirius::button>
            @endforeach
        </div>
        <x-slot:footer><x-sirius::link :href="route('blade-components.button')" wire:navigate>Button documentation</x-sirius::link></x-slot:footer>
    </x-sirius::card>
    <x-sirius::card header="Badges">
        <div class="flex flex-wrap gap-3" data-landing-badges>
            @foreach (['primary', 'info', 'secondary', 'success', 'danger', 'warning', 'ghost', 'outline'] as $variant)
                <x-sirius::badge :variant="$variant">{{ ucfirst($variant) }}</x-sirius::badge>
            @endforeach
        </div>
        <x-slot:footer><x-sirius::link :href="route('blade-components.badge')" wire:navigate>Badge documentation</x-sirius::link></x-slot:footer>
    </x-sirius::card>
</div>
