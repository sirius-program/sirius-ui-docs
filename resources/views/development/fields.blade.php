<x-layouts::app title="Field integration">
    <article class="mx-auto max-w-4xl space-y-8">
        <h1 class="text-3xl font-semibold">Field integration</h1>
        <section class="space-y-4">
            <h2 class="text-xl font-medium">Livewire validation</h2>
            <livewire:examples.field-example />
        </section>
        <section class="space-y-4">
            <h2 class="text-xl font-medium">Blade validation</h2>
            @include('blade-components.demos.field-blade')
        </section>
        @include('blade-components.demos.field-groups')
        @include('blade-components.demos.field-states')
    </article>
</x-layouts::app>
