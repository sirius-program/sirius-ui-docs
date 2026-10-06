<?php

declare(strict_types=1);

use App\Livewire\Examples\CalendarActions;
use App\Livewire\Examples\InvoiceCalendar;
use App\Livewire\Examples\TeamCalendar;
use App\Models\DemoInvoice;
use App\Support\CalendarSample;
use App\Support\InvoiceSample;
use Carbon\CarbonImmutable;
use Livewire\Livewire;

it('renders the scheduling docs and integration fixtures', function (): void {
    $this->get(route('livewire-components.calendar'))->assertOk()->assertSee('data-sir-calendar', false)
        ->assertSee('data-usage-example', false)->assertSee('id="translations"', false);
    $this->get(route('development.calendar'))->assertOk()->assertSee('second-calendar')->assertSee('dialog-calendar')->assertSee('tab-calendar');
});

it('renders separate Calendar topics with their own examples', function (string $route, string $view, string $calendarId): void {
    $this->get(route($route))->assertOk()->assertViewIs($view)
        ->assertSee('id="' . $calendarId . '"', false)->assertSee('data-usage-example', false);
})->with([
    ['livewire-components.calendar', 'livewire-components.calendar-docs', 'team-calendar'],
    ['livewire-components.calendar.actions', 'livewire-components.calendar-actions-docs', 'team-calendar'],
    ['livewire-components.calendar.events', 'livewire-components.calendar-events-docs', 'invoice-calendar'],
    ['livewire-components.calendar.options', 'livewire-components.calendar-options-docs', 'options-calendar'],
]);

it('keeps the application edit form on Actions and both event sources on Events', function (): void {
    $this->get(route('livewire-components.calendar'))->assertOk()->assertDontSee('id="team-calendar-edit"', false);
    $this->get(route('livewire-components.calendar.actions'))->assertOk()->assertSee('id="team-calendar-edit"', false);
    $this->get(route('livewire-components.calendar.events'))->assertOk()->assertSee('id="invoice-calendar"', false)
        ->assertSee('id="collection-calendar"', false)->assertDontSee('id="team-calendar-edit"', false);
});

it('queries Collection events by overlap and keeps recurring definitions', function (): void {
    $events = CalendarSample::events('team-calendar', CarbonImmutable::parse('2028-10-01', 'Asia/Jakarta'), CarbonImmutable::parse('2028-10-17', 'Asia/Jakarta'), 'Asia/Jakarta');

    expect($events->pluck('id')->all())->toBe(['kickoff', 'release', 'standup']);
    expect(CalendarSample::events('team-calendar', CarbonImmutable::parse('2028-10-03', 'Asia/Jakarta'), CarbonImmutable::parse('2028-10-16', 'Asia/Jakarta'), 'Asia/Jakarta')->pluck('id')->all())->toBe(['standup']);
});

it('persists accepted scheduling changes and keeps rejected changes unchanged', function (): void {
    $test = Livewire::test(TeamCalendar::class, ['id' => 'team-calendar', 'timezone' => 'Asia/Jakarta', 'editable' => true]);
    $test->call('fetchEvents', '2028-10-01T00:00:00+07:00', '2028-11-01T00:00:00+07:00');
    $old = ['start' => '2028-10-16T09:00:00+07:00', 'end' => '2028-10-16T10:00:00+07:00', 'allDay' => false];
    $new = ['start' => '2028-10-17T09:00:00+07:00', 'end' => '2028-10-17T10:00:00+07:00', 'allDay' => false];

    $test->call('interact', 'event-drop', ['eventId' => 'kickoff', 'old' => $old, 'new' => $new])->assertReturned(true);
    expect(CalendarSample::find('team-calendar', 'kickoff')['start'])->toBe('2028-10-17T09:00:00+07:00');
    expect(CalendarSample::find('second-calendar', 'kickoff')['start'])->toBe('2028-10-16T09:00:00+07:00');
    $test->call('toggleRejection')->call('interact', 'event-resize', ['eventId' => 'kickoff', 'old' => $new, 'new' => $old])->assertReturned(false);
    expect(CalendarSample::find('team-calendar', 'kickoff')['start'])->toBe('2028-10-17T09:00:00+07:00');
});

it('creates validates edits and deletes sessions through the separate application form', function (): void {
    $form = Livewire::test(CalendarActions::class);
    $form->call('create', ['id' => 'unrelated', 'start' => '2028-10-16', 'allDay' => true])->assertSet('start', '');
    $form->call('create', ['id' => 'team-calendar', 'timezone' => 'Asia/Jakarta', 'start' => '2028-10-21', 'end' => '2028-10-22', 'allDay' => true])
        ->assertSet('start', '2028-10-21 00:00:00')->call('save')->assertHasErrors(['title' => 'required']);
    $form->set('title', 'Review draft')->call('save')->assertHasNoErrors();
    expect(CalendarSample::records('team-calendar')->last())->toMatchArray(['title' => 'Review draft', 'start' => '2028-10-21', 'end' => '2028-10-22', 'allDay' => true]);
    $form->call('edit', ['id' => 'team-calendar', 'eventId' => 'kickoff', 'timezone' => 'UTC'])->assertSet('start', '2028-10-16 02:00:00')
        ->set('title', 'Updated kickoff')->call('save')->assertHasNoErrors();
    expect(CalendarSample::find('team-calendar', 'kickoff')['title'])->toBe('Updated kickoff');
    $form->call('remove')->assertSet('feedback', 'Event removed.');
    expect(CalendarSample::records('team-calendar')->pluck('id')->all())->not->toContain('kickoff');
});

it('reloads scoped events and refuses fixed or foreign records in application handlers', function (): void {
    Livewire::test(CalendarActions::class)->call('edit', ['id' => 'team-calendar', 'eventId' => 'foreign'])->assertStatus(404);
    Livewire::test(CalendarActions::class)->call('edit', ['id' => 'team-calendar', 'eventId' => 'contract'])->assertSet('eventId', null)
        ->assertSet('feedback', 'This event is fixed. Recurring events are read-only in this demo.');
    $form = Livewire::test(CalendarActions::class);
    $form->call('edit', ['id' => 'team-calendar', 'eventId' => 'standup'])->assertSet('eventId', null);
});

it('executes the documented Eloquent event source with scoped records and exclusive ends', function (): void {
    InvoiceSample::initialize(false);
    DemoInvoice::factory()->create(['number' => 'INV-100', 'workspace' => 'design', 'issued_on' => '2028-10-16']);
    DemoInvoice::factory()->create(['number' => 'INV-200', 'workspace' => 'other', 'issued_on' => '2028-10-16']);
    DemoInvoice::factory()->create(['number' => 'INV-300', 'workspace' => 'design', 'issued_on' => '2028-10-17']);
    $calendar = new InvoiceCalendar;
    $calendar->mount(timezone: 'Asia/Jakarta');

    $events = $calendar->fetchEvents('2028-10-16T00:00:00+07:00', '2028-10-17T00:00:00+07:00');

    expect($events)->toHaveCount(1);
    expect($events[0])->toMatchArray(['id' => '1', 'start' => '2028-10-16', 'end' => '2028-10-17', 'allDay' => true]);
});

it('validates the exclusive all day end without changing the stored event', function (): void {
    $form = Livewire::test(CalendarActions::class);
    $form->call('edit', ['id' => 'team-calendar', 'eventId' => 'kickoff'])->set('allDay', true)->call('save')->assertHasErrors(['end']);

    expect(CalendarSample::find('team-calendar', 'kickoff')['allDay'])->toBeFalse();
});
