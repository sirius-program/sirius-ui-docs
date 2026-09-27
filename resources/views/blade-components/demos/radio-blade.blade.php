<x-sirius::form method="POST" action="{{ route('blade-components.radio.store') }}" novalidate class="space-y-5" data-blade-example="radio">
    @include('blade-components.demos.radio')
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
    @if (session('sample-success-radio'))<p role="status">Sample validated. Nothing was stored.</p>@endif
</x-sirius::form>
