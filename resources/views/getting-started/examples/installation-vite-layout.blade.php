@php
    $viteLayout = <<<'BLADE'
@vite(['resources/css/app.css', 'resources/js/app.js'])
BLADE;
@endphp
<x-docs-code language="Blade" :source="$viteLayout" />
