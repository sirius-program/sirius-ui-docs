<section class="min-w-0 space-y-3" data-docs-props>
    <h3 class="text-xl font-medium">Attributes</h3>
    <x-docs-props :rows="[
        ['width', 'string | number', '100%', 'CSS length or a pixel count.'],
        ['height', 'string | number', '1rem', 'CSS length or a pixel count.'],
        ['shape', 'rectangle | rounded | circle', 'rounded', 'Placeholder shape. Use equal width and height for a circle.']
    ]" note="Accepts HTML5 attributes, Alpine events, data-*, and Livewire attributes such as wire:key. Skeleton remains hidden from assistive technology." />
</section>