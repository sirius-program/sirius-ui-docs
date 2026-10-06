<div class="min-w-0 space-y-4" data-revenue-demo="{{ $chartId }}">
    @if($visible)
        @if($mode === 'extensions')
            @include('livewire-components.demos.chart-extended-control')
        @else
            @include('livewire-components.demos.chart-control')
        @endif
    @endif
    <div class="flex flex-wrap gap-2">
        <x-sirius::button wire:click="loadProjection">Load projection</x-sirius::button>
        <x-sirius::button wire:click="changeType">Change type</x-sirius::button>
        @if(in_array($mode, ['options', 'development'], true))
            <x-sirius::button wire:click="changeOptions">Change options</x-sirius::button>
        @endif
        <x-sirius::button wire:click="clearData">Clear data</x-sirius::button>
        <x-sirius::button wire:click="resetSample">Reset sample</x-sirius::button>
        @if($mode === 'development')
            <x-sirius::button wire:click="$toggle('visible')">Toggle chart</x-sirius::button>
            <x-sirius::button wire:click="$toggle('loading')">Toggle loading</x-sirius::button>
        @endif
    </div>
</div>

