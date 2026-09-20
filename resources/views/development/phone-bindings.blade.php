<x-layouts::app title="Phone binding integration">
<div class="mx-auto max-w-3xl space-y-8">
    <div x-data="{ phone: '+6281234567890' }" class="space-y-3">
        <x-sirius::phone id="alpine-phone" country="ID" label="Alpine phone" x-model="phone" />
        <output data-alpine-phone x-text="phone === null ? 'null' : phone"></output>
        <button type="button" x-on:click="phone = '+6281234567891'">Load Alpine phone</button>
    </div>
    <div data-phone-instance="first"><livewire:examples.phone-example /></div>
    <div data-phone-instance="second"><livewire:examples.phone-example /></div>
</div>
</x-layouts::app>
