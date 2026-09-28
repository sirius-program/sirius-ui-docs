<x-sirius::button-group label="Invoice pages">
    <x-sirius::button variant="outline" wire:click="$set('revision', {{ max(0, $revision - 1) }})">Previous</x-sirius::button>
    <x-sirius::button variant="outline" wire:click="refreshExample">Next</x-sirius::button>
</x-sirius::button-group>
<p role="status">Page {{ $revision + 1 }}</p>
