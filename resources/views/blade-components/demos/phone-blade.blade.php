<form method="POST" action="{{ route('blade-components.phone.store') }}" novalidate class="space-y-5" data-blade-phone>
    @csrf
    @include('blade-components.demos.phone-delivery')
    @include('blade-components.demos.phone-partner')
    @include('blade-components.demos.phone-traveler')
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
    @if (session('phone-success'))<p role="status">Phone contacts validated. Nothing was stored.</p>@endif
</form>
