<?php

declare(strict_types=1);

use App\Livewire\Examples\CurrencyExample;
use Livewire\Livewire;

it('renders currency navigation and exact separate Blade examples', function (): void {
    $response = $this->get(route('blade-components.currency'))->assertSee('Project budget')->assertSee('Invoice adjustment');
    foreach (['currency-budget', 'currency-adjustment'] as $example) {
        $response->assertSee(e(trim(file_get_contents(resource_path('views/blade-components/demos/' . $example . '.blade.php')))), false);
    }
    $this->get(route('started'))->assertSee(route('blade-components.currency'));
});

it('validates canonical currency on native submissions without rounding or flashing unsafe data', function (mixed $budget, string $adjustment, string $error): void {
    $this->post(route('blade-components.currency.store'), ['budget' => $budget, 'adjustment' => $adjustment, 'unexpected' => 'private'])
        ->assertSessionHasErrorsIn('currency', [$error])->assertSessionMissing('sample-currency.unexpected');
})->with([
    ['', '', 'budget'], ['1,234.50', '0', 'budget'], ['-1', '0', 'budget'],
    ['1.234', '0', 'budget'], ['1e3', '0', 'budget'], [['1'], '0', 'budget'],
    ['0', '1.2345', 'adjustment'], ['0', '-1,234', 'adjustment'],
]);

it('preserves huge decimal strings and trailing zeroes through the native controller', function (): void {
    $this->post(route('blade-components.currency.store'), ['budget' => '123456789012345678901234567890.50', 'adjustment' => '-0.125'])
        ->assertRedirect(route('blade-components.currency') . '#currency-blade')->assertSessionHasNoErrors()
        ->assertSessionHas('sample-currency.budget', '123456789012345678901234567890.50')
        ->assertSessionHas('sample-currency.adjustment', '-0.125')->assertSessionHas('currency-success', true);
});

it('loads and resets currency examples without validating stale values', function (): void {
    $this->post(route('blade-components.currency.store'), ['sample_action' => 'load'])->assertSessionHas('sample-currency.budget', '1234567.50')->assertSessionHasNoErrors();
    $this->post(route('blade-components.currency.store'), ['sample_action' => 'reset', 'budget' => 'invalid'])->assertSessionHas('sample-currency', [])->assertSessionHasNoErrors();
    $this->post(route('blade-components.currency.store'), ['sample_action' => 'delete'])->assertUnprocessable();
});

it('validates livewire decimal precision and resets errors while retaining string values', function (): void {
    Livewire::test(CurrencyExample::class)->set('budget', '1.234')->set('adjustment', '-1.125')->call('save')
        ->assertHasErrors('budget')->assertSee('Enter a non-negative budget with at most 2 decimal places.')
        ->assertSet('budget', '1.234')->call('loadExample')->assertSet('budget', '1234567.50')->assertSet('adjustment', '-1250.125')
        ->call('save')->assertHasNoErrors()->assertSet('saved', true)->call('resetExample')->assertSet('budget', '')->assertSet('adjustment', '')->assertSet('saved', false);
});
