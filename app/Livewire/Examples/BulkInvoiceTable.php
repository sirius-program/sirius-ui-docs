<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Models\DemoInvoice;
use App\Support\InvoiceSample;
use Illuminate\Database\Eloquent\Builder;
use Sirius\Ui\Livewire\Table;
use Sirius\Ui\Table\Column;
use Sirius\Ui\Table\Filter;

/** @extends Table<DemoInvoice> */
final class BulkInvoiceTable extends Table
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
            new Column('customer', 'Customer', searchable: true, sortable: true),
            new Column('status', 'Status', sortable: true, view: 'livewire-components.demos.table-status'),
        ];
    }

    /** @return list<Filter> */
    protected function filters(): array
    {
        return [new Filter('status', 'Status', static function (Builder $query, string $value): void {
            $query->where('status', $value);
        }, type: 'select', options: ['pending' => 'Pending', 'paid' => 'Paid', 'overdue' => 'Overdue'])];
    }

    protected function bulkActionsView(): string
    {
        return 'livewire-components.demos.table-bulk-buttons';
    }
}
