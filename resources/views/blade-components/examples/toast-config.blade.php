@include('blade-components.examples.publish-config')
<x-docs-code language="PHP">// config/sirius-ui.php
'toast' => [
    'duration' => env('SIRIUS_UI_TOAST_DURATION', 5000),
    'position' => env('SIRIUS_UI_TOAST_POSITION', 'top-end'),
],
</x-docs-code>
<x-docs-code language="ENV"># Optional global overrides in your application's environment:
SIRIUS_UI_TOAST_DURATION=5000
SIRIUS_UI_TOAST_POSITION="top-end"</x-docs-code>