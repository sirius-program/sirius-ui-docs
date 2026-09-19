<x-docs-code language="Shell">php artisan vendor:publish --tag=sirius-ui-config</x-docs-code>
<x-docs-code language="PHP">// config/sirius-ui.php - unset environment overrides inherit app settings:
'locale' => env('SIRIUS_UI_LOCALE'),
'timezone' => env('SIRIUS_UI_TIMEZONE'),</x-docs-code>
<x-docs-code language="ENV"># Optional global overrides in your application's environment:
SIRIUS_UI_LOCALE=id
SIRIUS_UI_TIMEZONE=Asia/Jakarta</x-docs-code>
