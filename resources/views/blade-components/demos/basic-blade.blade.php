<form method="POST" action="{{ route('blade-components.examples.store', ['kind' => $kind]) }}" novalidate class="space-y-5" data-blade-example="{{ $kind }}">
    @csrf
    @switch($kind)
        @case('input')
            @include('blade-components.demos.input-title')
            @include('blade-components.demos.input-quantity')
            @break
        @case('password')
            @include('blade-components.demos.password')
            @break
        @case('textarea')
            @include('blade-components.demos.textarea')
            @break
        @case('checkbox')
            @include('blade-components.demos.checkbox-agreement')
            @include('blade-components.demos.checkbox-roles')
            @include('blade-components.demos.checkbox-mixed')
            @break
        @case('radio')
            @include('blade-components.demos.radio')
            @break
        @case('switch')
            @include('blade-components.demos.switch')
            @break
    @endswitch
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
    @if (session('sample-success-'.$kind))<p role="status">Sample validated. Nothing was stored.</p>@endif
</form>
