<x-sirius::input id="blade-input-title" name="title" label="Project title"
    placeholder="Website redesign" :value="session('sample-input.title', '')"
    error-bag="sample-input" helper="Up to 80 characters." required maxlength="80">
    <x-slot:prefix>
        <x-heroicon-o-pencil class="size-4" aria-hidden="true" />
    </x-slot:prefix>
</x-sirius::input>
