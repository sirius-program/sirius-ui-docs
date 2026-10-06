<?php

declare(strict_types=1);

namespace App\Livewire\Examples;

use App\Support\CalendarSample;
use Carbon\CarbonImmutable;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Sirius\Ui\Calendar\Dates;

final class CalendarActions extends Component
{
    #[Locked]
    public string $calendarId = 'team-calendar';

    #[Locked]
    public ?string $eventId = null;

    #[Locked]
    public string $timezone = 'Asia/Jakarta';

    public string $title = '';

    public string $start = '';

    public string $end = '';

    public bool $allDay = false;

    public string $feedback = '';

    public bool $rejected = false;

    public bool $visible = true;

    /** @param array<string, mixed> $context */
    #[On('schedule:create')]
    public function create(array $context): void
    {
        if (($context['id'] ?? null) !== $this->calendarId) {
            return;
        }
        $timezone = $context['timezone'] ?? null;
        abort_unless(is_string($timezone) && in_array($timezone, ['Asia/Jakarta', 'UTC'], true), 422);
        $this->timezone = $timezone;
        $span = Dates::span($context, $timezone);
        $this->eventId = null;
        $this->title = '';
        $this->allDay = $span['allDay'];
        $from = Dates::parse($span['start'], $timezone, $this->allDay);
        $until = $span['end'] === null ? ($this->allDay ? $from->addDay() : $from->addHour()) : Dates::parse($span['end'], $timezone, $this->allDay);
        $this->start = $from->format('Y-m-d H:i:s');
        $this->end = $until->format('Y-m-d H:i:s');
        $this->resetValidation();
        $this->dispatch('dialog:show', id: $this->calendarId . '-edit');
    }

    /** @param array<string, mixed> $context */
    #[On('schedule:edit')]
    public function edit(array $context): void
    {
        if (($context['id'] ?? null) !== $this->calendarId) {
            return;
        }
        $id = $context['eventId'] ?? null;
        abort_unless(is_string($id), 422);
        $record = CalendarSample::find($this->calendarId, $id);
        if (!isset($record['start']) || ($record['editable'] ?? true) === false) {
            $this->feedback = 'This event is fixed. Recurring events are read-only in this demo.';

            return;
        }
        $this->create([...$record, 'id' => $this->calendarId, 'timezone' => $context['timezone'] ?? $this->timezone]);
        $this->eventId = $id;
        $title = $record['title'] ?? null;
        abort_unless(is_string($title), 422);
        $this->title = $title;
    }

    public function save(): void
    {
        $this->validate(['title' => ['required', 'string', 'max:120'], 'start' => ['required', 'date_format:Y-m-d H:i:s'],
            'end'                => ['required', 'date_format:Y-m-d H:i:s', 'after:start'], 'allDay' => ['boolean']]);
        $start = CarbonImmutable::createFromFormat('!Y-m-d H:i:s', $this->start, $this->timezone);
        $end = CarbonImmutable::createFromFormat('!Y-m-d H:i:s', $this->end, $this->timezone);
        abort_unless($start instanceof CarbonImmutable && $end instanceof CarbonImmutable, 422);
        if ($this->allDay && $end->startOfDay() <= $start->startOfDay()) {
            throw ValidationException::withMessages(['end' => 'Choose an end date after the start date for all-day sessions.']);
        }
        $schedule = Dates::span(['start' => $this->allDay ? $start->toDateString() : $start->toIso8601String(),
            'end'                        => $this->allDay ? $end->toDateString() : $end->toIso8601String(), 'allDay' => $this->allDay], $this->timezone);
        CalendarSample::save($this->calendarId, $this->eventId, $this->title, $schedule);
        $this->feedback = $this->title . ' saved.';
        $this->dispatch('dialog:hide', id: $this->calendarId . '-edit');
        $this->dispatch('calendar:refresh.' . $this->calendarId);
    }

    public function remove(): void
    {
        abort_unless($this->eventId !== null, 422);
        CalendarSample::remove($this->calendarId, $this->eventId);
        $this->feedback = 'Event removed.';
        $this->dispatch('dialog:hide', id: $this->calendarId . '-edit');
        $this->dispatch('calendar:refresh.' . $this->calendarId);
    }

    #[On('schedule:rejection')]
    public function rejection(string $id, bool $rejected): void
    {
        if ($id === $this->calendarId) {
            $this->rejected = $rejected;
        }
    }

    public function render(): View
    {
        return view('livewire.examples.calendar-actions');
    }
}
