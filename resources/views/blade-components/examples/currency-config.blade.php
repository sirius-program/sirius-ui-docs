@include('blade-components.examples.publish-config')
<x-docs-code language="PHP">// config/sirius-ui.php
'currency' => [
    'thousands_separator' => env('SIRIUS_UI_CURRENCY_THOUSANDS_SEPARATOR', ','),
    'precision' => env('SIRIUS_UI_CURRENCY_PRECISION', 2),
    'decimal_separator' => env('SIRIUS_UI_CURRENCY_DECIMAL_SEPARATOR', '.'),
],</x-docs-code>
<x-docs-code language="ENV"># Optional global overrides in your application's environment:
SIRIUS_UI_CURRENCY_THOUSANDS_SEPARATOR="."
SIRIUS_UI_CURRENCY_DECIMAL_SEPARATOR=","
SIRIUS_UI_CURRENCY_PRECISION=2</x-docs-code>
