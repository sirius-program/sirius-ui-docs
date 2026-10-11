@php
    $typographyFontFace = <<<'CSS'
@font-face {
    font-family: 'App Sans';
    src: url('/fonts/app-sans.woff2') format('woff2');
    font-style: normal;
    font-weight: 400;
    font-display: swap;
}

:root {
    --sir-font-family: 'App Sans', sans-serif;
}
CSS;
@endphp
<x-docs-code language="CSS" :source="$typographyFontFace" />
