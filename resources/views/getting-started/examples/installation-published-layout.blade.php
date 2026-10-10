@php
    $publishedAssets = <<<'BLADE'
<link rel="stylesheet" href="{{ asset('vendor/sirius-ui/sirius.css') }}">
<script src="{{ asset('vendor/sirius-ui/sirius.js') }}" defer></script>
BLADE;
@endphp
<x-docs-code language="Blade" :source="$publishedAssets" />
