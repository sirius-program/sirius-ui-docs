<x-sirius::form method="POST" action="{{ route('blade-components.richtext.store') }}" class="space-y-5" data-richtext-blade novalidate>
    @include('blade-components.demos.richtext-announcement')
    @include('blade-components.demos.richtext-signature')
    <div class="flex flex-wrap gap-2">
        <flux:button type="submit" name="sample_action" value="validate">Submit / Validate</flux:button>
        <flux:button type="submit" name="sample_action" value="load" formnovalidate>Load Value</flux:button>
        <flux:button type="submit" name="sample_action" value="reset" formnovalidate>Reset Sample</flux:button>
    </div>
    @if (session('richtext-preview'))<div data-richtext-blade-preview role="status"><p>Sanitized preview</p>{!! session('richtext-preview') !!}</div>@endif
</x-sirius::form>
