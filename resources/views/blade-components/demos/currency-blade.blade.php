<x-sirius::form method="POST" action="{{ route('blade-components.currency.store') }}" novalidate class="space-y-5" data-blade-currency>
    @include('blade-components.demos.currency-budget')
    @include('blade-components.demos.currency-adjustment')
    <div class="flex flex-wrap gap-2">
        <x-sirius::button type="submit" name="sample_action" value="validate">Submit / Validate</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="load" formnovalidate>Load Value</x-sirius::button>
        <x-sirius::button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</x-sirius::button>
    </div>
    @if (session('currency-success'))<p role="status">Amounts validated. Nothing was stored.</p>@endif
</x-sirius::form>
