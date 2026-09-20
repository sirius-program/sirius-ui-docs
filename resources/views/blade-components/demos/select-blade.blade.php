<form method="POST" action="{{ route('blade-components.select.store') }}" novalidate class="space-y-5" data-blade-select>
    @csrf
    @include('blade-components.demos.select-shipping')
    @include('blade-components.demos.select-topics')
    @include('blade-components.demos.select-venue')
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="action" value="load">Load Value</flux:button>
        <flux:button type="submit" name="action" value="reset">Reset Sample</flux:button>
    </div>
    @if (session('select_saved'))<p role="status">Selections validated. Nothing was stored.</p>@endif
</form>
