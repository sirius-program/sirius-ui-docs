@include('blade-components.examples.publish-config')
<x-docs-code language="PHP">// config/sirius-ui.php
'phone_country' => env('SIRIUS_UI_PHONE_COUNTRY'),</x-docs-code>
<x-docs-code language="ENV"># Optional global overrides in your application's environment:
SIRIUS_UI_PHONE_COUNTRY=ID</x-docs-code>