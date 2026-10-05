@php
    $selectionEvents = <<<'PHP'
// From your application component, after handling its result:
$this->dispatch('table:remove-selection.bulk-invoices', ids: $processedIds);
$this->dispatch('table:refresh.bulk-invoices');

// Or clear every checked ID explicitly:
$this->dispatch('table:clear-selection.bulk-invoices');
PHP;
@endphp
<x-docs-code language="PHP" :source="$selectionEvents" />
