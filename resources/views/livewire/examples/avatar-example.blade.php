<div class="space-y-5" data-avatar-example>
    @if ($visible)
        <x-sirius::avatar id="livewire-avatar" :src="$source" :alt="$name" :fallback="$name" size="lg" wire:key="team-avatar" />
    @endif
    <div class="flex flex-wrap gap-3">
        <x-sirius::button wire:click="loadImage">Load image</x-sirius::button>
        <x-sirius::button wire:click="failImage">Use invalid image</x-sirius::button>
        <x-sirius::button wire:click="rename">Rename member</x-sirius::button>
        <x-sirius::button wire:click="$toggle('visible')">Toggle visibility</x-sirius::button>
    </div>
</div>
