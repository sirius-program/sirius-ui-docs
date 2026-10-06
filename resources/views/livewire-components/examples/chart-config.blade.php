@include('blade-components.examples.publish-config')
<x-docs-code language="PHP">// config/sirius-ui.php - unset environment overrides inherit app settings:
'locale' => env('SIRIUS_UI_LOCALE'),</x-docs-code>
<x-docs-code language="ENV"># Optional global overrides in your application's environment:
SIRIUS_UI_LOCALE=id</x-docs-code>
