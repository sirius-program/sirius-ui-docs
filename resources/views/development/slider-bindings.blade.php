<x-layouts::app title="Slider bindings">
    <div x-data="{ amount: 20, interval: [20, 80], locked: false }" class="space-y-6">
        <x-sirius::slider id="alpine-slider" label="Amount" x-model="amount" x-bind:readonly="locked" />
        <x-sirius::slider id="alpine-range" label="Interval" range :value="[20, 80]" :min="[0, 0]" :max="[100, 100]" :step="[1, 5]" x-model="interval" />
        <output data-alpine-values x-text="JSON.stringify([amount, interval])"></output>
        <button x-on:click="amount = 60; interval = [40, 90]">Load Alpine value</button>
        <button x-on:click="interval = [90, 20]">Set invalid range</button>
        <button x-on:click="locked = !locked">Toggle Alpine readonly</button>
    </div>
</x-layouts::app>
