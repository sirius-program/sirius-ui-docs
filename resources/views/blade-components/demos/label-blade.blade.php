<form method="POST" action="{{ route('blade-components.examples.store', ['kind' => 'label']) }}" novalidate class="space-y-4" data-blade-example="label">
    @csrf
    @include('blade-components.demos.label-required')
    @include('blade-components.demos.label-optional')
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
    @if (session('sample-success-label'))<p role="status">Validation passed. Nothing was stored.</p>@endif
</form>
