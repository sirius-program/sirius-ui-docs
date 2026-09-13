<x-layouts::app title="Currency binding integration">
    <main class="mx-auto max-w-3xl space-y-8">
        <h1>Currency binding integration</h1>
        <livewire:examples.currency-bindings-example />
        <div x-data="{ amount: '1234.50' }" class="space-y-4">
            <x-sirius::currency id="alpine-currency" label="Alpine amount" x-model="amount" />
            <button type="button" x-on:click="amount = '9876.50'">Load Alpine value</button>
            <output data-alpine-amount x-text="amount"></output>
        </div>
        <div data-currency-instance="first"><livewire:examples.currency-example /></div>
        <div data-currency-instance="second"><livewire:examples.currency-example /></div>
    </main>
</x-layouts::app>
