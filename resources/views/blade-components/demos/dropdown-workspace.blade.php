<x-sirius::dropdown id="workspace-actions" align="end">
    <x-slot:trigger><x-sirius::avatar fallback="Nadia Putri" size="sm" /> My workspace</x-slot:trigger>
    <x-sirius::dropdown.item name="Dashboard" :link="route('dashboard')" icon="heroicon-o-home" wire:navigate active />
    <x-sirius::dropdown.item name="Messages" :link="route('blade-components.message')" icon="heroicon-o-envelope" wire:navigate>
        <x-slot:trailing><x-sirius::badge variant="primary">3</x-sirius::badge></x-slot:trailing>
    </x-sirius::dropdown.item>
    <x-sirius::dropdown.item name="Appearance" :link="route('appearance.edit')" icon="heroicon-o-paint-brush" />
</x-sirius::dropdown>
