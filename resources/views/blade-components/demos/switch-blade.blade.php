<x-sirius::form method="POST" action="{{ route('blade-components.switch.store') }}" novalidate class="space-y-5" data-blade-example="switch">
    @include('blade-components.demos.switch')
    <div class="flex flex-wrap gap-2">
        <x-sirius::button type="submit" name="sample_action" value="validate">Submit / Validate</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="load" formnovalidate>Load Value</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</x-sirius::button>
    </div>
    @if (session('sample-success-switch'))<p role="status">Sample validated. Nothing was stored.</p>@endif
</x-sirius::form>
