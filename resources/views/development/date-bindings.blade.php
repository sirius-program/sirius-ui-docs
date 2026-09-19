<x-layouts::app title="Date binding integration">
    <main class="mx-auto max-w-3xl space-y-6 p-6">
        <h1>Date binding integration</h1>
        <div x-data="{ day: '2028-02-29' }" class="space-y-3">
            <x-sirius::datetime-picker id="alpine-date" label="Alpine date" x-model="day" />
            <p x-text="day" data-alpine-date></p>
            <button type="button" x-on:click="day = '2028-12-31'">Load Alpine date</button>
        </div>
        <div data-date-instance="first"><livewire:examples.datetime-picker-example /></div>
        <div data-date-instance="second"><livewire:examples.datetime-picker-example /></div>
    </main>
</x-layouts::app>
