<form method="POST" action="{{ route('blade-components.datetime-picker.store') }}" novalidate class="space-y-5" data-blade-datetime-picker>
    @csrf
    @include('blade-components.demos.datetime-picker-date')
    @include('blade-components.demos.datetime-picker-time')
    @include('blade-components.demos.datetime-picker-datetime')
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
    @if (session('datetime-picker-success'))<p role="status">Travel dates validated. Nothing was stored.</p>@endif
</form>
