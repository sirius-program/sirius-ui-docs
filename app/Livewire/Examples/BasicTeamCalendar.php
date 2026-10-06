<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Support\CalendarSample;
use Carbon\CarbonImmutable;
use Sirius\Ui\Livewire\Calendar;

final class BasicTeamCalendar extends Calendar
{
    /** @return iterable<array<string, mixed>> */
    protected function events(CarbonImmutable $start, CarbonImmutable $end, string $timezone): iterable
    {
        return CalendarSample::events($this->calendarId, $start, $end, $timezone);
    }
}
