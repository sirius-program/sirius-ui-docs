<div class="space-y-5 p-6" x-data="{ clicks: 0 }">
    <div class="flex flex-wrap gap-3">
        <x-sirius::button wire:click="rename">Rename export</x-sirius::button>
        <x-sirius::button wire:click="$toggle('locked')">Toggle disabled</x-sirius::button>
        <x-sirius::button wire:click="$toggle('opened')">Toggle server open</x-sirius::button>
        <x-sirius::button wire:click="$toggle('visible')">Toggle visibility</x-sirius::button>
        <x-sirius::button wire:click="increment">Update count</x-sirius::button>
    </div>
    <p id="navigation-count">Count: {{ $count }}</p>
    <p id="navigation-clicks" x-text="'Clicks: ' + clicks"></p>
    @if ($visible)
        <x-sirius::dropdown id="livewire-actions" trigger="Project actions" :open="$opened" wire:key="livewire-actions">
            <x-sirius::dropdown.item id="livewire-save" name="Save" :disabled="$locked" wire:click="increment" x-on:click="clicks++" />
            <x-sirius::dropdown.item id="livewire-export" :name="$name">
                <x-slot:submenu>
                    <x-sirius::dropdown.item id="livewire-pdf" name="PDF" wire:click="increment" />
                </x-slot:submenu>
            </x-sirius::dropdown.item>
            @foreach (range(1, 24) as $index)
                <x-sirius::dropdown.item :id="'recent-'.$index" :name="'Recent project '.$index" wire:click="increment" :wire:key="'recent-'.$index" />
            @endforeach
        </x-sirius::dropdown>
        <x-sirius::menu id="livewire-menu" label="Project navigation" wire:key="livewire-menu" class="max-w-sm">
            <x-sirius::menu.item id="livewire-settings" name="Settings">
                <x-slot:submenu>
                    <x-sirius::menu.item name="Save settings" :disabled="$locked" wire:click="increment" />
                </x-slot:submenu>
            </x-sirius::menu.item>
        </x-sirius::menu>
    @endif
</div>
