<div data-slideover-form="blade" class="inline-block">
    <x-sirius::button data-sir-dialog-open="project-navigation">Left</x-sirius::button>
    <x-sirius::slideover id="project-navigation" header="Projects" side="left" size="sm">
        <ul class="space-y-4">
            <li>Website redesign</li>
            <li>Customer portal</li>
            <li>Mobile checkout</li>
        </ul>
        <x-slot:footer><x-sirius::button data-sir-dialog-close>Close</x-sirius::button></x-slot:footer>
    </x-sirius::slideover>
</div>
