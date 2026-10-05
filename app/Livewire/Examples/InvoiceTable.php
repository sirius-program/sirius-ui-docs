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
final class InvoiceTable extends Table
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
            new Column('amount', 'Amount (USD)', sortable: true, format: static fn (mixed $value): string => '$' . number_format((int) $value / 100, 2)),
        ];
    }

    /** @return list<Filter> */
    protected function filters(): array
    {
        return [
            new Filter('customer', 'Customer', static function (Builder $query, string $value): void {
                $query->where('customer', 'like', '%' . $value . '%');
            }),
            new Filter('status', 'Status', static function (Builder $query, string $value): void {
                $query->where('status', $value);
            }, type: 'select', options: ['pending' => 'Pending', 'paid' => 'Paid', 'overdue' => 'Overdue']),
            new Filter('client', 'Customer directory', static function (Builder $query, string $value): void {
                $query->where('customer', $value);
            }, type: 'select', searchUrl: route('livewire-components.table.customers')),
            new Filter('issued', 'Issued on', static function (Builder $query, string $value): void {
                $query->where('issued_on', $value);
            }, type: 'date'),
            new Filter('reminder', 'Reminder time', static function (Builder $query, string $value): void {
                $query->where('reminder_at', $value);
            }, type: 'time'),
            new Filter('sent', 'Sent at', static function (Builder $query, string $value): void {
                $query->where('sent_at', $value);
            }, type: 'datetime'),
        ];
    }

    protected function rowActionsView(): string
    {
        return 'livewire-components.demos.table-row-actions';
    }
}
