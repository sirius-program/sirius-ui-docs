<?php

declare(strict_types=1);

use App\Livewire\Examples\FloatingExample;
use Livewire\Livewire;

it('renders floating documentation with separate demos copyable usage and attributes', function (string $component): void {
    $this->get(route('blade-components.' . $component))->assertOk()
        ->assertSee('id="' . $component . '-demo"', false)->assertSee('id="' . $component . '-usage"', false)
        ->assertSee('id="' . $component . '-attributes"', false)->assertSee('id="assets-and-interaction"', false)
        ->assertSee('data-demo-mode="blade"', false)->assertSee('data-usage-example', false)
        ->assertDontSee('data-demo-mode="livewire"', false)->assertDontSee('Shared field contract');
})->with(['tooltip', 'popover']);

it('updates floating fixture content visibility and server open state', function (): void {
    Livewire::test(FloatingExample::class)->call('increment')->assertSet('count', 1)
        ->call('rename')->assertSee('Access is limited to invited members.')
        ->set('opened', true)->assertSee('data-initial-open="true"', false)
        ->set('name', 'Alex')->assertSet('name', 'Alex')
        ->set('visible', false)->assertDontSee('id="livewire-sharing"', false)
        ->set('visible', true)->assertSee('id="livewire-sharing"', false);
});

it('includes floating panels inside the unified development overlay fixture', function (): void {
    $this->get(route('development.overlays'))->assertOk()
        ->assertSee('id="floating-dialog"', false)->assertSee('id="floating-slideover"', false)
        ->assertSee('id="dialog-sharing"', false)->assertSee('id="slideover-sharing"', false);
});
