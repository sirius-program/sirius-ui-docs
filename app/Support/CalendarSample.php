<?php

declare(strict_types=1);

namespace App\Support;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Sirius\Ui\Calendar\Dates;

final class CalendarSample
{
    /** @return list<array<string, mixed>> */
    public static function defaults(): array
    {
        return [
            ['id' => 'kickoff', 'title' => 'Website kickoff', 'start' => '2028-10-16T09:00:00+07:00', 'end' => '2028-10-16T10:00:00+07:00', 'allDay' => false],
            ['id' => 'workshop', 'title' => 'Design workshop', 'start' => '2028-10-18', 'end' => '2028-10-20', 'allDay' => true],
            ['id' => 'release', 'title' => 'Release preparation', 'start' => '2028-09-28', 'end' => '2028-10-03', 'allDay' => true],
            ['id' => 'contract', 'title' => 'Contract review (fixed)', 'start' => '2028-10-19T14:00:00+07:00', 'end' => '2028-10-19T15:00:00+07:00', 'allDay' => false, 'editable' => false],
            ['id' => 'standup', 'title' => 'Daily standup', 'daysOfWeek' => [1, 2, 3, 4, 5], 'startTime' => '09:00', 'endTime' => '09:15', 'startRecur' => '2028-10-01', 'endRecur' => '2028-11-01'],
        ];
    }

    /** @return Collection<int, array<string, mixed>> */
    public static function records(string $calendar): Collection
    {
        $records = session('calendar-sample.' . $calendar, self::defaults());
        abort_unless(is_array($records), 422);

        return collect($records)->filter(static fn (mixed $item): bool => is_array($item))->map(static function (array $item): array {
            $record = [];
            foreach ($item as $key => $value) {
                abort_unless(is_string($key), 422);
                $record[$key] = $value;
            }

            return $record;
        })->values();
    }

    /** @return Collection<int, array<string, mixed>> */
    public static function events(string $calendar, CarbonImmutable $start, CarbonImmutable $end, string $timezone): Collection
    {
        return self::records($calendar)->filter(static function (array $record) use ($start, $end, $timezone): bool {
            if (!is_string($record['start'] ?? null)) {
                return true;
            }
            $allDay = $record['allDay'] === true;
            $from = Dates::parse($record['start'], $timezone, $allDay);
            $until = is_string($record['end'] ?? null) ? Dates::parse($record['end'], $timezone, $allDay) : ($allDay ? $from->addDay() : $from->addHour());

            return $from < $end && $until > $start;
        })->values();
    }

    /** @return array<string, mixed> */
    public static function find(string $calendar, string $id): array
    {
        $record = self::records($calendar)->firstWhere('id', $id);
        abort_unless(is_array($record), 404);

        return $record;
    }

    /** @param array{start: string, end: ?string, allDay: bool} $schedule */
    public static function save(string $calendar, ?string $id, string $title, array $schedule): void
    {
        $records = self::records($calendar);
        if ($id !== null) {
            $record = self::find($calendar, $id);
            abort_if(($record['editable'] ?? true) === false || !isset($record['start']), 403);
        }
        $id ??= 'session-' . bin2hex(random_bytes(5));
        $records = $records->reject(static fn (array $record): bool => $record['id'] === $id)->values();
        $records->push(['id' => $id, 'title' => $title, ...$schedule]);
        session()->put('calendar-sample.' . $calendar, $records->all());
    }

    public static function remove(string $calendar, string $id): void
    {
        $record = self::find($calendar, $id);
        abort_if(($record['editable'] ?? true) === false || !isset($record['start']), 403);
        session()->put('calendar-sample.' . $calendar, self::records($calendar)->reject(static fn (array $item): bool => $item['id'] === $id)->values()->all());
    }
}
