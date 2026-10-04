<section class="space-y-4" id="livewire-toast-fixture">
    <div class="flex flex-wrap gap-3">
        <x-sirius::button id="event-notify" wire:click="notify">Save delivery</x-sirius::button>
        <x-sirius::button id="event-hide" wire:click="hideNotification">Hide delivery notice</x-sirius::button>
        <x-sirius::button id="bound-notify" wire:click="$set('open', true)">Show timed notice</x-sirius::button>
        <x-sirius::button id="toast-refresh" wire:click="$set('revision', {{ $revision + 1 }})">Refresh content</x-sirius::button>
        <x-sirius::button id="toast-toggle" wire:click="$toggle('visible')">Toggle notifications</x-sirius::button>
    </div>
    <p id="toast-server-state">{{ $open ? 'Open' : 'Closed' }}</p>
    <p id="toast-revision">Revision: {{ $revision }}</p>
    <p id="toast-actions">Actions: {{ $actions }}</p>
    @if ($visible)
        <x-sirius::toast id="event-toast" wire:key="event-toast" title="Delivery saved" :text="'Delivery revision '.$revision" variant="success" :duration="0">
            <x-slot:footer><x-sirius::button id="toast-acknowledge" wire:click="acknowledge">Acknowledge</x-sirius::button></x-slot:footer>
        </x-sirius::toast>
        <x-sirius::toast id="bound-toast" wire:key="bound-toast" title="Project saved" :text="'Project revision '.$revision" :open="$open" :duration="900"
            x-on:toast:close="if ($event.target === $el && $wire.open) $wire.set('open', false)" />
    @endif
</section>
