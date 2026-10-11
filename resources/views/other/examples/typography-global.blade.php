@php
    $typographyGlobal = <<<'CSS'
:root {
    --sir-font-family: Georgia, 'Times New Roman', serif;
    --sir-font-family-mono: 'Courier New', monospace;
    --sir-font-size-base: 1.0625rem;
    --sir-font-size-sm: 0.9375rem;
}
CSS;
@endphp
<x-docs-code language="CSS" :source="$typographyGlobal" />
