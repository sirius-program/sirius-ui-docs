<x-layouts::app title="Select binding integration">
<div class="mx-auto max-w-3xl space-y-8">
    <div x-data="{ choice: '0', interests: ['design'] }" class="space-y-3">
        <x-sirius::select id="alpine-select" label="Alpine delivery" :options="\App\Support\SelectCatalog::shipping()" x-model="choice" />
        <x-sirius::select id="alpine-multiple" label="Alpine interests" :options="\App\Support\SelectCatalog::topics()" x-model="interests" multiple />
        <output data-alpine-choice x-text="choice === null ? 'null' : choice"></output>
        <output data-alpine-interests x-text="JSON.stringify(interests)"></output>
        <button type="button" x-on:click="choice = 'express'; interests = ['research']">Load Alpine selections</button>
    </div>
    <div data-select-instance="first"><livewire:examples.select-example /></div>
    <div data-select-instance="second"><livewire:examples.select-example /></div>
</div>
</x-layouts::app>
