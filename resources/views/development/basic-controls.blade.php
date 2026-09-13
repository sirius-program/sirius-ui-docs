<x-layouts::app title="Basic control integration">
    <main class="mx-auto max-w-3xl space-y-10">
        <h1 class="text-2xl">Basic control integration</h1>
        <livewire:examples.basic-controls-example />
        <livewire:examples.basic-controls-example kind="password" />
        <div data-auto-id-example>
            <livewire:examples.basic-controls-example :automatic-ids="true" />
        </div>
        @include('blade-components.demos.plain-form')
        <a href="{{ route('blade-components.control', ['control' => 'checkbox']) }}" wire:navigate>Open checkbox docs</a>
    </main>
</x-layouts::app>
