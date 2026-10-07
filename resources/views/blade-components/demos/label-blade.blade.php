<x-sirius::form method="POST" action="{{ route('blade-components.label.store') }}" novalidate class="space-y-4" data-blade-example="label">
    @include('blade-components.demos.label-required')
    @include('blade-components.demos.label-optional')
    <div class="flex flex-wrap gap-2">
        <x-sirius::button type="submit" name="sample_action" value="validate">Submit / Validate</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="load" formnovalidate>Load Value</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</x-sirius::button>
    </div>
    @if (session('sample-success-label'))<p role="status">Validation passed. Nothing was stored.</p>@endif
</x-sirius::form>
