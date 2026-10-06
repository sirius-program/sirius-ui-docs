<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Models\DemoInvoice;
use App\Support\InvoiceSample;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

final class InvoiceChartDemo extends Component
{
    public function render(): View
    {
        // The source applies the application workspace scope before aggregation.
        $totals = InvoiceSample::query()->get()->groupBy('status')
            ->map(static fn (Collection $invoices): float => $invoices->sum(static fn (DemoInvoice $invoice): int => $invoice->amount) / 100);
        $data = ['labels' => $totals->keys()->all(), 'datasets' => [['label' => 'Invoice total (USD)', 'data' => $totals->values()->all()]]];

        return view('livewire.examples.invoice-chart-demo', ['data' => $data, 'totals' => $totals]);
    }
}
