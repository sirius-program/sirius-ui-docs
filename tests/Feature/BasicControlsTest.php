<?php

declare(strict_types=1);

use App\Livewire\Examples\BasicControlsExample;
use Livewire\Livewire;

it('renders each basic control documentation page', function (string $control, array $examples): void {
    $this->get(route('blade-components.control', ['control' => $control]))
        ->assertSee(array_map(fn (string $example): string => 'data-blade-example="' . $example . '"', $examples), false)
        ->assertDontSee('Toggle sample controls')
        ->assertDontSee('data-basic-state', false);
})->with([
    ['input', ['input', 'password']],
    ['textarea', ['textarea']],
    ['choices', ['checkbox', 'radio', 'switch']],
]);

it('redirects former component pages to their combined documentation', function (string $old, string $destination): void {
    $this->get(route('blade-components.control', ['control' => $old]))
        ->assertRedirect(route('blade-components.control', ['control' => $destination]));
})->with([['password', 'input'], ['checkbox', 'choices'], ['radio', 'choices'], ['switch', 'choices']]);

it('renders validation failures through each reactive control', function (string $kind, string $key): void {
    Livewire::test(BasicControlsExample::class, ['kind' => $kind])->call('save')->assertHasErrors([$key])->assertSee('aria-invalid="true"', false)
        ->call('loadExample')->call('save')->assertHasNoErrors()->assertSee('Sample validated. Nothing was stored.')
        ->call('resetExample')->assertSet('saved', false);
})->with([['input', 'title'], ['password', 'password'], ['textarea', 'notes'], ['checkbox', 'agreed'], ['radio', 'plan'], ['switch', 'enabled']]);

it('validates ordinary submission and normalizes omitted boolean fields', function (): void {
    $this->post(route('blade-components.basic.store'), ['title' => 'Example', 'quantity' => '0', 'plan' => '0', 'roles' => ['0', 'editor']])
        ->assertRedirect(route('blade-components.control', ['control' => 'input']))
        ->assertSessionHas('basic-result.enabled', false)
        ->assertSessionHas('basic-result.roles', ['0', 'editor']);
});

it('rejects invalid ordinary form values in the named error bag', function (): void {
    $this->post(route('blade-components.basic.store'), ['title' => '', 'quantity' => -1, 'plan' => 'invalid', 'roles' => ['admin']])
        ->assertSessionHasErrorsIn('basic', ['title', 'quantity', 'plan', 'roles.0']);
});
