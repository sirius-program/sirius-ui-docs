<x-sirius::input :id="($automaticIds ?? false) ? null : $demoId.'-title'" placeholder="Website redesign" label="Project title" error-bag="default" name="title" wire:model="title" helper="Up to 80 characters." required maxlength="80" :readonly="$locked" data-basic-title>
    <x-slot:prefix>
        <x-heroicon-o-pencil class="size-4" aria-hidden="true" />
    </x-slot:prefix>
</x-sirius::input>
<x-sirius::input :id="($automaticIds ?? false) ? null : $demoId.'-quantity'" label="Team seats" helper="Reserve up to 100 seats for your team." required type="number" wire:model.number="quantity" error-bag="default" name="quantity" min="0" max="100" step="1" suffix="seats" :readonly="$locked" data-basic-quantity />
@include('blade-components.demos.password-livewire-fields')
