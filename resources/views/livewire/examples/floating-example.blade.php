<div x-data="{ clicks: 0 }" id="floating-livewire-fixture" class="space-y-4">
    <div class="flex flex-wrap gap-3">
        <x-sirius::button id="floating-increment" wire:click="increment">Refresh floating content</x-sirius::button>
        <x-sirius::button id="floating-rename" wire:click="rename">Update hint</x-sirius::button>
        <x-sirius::button id="floating-server" wire:click="$toggle('opened')">Toggle floating server state</x-sirius::button>
        <x-sirius::button id="floating-visible" wire:click="$toggle('visible')">Toggle floating visibility</x-sirius::button>
    </div>
    <p id="floating-count">Count: {{ $count }}</p>
    <p id="floating-clicks" x-text="'Clicks: ' + clicks"></p>
    @if ($visible)
        <x-sirius::tooltip id="livewire-hint" :text="$hint" wire:key="livewire-hint">
            <x-sirius::button id="livewire-hint-trigger" aria-describedby="floating-count" wire:click="increment">File access</x-sirius::button>
        </x-sirius::tooltip>
        <x-sirius::popover id="livewire-sharing" label="Project sharing" :open="$opened" wire:key="livewire-sharing">
            <x-slot:trigger>
                <x-sirius::button id="livewire-sharing-trigger" wire:click="increment" x-on:click="clicks++">Project sharing</x-sirius::button>
            </x-slot:trigger>
            <p id="floating-panel-count">Count: {{ $count }}</p>
            <x-sirius::input id="floating-name" label="Invited member" wire:model.live="name" />
            <x-sirius::button id="floating-save" wire:click="increment">Save invitation</x-sirius::button>
            <x-sirius::button id="floating-done" data-sir-popover-close>Done</x-sirius::button>
        </x-sirius::popover>
    @endif
</div>
