@php
    $collectionFilters = <<<'PHP'
use Illuminate\Support\Collection;
use Sirius\Ui\Table\Filter;

protected function filters(): array
{
    return [
        new Filter('customer', 'Customer', static fn (Collection $rows, string $value): Collection =>
            $rows->filter(static fn (array|object $record): bool =>
                mb_stripos(data_get($record, 'customer'), $value) !== false)),
        new Filter('status', 'Status', static fn (Collection $rows, string $value): Collection =>
            $rows->where('status', $value),
            type: 'select', options: ['pending' => 'Pending', 'paid' => 'Paid']),
    ];
}
PHP;
@endphp
<x-docs-code language="PHP" :source="$collectionFilters" />
