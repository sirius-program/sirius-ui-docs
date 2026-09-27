<x-layouts::app title="Richtext binding integration">
    <div x-data="{ body: '<p>Initial note</p>', locked: false }" class="mx-auto max-w-3xl space-y-4">
        <x-sirius::richtext id="alpine-richtext" label="Announcement" x-model="body" x-bind:readonly="locked" />
        <output data-alpine-richtext x-text="body"></output>
        <button type="button" x-on:click="body = '<p>Updated from Alpine</p>'">Load Alpine value</button>
        <button type="button" x-on:click="locked = !locked">Toggle Alpine readonly</button>
    </div>
</x-layouts::app>
