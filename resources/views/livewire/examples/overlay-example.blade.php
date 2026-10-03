<div>
    <div class="flex flex-wrap gap-2">
        <x-sirius::button id="server-alert-trigger" wire:click="$set('active', 'alert')">Open server alert</x-sirius::button>
        <x-sirius::button id="server-slideover-trigger" wire:click="$set('active', 'slideover')">Open server slideover</x-sirius::button>
        <x-sirius::button wire:click="$toggle('visible')">Toggle overlay visibility</x-sirius::button>
    </div>
    <p data-overlay-state>{{ $active === '' ? 'Closed' : $active }}</p>
    @if ($visible)
        <x-sirius::alert id="server-alert" title="Review delivery" :text="'Delivery revision '.$revision" icon="heroicon-o-information-circle" :open="$active === 'alert'" wire:key="server-alert"
            x-on:dialog:close="if ($event.target === $el && $wire.active === 'alert') $wire.set('active', '')">
            <x-slot:footer>
                <x-sirius::button wire:click="$set('active', 'slideover')">Edit delivery</x-sirius::button>
                <x-sirius::button wire:click="$set('active', '')">Cancel alert</x-sirius::button>
            </x-slot:footer>
        </x-sirius::alert>
        <x-sirius::slideover id="server-slideover" header="Delivery note" :open="$active === 'slideover'" wire:key="server-slideover" initial-focus="#overlay-note"
            x-on:dialog:close="if ($event.target === $el && $wire.active === 'slideover') $wire.set('active', '')">
            <form id="overlay-note-form" wire:submit="save" novalidate class="space-y-4">
                <p>Delivery revision {{ $revision }}</p>
                <x-sirius::input id="overlay-note" label="Delivery note" wire:model="note" required />
                <x-sirius::button wire:click="$set('revision', {{ $revision + 1 }})">Refresh delivery note</x-sirius::button>
                <x-sirius::button wire:click="$set('visible', false)">Remove active overlay</x-sirius::button>
            </form>
            <x-slot:footer>
                <x-sirius::button type="submit" form="overlay-note-form" variant="primary">Save delivery note</x-sirius::button>
                <x-sirius::button wire:click="$set('active', 'alert')">Review delivery</x-sirius::button>
                <x-sirius::button data-sir-dialog-close>Cancel delivery note</x-sirius::button>
            </x-slot:footer>
        </x-sirius::slideover>
    @endif
</div>
