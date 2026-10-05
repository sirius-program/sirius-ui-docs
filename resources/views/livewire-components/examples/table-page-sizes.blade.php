@php
    $pageSizesSource = <<<'PHP'
/** @return list<int> */
protected function pageSizes(): array
{
    return [10, 25, 50, 100];
}
PHP;
@endphp
<x-docs-code language="PHP" :source="$pageSizesSource" />
