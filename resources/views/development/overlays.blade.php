<x-layouts::app title="Overlay integration">
    <section class="grid gap-6" data-dialog-integration>
        <h2 class="text-xl font-semibold">Dialog</h2>
        <livewire:examples.dialog-example />
        <div x-data="{ showing: false }">
            <x-sirius::button id="alpine-dialog-trigger" x-on:click="showing = true">Open Alpine dialog</x-sirius::button>
            <x-sirius::dialog id="alpine-dialog" header="Alpine dialog" x-bind:data-open="showing" x-on:dialog:close="if ($event.target === $el) showing = false">
                <x-sirius::button data-sir-dialog-open="second-dialog">Switch to second dialog</x-sirius::button>
            </x-sirius::dialog>
        </div>
        <x-sirius::dialog id="second-dialog" header="Second dialog" initial-focus="#second-close">
            <x-sirius::button id="second-close" data-sir-dialog-close>Close second dialog</x-sirius::button>
        </x-sirius::dialog>
    </section>
    <section class="mt-8 grid gap-6" data-overlay-integration>
        <h2 class="text-xl font-semibold">Alert and Slideover</h2>
        <livewire:examples.overlay-example />
        <div x-data="{ reviewing: false }">
            <x-sirius::button id="alpine-alert-trigger" x-on:click="reviewing = true">Open Alpine alert</x-sirius::button>
            <x-sirius::alert id="alpine-alert" title="Review delivery" text="Switch to a delivery panel?" x-bind:data-open="reviewing" x-on:dialog:close="if ($event.target === $el) reviewing = false">
                <x-slot:footer><x-sirius::button data-sir-dialog-open="blade-slideover">Open delivery panel</x-sirius::button></x-slot:footer>
            </x-sirius::alert>
        </div>
        <x-sirius::slideover id="blade-slideover" header="Delivery panel">
            <x-sirius::button data-sir-dialog-open="blade-dialog">Open invoice dialog</x-sirius::button>
        </x-sirius::slideover>
        <x-sirius::dialog id="blade-dialog" header="Invoice review">
            <x-sirius::button data-sir-dialog-open="nested-alert">Try nested alert</x-sirius::button>
            <x-sirius::alert id="nested-alert" text="Nested prompt" />
        </x-sirius::dialog>
        <div x-data="{ archived: false }">
            <x-sirius::button data-sir-dialog-open="archive-project">Archive project</x-sirius::button>
            <x-sirius::alert id="archive-project" title="Archive this project?" text="You can restore this project later." initial-focus="#archive-cancel" :close-on-escape="false" :close-on-backdrop="false">
                <x-slot:footer>
                    <x-sirius::button id="archive-cancel" data-sir-dialog-close>Cancel</x-sirius::button>
                    <x-sirius::button variant="danger" x-on:click="archived = true" data-sir-dialog-close>Confirm archive</x-sirius::button>
                </x-slot:footer>
            </x-sirius::alert>
            <template x-if="archived"><p data-archive-status>Project archived in this sample. Nothing was stored.</p></template>
        </div>
    </section>
    <div data-dialog-layout data-overlay-layout style="height:1800px">Scroll-lock fixture</div>
    <div data-dialog-fixed data-overlay-fixed style="position:fixed;right:10px;top:10px;width:20px;height:20px;pointer-events:none"></div>
</x-layouts::app>
