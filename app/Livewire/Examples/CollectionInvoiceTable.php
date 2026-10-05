<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Sirius\Ui\Livewire\Table;
use Sirius\Ui\Table\Column;

/** @extends Table<Model> */
final class CollectionInvoiceTable extends Table
{
    /** @return Collection<int, array{id: int, number: string, customer: string, amount: int}> */
    protected function query(): Collection
    {
        return collect([
            ['id' => 1, 'number' => 'INV-1042', 'customer' => 'Northstar Studio', 'amount' => 12000],
            ['id' => 2, 'number' => 'INV-1043', 'customer' => 'Orbit Coffee', 'amount' => 12750],
            ['id' => 3, 'number' => 'INV-1044', 'customer' => 'Bright Books', 'amount' => 13500],
            ['id' => 4, 'number' => 'INV-1045', 'customer' => 'Cedar Workshop', 'amount' => 14250],
        ]);
    }

    /** @return list<Column> */
    protected function columns(): array
    {
        return [
            new Column('number', 'Invoice', searchable: true, sortable: true),
            new Column('customer', 'Customer', searchable: true, sortable: true),
            new Column('amount', 'Amount (USD)', sortable: true,
                format: static fn (mixed $value): string => '$' . number_format((int) $value / 100, 2)),
        ];
    }

    /** @return list<int> */
    protected function pageSizes(): array
    {
        return [2, 4];
    }
}
