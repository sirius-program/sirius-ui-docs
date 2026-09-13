<form method="POST" action="{{ route('blade-components.currency.store') }}" novalidate class="space-y-5" data-blade-currency>
    @csrf
    @include('blade-components.demos.currency-budget')
    @include('blade-components.demos.currency-adjustment')
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
    @if (session('currency-success'))<p role="status">Amounts validated. Nothing was stored.</p>@endif
</form>
