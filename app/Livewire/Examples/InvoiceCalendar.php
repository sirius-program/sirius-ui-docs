<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Models\DemoInvoice;
use App\Support\InvoiceSample;
use Carbon\CarbonImmutable;
use Sirius\Ui\Calendar\Dates;
use Sirius\Ui\Livewire\Calendar;

final class InvoiceCalendar extends Calendar
{
    /** @return iterable<array<string, mixed>> */
    protected function events(CarbonImmutable $start, CarbonImmutable $end, string $timezone): iterable
    {
        return InvoiceSample::query()->where('issued_on', '>=', $start->toDateString())
            ->where('issued_on', '<', $end->toDateString())->get()->map(static function (DemoInvoice $invoice) use ($timezone): array {
                $id = $invoice->getKey();
                $issued = $invoice->getAttribute('issued_on');
                abort_unless(is_int($id) && is_string($issued), 422);
                $day = Dates::parse($issued, $timezone, true);

                return ['id' => $id, 'title' => $invoice->number . ' · ' . $invoice->customer,
                    'start'  => $day->toDateString(), 'end' => $day->addDay()->toDateString(), 'allDay' => true];
            });
    }
}
