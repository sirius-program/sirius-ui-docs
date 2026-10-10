@php
    $customSetExample = <<<'PHP'
'workspace' => [
    'path' => resource_path('svg'),
    'prefix' => 'workspace',
],
PHP;
@endphp
<x-docs-code language="PHP" :source="$customSetExample" />
