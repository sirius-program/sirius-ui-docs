<x-sirius::form method="POST" action="{{ route('blade-components.slider.store') }}" class="space-y-5" data-slider-blade novalidate>
    @include('blade-components.demos.slider-discount')
    @include('blade-components.demos.slider-budget')
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
    @if (session('slider-success'))<p role="status">Preferences validated. Nothing was stored.</p>@endif
</x-sirius::form>
