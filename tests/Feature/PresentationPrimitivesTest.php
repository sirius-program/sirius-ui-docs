<?php

declare(strict_types=1);

use App\Livewire\Examples\AvatarExample;
use Livewire\Livewire;

it('renders the primitive documentation with separate demos usage and attributes', function (string $component): void {
    $response = $this->get(route('blade-components.' . $component))->assertOk()
        ->assertSee('id="' . $component . '-demo"', false)
        ->assertSee('id="' . $component . '-usage"', false)
        ->assertSee('id="' . $component . '-attributes"', false)
        ->assertSee('data-demo-mode="blade"', false)->assertSee('data-usage-example', false)
        ->assertDontSee('data-demo-mode="livewire"', false)->assertDontSee('Shared field contract');

    if ($component === 'avatar') {
        $response->assertSee('id="assets-and-interaction"', false);
    }
})->with(['avatar', 'separator', 'skeleton']);

it('updates the development avatar source and name and supports removal and remounting', function (): void {
    Livewire::test(AvatarExample::class)->assertSee('NP')->call('loadImage')
        ->assertSee('src="' . asset('sample/sample.jpg') . '"', false)
        ->call('rename')->assertSee('AM')->assertSee('aria-label="Alex Morgan"', false)
        ->call('failImage')->assertSee('src="' . asset('sample/sample.pdf') . '"', false)
        ->set('visible', false)->assertDontSee('id="livewire-avatar"', false)
        ->set('visible', true)->assertSee('id="livewire-avatar"', false);
});

it('loads the development avatar fixture inside its local route', function (): void {
    $this->get(route('development.avatar'))->assertOk()->assertSee('id="livewire-avatar"', false);
});
