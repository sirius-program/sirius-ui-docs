<x-layouts::app title="Toast integration">
    <div class="mx-auto max-w-4xl space-y-8 p-6">
        <livewire:examples.toast-example />
        <div class="flex flex-wrap gap-3">
            <x-sirius::button id="timer-trigger" data-sir-toast-open="timer-toast">Timed notice</x-sirius::button>
            <x-sirius::button id="persistent-trigger" data-sir-toast-open="persistent-toast">Persistent notice</x-sirius::button>
            <x-sirius::button id="toast-dialog-trigger" data-sir-dialog-open="toast-dialog">Open Dialog</x-sirius::button>
            <x-sirius::button id="toast-slideover-trigger" data-sir-dialog-open="toast-slideover">Open Slideover</x-sirius::button>
        </div>
        <x-sirius::toast id="timer-toast" title="Draft saved" text="Your draft is available for review." :duration="900"><x-slot:footer><button type="button" id="timer-action">Review later</button></x-slot:footer></x-sirius::toast>
        <x-sirius::toast id="persistent-toast" title="Upload ready" text="Download the completed report." :duration="0" position="bottom-end" />
        @for ($index = 1; $index <= 25; $index++)
            <x-sirius::toast :id="'queued-toast-'.$index" :title="'Job '.$index" text="Your report is ready." :duration="0" :position="$index % 2 === 0 ? 'bottom-start' : 'top-end'" />
        @endfor
        <div x-data="{ visible: false }">
            <x-sirius::button id="alpine-toast-trigger" x-on:click="visible = true">Alpine notice</x-sirius::button>
            <x-sirius::toast id="alpine-toast" text="Preferences saved." x-bind:data-open="visible" :duration="0" x-on:toast:close="visible = false" />
        </div>
        <x-sirius::dialog id="toast-dialog" header="Project details">
            <x-sirius::input id="toast-dialog-title" label="Project title" value="Website redesign" />
            <x-sirius::button id="dialog-notify" data-sir-toast-open="event-toast" class="mt-4">Show delivery notice</x-sirius::button>
        </x-sirius::dialog>
        <x-sirius::slideover id="toast-slideover" header="Delivery details">
            <x-sirius::input id="toast-slideover-note" label="Delivery note" value="Friday review" />
            <x-sirius::button id="slideover-notify" data-sir-toast-open="event-toast" class="mt-4">Show delivery notice</x-sirius::button>
        </x-sirius::slideover>
        <x-sirius::button id="toast-navigation" as="a" :href="route('blade-components.toast')" wire:navigate>Toast docs</x-sirius::button>
    </div>
</x-layouts::app>
