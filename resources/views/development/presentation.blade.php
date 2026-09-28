<x-layouts::app title="Presentation integration">
    <div class="space-y-6">
        <livewire:examples.presentation-example kind="message" />
        @include('blade-components.demos.message-blade')
        <livewire:examples.presentation-example kind="button" />
        <livewire:examples.presentation-example kind="button-group" />
    </div>
</x-layouts::app>
