<x-sirius::form method="POST" action="{{ route('blade-components.select.store') }}" novalidate class="space-y-5" data-blade-select>
    @include('blade-components.demos.select-shipping')
    @include('blade-components.demos.select-topics')
    @include('blade-components.demos.select-venue')
    <div class="flex flex-wrap gap-2">
        <x-sirius::button type="submit" name="action" value="validate">Submit / Validate</x-sirius::button>
        <x-sirius::button type="submit" name="action" value="load">Load Value</x-sirius::button>
        <x-sirius::button type="submit" name="action" value="reset">Reset Sample</x-sirius::button>
    </div>
    @if (session('select_saved'))<p role="status">Selections validated. Nothing was stored.</p>@endif
</x-sirius::form>
