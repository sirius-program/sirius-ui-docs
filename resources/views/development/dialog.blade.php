<x-layouts::app title="Dialog integration">
    <livewire:examples.dialog-example />
    <div x-data="{ showing: false }" class="mt-6">
        <x-sirius::button id="alpine-dialog-trigger" x-on:click="showing = true">Open Alpine dialog</x-sirius::button>
        <x-sirius::dialog id="alpine-dialog" header="Alpine dialog" x-bind:data-open="showing" x-on:dialog:close="if ($event.target === $el) showing = false">
            <x-sirius::button data-sir-dialog-open="second-dialog">Switch to second dialog</x-sirius::button>
        </x-sirius::dialog>
    </div>
    <x-sirius::dialog id="second-dialog" header="Second dialog" initial-focus="#second-close">
        <x-sirius::button id="second-close" data-sir-dialog-close>Close second dialog</x-sirius::button>
    </x-sirius::dialog>
    <div data-dialog-fixed style="position:fixed;right:10px;top:10px;width:20px;height:20px;pointer-events:none"></div>
    <div data-dialog-layout style="height:1800px">Scroll-lock fixture</div>
</x-layouts::app>
