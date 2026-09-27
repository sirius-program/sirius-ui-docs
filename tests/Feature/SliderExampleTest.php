<?php

declare(strict_types=1);

use App\Livewire\Examples\SliderExample;
use Livewire\Livewire;

it('validates ordered numeric slider values in Blade and Livewire', function (): void {
    Livewire::test(SliderExample::class)->set('discount', 25)->set('budget', [80, 220])->call('save')->assertHasNoErrors()->assertSet('saved', true);
    $this->post(route('blade-components.slider.store'), ['discount' => '25', 'budget' => ['80', '220']])
        ->assertSessionHasNoErrors()->assertSessionHas('slider-success', true)->assertSessionHas('sample-slider.budget', ['80', '220']);
    $this->get(route('blade-components.slider'))->assertOk()->assertSee('value="80"', false);
});

it('rejects malformed out of bounds off step and crossed slider submissions', function (mixed $discount, mixed $budget, string $key): void {
    $this->post(route('blade-components.slider.store'), ['discount' => $discount, 'budget' => $budget])->assertSessionHasErrorsIn('slider', $key)->assertSessionMissing('slider-success');
    $this->get(route('blade-components.slider'))->assertOk();
    if (is_array($budget) && (is_string($discount) || is_int($discount))) {
        Livewire::test(SliderExample::class)->set('discount', $discount)->set('budget', $budget)->call('save')->assertHasErrors($key)->assertSet('saved', false);
    }
})->with([
    ['bad', [40, 160], 'discount'],
    [55, [40, 160], 'discount'],
    [12, [40, 160], 'discount'],
    [10, [40], 'budget'],
    [10, 'bad', 'budget'],
    [10, [180, 160], 'budget.0'],
    [10, [41, 160], 'budget.0'],
    [10, [40, 150], 'budget.1'],
    [10, [40, 320], 'budget.1'],
]);

it('loads and resets the same slider samples in both submission modes', function (): void {
    Livewire::test(SliderExample::class)->call('loadExample')->assertSet('discount', 25)->assertSet('budget', [80, 220])->call('resetExample')->assertSet('discount', 10)->assertSet('budget', [40, 160]);
    $this->post(route('blade-components.slider.store'), ['sample_action' => 'load'])->assertSessionHas('sample-slider', ['discount' => 25, 'budget' => [80, 220]]);
    $this->post(route('blade-components.slider.store'), ['sample_action' => 'reset'])->assertSessionHas('sample-slider', []);
    $this->post(route('blade-components.slider.store'), ['sample_action' => 'delete'])->assertUnprocessable();
});
