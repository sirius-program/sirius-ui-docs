<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Models\DemoInvoice;
use App\Support\InvoiceSample;
use Illuminate\Database\Eloquent\Builder;
use Sirius\Ui\Livewire\Table;
use Sirius\Ui\Table\Column;

/** @extends Table<DemoInvoice> */
final class ColumnInvoiceTable extends Table
{
    /** @return Builder<DemoInvoice> */
    protected function query(): Builder
    {
        return InvoiceSample::query();
    }

    /** @return list<Column> */
    protected function columns(): array
    {
        return [
            new Column('number', 'Invoice', searchable: true, sortable: true),
            new Column('customer', 'Customer', field: 'demo_invoices.customer', searchable: true, sortable: true),
            new Column('status', 'Status', sortable: true, view: 'livewire-components.demos.table-status'),
            new Column('amount', 'Amount (USD)', sortable: true,
                format: static fn (mixed $value, DemoInvoice $record): string => '$' . number_format((int) $value / 100, 2) . ($record->status === 'paid' ? ' · Paid' : '')),
        ];
    }
}
