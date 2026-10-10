@php
    $iconExample = <<<'BLADE'
<x-sirius::icon name="heroicon-o-shield-check" label="Payment verified" />
<x-sirius::button icon="heroicon-o-pencil" aria-label="Edit project" />
BLADE;
@endphp
<x-docs-code :source="$iconExample" />
