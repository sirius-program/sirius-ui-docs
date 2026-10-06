<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Support\CalendarSample;
use Carbon\CarbonImmutable;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Sirius\Ui\Calendar\Dates;
use Sirius\Ui\Livewire\Calendar;

final class TeamCalendar extends Calendar
{
    #[Locked]
    public bool $rejectChanges = false;

    /** @return iterable<array<string, mixed>> */
    protected function events(CarbonImmutable $start, CarbonImmutable $end, string $timezone): iterable
    {
        return CalendarSample::events($this->calendarId, $start, $end, $timezone);
    }

    /** @param array<string, mixed> $context */
    protected function onDateClick(array $context): void
    {
        $this->dispatch('schedule:create', context: $context);
    }

    /** @param array<string, mixed> $context */
    protected function onSelect(array $context): void
    {
        $this->onDateClick($context);
    }

    /** @param array<string, mixed> $context */
    protected function onEventClick(array $context): void
    {
        $this->dispatch('schedule:edit', context: $context);
    }

    /** @param array<string, mixed> $context */
    protected function onEventDrop(array $context): bool
    {
        if ($this->rejectChanges) {
            return false;
        }
        $eventId = $context['eventId'] ?? null;
        $new = $context['new'] ?? null;
        abort_unless(is_string($eventId) && is_array($new), 422);
        $record = CalendarSample::find($this->calendarId, $eventId);
        $title = $record['title'] ?? null;
        abort_unless(is_string($title), 422);
        CalendarSample::save($this->calendarId, $eventId, $title, Dates::span($new, $this->timezone()));

        return true;
    }

    /** @param array<string, mixed> $context */
    protected function onEventResize(array $context): bool
    {
        return $this->onEventDrop($context);
    }

    #[On('calendar:rejection.{calendarId}')]
    public function toggleRejection(): void
    {
        $this->rejectChanges = !$this->rejectChanges;
        $this->dispatch('schedule:rejection', id: $this->calendarId, rejected: $this->rejectChanges);
    }

    #[On('calendar:timezone.{calendarId}')]
    public function switchTimezone(): void
    {
        $this->configure(['timeZone' => $this->timezone() === 'Asia/Jakarta' ? 'UTC' : 'Asia/Jakarta']);
    }
}
