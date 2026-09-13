<div data-currency-bindings class="space-y-4">
    <x-sirius::currency id="binding-change" label="Change timing" wire:model.change="change" />
    <x-sirius::currency id="binding-lazy" label="Lazy timing" wire:model.lazy="lazy" />
    <x-sirius::currency id="binding-enter" label="Enter timing" wire:model.enter="enter" />
    <x-sirius::currency id="binding-deferred" label="Deferred timing" wire:model="deferred" />
    <button type="button" wire:click="$refresh">Refresh bindings</button>
</div>
