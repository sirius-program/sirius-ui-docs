<?php

declare(strict_types=1);

use App\Livewire\Examples\DatetimePickerExample;
use Livewire\Livewire;

it('documents all three date modes using exact native demo sources', function (): void {
    $response = $this->get(route('blade-components.datetime-picker'))->assertOk()->assertSee('Departure date')->assertSee('Reminder')->assertSee('Jadwal konsultasi');
    foreach (['date', 'time', 'datetime'] as $mode) {
        $response->assertSee(e(trim(file_get_contents(resource_path('views/blade-components/demos/datetime-picker-' . $mode . '.blade.php')))), false);
    }
    $this->get(route('started'))->assertSee(route('blade-components.datetime-picker'));
    $this->get(route('development.datetime-picker'))->assertOk();
    $this->get(route('development.date-bindings'))->assertOk();
});

it('validates native calendar values without normalizing malformed dates', function (string $field, mixed $value): void {
    $values = ['departure' => '2028-02-29', 'reminder' => '09:30', 'appointment' => '2028-12-31 14:30:45'];
    $values[$field] = $value;
    $this->post(route('blade-components.datetime-picker.store'), $values + ['private' => 'secret'])
        ->assertSessionHasErrorsIn('datetime-picker', [$field])->assertSessionMissing('sample-datetime-picker.private');
})->with([
    ['departure', '2028-02-30'], ['departure', '2027-02-29'], ['departure', '29/02/2028'],
    ['departure', '2028-03-01'], ['departure', ['2028-02-29']], ['departure', '2029-01-01'],
    ['reminder', '07:59'], ['reminder', '20:01'], ['reminder', '25:00'],
    ['appointment', '2028-12-31 14:30'], ['appointment', '2028-12-31T14:30:45Z'],
]);

it('loads validates and resets native date samples', function (): void {
    $values = ['departure' => '2028-02-29', 'reminder' => '09:30', 'appointment' => '2028-12-31 14:30:45'];
    $this->post(route('blade-components.datetime-picker.store'), $values)->assertSessionHasNoErrors()->assertSessionHas('sample-datetime-picker', $values)->assertSessionHas('datetime-picker-success', true);
    $this->post(route('blade-components.datetime-picker.store'), ['sample_action' => 'load'])->assertSessionHas('sample-datetime-picker', $values);
    $this->post(route('blade-components.datetime-picker.store'), ['sample_action' => 'reset'])->assertSessionHas('sample-datetime-picker', []);
    $this->post(route('blade-components.datetime-picker.store'), ['sample_action' => 'delete'])->assertUnprocessable();
});

it('validates and resets livewire date samples as wall clock strings', function (): void {
    Livewire::test(DatetimePickerExample::class)->set('departure', '2028-02-30')->call('save')->assertHasErrors(['departure', 'reminder', 'appointment'])
        ->call('loadExample')->assertSet('departure', '2028-02-29')->assertSet('reminder', '09:30')->assertSet('appointment', '2028-12-31 14:30:45')
        ->call('save')->assertHasNoErrors()->assertSet('saved', true)->call('resetExample')->assertSet('departure', '')->assertSet('saved', false);
});
