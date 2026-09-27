<x-sirius::form method="POST" action="{{ route('blade-components.input.store') }}" novalidate class="space-y-5" data-blade-example="input">
    @include('blade-components.demos.input-title')
    @include('blade-components.demos.input-quantity')
    @include('blade-components.demos.password')
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
    @if (session('sample-success-input'))<p role="status">Sample validated. Nothing was stored.</p>@endif
</x-sirius::form>
