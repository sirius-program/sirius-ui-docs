@php
    $fieldExample = <<<'BLADE'
<x-sirius::input id="billing-email" name="billing_email" type="email" label="Billing email" helper="For your receipt" />
BLADE;
@endphp
<x-docs-code :source="$fieldExample" />
