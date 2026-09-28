<?php

declare(strict_types=1);

use App\Livewire\Examples\LayoutExample;
use Livewire\Livewire;

it('renders layout documentation with native demos and copyable examples', function (string $component): void {
    $this->get(route('blade-components.' . $component))->assertOk()
        ->assertSee('data-demo-mode="blade"', false)->assertDontSee('data-demo-mode="livewire"', false)
        ->assertSee('id="' . $component . '-usage"', false);
})->with(['card', 'accordion']);

it('renders server controlled disclosure state and updated card slots', function (): void {
    Livewire::test(LayoutExample::class)->set('expanded', true)->assertSee(' open ', false)
        ->call('refreshExample')->assertSee('Invoice revision 1')->assertSet('expanded', true)
        ->set('visible', false)->assertDontSee('id="livewire-shipping"', false)
        ->set('visible', true)->assertSee('id="livewire-shipping"', false);
});
